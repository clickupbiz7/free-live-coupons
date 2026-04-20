<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Blog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // COUNTS
        $categories = Category::count();
        $stores = Store::count();
        $coupons = Coupon::count();
        $blogs = Blog::count();

        // STATUS COUNTS
        $activeCoupons = Coupon::whereDate('expiry_date', '>=', now())->count();
        $expiredCoupons = Coupon::whereDate('expiry_date', '<', now())->count();

        // FILTER (MONTH)
        $query = Coupon::query();

        if ($request->month) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        // RECENT COUPONS
        $recentCoupons = $query->latest()->take(5)->get();

        // CHART DATA
        $months = [];
        $monthlyCoupons = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date("M", mktime(0, 0, 0, $i, 1));
            $monthlyCoupons[] = Coupon::whereMonth('created_at', $i)->count();
        }

        return view('admin.dashboard', compact(
            'categories',
            'stores',
            'coupons',
            'blogs',
            'activeCoupons',
            'expiredCoupons',
            'recentCoupons',
            'months',
            'monthlyCoupons'
        ));
    }

    // REAL-TIME CHART API
    public function chartData()
    {
        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date("M", mktime(0, 0, 0, $i, 1));
            $counts[] = Coupon::whereMonth('created_at', $i)->count();
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }
}