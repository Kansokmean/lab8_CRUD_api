<?php
require_once 'config/database.php';

class labEight {
    private $pdo;
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            die("Database connection failed: " . $err->getMessage());
        }
    }

    function create($tbname, $data) {
        try {
            $fields = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));

            $sql = "insert into $tbname ($fields) values ($placeholders)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($data);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update($tbname, $data, $conditions) {
        try {
            $conditionString = implode(" AND ", array_map(fn($key) => "$key = :cond_$key", array_keys($conditions)));
            $checkSql = "SELECT COUNT(*) FROM $tbname WHERE $conditionString";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute(array_combine(array_map(fn($key) => "cond_$key", array_keys($conditions)), array_values($conditions)));

            if ($checkStmt->fetchColumn() == 0) {
                return false; 
            }

            $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $sql = "UPDATE $tbname SET $setClause WHERE $conditionString";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute(array_merge($data, array_combine(array_map(fn($key) => "cond_$key", array_keys($conditions)), array_values($conditions))));
        } catch (Exception $e) {
            return false;
        }
    }
    public function delete($table, $conditions) {
        $sql = "DELETE FROM $table WHERE ";
        $params = [];
        
        foreach ($conditions as $column => $value) {
            $sql .= "$column = ? ";
            $params[] = $value;
        }
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    function getAll($tbname) {
        try {
            $sql = "select * from $tbname";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return  $data;

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
}
?>
