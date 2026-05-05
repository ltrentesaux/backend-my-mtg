<?php

require_once 'db.php';

$user_id = $_GET['user_id'];

// getAllDeckFromUser
$getDeckFromUser = "SELECT * FROM decks WHERE user_id = ?";
$stmt = $conn->prepare($getDeckFromUser);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$deck = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($deck);

// addToDeck
$addToDeck = "INSERT INTO decks (user_id, card_id, lang, variant) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($addToDeck);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// removeFromDeck
$removeFromDeck = "DELETE FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($removeFromDeck);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// updateDeck
$updateDeck = "UPDATE decks SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateDeck);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// getDeckById
$getDeckById = "SELECT * FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($getDeckById);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$result = $stmt->get_result();
$deck = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($deck);

// updateDeckById
$updateDeckById = "UPDATE decks SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateDeckById);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// deleteDeckById
$deleteDeckById = "DELETE FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($deleteDeckById);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// getDeckByName
$getDeckByName = "SELECT * FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($getDeckByName);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$result = $stmt->get_result();
$deck = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($deck);

// updateDeckByName
$updateDeckByName = "UPDATE decks SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateDeckByName);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// deleteDeckByName
$deleteDeckByName = "DELETE FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($deleteDeckByName);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// getDeckByCardId
$getDeckByCardId = "SELECT * FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($getDeckByCardId);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$result = $stmt->get_result();
$deck = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($deck);

// updateDeckByCardId
$updateDeckByCardId = "UPDATE decks SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateDeckByCardId);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// deleteDeckByCardId
$deleteDeckByCardId = "DELETE FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($deleteDeckByCardId);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// getDeckByLang
$getDeckByLang = "SELECT * FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($getDeckByLang);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$result = $stmt->get_result();
$deck = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode($deck);

// updateDeckByLang
$updateDeckByLang = "UPDATE decks SET user_id = ?, card_id = ?, lang = ?, variant = ? WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($updateDeckByLang);
$stmt->bind_param("isssisss", $user_id, $card_id, $lang, $variant, $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);

// deleteDeckByLang
$deleteDeckByLang = "DELETE FROM decks WHERE user_id = ? AND card_id = ? AND lang = ? AND variant = ?";
$stmt = $conn->prepare($deleteDeckByLang);
$stmt->bind_param("isss", $user_id, $card_id, $lang, $variant);
$stmt->execute();
$stmt->close();

echo json_encode($deck);
