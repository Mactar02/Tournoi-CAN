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

    $sql = "INSERT INTO equipes (nom, classement_fifa, participations, entraineur) VALUES ('$nom', '$classement_fifa', '$participations', '$entraineur')";
    if ($conn->query($sql) === TRUE) {
        echo "Nouvelle équipe créée avec succès";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Read
$sql = "SELECT id, nom, classement_fifa, participations, entraineur FROM equipes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nom: " . $row["nom"]. " - Classement FIFA: " . $row["classement_fifa"]. " - Participations: " . $row["participations"]. " - Entraineur: " . $row["entraineur"]. "<br>";
    }
} else {
    echo "0 résultats";
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $classement_fifa = $_POST['classement_fifa'];
    $participations = $_POST['participations'];
    $entraineur = $_POST['entraineur'];

    $sql = "UPDATE equipes SET nom='$nom', classement_fifa='$classement_fifa', participations='$participations', entraineur='$entraineur' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Équipe mise à jour avec succès";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM equipes WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Équipe supprimée avec succès";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>