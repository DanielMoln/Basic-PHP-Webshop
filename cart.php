<?php
session_start();
require('connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$userId = $user['id'];

function addToCart($userId, $productId) {
    global $kapcsolat;
    $stmt = $kapcsolat->prepare("INSERT INTO cart (userId, productId, quantity) 
                            VALUES (:userId, :productId, 1) 
                            ON DUPLICATE KEY UPDATE quantity = quantity + 1"); 
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':productId', $productId);
    return $stmt->execute();
}

function getCartItems($userId) {
    global $kapcsolat;
    $stmt = $kapcsolat->prepare("SELECT products.*, cart.quantity 
                            FROM products
                            JOIN cart ON products.id = cart.productId
                            WHERE cart.userId = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeFromCart($userId, $productId) {
    global $kapcsolat;
    $stmt = $kapcsolat->prepare("DELETE FROM cart WHERE userId = :userId AND productId = :productId");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':productId', $productId);
    return $stmt->execute();
}

function updateCartQuantity($userId, $productId, $quantity) {
    global $kapcsolat;
    $stmt = $kapcsolat->prepare("UPDATE cart SET quantity = :quantity 
                            WHERE userId = :userId AND productId = :productId");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':productId', $productId);
    $stmt->bindParam(':quantity', $quantity);
    return $stmt->execute();
}

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

$cartItems = null;
$cartTotal = null;

try
{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'add') {
            /* Add product to cart */
    
            addToCart($userId, $_GET['id']);
            header("Location: cart.php"); 
            exit();
        } elseif ($_GET['action'] == 'remove') {
            /* Remove product from cart */
    
            removeFromCart($userId, $_GET['id']);
            header("Location: cart.php"); 
            exit();
        } elseif ($_GET['action'] == 'update') {
            /* Update product in the cart  */
    
            $productId = $_GET['id'];
            $quantity = $_POST['quantity'];
    
            updateCartQuantity($userId, $productId, $quantity);
            header("Location: cart.php"); 
            exit();
        }
    }
    
    $cartItems = getCartItems($userId);
    $cartTotal = getCartTotal($userId);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #444;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background: #f4f4f4;
            font-weight: bold;
        }

        table td {
            vertical-align: middle;
        }

        input[type="number"] {
            width: 50px;
            padding: 5px;
            font-size: 1rem;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background: #218838;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .total {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }

        .btn-back {
            display: inline-block;
            margin-top: 10px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Kosár</h2>

    <div class="container">
        <?php if (empty($cartItems)) : ?>
            <p>Üres a kosarad :(</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Termék</th>
                        <th>Ár</th>
                        <th>Darabszám</th>
                        <th>Összesen</th>
                        <th>Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item) : ?>
                        <tr>
                            <td><?php echo utf8_encode($item['name']); ?></td>
                            <td><?php echo $item['price']; ?> $</td>
                            <td>
                                <form method="post" action="cart.php?action=update&id=<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                    <button type="submit">Frissítés</button>
                                </form>
                            </td>
                            <td><?php echo $item['price'] * $item['quantity']; ?> $</td>
                            <td><a href="cart.php?action=remove&id=<?php echo $item['id']; ?>">Törlés</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                <p><b>Összesen:</b> <?php echo $cartTotal; ?> $</p>
            </div>

            <form method="post" action="purchase.php">
                <button type="submit">Vásárlás</button>
            </form>

        <?php endif; ?>

        <a class="btn-back" href="index.php">Vissza a főoldalra</a>
    </div>

</body>
</html>