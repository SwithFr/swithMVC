<?php


namespace Core\Components;

use PDO;
use SwithError\SwithError;

class DbProvider
{

    /**
     * La connexion PDO
     * @var null|PDO
     */
    private $db = null;

    /**
     * L'instance du singleton
     * @var null|DbProvider
     */
    private static $_instance = null;

    private function __construct()
    {
        try {
            $this->db = new PDO(
                'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'],
                $_ENV['DB_LOGIN'],
                $_ENV['DB_PASSWORD'],
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => constant($_ENV['DB_OPTION_FETCH_MODE']),
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            $this->db->query('SET CHARACTER SET ' . $_ENV['DB_ENCODE']);
            $this->db->query('SET NAMES ' . $_ENV['DB_ENCODE']);
        } catch (PDOException $e) {
            if ($_ENV['DEBUG']) {
                (new SwithError([
                    "title" => "Echec de connexion à la base de donnée",
                    "message" => "La connexion à la base de donnée à échouée."
                ]))->display();
            }
        }
    }

    /**
     * Permet de récupérer la connexion PDO
     * @return null|PDO
     */
    public static function getDb()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new DbProvider();
        }
        return self::$_instance->db;
    }

} 