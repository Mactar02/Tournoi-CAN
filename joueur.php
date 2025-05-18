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
        input[type="text"], input[type="number"], select {
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
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "can2025";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $age = $_POST['age'];
        $poste = htmlspecialchars($_POST['poste']);
        $equipe_id = $_POST['equipe_id'];

        // Vérifier si equipe_id existe dans la table equipes
        $check_sql = "SELECT id FROM equipes WHERE id = $equipe_id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $sql = "INSERT INTO joueurs (nom, age, poste, equipe_id) VALUES ('$nom', '$age', '$poste', '$equipe_id')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Nouveau joueur ajouté avec succès</p>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "<p>Erreur : L'ID de l'équipe n'existe pas.</p>";
        }
    }

    // Update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $nom = htmlspecialchars($_POST['nom']);
        $age = $_POST['age'];
        $poste = htmlspecialchars($_POST['poste']);
        $equipe_id = $_POST['equipe_id'];

        $sql = "UPDATE joueurs SET nom='$nom', age='$age', poste='$poste', equipe_id='$equipe_id' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Joueur mis à jour avec succès</p>";
        } else {
            echo "<p>Error updating record: " . $conn->error . "</p>";
        }
    }

    // Delete
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = "DELETE FROM joueurs WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Joueur supprimé avec succès</p>";
        } else {
            echo "<p>Error deleting record: " . $conn->error . "</p>";
        }
    }
    ?>

    <form action="" method="post">
        <label for="nom">Nom du joueur:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" required>

        <label for="poste">Poste:</label>
        <input type="text" id="poste" name="poste" required>

        <label for="equipe_id">Équipe:</label>
        <select id="equipe_id" name="equipe_id" required>
            <?php
            // Récupérer les équipes disponibles
            $sql = "SELECT id, nom FROM equipes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["nom"]) . '</option>';
                }
            } else {
                echo '<option value="">Aucune équipe disponible</option>';
            }
            ?>
        </select>

        <input type="submit" name="create" value="Ajouter un joueur">
    </form>

    <?php
    // Read
    $sql = "SELECT id, nom, age, poste, equipe_id FROM joueurs";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Âge</th>
                    <th>Poste</th>
                    <th>ID Équipe</th>
                    <th>Actions</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["nom"]) . "</td>
                    <td>" . htmlspecialchars($row["age"]) . "</td>
                    <td>" . htmlspecialchars($row["poste"]) . "</td>
                    <td>" . htmlspecialchars($row["equipe_id"]) . "</td>
                    <td>
                        <a href='?delete=" . htmlspecialchars($row["id"]) . "'>Supprimer</a>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <input type='text' name='nom' value='" . htmlspecialchars($row["nom"]) . "' required>
                            <input type='number' name='age' value='" . htmlspecialchars($row["age"]) . "' required>
                            <input type='text' name='poste' value='" . htmlspecialchars($row["poste"]) . "' required>
                            <select name='equipe_id' required>";

                            // Affichage des équipes dans le formulaire de mise à jour
                            $sql_equipes = 'SELECT id, nom FROM equipes';
                            $result_equipes = $conn->query($sql_equipes);
                            while ($equipe = $result_equipes->fetch_assoc()) {
                                $selected = ($equipe['id'] == $row['equipe_id']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($equipe['id']) . '" ' . $selected . '>' . htmlspecialchars($equipe['nom']) . '</option>';
                            }

            echo "</select>
                            <input type='submit' name='update' value='Mettre à jour'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun joueur trouvé.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
