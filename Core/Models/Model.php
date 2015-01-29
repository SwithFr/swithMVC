<?php 

namespace Core\Models;
use \PDO;
use App\Config\AppConfig;

/**
 * Model principal (dont tous les autres héritent)
 * Contient les fonctions communes à tous les models.
 */

class Model{

	/*
		VAIRABLES
	 */

	/**
	 * Nom du model
	 * @var string
	 */
	public $name = false;
	/**
	 * Le nom de la table liée au model [le nom du model en minuscules et au pluriel]
	 * @var string
	 */
	public $table = false;

	/**
	 * clé primaire
	 * @var string [id]
	 */
	public $primaryKey = "id";

	/**
	 * Clé étrangère
	 * @var string
	 */
	public $foreignKey;

	/**
	 * La base de donnée à utiliser
	 * @var string
	 */
	public $database = 'default';

	/**
	 * L'instance PDO de la bdd
	 * @var Object PDO
	 */
	protected $bdd;

	/**
	 * Tableau contenant les connexions
	 * @var Array
	 */
	public $connexions = [];

	/*
		METHODES
	 */

	public function __construct($data){

		$this->data = $data;

		$conf = AppConfig::$databases[$this->database];

		// Initialisation des variables
        $this->setNameTableAndModel();
        
		// Si on est déjà connecté à la base de donnée on return true
		if(isset($this->connexions[$this->database])){
			return true;
		}

		// On tente de se connecter
	 	try {
	        $pdo = new PDO(
	        	"mysql:host={$conf['host']};
	        	dbname={$conf['dbname']}",
	        	$conf['login'], 
	        	$conf['password']
	        );
	      	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	      	if(AppConfig::$debug)
	      	 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 
	        $pdo->query('SET CHARACTER SET '.$conf['encode']);
	        $pdo->query('SET NAMES '.$conf['encode']);

	        $this->connexions[$this->database] = $this->bdd = $pdo;
        }catch (PDOException $e) {
            if(AppConfig::$debug){
           		die($e->getMessage());
            }
           	else{
           		die("Une erreure est survenue !");
           	}
        }
	}

