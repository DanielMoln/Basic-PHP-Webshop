<?php
session_start();
require('connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; 

if (!$user['isAdmin']) {
    header("Location: index.php"); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $preview = $_POST['preview'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $license = $_POST['license'];

    $stmt = $kapcsolat->prepare("INSERT INTO products (name, preview, category, price, license) 
                            VALUES (:name, :preview, :category, :price, :license)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':preview', $preview);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':license', $license);
    if ($stmt->execute()) {
        $successMessage = "Termék sikeresen hozzáadva!";
    } else {
        $errorMessage = "Hiba a termék felvitele közben.";
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Termék hozzáadása</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333333;
            margin-bottom: 1rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-align: left;
        }

        input, select, button {
            padding: 0.75rem;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            margin-top: 1rem;
            background-color: #6c757d;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        .message {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Termék hozzáadása</h2>

        <?php if (isset($successMessage)) : ?>
            <p class="message success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (isset($errorMessage)) : ?>
            <p class="message error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="post" action="add_product.php">
            <label for="name">Név:</label>
            <input type="text" id="name" name="name" required>

            <label for="preview">Kép:</label>
            <input type="text" id="preview" name="preview" required>

            <label for="category">Kategória:</label>
            <select id="category" name="category">
                <option value="animal">Animal</option>
                <option value="architecture">Architecture</option>
                <option value="characters">Characters</option>
            </select>

            <label for="price">Ár:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="license">License:</label>
            <input type="text" id="license" name="license" required>

            <button type="submit">Termék hozzáadása</button>
        </form>

        <button class="back-button" onclick="window.location.href='index.php';">Vissza a kezdőlapra</button>
    </div>
</body>
</html>
