<?php
namespace App\controllers;

use App\models\ProductsManager;

class ProductsController
{
    private $productsManager;

    public function __construct()
    {
        $this->productsManager = new ProductsManager();
    
    }

    public function showDashboard()
    {
        //$movies = $this->productsManager->getMoviesSinceLastWednesday();

        require __DIR__ . '/../views/dashboard.php';
    }

}