<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "can2025";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fonction pour créer un match
function createMatch($date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2) {
    global $conn;
    $sql = "INSERT INTO matchs (date, stade_id, equipe1_id, equipe2_id, score1, score2)
            VALUES (:date, :stade_id, :equipe1_id, :equipe2_id, :score1, :score2)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'date' => $date,
        'stade_id' => $stade_id,
        'equipe1_id' => $equipe1_id,
        'equipe2_id' => $equipe2_id,
        'score1' => $score1,
        'score2' => $score2
    ]);
    return $conn->lastInsertId();
}

// Fonction pour récupérer un match par son ID
function getMatch($id) {
    global $conn;
    $sql = "SELECT * FROM matchs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer tous les matchs
function getAllMatches() {
    global $conn;
    $sql = "SELECT * FROM matchs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour un match
function updateMatch($id, $date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2) {
    global $conn;
    $sql = "UPDATE matchs 
            SET date = :date, stade_id = :stade_id, equipe1_id = :equipe1_id, 
                equipe2_id = :equipe2_id, score1 = :score1, score2 = :score2 
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'date' => $date,
        'stade_id' => $stade_id,
        'equipe1_id' => $equipe1_id,
        'equipe2_id' => $equipe2_id,
        'score1' => $score1,
        'score2' => $score2
    ]);
    return $stmt->rowCount();
}

// Fonction pour supprimer un match
function deleteMatch($id) {
    global $conn;
    $sql = "DELETE FROM matchs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
}

// Traitement des actions CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'create':
                $date = $_POST['date'];
                $stade_id = $_POST['stade_id'];
                $equipe1_id = $_POST['equipe1_id'];
                $equipe2_id = $_POST['equipe2_id'];
                $score1 = $_POST['score1'];
                $score2 = $_POST['score2'];
                $matchId = createMatch($date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2);
                echo "<p>Match créé avec l'ID : $matchId</p>";
                break;

            case 'update':
                $id = $_POST['id'];
                $date = $_POST['date'];
                $stade_id = $_POST['stade_id'];
                $equipe1_id = $_POST['equipe1_id'];
                $equipe2_id = $_POST['equipe2_id'];
                $score1 = $_POST['score1'];
                $score2 = $_POST['score2'];
                $rowsUpdated = updateMatch($id, $date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2);
                echo "<p>Nombre de lignes mises à jour : $rowsUpdated</p>";
                break;

            case 'delete':
                $id = $_POST['id'];
                $rowsDeleted = deleteMatch($id);
                echo "<p>Nombre de lignes supprimées : $rowsDeleted</p>";
                break;

            default:
                echo "<p>Action non reconnue.</p>";
                break;
        }
    }
}

// Récupérer tous les matchs pour affichage
$matches = getAllMatches();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Matchs</title>
    <style>
        /* Style général du formulaire */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <!-- Formulaire d'ajout de match -->
    <div class="form-container">
        <h1>Ajouter un Match</h1>
        <form action="" method="post">
            <input type="hidden" name="action" value="create">
            <div class="form-group">
                <label for="date">Date du match:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="stade_id">ID du stade:</label>
                <input type="number" id="stade_id" name="stade_id" required>
            </div>
            <div class="form-group">
                <label for="equipe1_id">ID de l'équipe 1:</label>
                <input type="number" id="equipe1_id" name="equipe1_id" required>
            </div>
            <div class="form-group">
                <label for="equipe2_id">ID de l'équipe 2:</label>
                <input type="number" id="equipe2_id" name="equipe2_id" required>
            </div>
            <div class="form-group">
                <label for="score1">Score de l'équipe 1:</label>
                <input type="number" id="score1" name="score1" required>
            </div>
            <div class="form-group">
                <label for="score2">Score de l'équipe 2:</label>
                <input type="number" id="score2" name="score2" required>
            </div>
            <div class="form-group">
                <button type="submit">Ajouter le match</button>
            </div>
        </form>
    </div>

    <!-- Affichage des matchs -->
    <h2>Liste des Matchs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Stade ID</th>
            <th>Équipe 1</th>
            <th>Équipe 2</th>
            <th>Score 1</th>
            <th>Score 2</th>
        </tr>
        <?php
        if (count($matches) > 0) {
            foreach ($matches as $match) {
                echo "<tr>
                        <td>{$match['id']}</td>
                        <td>{$match['date']}</td>
                        <td>{$match['stade_id']}</td>
                        <td>{$match['equipe1_id']}</td>
                        <td>{$match['equipe2_id']}</td>
                        <td>{$match['score1']}</td>
                        <td>{$match['score2']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun match trouvé.</td></tr>";
        }
        ?>
    </table>
</body>
</html>