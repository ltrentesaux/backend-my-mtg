<?php

require_once 'db.php';

$user_id = $_GET['user_id'];

// getAllCollectionFromUser
$getCollectionFromUser = "SELECT * FROM collections WHERE user_id = ?";
$stmt = $conn->prepare($getCollectionFromUser);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$collection = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($collection);

// addToCollection
$addToCollection = "INSERT INTO collections (user_id, card_id, lang, variant) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($addToCollection);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($collection);

// removeFromCollection
$removeFromCollection = "DELETE FROM collections WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($removeFromCollection);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($collection);

// updateCollection
$updateCollection = "UPDATE collections SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateCollection);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($collection);

