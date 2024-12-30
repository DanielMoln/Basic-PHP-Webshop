<?php
session_start();
require('connect.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        $stmt = $kapcsolat->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        if ($stmt->fetch()) {
            echo "Felhasználónév már foglalt!";
        } else {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $kapcsolat->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            echo "Sikeres regisztráció";
            header("Location: login.php");
            exit();
        }
    } catch(PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Regisztrációs hiba, nem töltöttél ki minden mezőt!";
}
?>