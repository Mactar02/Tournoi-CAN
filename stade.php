<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Stades</title>
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
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #ffc107;
            color: black;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <form action="submit_stades.php" method="post">
        <label for="nom">Nom du stade:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="ville">Ville:</label>
        <input type="text" id="ville" name="ville" required>

        <label for="capacite">Capacité:</label>
        <input type="number" id="capacite" name="capacite" required>

        <input type="submit" value="Soumettre">
    </form>
</body>
</html>