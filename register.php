<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container h1 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
        }

        .register-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.9rem;
        }

        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .register-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .register-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .register-container p {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Regisztráció</h1>
        <form action="handle_registration.php" method="post">
            <label for="username">Felhasználónév:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Jelszó:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Regisztráció">
        </form>
        <p>Van már fiókod? <a href="login.php">Jelentkezz be itt</a>.</p>
    </div>
</body>
</html>
