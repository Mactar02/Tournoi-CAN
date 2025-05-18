<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Statistiques</title>
    <link rel="stylesheet" href="styles.css">
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

input[type="number"],
input[type="text"] {
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
    </style>
    
</head>
<body>
    <form action="submit.php" method="post">
        <label for="match_id">ID du Match:</label>
        <input type="number" id="match_id" name="match_id" required>

        <label for="possession">Possession (%):</label>
        <input type="number" id="possession" name="possession" required>

        <label for="tirs">Tirs:</label>
        <input type="number" id="tirs" name="tirs" required>

        <label for="tirs_cadres">Tirs Cadrés:</label>
        <input type="number" id="tirs_cadres" name="tirs_cadres" required>

        <label for="cartons_jaunes">Cartons Jaunes:</label>
        <input type="number" id="cartons_jaunes" name="cartons_jaunes" required>

        <label for="cartons_rouges">Cartons Rouges:</label>
        <input type="number" id="cartons_rouges" name="cartons_rouges" required>

        <label for="buteurs">Buteurs:</label>
        <input type="text" id="buteurs" name="buteurs" required>

         <label for="id_groupe">groupes :</label>
        <label for="id_groupe">Groupe:</label>
<select id="id_groupe" name="id_groupe" required>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>
</select>



        <button type="submit">Soumettre</button>
    </form>
</body>
</html>