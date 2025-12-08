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
    public function show(Request $request, $gameId)
    {
        $game = Game::with(['genres', 'services.booster.user', 'services.game'])->findOrFail($gameId);
        
        // Get all boosters for this game
        $boosters = $game->services->groupBy('booster_id')->map(fn($services) => $services->first()->booster);
        
        // Filter boosters
        $filteredBoosters = $boosters;
        
        // Search by booster name
        if ($request->has('search') && $request->search != '') {
            $filteredBoosters = $filteredBoosters->filter(function($booster) use ($request) {
                return stripos($booster->user->user_name, $request->search) !== false;
            });
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            switch ($request->rating) {
                case 'diamond':
                    $filteredBoosters = $filteredBoosters->filter(fn($b) => $b->booster_rating >= 4.5);
                    break;
                case 'gold':
                    $filteredBoosters = $filteredBoosters->filter(fn($b) => $b->booster_rating >= 3.5);
                    break;
                case 'silver':
                    $filteredBoosters = $filteredBoosters->filter(fn($b) => $b->booster_rating < 3.5);
                    break;
                case 'bestseller':
                    $filteredBoosters = $filteredBoosters->filter(fn($b) => $b->booster_rating >= 4.8);
                    break;
            }
        }
        
        // Sort
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'rating_desc':
                    $filteredBoosters = $filteredBoosters->sortByDesc('booster_rating')->values();
                    break;
                case 'rating_asc':
                    $filteredBoosters = $filteredBoosters->sortBy('booster_rating')->values();
                    break;
                case 'name_asc':
                    $filteredBoosters = $filteredBoosters->sortBy(fn($b) => $b->user->user_name)->values();
                    break;
                case 'name_desc':
                    $filteredBoosters = $filteredBoosters->sortByDesc(fn($b) => $b->user->user_name)->values();
                    break;
            }
        } else {
            // Default sort by rating descending
            $filteredBoosters = $filteredBoosters->sortByDesc('booster_rating')->values();
        }
        
        // Filter services for All Services tab
        $filteredServices = $game->services;
        
        // Search by service name
        if ($request->has('search') && $request->search != '') {
            $filteredServices = $filteredServices->filter(function($service) use ($request) {
                return stripos($service->service_name, $request->search) !== false;
            });
        }
        
        // Filter by service rating
        if ($request->has('rating') && $request->rating != '') {
            switch ($request->rating) {
                case 'diamond':
                    $filteredServices = $filteredServices->filter(fn($s) => $s->service_rating >= 4.5);
                    break;
                case 'gold':
                    $filteredServices = $filteredServices->filter(fn($s) => $s->service_rating >= 3.5);
                    break;
                case 'silver':
                    $filteredServices = $filteredServices->filter(fn($s) => $s->service_rating < 3.5);
                    break;
                case 'bestseller':
                    $filteredServices = $filteredServices->filter(fn($s) => $s->service_rating >= 4.8);
                    break;
            }
        }
        
        // Sort services
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'rating_desc':
                    $filteredServices = $filteredServices->sortByDesc('service_rating')->values();
                    break;
                case 'rating_asc':
                    $filteredServices = $filteredServices->sortBy('service_rating')->values();
                    break;
                case 'name_asc':
                    $filteredServices = $filteredServices->sortBy('service_name')->values();
                    break;
                case 'name_desc':
                    $filteredServices = $filteredServices->sortByDesc('service_name')->values();
                    break;
            }
        } else {
            // Default sort by rating descending
            $filteredServices = $filteredServices->sortByDesc('service_rating')->values();
        }
        
        return view('marketplace.game-detail', compact('game', 'filteredBoosters', 'filteredServices'));
    }
}
