<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * List all games.
     */
    public function index(Request $request)
    {
        // Get top 6 games by rating for popular section (consistent across all pages)
        $popularGames = Game::orderBy('game_rating', 'desc')->take(6)->get();
        
        // Build query for all games with search, filter, and sort
        $query = Game::query();
        
        // Search by game name
        if ($request->has('search') && $request->search != '') {
            $query->where('game_name', 'LIKE', '%' . $request->search . '%');
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            switch ($request->rating) {
                case 'top':
                    $query->where('game_rating', '>=', 4.5);
                    break;
                case 'popular':
                    $query->where('game_rating', '>=', 3.5);
                    break;
                case 'trending':
                    $query->where('game_rating', '>=', 3.0);
                    break;
            }
        }
        
        // Sort by rating or name
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'rating_desc':
                    $query->orderBy('game_rating', 'desc');
                    break;
                case 'rating_asc':
                    $query->orderBy('game_rating', 'asc');
                    break;
                case 'name_asc':
                    $query->orderBy('game_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('game_name', 'desc');
                    break;
            }
        } else {
            // Default sort by rating descending
            $query->orderBy('game_rating', 'desc');
        }
        
        // Paginate 12 games per page (4 rows x 3 columns)
        $games = $query->paginate(12);
        
        return view('marketplace.games', compact('games', 'popularGames'));
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
