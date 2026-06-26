<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index($userId)
    {
        $decksRaw = DB::table('decks')->where('user_id', $userId)->get();
        $decks = [];

        foreach ($decksRaw as $deckRow) {
            $deck = (array) $deckRow;
            $deck['cards'] = DB::table('deck_cards')->where('deck_id', $deckRow->id)->get();
            $decks[] = $deck;
        }

        return response()->json(['success' => true, 'decks' => $decks]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'format' => 'nullable|string'
        ]);

        $formatName = $validated['format'] ?? 'Standard';

        $format = DB::table('deck_format')->where('label', $formatName)->first();
        if ($format) {
            $formatId = $format->id;
        } else {
            $formatId = DB::table('deck_format')->insertGetId([
                'label' => $formatName,
                'description' => 'Format ' . $formatName,
                'quantity_of_cards' => ($formatName === 'Commander') ? 100 : 60
            ]);
        }

        $deckId = DB::table('decks')->insertGetId([
            'user_id' => $validated['user_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'deck_format_id' => $formatId,
        ]);

        return response()->json(['success' => true, 'deck_id' => $deckId]);
    }

    public function addCard(Request $request, $deckId)
    {
        $validated = $request->validate([
            'card_id' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $cardId = $validated['card_id'];
        $quantity = $request->input('quantity', 1);
        $lang = $request->input('lang', 'fr');
        $variant = $request->input('variant', 'nonfoil');

        // Check if exists
        $existing = DB::table('deck_cards')
            ->where('deck_id', $deckId)
            ->where('card_id', $cardId)
            ->where('variant', $variant)
            ->first();

        if ($existing) {
            DB::table('deck_cards')->where('id', $existing->id)->increment('quantity_total', $quantity);
        } else {
            DB::table('deck_cards')->insert([
                'deck_id' => $deckId,
                'card_id' => $cardId,
                'lang' => $lang,
                'variant' => $variant,
                'quantity_total' => $quantity,
                'quantity_owned' => 0,
                'is_commander' => false
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function updateQuantity(Request $request, $deckId, $cardId)
    {
        $validated = $request->validate([
            'type' => 'required|in:total,owned',
            'change' => 'required|integer',
            'variant' => 'nullable|string'
        ]);

        $variant = $validated['variant'] ?? 'nonfoil';
        $deckCard = DB::table('deck_cards')
            ->where('deck_id', $deckId)
            ->where('card_id', $cardId)
            ->where('variant', $variant)
            ->first();

        if (!$deckCard) {
            return response()->json(['success' => false, 'message' => 'Card not found'], 404);
        }

        if ($validated['type'] === 'total') {
            $newTotal = $deckCard->quantity_total + $validated['change'];
            if ($newTotal <= 0) {
                DB::table('deck_cards')->where('id', $deckCard->id)->delete();
            } else {
                DB::table('deck_cards')->where('id', $deckCard->id)->update(['quantity_total' => $newTotal]);
            }
        } else {
            $newOwned = $deckCard->quantity_owned + $validated['change'];
            $newOwned = max(0, min($newOwned, $deckCard->quantity_total));
            DB::table('deck_cards')->where('id', $deckCard->id)->update(['quantity_owned' => $newOwned]);
        }

        return response()->json(['success' => true]);
    }

    public function removeCard($deckId, $cardId)
    {
        DB::table('deck_cards')
            ->where('deck_id', $deckId)
            ->where('card_id', $cardId)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function destroy($deckId)
    {
        DB::table('decks')->where('id', $deckId)->delete();
        return response()->json(['success' => true]);
    }
}
