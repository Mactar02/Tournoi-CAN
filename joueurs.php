<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Joueurs</title>
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
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <form action="submit_joueurs.php" method="post">
        <label for="nom">Nom du joueur:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" required>

        <label for="poste">Poste:</label>
        <input type="text" id="poste" name="poste" required>

        <label for="equipe_id">ID de l'équipe:</label>
        <input type="number" id="equipe_id" name="equipe_id" required>

        <input type="submit" value="Soumettre">
    </form>
</body>
</html>