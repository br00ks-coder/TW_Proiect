<?php

namespace Model;

require_once PROJECT_ROOT_PATH . "/Model/PDOConn.php";

class FlowerModel extends PDOConn
{
    public function getFlowers($limit)
    {
        return $this->selectAll("SELECT * FROM flowers ORDER BY id ASC LIMIT :limit", ['limit' => $limit]);
    }
}

