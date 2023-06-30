<?php

require_once PROJECT_ROOT_PATH . "/Model/PDOConn.php";

class FlowerModel extends PDOConn
{
    /**
     * @throws Exception
     */
    public function getFlowers($limit): bool|array
    {
        return $this->selectAll("SELECT * FROM flowers ORDER BY id LIMIT :limit", ['limit' => $limit]);
    }


    /**
     * @throws Exception
     */
    public function addFlower($flowerData): PDOStatement
    {
        $query = "INSERT INTO flowers
              (name, description, price, available_quantity, created_at, difficulty, flower_images)
              VALUES (:name, :description, :price, :available_quantity, CURRENT_TIMESTAMP, :difficulty, NULL)";

        return $this->executeStatement($query, $flowerData);
    }


    /**
     * @throws Exception
     */
    public function updateFlower($flowerData): PDOStatement
    {
        $query = "UPDATE flowers SET
                    name = :name,
                    description = :description,
                    price = :price,
                    available_quantity = :available_quantity,
                    difficulty = :difficulty
                    WHERE id = :id";

        return $this->executeStatement($query, $flowerData);
    }


    /**
     * @throws Exception
     */
    public function deleteFlower($flowerId): PDOStatement
    {
        $query = "DELETE FROM flowers WHERE id = :id";

        return $this->executeStatement($query, ['id' => $flowerId]);
    }

}

