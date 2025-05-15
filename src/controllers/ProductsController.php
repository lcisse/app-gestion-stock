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
        session_start();

        $products = $this->productsManager->findAllProducts();

        require __DIR__ . '/../views/dashboard.php';
    }

    public function createProduct()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $marque = trim($_POST['marque'] ?? '');
            $quantite = $_POST['quantite'] ?? '';
            $categorie = trim($_POST['categorie'] ?? '');

            $errors = [];

            if ($nom === '' || $marque === '' || $categorie === '' ||
                strlen($nom) > 100 || strlen($marque) > 100 || strlen($categorie) > 100) {
                $errors[] = "Tous les champs sont requis et ne doivent pas dépasser 100 caractères.";
            }

            if (!filter_var($quantite, FILTER_VALIDATE_INT) || $quantite < 0) {
                $errors[] = "La quantité doit être un entier positif.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: index.php?action=dashboard');
                exit;
            }

            $product = [
                'nom' => htmlspecialchars($nom),
                'marque' => htmlspecialchars($marque),
                'quantite' => (int)$quantite,
                'categorie' => htmlspecialchars($categorie)
            ];

            $this->productsManager->insertOneProduct($product);

            $_SESSION['success'] = "Produit ajouté avec succès.";
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    public function deleteProduct()
    {
        session_start();

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $this->productsManager->deleteById($id);
                $_SESSION['success'] = "Produit supprimé avec succès.";
            } catch (\Exception $e) {
                $_SESSION['errors'][] = "Erreur lors de la suppression.";
            }
        } else {
            $_SESSION['errors'][] = "ID invalide.";
        }

        header('Location: index.php?action=dashboard');
        exit;
    }

    public function editProduct()
    {
        session_start();

        if (!isset($_GET['id'])) {
            $_SESSION['errors'][] = "ID manquant.";
            header('Location: index.php?action=dashboard');
            exit;
        }

        $id = $_GET['id'];

        try {
            
            $product = $this->productsManager->findById($id);
            
            require __DIR__ . '/../views/editProduct.php';

        } catch (\Exception $e) {
            $_SESSION['errors'][] = "Produit introuvable.";
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    public function updateProduct()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];

            $nom = trim($_POST['nom'] ?? '');
            $marque = trim($_POST['marque'] ?? '');
            $quantite = $_POST['quantite'] ?? '';
            $categorie = trim($_POST['categorie'] ?? '');

            $errors = [];

            if ($nom === '' || $marque === '' || $categorie === '' ||
                strlen($nom) > 100 || strlen($marque) > 100 || strlen($categorie) > 100) {
                $errors[] = "Tous les champs sont requis et ne doivent pas dépasser 100 caractères.";
            }

            if (!filter_var($quantite, FILTER_VALIDATE_INT) || $quantite < 0) {
                $errors[] = "La quantité doit être un entier positif.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: index.php?action=editProduct&id=$id");
                exit;
            }

            $product = [
                'nom' => htmlspecialchars($nom),
                'marque' => htmlspecialchars($marque),
                'quantite' => (int)$quantite,
                'categorie' => htmlspecialchars($categorie)
            ];

            try {
                $this->productsManager->updateById($id, $product);
                $_SESSION['success'] = "Produit mis à jour avec succès.";
            } catch (\Exception $e) {
                $_SESSION['errors'][] = "Erreur lors de la mise à jour.";
            }

            header('Location: index.php?action=dashboard');
            exit;
        }
    }





}