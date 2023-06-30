<?php

class PDOConn
{
    protected ?PDO $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new PDO("pgsql:host=" . DB_HOST .
                ";port=" . DB_PORT .
                ";dbname=" . DB_DATABASE_NAME,
                DB_USERNAME, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch
        (PDOException  $e) {
            die($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function selectAll($query = "", $params = []): bool|array
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to prepare statement: " . $query);
            }

            foreach ($params as $param => $value) {
                $stmt->bindValue(':' . $param, $value);
            }

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $results;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function add($query = "", $params = []): bool|array{
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to prepare statement: " . $query);
            }

            foreach ($params as $param => $value) {
                $stmt->bindValue(':' . $param, $value);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    protected function executeStatement($query = "", $params = []): PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to prepare statement: " . $query);
            }

            if ($params) {
                foreach ($params as $paramName => $paramValue) {
                    $stmt->bindValue(':' . $paramName, $paramValue);
                }
            }

            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

