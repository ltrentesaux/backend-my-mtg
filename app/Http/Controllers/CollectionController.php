<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index($userId)
    {
        $collection = DB::table('collections')->where('user_id', $userId)->get();
        return response()->json(['success' => true, 'collection' => $collection]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'card_id' => 'required|string',
        ]);

        $cardId = $validated['card_id'];
        $lang = $request->input('lang', 'fr');
        $variant = $request->input('variant', 'nonfoil');

        // Check if exists
        $existing = DB::table('collections')
            ->where('user_id', $validated['user_id'])
            ->where('card_id', $cardId)
            ->where('variant', $variant)
            ->first();

        if ($existing) {
            DB::table('collections')->where('id', $existing->id)->increment('quantity');
        } else {
            DB::table('collections')->insert([
                'user_id' => $validated['user_id'],
                'card_id' => $cardId,
                'lang' => $lang,
                'variant' => $variant,
                'quantity' => 1
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function updateQuantity(Request $request, $userId, $cardId)
    {
        $validated = $request->validate([
            'change' => 'required|integer',
            'variant' => 'nullable|string'
        ]);

        $variant = $validated['variant'] ?? 'nonfoil';
        
        $collectionCard = DB::table('collections')
            ->where('user_id', $userId)
            ->where('card_id', $cardId)
            ->where('variant', $variant)
            ->first();

        if (!$collectionCard) {
            return response()->json(['success' => false, 'message' => 'Card not found in collection'], 404);
        }

        $newQuantity = $collectionCard->quantity + $validated['change'];

        if ($newQuantity <= 0) {
            DB::table('collections')->where('id', $collectionCard->id)->delete();
        } else {
            DB::table('collections')->where('id', $collectionCard->id)->update(['quantity' => $newQuantity]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $userId, $cardId)
    {
        $variant = $request->query('variant', 'nonfoil');

        DB::table('collections')
            ->where('user_id', $userId)
            ->where('card_id', $cardId)
            ->where('variant', $variant)
            ->delete();

        return response()->json(['success' => true]);
    }
}
