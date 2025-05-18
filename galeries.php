<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Galerie</title>
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
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $categorie = $_POST['categorie'];
        
        // Gestion du fichier image
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Vérifier si le fichier est une image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $lien_image = $target_file;
                
                $sql = "INSERT INTO galerie (titre, description, categorie, lien_image) VALUES ('$titre', '$description', '$categorie', '$lien_image')";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Nouvelle photo ajoutée avec succès</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                echo "<p>Désolé, une erreur s'est produite lors du téléchargement de votre fichier.</p>";
            }
        } else {
            echo "<p>Le fichier n'est pas une image.</p>";
        }
    }

    // Update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id_photo = $_POST['id_photo'];
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $categorie = $_POST['categorie'];
        $lien_image = $_POST['lien_image'];

        $sql = "UPDATE galerie SET titre='$titre', description='$description', categorie='$categorie', lien_image='$lien_image' WHERE id_photo=$id_photo";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Photo mise à jour avec succès</p>";
        } else {
            echo "<p>Error updating record: " . $conn->error . "</p>";
        }
    }

    // Delete
    if (isset($_GET['delete'])) {
        $id_photo = $_GET['delete'];

        $sql = "DELETE FROM galerie WHERE id_photo=$id_photo";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Photo supprimée avec succès</p>";
        } else {
            echo "<p>Error deleting record: " . $conn->error . "</p>";
        }
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="titre">Titre de la photo:</label>
        <input type="text" id="titre" name="titre" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="categorie">Catégorie:</label>
        <input type="text" id="categorie" name="categorie" required>

        <label for="image">Choisir une image:</label>
        <input type="file" id="image" name="image" required>

        <input type="submit" name="create" value="Soumettre">
    </form>

    <?php
    // Read
    $sql = "SELECT id_photo, titre, description, categorie, lien_image FROM galerie";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id_photo"]. "</td>
                <td>" . $row["titre"]. "</td>
                <td>" . $row["description"]. "</td>
                <td>" . $row["categorie"]. "</td>
                <td><img src='" . $row["lien_image"]. "' alt='" . $row["titre"]. "' style='width: 100px; height: auto;'></td>
                <td>
                    <a href='?delete=" . $row["id_photo"]. "'>Supprimer</a>
                    <form action='' method='post' style='display:inline;'>
                        <input type='hidden' name='id_photo' value='" . $row["id_photo"]. "'>
                        <input type='text' name='titre' value='" . $row["titre"]. "' required>
                        <textarea name='description' required>" . $row["description"]. "</textarea>
                        <input type='text' name='categorie' value='" . $row["categorie"]. "' required>
                        <input type='text' name='lien_image' value='" . $row["lien_image"]. "' required>
                        <input type='submit' name='update' value='Mettre à jour'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucune photo trouvée.</p>";
}

$conn->close();
    ?>
</body>
</html>