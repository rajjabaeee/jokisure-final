<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * List all games.
     */
    public function index()
    {
        $games = Game::all();
        return view('marketplace.games', compact('games'));
    }

    /**
     * Show a single game.
     */
    public function show($gameId)
    {
        $game = Game::findOrFail($gameId);
        return view('marketplace.game-detail', compact('game'));
    }
}
