<?php
session_start();
require('connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit();
}

$user = $_SESSION['user'];

$stmt = $kapcsolat->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $kapcsolat->prepare("SELECT SUM(quantity) AS total FROM cart WHERE userId = :userId");
$stmt->bindParam(':userId', $user['id']);
$stmt->execute();
$cartAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($cartAmount == null)
{
    $cartAmount = 0;
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modell Kereskedés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        header h2 {
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        #menu a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            margin: 0 10px;
        }

        #menu a:hover {
            text-decoration: underline;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .product {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            max-width: 200px;
            text-align: center;
            transition: transform 0.2s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product h3 {
            font-size: 1.1rem;
            padding: 10px 0;
        }

        .product a {
            display: block;
            background: #28a745;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 0 0 8px 8px;
            font-weight: bold;
        }

        .product a:hover {
            background: #218838;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #f4f4f4;
        }
    </style>
</head>
<body>

    <header>
        <h2>Üdvözöllek, <?php echo $_SESSION['user']['username']; ?>!</h2>
    </header>

    <div class="container">
        <div id="menu">
            <?php if ($user['isAdmin']) : ?>
                <a href="add_product.php">Modell hozzáadása</a>
            <?php endif; ?>

            <div id="submenu">
                <a href="cart.php">Kosár megtekintése (<?php echo $cartAmount; ?>)</a>
                <a href="logout.php">Kilépés</a>
            </div>
        </div>

        <h2>Elérhető modellek</h2>

        <div class="products">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <img src="<?php echo $product['preview']; ?>" alt="Product Image">
                    <h3>
                        <?php echo utf8_encode($product['name']); ?><br>
                        Ár: <?php echo $product['price']; ?> $
                    </h3>
                    <a href="cart.php?action=add&id=<?php echo $product['id']; ?>">Kosárba rakom</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>© 2024 Modell Kereskedés. Minden jog fenntartva.</p>
    </footer>

</body>
</html>
