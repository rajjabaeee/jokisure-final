<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booster;

class BoosterController extends Controller
{
    /**
     * Display a listing of all boosters.
     */
    public function index(Request $request)
    {
        // Start query with user relationship
        $query = Booster::with('user');

        // Search by booster name
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('user_name', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            switch ($request->rating) {
                case 'diamond':
                    $query->where('booster_rating', '>=', 45);
                    break;
                case 'gold':
                    $query->where('booster_rating', '>=', 35)
                          ->where('booster_rating', '<', 45);
                    break;
                case 'silver':
                    $query->where('booster_rating', '<', 35);
                    break;
                case 'bestseller':
                    $query->where('booster_rating', '>=', 48);
                    break;
            }
        }

        // Sort by
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'rating_desc':
                    $query->orderByDesc('booster_rating');
                    break;
                case 'rating_asc':
                    $query->orderBy('booster_rating');
                    break;
                case 'name_asc':
                    $query->join('user', 'booster.user_id', '=', 'user.user_id')
                          ->orderBy('user.user_name', 'asc')
                          ->select('booster.*');
                    break;
                case 'name_desc':
                    $query->join('user', 'booster.user_id', '=', 'user.user_id')
                          ->orderBy('user.user_name', 'desc')
                          ->select('booster.*');
                    break;
            }
        } else {
            // Default sort by rating descending
            $query->orderByDesc('booster_rating');
        }

        // Paginate results
        $boosters = $query->paginate(20);
        
        return view('marketplace.boosters', compact('boosters'));
    }

    /**
     * Show a booster's profile by ID.
     */
    public function show(Request $request, Booster $booster)
    {
        // Load relationships
        $booster->load(['user', 'services.game', 'tags']);

        // Format booster data for view
        $boosterData = [
            'name' => $booster->user->user_name,
            'avatar' => asset('assets/' . str()->slug($booster->user->user_name) . '.jpg'),
            'banner' => asset('assets/' . str()->slug($booster->user->user_name) . '-bg.jpg'),
            'verified' => $booster->verified,
            'online' => true, // You can add online status to booster table if needed
            'badges' => $booster->tags->pluck('seller_tag_name')->toArray() ?? [],
            'about' => $booster->booster_desc ?? 'No description available',
            'work_hours' => substr($booster->work_start ?? '00:00', 0, 5) . ' - ' . substr($booster->work_end ?? '23:59', 0, 5),
            'satisfaction' => $booster->booster_satisfaction . '%',
            'customers' => $booster->past_buyers ?? 0,
        ];

        // Format games data (get unique games from booster's services)
        $games = $booster->services()
            ->with('game')
            ->get()
            ->pluck('game')
            ->unique('game_id')
            ->map(function($game) {
                return [
                    'game_name' => $game->game_name,
                    'poster' => asset('assets/' . str()->slug($game->game_name) . '.jpg'),
                ];
            })
            ->values()
            ->toArray();

        // Start services query
        $servicesQuery = $booster->services()->with('game');

        // Filter by service type
        if ($request->has('filter') && $request->filter != '' && $request->filter != 'all') {
            $filterType = $request->filter;
            $servicesQuery->where('service_name', 'like', "%{$filterType}%");
        }

        // Sort services
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'price_asc':
                    $servicesQuery->orderBy('service_price', 'asc');
                    break;
                case 'price_desc':
                    $servicesQuery->orderBy('service_price', 'desc');
                    break;
                case 'rating_asc':
                    $servicesQuery->orderBy('service_rating', 'asc');
                    break;
                case 'rating_desc':
                    $servicesQuery->orderBy('service_rating', 'desc');
                    break;
            }
        }

        // Format services data
        $services = $servicesQuery->get()->map(function($service) {
            return [
                'service_name' => $service->service_name ?? 'Service',
                'game_name' => $service->game->game_name ?? 'Unknown Game',
                'price' => $service->service_price ?? 0,
                'thumb' => asset('assets/' . str()->slug($service->game->game_name) . '.jpg'),
                'sold' => rand(10, 100) . ' sold', // You can add this to service table if needed
                'rating' => '★ ' . number_format($service->service_rating / 10 ?? 4.5, 1),
                'status' => 'Open', // You can add this to service table if needed
            ];
        })->toArray();

        return view('booster.booster-profile', [
            'booster' => $boosterData,
            'booster_id' => $booster->booster_id,
            'games' => $games,
            'services' => $services,
        ]);
    }
}
