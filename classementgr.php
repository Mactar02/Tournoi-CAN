<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des Groupes</title>
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
        input[type="text"],
        input[type="number"],
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
        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Classement des Groupes</h1>

    <!-- Formulaire pour ajouter ou modifier un classement -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <label for="groupe">Groupe:</label>
        <select id="groupe" name="groupe" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
        </select>

        <!-- Sélection du nom de l'équipe -->
        <label for="id_equipe">Équipe:</label>
        <select id="id_equipe" name="id_equipe" required>
            <option value="1">Équipe A</option>
            <option value="2">Équipe B</option>
            <option value="3">Équipe C</option>
            <option value="4">Équipe D</option>
            <option value="5">Équipe E</option>
            <option value="6">Équipe F</option>
        </select>

        <label for="position">Position:</label>
        <input type="number" id="position" name="position" required>

        <label for="matchs_joues">Matchs Joués:</label>
        <input type="number" id="matchs_joues" name="matchs_joues" required>

        <label for="victoires">Victoires:</label>
        <input type="number" id="victoires" name="victoires" required>

        <label for="nuls">Nuls:</label>
        <input type="number" id="nuls" name="nuls" required>

        <label for="defaites">Défaites:</label>
        <input type="number" id="defaites" name="defaites" required>

        <label for="buts_pour">Buts Pour:</label>
        <input type="number" id="buts_pour" name="buts_pour" required>

        <label for="buts_contre">Buts Contre:</label>
        <input type="number" id="buts_contre" name="buts_contre" required>

        <label for="difference_buts">Différence de Buts:</label>
        <input type="number" id="difference_buts" name="difference_buts" required>

        <label for="points">Points:</label>
        <input type="number" id="points" name="points" required>

        <!-- Champ pour télécharger une image -->
        <label for="photo">Photo de l'équipe:</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit">Ajouter</button>
    </form>

    <!-- Affichage du classement -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Groupe</th>
                <th>Équipe</th>
                <th>Position</th>
                <th>Matchs Joués</th>
                <th>Victoires</th>
                <th>Nuls</th>
                <th>Défaites</th>
                <th>Buts Pour</th>
                <th>Buts Contre</th>
                <th>Différence</th>
                <th>Points</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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
                            $sql = "INSERT INTO galerie (chemin_fichier) VALUES ('$target_file')";
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
                            $sql = "INSERT INTO galerie (chemin_fichier) VALUES ('$target_file')";
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
                    LEFT JOIN galerie ON classementgroupes.id_galerie = galerie.id_photo";

            // Exécuter la requête et stocker le résultat dans $result
            $result = $conn->query($sql);

            // Vérifier si la requête a réussi
            if ($result === FALSE) {
                echo "<p>Erreur lors de l'exécution de la requête : " . $conn->error . "</p>";
            } else {
                // Vérifier s'il y a des résultats
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
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>