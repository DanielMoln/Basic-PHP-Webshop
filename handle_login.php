<?php
session_start();
require('connect.php'); 

if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        $stmt = $kapcsolat->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $kapcsolat->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } else {
                echo "<p>Hibás felhasználónév vagy jelszó</p>";
            }
        } else {
            echo "<p>Hibás felhasználónév vagy jelszó</p>"; 
        }
    } catch(PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>