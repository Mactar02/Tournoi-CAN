<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Rediriger vers la page d'accueil
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = "admin"; // Nom d'utilisateur par défaut
    $password = "password"; // Mot de passe par défaut

    // Vérifier les identifiants
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        // Authentification réussie
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Rediriger vers la page d'accueil
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .login-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($error)) : ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>