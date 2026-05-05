<?php
require_once 'db.php';

header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->username) || !isset($data->email) || !isset($data->password)) {
    echo json_encode(["success" => false, "message" => "Veuillez remplir tous les champs."]);
    exit();
}

$username = htmlspecialchars(strip_tags($data->username));
$email = htmlspecialchars(strip_tags($data->email));
$password = password_hash($data->password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Email ou nom d'utilisateur déjà utilisé."]);
        exit();
    }

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$username, $email, $password])) {
        echo json_encode(["success" => true, "message" => "Inscription réussie."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription."]);
    }
} catch(Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur."]);
}
?>
