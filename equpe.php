<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Équipes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
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
            gap: 5px;
        }
        .actions form {
            margin: 0;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "can2025";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $nom = $_POST['nom'];
    $classement_fifa = $_POST['classement_fifa'];
    $participations = $_POST['participations'];
    $entraineur = $_POST['entraineur'];
    $groupe = $_POST['groupe'];

    $sql = "INSERT INTO equipes (nom, classement_fifa, participations, entraineur, id_groupe) VALUES ('$nom', '$classement_fifa', '$participations', '$entraineur', '$groupe')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Nouvelle équipe créée avec succès</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $classement_fifa = $_POST['classement_fifa'];
    $participations = $_POST['participations'];
    $entraineur = $_POST['entraineur'];
    $groupe = $_POST['groupe'];

    $sql = "UPDATE equipes SET nom='$nom', classement_fifa='$classement_fifa', participations='$participations', entraineur='$entraineur', groupe='$groupe' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Équipe mise à jour avec succès</p>";
    } else {
        echo "<p>Error updating record: " . $conn->error . "</p>";
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM equipes WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Équipe supprimée avec succès</p>";
    } else {
        echo "<p>Error deleting record: " . $conn->error . "</p>";
    }
}

// Read
$sql = "SELECT id, nom, classement_fifa, participations, entraineur, id_groupe FROM equipes";
$result = $conn->query($sql);
?>

<h2>Ajouter une nouvelle équipe</h2>
<form action="" method="post">
    <label for="nom">Nom de l'équipe:</label>
    <input type="text" id="nom" name="nom" required>

    <label for="classement_fifa">Classement FIFA:</label>
    <input type="number" id="classement_fifa" name="classement_fifa" required>

    <label for="participations">Participations:</label>
    <input type="number" id="participations" name="participations" required>

    <label for="entraineur">Entraîneur:</label>
    <input type="text" id="entraineur" name="entraineur" required>

    <label for="groupe">Groupe:</label>
    <select id="groupe" name="groupe" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>

    <input type="submit" name="create" value="Créer">
</form>

<h2>Liste des équipes</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Classement FIFA</th>
        <th>Participations</th>
        <th>Entraîneur</th>
        <th>Groupe</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["nom"] . "</td>
                    <td>" . $row["classement_fifa"] . "</td>
                    <td>" . $row["participations"] . "</td>
                    <td>" . $row["entraineur"] . "</td>
                    <td>" . $row["id_groupe"] . "</td>
                    <td class='actions'>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='text' name='nom' value='" . $row["nom"] . "'>
                            <input type='number' name='classement_fifa' value='" . $row["classement_fifa"] . "'>
                            <input type='number' name='participations' value='" . $row["participations"] . "'>
                            <input type='text' name='entraineur' value='" . $row["entraineur"] . "'>
                            <select name='groupe'>
                                <option value='A'" . ($row["id_groupe"] == 'A' ? ' selected' : '') . ">A</option>
                                <option value='B'" . ($row["id_groupe"] == 'B' ? ' selected' : '') . ">B</option>
                                <option value='C'" . ($row["id_groupe"] == 'C' ? ' selected' : '') . ">C</option>
                                <option value='D'" . ($row["id_groupe"] == 'D' ? ' selected' : '') . ">D</option>
                            </select>
                            <input type='submit' name='update' value='Modifier'>
                        </form>
                        <form action='' method='get' style='display:inline;'>
                            <input type='hidden' name='delete' value='" . $row["id"] . "'>
                            <input type='submit' value='Supprimer'>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>0 résultats</td></tr>";
    }
    ?>
</table>

<?php
$conn->close();
?>
</body>
</html>