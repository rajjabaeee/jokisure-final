<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booster;
use App\Models\Review;
use App\Models\WorkOrder;

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
            'user_id' => $booster->user_id,
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
                    'game_id' => $game->game_id,
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
            // Get service image based on name and description
            $imageName = $this->getServiceImageName($service);
            
            return [
                'service_id' => $service->service_id,
                'service_name' => $service->service_name ?? 'Service',
                'game_name' => $service->game->game_name ?? 'Unknown Game',
                'price' => $service->service_price ?? 0,
                'thumb' => asset('assets/' . $imageName),
                'sold' => rand(10, 100) . ' sold', // You can add this to service table if needed
                'rating' => '★ ' . number_format($service->service_rating ?? 4.5, 1),
                'status' => 'Open', // You can add this to service table if needed
            ];
        })->toArray();

        // Get reviews for this booster's services
        $reviews = Review::whereIn('service_id', $booster->services->pluck('service_id'))
            ->with(['buyer.user', 'service'])
            ->orderByDesc('user_rating')
            ->get()
            ->map(function($review) {
                return [
                    'user_name' => $review->buyer->user->user_name ?? 'Anonymous',
                    'user_initial' => substr($review->buyer->user->user_name ?? 'A', 0, 1),
                    'rating' => $review->user_rating,
                    'review_text' => $review->user_review,
                    'service_name' => $review->service->service_name ?? 'Service',
                    'stars' => str_repeat('★', $review->user_rating) . str_repeat('☆', 5 - $review->user_rating)
                ];
            });

        // Calculate rating statistics
        $ratingStats = [
            'total' => $reviews->count(),
            'average' => $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0,
            'distribution' => [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ]
        ];

        // Get work queue orders for this booster
        $workQueueOrders = WorkOrder::whereHas('orderItems.service', function($q) use ($booster) {
            $q->where('booster_id', $booster->booster_id);
        })
        ->with(['orderItems.service.game', 'orderItems.buyer.user', 'orderStatus'])
        ->orderBy('order_date', 'desc')
        ->get();

        return view('booster.booster-profile', [
            'booster' => $boosterData,
            'booster_id' => $booster->booster_id,
            'games' => $games,
            'services' => $services,
            'reviews' => $reviews,
            'rating_stats' => $ratingStats,
            'referrer' => $request->get('referrer', 'home'), // Default to home if no referrer
            'workQueueOrders' => $workQueueOrders,
        ]);
    }
    
    /**
     * Get service image name based on service name and description
     */
    private function getServiceImageName($service)
    {
        $serviceName = strtolower($service->service_name ?? '');
        $serviceDesc = strtolower($service->service_desc ?? '');
        
        // Check for specific service types
        if (str_contains($serviceName, 'abyss') || str_contains($serviceDesc, 'abyss')) {
            return 'abyss.jpg';
        } elseif (str_contains($serviceName, 'inazuma') || str_contains($serviceDesc, 'inazuma')) {
            return 'inazuma.png';
        } elseif (str_contains($serviceName, 'liyue') || str_contains($serviceDesc, 'liyue')) {
            return 'liyue.png';
        } elseif (str_contains($serviceName, 'mondstadt') || str_contains($serviceDesc, 'mondstadt')) {
            return 'Monstandt.png';
        } elseif (str_contains($serviceName, 'fontaine') || str_contains($serviceDesc, 'fontaine')) {
            return 'fontaine.png';
        } elseif (str_contains($serviceName, 'sumeru') || str_contains($serviceDesc, 'sumeru')) {
            return 'Sumeru.png';
        } elseif (str_contains($serviceName, 'dragonspine') || str_contains($serviceDesc, 'dragonspine')) {
            return 'Dragonspine.png';
        } elseif (str_contains($serviceName, 'enkanomiya') || str_contains($serviceDesc, 'enkanomiya')) {
            return 'enkanomiya.png';
        } elseif (str_contains($serviceName, 'natlan') || str_contains($serviceDesc, 'natlan')) {
            return 'Natlan.png';
        } elseif (str_contains($serviceName, 'chasm') || str_contains($serviceDesc, 'chasm')) {
            return 'Chasm.png';
        } else {
            // Default to game image
            $gameName = strtolower($service->game->game_name ?? 'genshin-impact');
            return str_replace(' ', '-', $gameName) . '.jpg';
        }
    }
}
