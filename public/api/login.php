<?php
require_once 'db.php';

header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->email) || !isset($data->password)) {
    echo json_encode(["success" => false, "message" => "Veuillez remplir tous les champs."]);
    exit();
}

$email = $data->email;
$password = $data->password;

try {
    $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        
        echo json_encode([
            "success" => true, 
            "message" => "Connexion réussie.",
            "user" => $user
        ]);

    } else {
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect."]);
    }
} catch(Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur."]);
}
?>
