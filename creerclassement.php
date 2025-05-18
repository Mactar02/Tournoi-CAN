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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create') {
    $groupe = $_POST['groupe'];
    $id_equipe = $_POST['id_equipe'];
    $position = $_POST['position'];
    $matchs_joues = $_POST['matchs_joues'];
    $victoires = $_POST['victoires'];
    $nuls = $_POST['nuls'];
    $defaites = $_POST['defaites'];
    $buts_pour = $_POST['buts_pour'];
    $buts_contre = $_POST['buts_contre'];
    $difference_buts = $_POST['difference_buts'];
    $points = $_POST['points'];

    // Gestion du téléchargement de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier le type de fichier
        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Insérer l'image dans la table galerie
                $sql = "INSERT INTO galerie (nom_fichier, chemin_fichier) VALUES ('" . basename($_FILES["photo"]["name"]) . "', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    $id_galerie = $conn->insert_id;

                    // Insérer le classement avec l'ID de l'équipe et l'ID de l'image
                    $sql = "INSERT INTO classementgroupes (groupe, id_equipe, position, matchs_joues, victoires, nuls, defaites, buts_pour, buts_contre, difference_buts, points, id_galerie)
                            VALUES ('$groupe', '$id_equipe', '$position', '$matchs_joues', '$victoires', '$nuls', '$defaites', '$buts_pour', '$buts_contre', '$difference_buts', '$points', '$id_galerie')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>Classement ajouté avec succès !</p>";
                    } else {
                        echo "<p>Erreur : " . $sql . "<br>" . $conn->error . "</p>";
                    }
                } else {
                    echo "<p>Erreur lors de l'insertion de l'image.</p>";
                }
            } else {
                echo "<p>Erreur lors du téléchargement de l'image.</p>";
            }
        } else {
            echo "<p>Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.</p>";
        }
    } else {
        echo "<p>Aucune image téléchargée.</p>";
    }
}

// Mettre à jour une entrée
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $groupe = $_POST['groupe'];
    $id_equipe = $_POST['id_equipe'];
    $position = $_POST['position'];
    $matchs_joues = $_POST['matchs_joues'];
    $victoires = $_POST['victoires'];
    $nuls = $_POST['nuls'];
    $defaites = $_POST['defaites'];
    $buts_pour = $_POST['buts_pour'];
    $buts_contre = $_POST['buts_contre'];
    $difference_buts = $_POST['difference_buts'];
    $points = $_POST['points'];

    // Gestion du téléchargement de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier le type de fichier
        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // Insérer l'image dans la table galerie
                $sql = "INSERT INTO galerie (nom_fichier, chemin_fichier) VALUES ('" . basename($_FILES["photo"]["name"]) . "', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    $id_galerie = $conn->insert_id;

                    // Mettre à jour le classement avec l'ID de l'équipe et l'ID de l'image
                    $sql = "UPDATE classementgroupes
                            SET groupe='$groupe', id_equipe='$id_equipe', position='$position', matchs_joues='$matchs_joues', victoires='$victoires', nuls='$nuls', defaites='$defaites', buts_pour='$buts_pour', buts_contre='$buts_contre', difference_buts='$difference_buts', points='$points', id_galerie='$id_galerie'
                            WHERE id=$id";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>Classement mis à jour avec succès !</p>";
                    } else {
                        echo "<p>Erreur : " . $sql . "<br>" . $conn->error . "</p>";
                    }
                } else {
                    echo "<p>Erreur lors de l'insertion de l'image.</p>";
                }
            } else {
                echo "<p>Erreur lors du téléchargement de l'image.</p>";
            }
        } else {
            echo "<p>Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.</p>";
        }
    } else {
        // Mettre à jour le classement sans changer l'image
        $sql = "UPDATE classementgroupes
                SET groupe='$groupe', id_equipe='$id_equipe', position='$position', matchs_joues='$matchs_joues', victoires='$victoires', nuls='$nuls', defaites='$defaites', buts_pour='$buts_pour', buts_contre='$buts_contre', difference_buts='$difference_buts', points='$points'
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Classement mis à jour avec succès !</p>";
        } else {
            echo "<p>Erreur : " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
}

// Supprimer une entrée
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM classementgroupes WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Classement supprimé avec succès !</p>";
    } else {
        echo "<p>Erreur : " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Récupérer les données pour affichage
$sql = "SELECT classementgroupes.*, equipes.nom AS nom_equipe, galerie.chemin_fichier
        FROM classementgroupes
        LEFT JOIN equipes ON classementgroupes.id_equipe = equipes.id
        LEFT JOIN galerie ON classementgroupes.id_galerie = galerie.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['groupe'] . "</td>
                <td>" . $row['nom_equipe'] . "</td>
                <td>" . $row['position'] . "</td>
                <td>" . $row['matchs_joues'] . "</td>
                <td>" . $row['victoires'] . "</td>
                <td>" . $row['nuls'] . "</td>
                <td>" . $row['defaites'] . "</td>
                <td>" . $row['buts_pour'] . "</td>
                <td>" . $row['buts_contre'] . "</td>
                <td>" . $row['difference_buts'] . "</td>
                <td>" . $row['points'] . "</td>
                <td><img src='" . $row['chemin_fichier'] . "' alt='Photo de l'équipe' width='50'></td>
                <td class='actions'>
                    <a href='?edit=" . $row['id'] . "'>Modifier</a>
                    <a href='?delete=" . $row['id'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette entrée ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='14'>Aucun classement trouvé.</td></tr>";
}

$conn->close();
?>