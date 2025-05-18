<?php
include 'db.php'; // Vérifie si l'utilisateur est connecté
?>

<?php
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createMatch($date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2) {
    global $conn;
    $sql = "INSERT INTO match (date, stade_id, equipe1_id, equipe2_id, score1, score2)
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

/**
 * Lire un match par son ID
 */
function getMatch($id) {
    global $conn;
    $sql = "SELECT * FROM match WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lire tous les matchs
 */
function getAllMatches() {
    global $conn;
    $sql = "SELECT * FROM match";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Mettre à jour un match
 */
function updateMatch($id, $date, $stade_id, $equipe1_id, $equipe2_id, $score1, $score2) {
    global $conn;
    $sql = "UPDATE match 
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

/**
 * Supprimer un match
 */
function deleteMatch($id) {
    global $conn;
    $sql = "DELETE FROM match WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
}

// Exemple d'utilisation des fonctions CRUD
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
                echo "Match créé avec l'ID : $matchId";
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
                echo "Nombre de lignes mises à jour : $rowsUpdated";
                break;

            case 'delete':
                $id = $_POST['id'];
                $rowsDeleted = deleteMatch($id);
                echo "Nombre de lignes supprimées : $rowsDeleted";
                break;

            default:
                echo "Action non reconnue.";
                break;
        }
    }
}

// Afficher tous les matchs
$matches = getAllMatches();
foreach ($matches as $match) {
    print_r($match);
}
?>