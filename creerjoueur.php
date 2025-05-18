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
    $age = $_POST['age'];
    $poste = $_POST['poste'];
    $equipe_id = $_POST['equipe_id'];

    $sql = "INSERT INTO joueurs (nom, age, poste, equipe_id) VALUES ('$nom', '$age', '$poste', '$equipe_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouveau joueur ajouté avec succès";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read
$sql = "SELECT id, nom, age, poste, equipe_id FROM joueurs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Nom: " . $row["nom"]. " - Âge: " . $row["age"]. " - Poste: " . $row["poste"]. " - ID Équipe: " . $row["equipe_id"]. "<br>";
    }
} else {
    echo "0 résultats";
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $age = $_POST['age'];
    $poste = $_POST['poste'];
    $equipe_id = $_POST['equipe_id'];

    $sql = "UPDATE joueurs SET nom='$nom', age='$age', poste='$poste', equipe_id='$equipe_id' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Joueur mis à jour avec succès";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM joueurs WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Joueur supprimé avec succès";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>