<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Groupes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Classement des Groupes</h1>

    <!-- Formulaire pour ajouter ou modifier un classement -->
    <form action="crud_classement.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <label for="groupe">Groupe:</label>
        <select id="groupe" name="groupe" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
        </select>

        <!-- Sélection du nom de l'équipe -->
        <label for="id_equipe">Équipe:</label>
        <select id="id_equipe" name="id_equipe" required>
            <option value="1">Équipe A</option>
            <option value="2">Équipe B</option>
            <option value="3">Équipe C</option>
            <option value="4">Équipe D</option>
            <option value="5">Équipe E</option>
            <option value="6">Équipe F</option>
        </select>

        <label for="position">Position:</label>
        <input type="number" id="position" name="position" required>

        <label for="matchs_joues">Matchs Joués:</label>
        <input type="number" id="matchs_joues" name="matchs_joues" required>

        <label for="victoires">Victoires:</label>
        <input type="number" id="victoires" name="victoires" required>

        <label for="nuls">Nuls:</label>
        <input type="number" id="nuls" name="nuls" required>

        <label for="defaites">Défaites:</label>
        <input type="number" id="defaites" name="defaites" required>

        <label for="buts_pour">Buts Pour:</label>
        <input type="number" id="buts_pour" name="buts_pour" required>

        <label for="buts_contre">Buts Contre:</label>
        <input type="number" id="buts_contre" name="buts_contre" required>

        <label for="difference_buts">Différence de Buts:</label>
        <input type="number" id="difference_buts" name="difference_buts" required>

        <label for="points">Points:</label>
        <input type="number" id="points" name="points" required>

        <!-- Champ pour télécharger une image -->
        <label for="photo">Photo de l'équipe:</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit">Ajouter</button>
    </form>

    <!-- Affichage du classement -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Groupe</th>
                <th>Équipe</th>
                <th>Position</th>
                <th>Matchs Joués</th>
                <th>Victoires</th>
                <th>Nuls</th>
                <th>Défaites</th>
                <th>Buts Pour</th>
                <th>Buts Contre</th>
                <th>Différence</th>
                <th>Points</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
    
    </table>
</body>
</html>