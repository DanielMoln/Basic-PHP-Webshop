<?php
session_start();

// Unset all session variables and destroy the session
session_unset(); 
session_destroy();

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilépés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            color: #333;
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

        .spinner {
            margin: 20px auto;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        // Redirect to login.php after 4 seconds
        setTimeout(() => {
            window.location.href = "login.php";
        }, 4000);
    </script>
</head>
<body>
    <div class="container">
        <h1>Kilépés sikeres!</h1>
        <p>Kiléptünk az ön felhasználói fiókjából. Hamarosan átírányítjuk a bejelentkezési oldalra...</p>
        <div class="spinner"></div>
    </div>
</body>
</html>
