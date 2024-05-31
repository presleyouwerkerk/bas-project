<?php
// verkooporder.php

namespace BasProject\classes;

class Verkooporder
{
    public function selectOrder(): array
    {
        try {
            $connection = new Connection();
            $pdo = $connection->getPdo();
            
            $query = "SELECT * FROM verkooporder";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}