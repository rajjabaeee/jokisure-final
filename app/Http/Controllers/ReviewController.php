<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function listCompletedOrders()
    {
        // Get completed orders for the authenticated user
        $completedOrders = $this->getDummyOrders()->where('orderStatus.order_status_name', 'Completed');
        
        return view('reviews.list', compact('completedOrders'));
    }

    //
    private function getDummyOrders()
    {
        return collect([
            (object)[
                'order_id' => 'ORD-88888',
                'created_at' => now()->parse('2025-04-18'),
                'total_amount' => 25000,
                'orderStatus' => (object)['order_status_name' => 'Completed'],
                'orderItems' => collect([
                    (object)[
                        'service' => (object)[
                            'service_id' => 'SERV-001',
                            'service_desc' => 'Weekly Boss Run',
                            'game' => (object)['game_name' => 'Genshin Impact'],
                            'booster' => (object)['user' => (object)['user_name' => 'MonkeyD']]
                        ]
                    ]
                ])
            ],
            (object)[
                'order_id' => 'ORD-77777',
                'created_at' => now()->parse('2025-03-15'),
                'total_amount' => 30000,
                'orderStatus' => (object)['order_status_name' => 'Completed'],
                'orderItems' => collect([
                    (object)[
                        'service' => (object)[
                            'service_id' => 'SERV-002',
                            'service_desc' => 'Natlan Exploration',
                            'game' => (object)['game_name' => 'Genshin Impact'],
                            'booster' => (object)['user' => (object)['user_name' => 'DragonSlayer']]
                        ]
                    ]
                ])
            ],
            (object)[
                'order_id' => 'ORD-66666',
                'created_at' => now()->parse('2025-02-10'),
                'total_amount' => 20000,
                'orderStatus' => (object)['order_status_name' => 'In Progress'],
                'orderItems' => collect([
                    (object)[
                        'service' => (object)[
                            'service_id' => 'SERV-003',
                            'service_desc' => 'Inazuma Quest',
                            'game' => (object)['game_name' => 'Genshin Impact'],
                            'booster' => (object)['user' => (object)['user_name' => 'SamuraiX']]
                        ]
                    ]
                ])
            ]
        ]);
    }

    public function create($orderId)
    {
        $order = $this->getDummyOrders()->firstWhere('order_id', $orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order dummy tidak ditemukan.');
        }

        $item = $order->orderItems->first();

        return view('reviews.create', compact('order', 'item'));
    }

    public function store(Request $request, $orderId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $order = $this->getDummyOrders()->firstWhere('order_id', $orderId);
        $item = $order->orderItems->first();

        $newReview = [
            'service_id' => $item->service->service_id,
            'buyer_name' => Auth::user()->name ?? 'User Dummy',
            'rating' => $request->rating,
            'review_text' => $request->review,
            'created_at' => now(),
        ];

        Session::push('dummy_reviews', $newReview);

        return redirect()->route('reviews.index', $item->service->service_id)
                         ->with('success', 'Review berhasil ditambahkan (Simulasi)');
    }

    public function index($serviceId)
    {
        $staticReviews = collect([
            [
                'buyer_name' => 'Budi Gaming',
                'rating' => 5,
                'review_text' => 'Booster ramah banget, cepet kelar!',
                'created_at' => now()->subDays(2)
            ],
            [
                'buyer_name' => 'Siti Genshin',
                'rating' => 4,
                'review_text' => 'Oke sih, cuma agak lama antri.',
                'created_at' => now()->subDays(5)
            ]
        ]);

        $sessionReviews = collect(Session::get('dummy_reviews', []));
        $reviews = $sessionReviews->merge($staticReviews);
        $service = (object)[
            'game_name' => 'Genshin Impact',
            'service_desc' => 'Weekly Boss Run'
        ];

        return view('reviews.index', compact('reviews', 'service'));
    }
}