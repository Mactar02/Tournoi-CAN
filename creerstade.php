<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "votre_base_de_donnees";

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
        echo "Nouveau stade ajouté avec succès";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read
$sql = "SELECT id, nom, ville, capacite FROM stades";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Nom: " . $row["nom"]. " - Ville: " . $row["ville"]. " - Capacité: " . $row["capacite"]. "<br>";
    }
} else {
    echo "0 résultats";
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $ville = $_POST['ville'];
    $capacite = $_POST['capacite'];

    $sql = "UPDATE stades SET nom='$nom', ville='$ville', capacite='$capacite' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Stade mis à jour avec succès";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM stades WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Stade supprimé avec succès";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>