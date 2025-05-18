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
    $lien_image = $_POST['lien_image'];

    $sql = "INSERT INTO galerie (titre, description, categorie, lien_image) VALUES ('$titre', '$description', '$categorie', '$lien_image')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle photo ajoutée avec succès";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read
$sql = "SELECT id_photo, titre, description, categorie, lien_image FROM galerie";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id_photo"]. " - Titre: " . $row["titre"]. " - Description: " . $row["description"]. " - Catégorie: " . $row["categorie"]. " - Lien: " . $row["lien_image"]. "<br>";
    }
} else {
    echo "0 résultats";
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
        echo "Photo mise à jour avec succès";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id_photo = $_GET['delete'];

    $sql = "DELETE FROM galerie WHERE id_photo=$id_photo";
    if ($conn->query($sql) === TRUE) {
        echo "Photo supprimée avec succès";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>