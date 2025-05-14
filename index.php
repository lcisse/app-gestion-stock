<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
use App\controllers\ProductsController;

class App
{
    private $productsController;

    public function __construct()
    {
        $this->productsController = new ProductsController();
    }

    public function run($action)
    {
        switch ($action) {
            case 'dashboard':
                $this->productsController->showDashboard();
                break;

            default:
                $this->productsController->showDashboard();
                break;
        }
    }
    
}

$app = new App();
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
$app->run($action);