<?php
namespace App\models;

require __DIR__ . '/../../vendor/autoload.php';
use MongoDB\Client;
use Dotenv\Dotenv;

class Manager
{
    protected $mongo;

    public function __construct()
    {
        // Charge les variables d’environnement
        if (!getenv('MONGO_DB_HOST')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }

        $host = $_ENV['MONGO_DB_HOST'];
        $port = $_ENV['MONGO_DB_PORT'];
        $dbName = $_ENV['MONGO_DB_NAME'];

        // Pas d'authentification
        $uri = "mongodb://$host:$port";

        try {
            $this->mongo = new Client($uri);
        } catch (\Exception $e) {
            die("Erreur de connexion MongoDB : " . $e->getMessage());
        }
    }

    public function getDatabase()
    {
        return $this->mongo->selectDatabase($_ENV['MONGO_DB_NAME']);
    }

    public function getCollection($collection)
    {
        return $this->getDatabase()->selectCollection($collection);
    }
}


