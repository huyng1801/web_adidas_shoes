<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "web_adidas_shoes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

function execute_query($sql) {
    global $conn;
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function execute_select_query($sql) {
    global $conn;
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            array_walk_recursive($result, function(&$item) {
                $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            });
            return $result;
        } else {
            return false;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function close_connection() {

}
?>
