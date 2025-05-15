<?php
namespace App\models;

class ProductsManager extends Manager
{
    public function insertManyProducts(array $products): void
    {
        $collection = $this->getCollection('device'); 
        
        try {
            $result = $collection->insertMany($products);
            echo count($result->getInsertedIds()) . " produits insérés avec succès.<br>";
        } catch (\Exception $e) {
            echo "Erreur d'insertion : " . $e->getMessage();
        }
    }

    public function findAllProducts(): array
    {
        $collection = $this->getCollection('device');

        try {
            return $collection->find()->toArray();
        } catch (\Exception $e) {
            echo "Erreur de lecture : " . $e->getMessage();
            return [];
        }
    }

    public function insertOneProduct(array $product): void
    {
        $collection = $this->getCollection('device');

        try {
            $collection->insertOne($product);
        } catch (\Exception $e) {
            echo "Erreur lors de l'ajout du produit : " . $e->getMessage();
        }
    }

    public function deleteById(string $id): void
    {
        $collection = $this->getCollection('device');

        try {
            $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        } catch (\Exception $e) {
            error_log("Erreur suppression MongoDB : " . $e->getMessage());
            throw new \Exception("Impossible de supprimer ce produit.");
        }
    }

    public function findById(string $id): ?array
    {
        $collection = $this->getCollection('device');

        try {
            $product = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
            return $product ? (array) $product : null;
        } catch (\Exception $e) {
            error_log("Erreur lecture MongoDB : " . $e->getMessage());
            return null;
        }
    }

    public function updateById(string $id, array $data): void
    {
        $collection = $this->getCollection('device');

        try {
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => $data]
            );
        } catch (\Exception $e) {
            error_log("Erreur update MongoDB : " . $e->getMessage());
            throw new \Exception("Erreur de mise à jour.");
        }
    }


}