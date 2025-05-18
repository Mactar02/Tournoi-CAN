<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Match</title>
    <style>
        /* Style général du formulaire */
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

.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}
        
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Ajouter un Match</h1>
        <form action="ajouter_match.php" method="post">
            <!-- Champ pour la date du match -->
            <div class="form-group">
                <label for="date">Date du match:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <!-- Champ pour l'identifiant du stade -->
            <div class="form-group">
                <label for="stade_id">ID du stade:</label>
                <input type="number" id="stade_id" name="stade_id" required>
            </div>

            <!-- Champ pour l'identifiant de la première équipe -->
            <div class="form-group">
                <label for="equipe1_id">ID de l'équipe 1:</label>
                <input type="number" id="equipe1_id" name="equipe1_id" required>
            </div>

            <!-- Champ pour l'identifiant de la deuxième équipe -->
            <div class="form-group">
                <label for="equipe2_id">ID de l'équipe 2:</label>
                <input type="number" id="equipe2_id" name="equipe2_id" required>
            </div>

            <!-- Champ pour le score de la première équipe -->
            <div class="form-group">
                <label for="score1">Score de l'équipe 1:</label>
                <input type="number" id="score1" name="score1" required>
            </div>

            <!-- Champ pour le score de la deuxième équipe -->
            <div class="form-group">
                <label for="score2">Score de l'équipe 2:</label>
                <input type="number" id="score2" name="score2" required>
            </div>

            <!-- Bouton de soumission -->
            <div class="form-group">
                <button type="submit">Ajouter le match</button>
            </div>
        </form>
    </div>
</body>
</html>