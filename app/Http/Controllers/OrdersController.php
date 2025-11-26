<?php

namespace App\Http\Controllers;

class OrdersController extends Controller
{
    public function detailWaitlist() { return view('orders.order-waitlist'); }
    public function detailPending()  { return view('orders.order-pending'); }
    public function detailProgress() { return view('orders.order-progress'); }
    public function detailCompleted(){ return view('orders.order-completed'); }
    public function trackPending()  { return view('orders.track-order-pending'); }
    public function trackProgress() { return view('orders.track-order-progress'); }
    public function trackCompleted(){ return view('orders.track-order-completed'); }
}
