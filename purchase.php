<?php
session_start();
require('connect.php');

function getCartTotal($userId) {
    global $kapcsolat;
    $stmt = $kapcsolat->prepare("SELECT SUM(products.price * cart.quantity) AS total 
                            FROM products
                            JOIN cart ON products.id = cart.productId
                            WHERE cart.userId = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function purchaseCart($userId) {
    global $kapcsolat;
    $total = getCartTotal($userId);
    $user = $_SESSION['user'];

    if ($user['money'] >= $total) {
        /* Deduct money from user balance */
        $stmt = $kapcsolat->prepare("UPDATE users SET money = money - :total WHERE id = :userId");
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        /* Clear cart */
        $stmt = $kapcsolat->prepare("DELETE FROM cart WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return true; 
    } else {
        return false; 
    }
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$purchaseSuccess = purchaseCart($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásárlás</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .container h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .success {
            color: #28a745;
        }

        .failure {
            color: #dc3545;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($purchaseSuccess): ?>
            <h1 class="success">Sikeres vásárlás!</h1>
            <p>Köszönjük a vásárlást! Az összeget levontuk az egyenlegéről.</p>
        <?php else: ?>
            <h1 class="failure">Nincs elég fedezet</h1>
            <p>Sajnos az egyenlege nem elegendő a vásárláshoz.</p>
        <?php endif; ?>

        <a href="index.php" class="btn">Vissza a főoldalra</a>
    </div>
</body>
</html>
