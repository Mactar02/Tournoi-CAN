<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Statistiques</title>
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
        input[type="number"],
        input[type="text"],
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
    </style>
</head>
<body>
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "can2025";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Créer une nouvelle entrée
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
        $match_id = $_POST['match_id'];
        $possession = $_POST['possession'];
        $tirs = $_POST['tirs'];
        $tirs_cadres = $_POST['tirs_cadres'];
        $cartons_jaunes = $_POST['cartons_jaunes'];
        $cartons_rouges = $_POST['cartons_rouges'];
        $buteurs = $_POST['buteurs'];
        $id_groupe = $_POST['id_groupe'];

        $sql = "INSERT INTO statistiques (match_id, possession, tirs, tirs_cadres, cartons_jaunes, cartons_rouges, buteurs, id_groupe)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiiss", $match_id, $possession, $tirs, $tirs_cadres, $cartons_jaunes, $cartons_rouges, $buteurs, $id_groupe);

        if ($stmt->execute()) {
            echo "<p>Statistiques ajoutées avec succès !</p>";
        } else {
            echo "<p>Erreur : " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // Mettre à jour une entrée
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $match_id = $_POST['match_id'];
        $possession = $_POST['possession'];
        $tirs = $_POST['tirs'];
        $tirs_cadres = $_POST['tirs_cadres'];
        $cartons_jaunes = $_POST['cartons_jaunes'];
        $cartons_rouges = $_POST['cartons_rouges'];
        $buteurs = $_POST['buteurs'];
        $id_groupe = $_POST['id_groupe'];

        $sql = "UPDATE statistiques SET match_id=?, possession=?, tirs=?, tirs_cadres=?, cartons_jaunes=?, cartons_rouges=?, buteurs=?, id_groupe=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiissi", $match_id, $possession, $tirs, $tirs_cadres, $cartons_jaunes, $cartons_rouges, $buteurs, $id_groupe, $id);

        if ($stmt->execute()) {
            echo "<p>Statistiques mises à jour avec succès !</p>";
        } else {
            echo "<p>Erreur : " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // Supprimer une entrée
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = "DELETE FROM statistiques WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<p>Statistiques supprimées avec succès !</p>";
        } else {
            echo "<p>Erreur : " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // Gestion du mode édition
    $edit_mode = false;
    $id = $match_id = $possession = $tirs = $tirs_cadres = $cartons_jaunes = $cartons_rouges = $buteurs = $id_groupe = "";

    if (isset($_GET['edit'])) {
        $edit_mode = true;
        $id = $_GET['edit'];

        $sql = "SELECT * FROM statistiques WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $match_id = $row['match_id'];
            $possession = $row['possession'];
            $tirs = $row['tirs'];
            $tirs_cadres = $row['tirs_cadres'];
            $cartons_jaunes = $row['cartons_jaunes'];
            $cartons_rouges = $row['cartons_rouges'];
            $buteurs = $row['buteurs'];
            $id_groupe = $row['id_groupe'];
        }
        $stmt->close();
    }
    ?>

    <!-- Formulaire pour créer ou mettre à jour -->
    <form action="" method="post">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>
        <label for="match_id">ID du Match:</label>
        <select id="match_id" name="match_id" required>
            <?php
            // Récupérer tous les match_id existants dans la table "matchs"
            $result = $conn->query("SELECT id FROM matchs");
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $match_id) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . $row['id'] . "</option>";
            }
            ?>
        </select>

        <label for="possession">Possession (%):</label>
        <input type="number" id="possession" name="possession" value="<?php echo $possession; ?>" required>

        <label for="tirs">Tirs:</label>
        <input type="number" id="tirs" name="tirs" value="<?php echo $tirs; ?>" required>

        <label for="tirs_cadres">Tirs Cadrés:</label>
        <input type="number" id="tirs_cadres" name="tirs_cadres" value="<?php echo $tirs_cadres; ?>" required>

        <label for="cartons_jaunes">Cartons Jaunes:</label>
        <input type="number" id="cartons_jaunes" name="cartons_jaunes" value="<?php echo $cartons_jaunes; ?>" required>

        <label for="cartons_rouges">Cartons Rouges:</label>
        <input type="number" id="cartons_rouges" name="cartons_rouges" value="<?php echo $cartons_rouges; ?>" required>

        <label for="buteurs">Buteurs:</label>
        <input type="text" id="buteurs" name="buteurs" value="<?php echo $buteurs; ?>" required>

        <label for="id_groupe">Groupe:</label>
        <select id="id_groupe" name="id_groupe" required>
            <option value="1" <?php echo ($id_groupe == '1') ? 'selected' : ''; ?>>A</option>
            <option value="2" <?php echo ($id_groupe == '2') ? 'selected' : ''; ?>>B</option>
            <option value="3" <?php echo ($id_groupe == '3') ? 'selected' : ''; ?>>C</option>
            <option value="4" <?php echo ($id_groupe == '4') ? 'selected' : ''; ?>>D</option>
            <option value="5" <?php echo ($id_groupe == '5') ? 'selected' : ''; ?>>E</option>
            <option value="6" <?php echo ($id_groupe == '6') ? 'selected' : ''; ?>>F</option>
        </select>

        <button type="submit" name="<?php echo $edit_mode ? 'update' : 'create'; ?>">
            <?php echo $edit_mode ? 'Mettre à jour' : 'Ajouter'; ?>
        </button>
    </form>

    <!-- Affichage des statistiques -->
    <?php
    $sql = "SELECT statistiques.*, groupes.nom AS nom_groupe
            FROM statistiques
            LEFT JOIN groupes ON statistiques.id_groupe = groupes.id_groupe";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Match ID</th>
                    <th>Possession</th>
                    <th>Tirs</th>
                    <th>Tirs Cadrés</th>
                    <th>Cartons Jaunes</th>
                    <th>Cartons Rouges</th>
                    <th>Buteurs</th>
                    <th>Groupe</th>
                    <th>Actions</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['match_id'] . "</td>
                    <td>" . $row['possession'] . "</td>
                    <td>" . $row['tirs'] . "</td>
                    <td>" . $row['tirs_cadres'] . "</td>
                    <td>" . $row['cartons_jaunes'] . "</td>
                    <td>" . $row['cartons_rouges'] . "</td>
                    <td>" . $row['buteurs'] . "</td>
                    <td>" . $row['nom_groupe'] . "</td> <!-- Afficher le nom du groupe -->
                    <td class='actions'>
                        <a href='?edit=" . $row['id'] . "'>Modifier</a>
                        <a href='?delete=" . $row['id'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette entrée ?\")'>Supprimer</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune statistique trouvée.</p>";
    }

    $conn->close();
    ?>
</body>
</html>