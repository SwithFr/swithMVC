<?php


namespace Core\Models\Behaviors;


trait Search
{
    /**
     * Permet d'effectuer une chercher
     * @param  string $what ce que l'on doit chercher
     * @param array|arrayt $where sur quel champs
     * @param string $get
     * @param null $table
     * @param  string $how Comment doit on chercher [around|exactly]
     * @return mixed
     */
    public function search($what, Array $where, $get = '*', $table = null, $how = "around")
    {
        if (is_null($table))
            $table = $this->table;

        if(is_string($get))
            $query = 'SELECT ' . $get . ' FROM ' . $table . ' WHERE ';
        elseif(is_array($get)) {
            $query = 'SELECT ';
            // Si on a des champs définis
            if (isset($get['fields']))
                $query .= $get['fields'];


            $query .= " FROM " . $table;

            // Si on doit faire un join
            if (isset($get['joins'])) {
                $joins = [];
                foreach ($get['joins'] as $j) {
                    if (!isset($this->joins) || !isset($this->joins[$j])) {
                        debug("Le model " . $this->name . " n'a pas d'association avec la table $j ! Veuillez créer un tableau public \$joins dans votre model " . $this->name, false);
                    } else {
                        $joins[] = " JOIN $j ON $j.{$this->primaryKey} = {$this->table}." . $this->joins[$j];
                    }
                }
                $query .= implode(" AND ", $joins) . ' WHERE ';
            }

        }

        $params = [];
        if ($how === "around") {
            $what = explode(" ", $what);
        } else {
            $what = [$what];
        }

        foreach ($where as $c) {
            foreach ($what as $w) {
                $w = trim($this->bdd->quote($w),'\'');
                if ($how === "around") {
                    $params[] = $c . " LIKE " . "'%$w%'";
                } elseif ($how === "exactly") {
                    $params[] = $c . " LIKE " . "'% $w %'";
                }
            }
        }
        $params = implode(" OR ", $params);

        $req = $this->bdd->query($query . $params);

        if ($_ENV['DB_OPTION_FETCH_MODE'] == 'PDO::FETCH_CLASS'){
            return $req->fetchAll(\PDO::FETCH_CLASS, 'App\\Models\\Entities\\' . $this->name . 'Entity');
        } else {
            return $req->fetchAll();
        }
    }

    /**
     * Effectue une recherche sur plusieurs tables
     * @param array $research
     * @return mixed
     */
    public function searchAll(Array $research)
    {
        foreach ($research as $table => $infos) {
            $results[$table] = $this->search($infos['what'], $infos['where'], $infos['get'], $table);
        }

        return $results;
    }

}