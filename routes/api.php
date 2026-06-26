<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DeckController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Collection routes
Route::get('/collections/{userId}', [CollectionController::class, 'index']);
Route::post('/collections', [CollectionController::class, 'store']);
Route::delete('/collections/{userId}/{cardId}', [CollectionController::class, 'destroy']);

// Decks routes
Route::get('/decks/{userId}', [DeckController::class, 'index']);
Route::post('/decks', [DeckController::class, 'store']);
Route::delete('/decks/{deckId}', [DeckController::class, 'destroy']);

// Deck Cards routes
Route::post('/decks/{deckId}/cards', [DeckController::class, 'addCard']);
Route::put('/decks/{deckId}/cards/{cardId}', [DeckController::class, 'updateQuantity']);
Route::delete('/decks/{deckId}/cards/{cardId}', [DeckController::class, 'removeCard']);
