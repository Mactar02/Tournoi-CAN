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
        $nom = $_POST['nom'];
        $ville = $_POST['ville'];
        $capacite = $_POST['capacite'];

        $sql = "INSERT INTO stades (nom, ville, capacite) VALUES ('$nom', '$ville', '$capacite')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Nouveau stade ajouté avec succès</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    // Update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $ville = $_POST['ville'];
        $capacite = $_POST['capacite'];

        $sql = "UPDATE stades SET nom='$nom', ville='$ville', capacite='$capacite' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Stade mis à jour avec succès</p>";
        } else {
            echo "<p>Error updating record: " . $conn->error . "</p>";
        }
    }

    // Delete
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = "DELETE FROM stades WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Stade supprimé avec succès</p>";
        } else {
            echo "<p>Error deleting record: " . $conn->error . "</p>";
        }
    }
    ?>

    <form action="" method="post">
        <label for="nom">Nom du stade:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="ville">Ville:</label>
        <input type="text" id="ville" name="ville" required>

        <label for="capacite">Capacité:</label>
        <input type="number" id="capacite" name="capacite" required>

        <input type="submit" name="create" value="Ajouter un stade">
    </form>

    <?php
    // Read
    $sql = "SELECT id, nom, ville, capacite FROM stades";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Capacité</th>
                    <th>Actions</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"]. "</td>
                    <td>" . $row["nom"]. "</td>
                    <td>" . $row["ville"]. "</td>
                    <td>" . $row["capacite"]. "</td>
                    <td>
                        <a href='?delete=" . $row["id"]. "'>Supprimer</a>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row["id"]. "'>
                            <input type='text' name='nom' value='" . $row["nom"]. "' required>
                            <input type='text' name='ville' value='" . $row["ville"]. "' required>
                            <input type='number' name='capacite' value='" . $row["capacite"]. "' required>
                            <input type='submit' name='update' value='Mettre à jour'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun stade trouvé.</p>";
    }

    $conn->close();
    ?>
</body>
</html>