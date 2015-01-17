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

	public function __construct(){
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
		
		$query  = "SELECT ";

		// Si on a des champs définis
		if(!isset($conditions['fields']))
			$query .= "*";
		else
			$query .= $conditions['fields'];


		if(is_null($table)){
			$query .= " FROM ".$this->table." as ".$this->name;
		}else{
			$query .= " FROM ".$table;
		}
		
		// Si on doit faire un join
		if(isset($conditions['joins'])) {
			// for($i = 0; $i < count($joins) ; $i++) {

			// 	switch ($joins[$i]) {
			// 		case 'categories':
			// 			if($model == 'subjects')
			// 				$query .= " JOIN categories ON categories.id = subcategories.category_id";
			// 			elseif($model == 'subcategories')
			// 				$query .= " JOIN subcategories ON categories.id = subcategories.category_id";
			// 			break;

			// 		case 'subcategories':
			// 			if($model == 'subjects')
			// 				$query .= " JOIN subcategories ON subcategories.id = subjects.subcategory_id";
			// 			elseif($model == 'categories')
			// 				$query .= " JOIN subcategories ON categories.id = subcategories.category_id";
			// 			break;

			// 		case 'subjects':
			// 				$query .= " JOIN subjects ON subjects.id = comments.subject_id";
			// 			break;

			// 		case 'comments':
			// 			$query .= " JOIN comments ON subjects.id = comments.subject_id";
			// 			break;

			// 		case 'users':
			// 			$query .= " JOIN users ON users.id = ".$model.".author_id";
			// 			break;
			// 	}
			// }
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

		// debug($query);
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
		$fields = $values = "(";
		$i = 0;
		$length = count($data);

		foreach($data as $k => $v){
			if($i < $length - 1){
				$fields .= $k.",";
				$values .= "'".$v."',";
			}else{
				$fields .= $k;
				$values .= "'".$v."'";
			}
			$i++;
		}
		$fields .= ")";
		$values .= ")";
		
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
    public function updateData($id,array $data,$table = null){
        $values = "";
        $i = 0;
		$length = count($data);

		foreach($data as $d => $v){
			if($i < $length - 1){
				$values .= "$d ='$v',";
			}else{
				$values .= "$d ='$v' ";
			}
			$i++;
		}
		if($table == null)
			$table = $this->table;

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
	 * @return [type]                 [description]
	 */
	public function count(array $joins = null, $table = null){
		$count = $this->getFirst(['fields'=>"COUNT({$this->primaryKey}) as count"],$joins,$table);
		return $count->count;
	}
	
}