	/**
	 * Permet de définir le nom de la table automatiquement
	 * si ils ne sont pas déjà définis
	 */
	private function setNameTableAndModel(){
		$classname = get_class($this);

	    if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
	    	if(!$this->name)
	    		$this->name = $matches[1];
	    	if(!$this->table)
	        	$this->table = strtolower($matches[1]).'s';
	    }
	}

	/**
	 * Fonction qui permet de selectionner des données en base de donnée.
	 * @param  string     $table      le nom de la table
	 * @param  array      $conditions les conditions que l'on veut
	 * @param  array|null $joins      Si l'on veut des joins
	 * @return [type]                 un object contenant les données demandées
	 */
	public function get(array $conditions = null, $table = null){

		if(method_exists($this, "beforeFilter"))
			$this->beforeFilter($this->data);
		
		$query  = "SELECT ";

		// Si on a des champs définis
		if(!isset($conditions['fields']))
			$query .= "*";
		else
			$query .= $conditions['fields'];


		if(is_null($table)){
			$query .= " FROM ".$this->table;
		}else{
			$query .= " FROM ".$table;
		}
		
		// Si on doit faire un join
		if(isset($conditions['joins'])) {
			$joins = [];
			foreach ($conditions['joins'] as $j) {
				if(!isset($this->joins) || !isset($this->joins[$j])){
					debug("Le model ".$this->name." n'a pas d'association avec la table $j ! Veuillez créer un tableau public \$joins dans votre model ".$this->name,false);
				}else{
					$joins[] = " JOIN $j ON $j.{$this->primaryKey} = {$this->table}.".$this->joins[$j];
				}
			}
			$query .= implode(" AND ", $joins);
		}

		// Si on a un Where
		if(isset($conditions['where'])) {
			if(!is_array($conditions['where'])){
				$query .= " WHERE ".$conditions['where'];
			}else{
				$query .= " WHERE ";
				$cond = [];
				foreach($conditions['where'] as $k => $v){
					if(!is_numeric($v))
						$v = "'".addslashes($v)."'";
					$cond[] = "$k=$v";
				}
				$query .= implode(' AND ', $cond);
			}
		}

		// Si on a une limite
		if(isset($conditions['limit'])) {
			if(isset($conditions['offset'])){
				$query .= " LIMIT ".$conditions['offset'].",".$conditions['limit'];
			}else{
				$query .= " LIMIT ".$conditions['limit'];
			}
			
		}

		// Si on a un group by
		if(isset($conditions['groupBy'])) {
			$query .= " GROUP BY ".$conditions['groupBy'];
		}

		// Si on a un order
		if(isset($conditions['order'])) {
			$query .= " ORDER BY ".$conditions['order'];
		}

		// debug($query,false);
		$req = $this->bdd->query($query);

		return $req->fetchAll();
	}

	/**
	 * Permet de récupérer le premier enregistrement d'une table.
	 * @param  string     $table      le nom de la table
	 * @param  array      $conditions les conditions que l'on veut
	 * @param  array|null $joins      Si l'on veut des joins
	 * @return [type]                 un object contenant les données demandées
	 */
	public function getFirst(array $conditions, array $joins = null, $table = null){
		return current($this->get($conditions, $joins,$table));
	}

	/**
	 * Permet de récupérer le dernier enregistrement d'une table.
	 * @param  string     $table      le nom de la table
	 * @param  array      $conditions les conditions que l'on veut
	 * @param  array|null $joins      Si l'on veut des joins
	 * @return [type]                 un object contenant les données demandées
	 */
	public function getLast(array $conditions, array $joins = null, $table = null){
		return end($this->get($conditions, $joins,$table));
	}

  	/**
     * Créer une entrée en bdd
     * @param $data
     * @param $table
     * @return bool
     */
	public function create($data,$table = null){


		if(method_exists($this, "beforeSave"))
			$this->beforeSave($this->data);

		$fields = $values = [];

		foreach($data as $k => $v){
			$fields[] = $k;
			if(!is_numeric($v)){
				$values[] = "'$v'";
			}else{
				$values[] = "$v";
			}
		}


		$fields = "(".implode(',',$fields).")";
		$values = "(".implode(',',$values).")";
		
		if($table == null)
			$table = $this->table;

		$this->bdd->query("INSERT INTO ".$table." $fields VALUES $values");
		return true;
	}

	/**
	 * Met à jour les données
	 * @param  int    $id    l'id de l'entrée que l'on veut update
	 * @param  array  $data  les données
	 * @param  string $table le nom de la table si besoin
	 */
    public function updateData($id,$data,$table = null){
        $values = [];

		foreach($data as $d => $v){
			if(!is_numeric($v)){
				$values[] = "$d ='$v'";
			}else
				$values[] = "$d =$v";
		}

		$values = implode(',', $values);

		if($table == null)
			$table = $this->table;

		// debug("UPDATE ".$table." SET $values WHERE id = $id");
        $this->bdd->query("UPDATE ".$table." SET $values WHERE id = $id");
    }

    /**
     * Supprime une antrée
     * @param  int    $id    l'id de l'entrée à supprimer
     * @param  string $table la table si besoin
     */
	public function delete($id,$table=null){
		if($table ==null)
			$table = $this->table;
		$req = $this->bdd->query("DELETE FROM ".$table." WHERE id=$id");
	}

	/**
	 * Permet de faire une pagination
	 * @param  array      $conditions [description]
	 * @param  array|null $joins      [description]
	 * @param  [type]     $perPage    [description]
	 * @param  [type]     $table      [description]
	 * @return
	 */
	public function count(array $joins = null, $table = null){
		$count = $this->getFirst(['fields'=>"COUNT({$this->primaryKey}) as count"],$joins,$table);
		return $count->count;
	}

	/**
	 * Permet de récuperer les infos en bdd pour vérifier si l'utilisateur à bien entré un bon login/mdp
	 * @param  string $login Le login entré par l'utilisateur
	 * @return stdClass      un objet content les indos trouvées.
	 */
	public function getLogged($login){
		$req = $this->bdd->query("SELECT id,password,role FROM users WHERE login='$login';");
		return $req->fetch();
	}

	/**
	 * Permet d'effectuer une chercher
	 * @param  string $what  ce que l'on doit chercher
	 * @param  arrayt $where sur quel champs
	 * @param  string $how   Comment doit on chercher [around|exactly]
	 * @return
	 */
	public function search($what,Array $where,$how="around"){

		$query = "SELECT * FROM {$this->table} WHERE ";
		$params = [];
		if($how === "around"){
			$what = explode(" ", $what);
		}else{
			$what = [$what];
		}

		foreach($where as $c){
			foreach ($what as $w) {
				if($how==="around"){
					$params[] = $c." LIKE "."'%$w%'" ;
				}elseif($how==="exactly"){
					$params[] = $c." LIKE "."'% $w %'" ;
				}
			}
		}
		
		$params = implode(" OR ", $params);

		$req =  $this->bdd->query($query.$params);
		return $req->fetchAll();
	}
	
}