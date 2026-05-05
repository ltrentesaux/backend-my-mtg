<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deck_format', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->text('description')->nullable();
            $table->integer('quantity_of_cards');
        });

        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('card_id', 100)->index();
            $table->string('lang', 10)->default('fr');
            $table->integer('quantity')->default(1);
            $table->enum('variant', ['nonfoil', 'foil'])->default('nonfoil');
            $table->timestamp('created_at')->useCurrent();
            
            $table->unique(['user_id', 'card_id', 'variant'], 'uniq_user_card_variant');
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('card_id', 100)->index();
            $table->string('lang', 10)->default('fr');
            $table->enum('variant', ['nonfoil', 'foil'])->default('nonfoil');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('wanted', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('card_id', 100)->index();
            $table->string('lang', 10)->default('fr');
            $table->enum('variant', ['nonfoil', 'foil'])->default('nonfoil');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('deck_format_id')->constrained('deck_format')->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('deck_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained('decks')->onDelete('cascade');
            $table->string('card_id', 100)->index();
            $table->string('lang', 10)->default('fr');
            $table->enum('variant', ['nonfoil', 'foil'])->default('nonfoil');
            $table->integer('quantity_owned')->default(0);
            $table->integer('quantity_total');
            $table->boolean('is_commander')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deck_cards');
        Schema::dropIfExists('decks');
        Schema::dropIfExists('wanted');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('deck_format');
    }
};
