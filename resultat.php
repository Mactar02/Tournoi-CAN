<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Matchs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Style pour le message "Aucun résultat trouvé" */
        td[colspan='5'] {
            text-align: center;
            font-style: italic;
            color: #888;
        }

        /* Style du formulaire */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="number"],
        form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Résultats des Matchs</h1>

    <!-- Formulaire pour ajouter un résultat -->
    <form id="formResultat">
        <label for="match_id">Match ID:</label>
        <input type="number" id="match_id" name="match_id" required>

        <label for="equipe_id">Équipe ID:</label>
        <input type="number" id="equipe_id" name="equipe_id" required>

        <label for="buts_marques">Buts Marqués:</label>
        <input type="number" id="buts_marques" name="buts_marques" required>

        <label for="buts_encaisses">Buts Encaisseés:</label>
        <input type="number" id="buts_encaisses" name="buts_encaisses" required>

        <input type="submit" value="Ajouter le résultat">
    </form>

    <!-- Tableau des résultats -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Match ID</th>
                <th>Équipe ID</th>
                <th>Buts Marqués</th>
                <th>Buts Encaisseés</th>
            </tr>
        </thead>
       
    </table>

    <script>
        // JavaScript pour gérer l'ajout de nouveaux résultats
        document.getElementById("formResultat").addEventListener("submit", function (event) {
            event.preventDefault(); // Empêche le rechargement de la page

            // Récupérer les valeurs du formulaire
            const matchId = document.getElementById("match_id").value;
            const equipeId = document.getElementById("equipe_id").value;
            const butsMarques = document.getElementById("buts_marques").value;
            const butsEncaisseés = document.getElementById("buts_encaisses").value;

            // Générer un ID unique (simulé ici)
            const newId = document.querySelectorAll("#tableBody tr").length + 1;

            // Créer une nouvelle ligne pour le tableau
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${newId}</td>
                <td>${matchId}</td>
                <td>${equipeId}</td>
                <td>${butsMarques}</td>
                <td>${butsEncaisseés}</td>
            `;

            // Ajouter la nouvelle ligne au tableau
            document.getElementById("tableBody").appendChild(newRow);

            // Réinitialiser le formulaire
            document.getElementById("formResultat").reset();
        });
    </script>
</body>
</html>