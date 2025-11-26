<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoosterController extends Controller
{
    public function show(string $username = 'BangBoost')
    {
        // ------- DUMMY DATA (tanpa DB) -------
        $booster = [
            'username'    => $username,
            'name'        => $username,
            'avatar'      => asset('assets/images/pp.jpg'),
            'banner'      => asset('assets/images/booster banner.jpg'),
            'verified'    => true,
            'online'      => true,
            'about'       => 'EN/ID GMT+7 | Email: bangboost@gmail.com<br/>Call me Bang!',
            'work_hours'  => '09.00 WIB - 22.00 WIB',
            'satisfaction'=> '98%',
            'customers'   => '1000+',
            'badges'      => ['Diamond Booster', 'May Best Seller'],
        ];

        $games = [
            ['game_name' => 'Genshin Impact',      'poster' => asset('assets/images/genshin.jpg')],
            ['game_name' => 'Zenless Zone Zero',   'poster' => asset('assets/images/zzz.jpg')],
            ['game_name' => 'Honkai: Star Rail',   'poster' => asset('assets/images/honkai.jpg')],
        ];

        $services = [
        [
            'service_name' => 'Genshin | Abyss',
            'game_name'    => 'Genshin Impact',
            'price'        => 60000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/abyss.jpg'),
            'sold'         => '300 sold',
            'rating'       => '★ 4.8 (120)',
        ],
        [
            'service_name' => 'Explore Inazuma 100%',
            'game_name'    => 'Genshin Impact',
            'price'        => 80000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/inazuma.png'),
            'sold'         => '49 sold',
            'rating'       => '★ 4.9 (7)',
        ],
        [
            'service_name' => 'Boss Mats Weekly',
            'game_name'    => 'Genshin Impact',
            'price'        => 75000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/genshin boss.png'),
            'sold'         => '210 sold',
            'rating'       => '★ 4.7 (88)',
        ],
        [
            'service_name' => 'Explore Map Fontaine',
            'game_name'    => 'Genshin Impact',
            'price'        => 70000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/fontaine.png'),
            'sold'         => '160 sold',
            'rating'       => '★ 4.6 (54)',
        ],
        [
            'service_name' => 'Explore Map Liyue',
            'game_name'    => 'Genshin Impact',
            'price'        => 50000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/liyue.png'),
            'sold'         => '95 sold',
            'rating'       => '★ 4.8 (33)',
        ],
        [
            'service_name' => 'Explore Map Mondstadt',
            'game_name'    => 'Genshin Impact',
            'price'        => 45000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/Monstandt.png'),
            'sold'         => '180 sold',
            'rating'       => '★ 4.7 (62)',
        ],
        [
            'service_name' => 'Explore Map Sumeru',
            'game_name'    => 'Genshin Impact',
            'price'        => 55000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/Sumeru.png'),
            'sold'         => '120 sold',
            'rating'       => '★ 4.7 (41)',
        ],
        [
            'service_name' => 'Explore Map Dragonspine',
            'game_name'    => 'Genshin Impact',
            'price'        => 90000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/dragonspine.png'),
            'sold'         => '58 sold',
            'rating'       => '★ 4.9 (29)',
        ],
        [
            'service_name' => 'Explore Map Enkanomiya',
            'game_name'    => 'Genshin Impact',
            'price'        => 30000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/enkanomiya.png'),
            'sold'         => '420 sold',
            'rating'       => '★ 4.8 (150)',
        ],
        [
            'service_name' => 'Explore Map Natlan',
            'game_name'    => 'Genshin Impact',
            'price'        => 65000,
            'status'       => 'open',
            'thumb'        => asset('assets/images/Natlan.png'),
            'sold'         => '77 sold',
            'rating'       => '★ 4.6 (25)',
            ],
        ];

        // -------------------------------------

        return view('booster.profile', compact('booster','games','services'));
    }
}
