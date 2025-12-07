<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Service;
use App\Models\Booster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    /**
     * Display the home page with games, featured boosters, and services
     */
    public function index(Request $request)
    {
        // Get all games for the game carousel, ordered by popularity
        $games = Game::select('game_id', 'game_name', 'game_rating')
            ->orderByDesc('game_rating')
            ->get();

        // Get featured boosters (top-rated boosters with user info)
        // Join with users table to get user details
        $featuredBoosters = Booster::with('user')
            ->where('verified', 1)  // Only verified boosters
            ->orderByDesc('booster_rating')
            ->orderByDesc('past_buyers')
            ->limit(8)
            ->get()
            ->map(function ($booster) {
                return (object) [
                    'booster_id' => $booster->booster_id,
                    'user_id' => $booster->user_id,
                    'user_name' => $booster->user->user_name ?? 'Unknown',
                    'user_rating' => $booster->booster_rating ?? 0,
                    'user_profile_pic' => $booster->user->user_profile_pic ?? null,
                    'past_buyers' => $booster->past_buyers ?? 0,
                    'booster_satisfaction' => $booster->booster_satisfaction ?? 0,
                ];
            });

        // Get featured services for the "For You" section
        // Include game and booster information with proper relationships
        $services = Service::with(['booster.user', 'game'])
            ->whereHas('booster', function ($query) {
                $query->where('verified', 1);
            })
            ->orderByDesc('service_rating')
            ->orderByDesc('service_id')  // Add some variation
            ->limit(6)
            ->get()
            ->map(function ($service) {
                $boosterUser = $service->booster && $service->booster->user 
                    ? $service->booster->user 
                    : null;
                    
                return (object) [
                    'service_id' => $service->service_id,
                    'booster_id' => $service->booster_id,
                    'game_id' => $service->game_id,
                    'game' => $service->game,
                    'game_name' => $service->game->game_name ?? 'Unknown Game',
                    'service_desc' => $service->service_desc ?? 'Service',
                    'est_time' => $service->est_time ?? '1-2 jam',
                    'service_price' => $service->service_price ?? 0,
                    'service_rating' => $service->service_rating ?? 0,
                    'booster_name' => $boosterUser->user_name ?? 'Unknown',
                    'booster_profile_pic' => $boosterUser->user_profile_pic ?? null,
                ];
            });

        return view('marketplace.home', [
            'games' => $games,
            'services' => $services,
            'featuredBoosters' => $featuredBoosters,
        ]);
    }

    /**
     * Get games filtered by genre or search
     */
    public function getGamesByGenre(Request $request)
    {
        $genre = $request->query('genre');
        $search = $request->query('search');

        $query = Game::query();

        if ($search) {
            $query->where('game_name', 'like', "%{$search}%");
        }

        $games = $query->orderByDesc('game_rating')->get();

        return response()->json([
            'success' => true,
            'data' => $games
        ]);
    }

    /**
     * Get featured boosters with pagination
     */
    public function getFeaturedBoosters(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $boosters = Booster::with('user')
            ->where('verified', 1)
            ->orderByDesc('booster_rating')
            ->orderByDesc('past_buyers')
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($booster) {
                return [
                    'booster_id' => $booster->booster_id,
                    'user_id' => $booster->user_id,
                    'user_name' => $booster->user->user_name,
                    'user_rating' => $booster->booster_rating,
                    'past_buyers' => $booster->past_buyers,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $boosters,
            'total' => Booster::where('verified', 1)->count()
        ]);
    }
}
