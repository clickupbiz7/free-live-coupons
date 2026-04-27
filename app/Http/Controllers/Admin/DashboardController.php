<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /* ===============================
           BASIC COUNTS
        =============================== */
        $categories = Category::count();
        $stores     = Store::count();
        $coupons    = Coupon::count();
        $blogs      = Blog::count();

        $activeCoupons  = Coupon::whereDate('expiry_date', '>=', now())->count();
        $expiredCoupons = Coupon::whereDate('expiry_date', '<', now())->count();

        /* ===============================
           FILTER RANGE
        =============================== */
        $range = $request->range ?? 'all';

        $baseClickQuery = DB::table('coupon_clicks');

        if ($range == 'today') {
            $baseClickQuery->whereDate('coupon_clicks.created_at', today());
        }

        if ($range == '3days') {
            $baseClickQuery->where(
                'coupon_clicks.created_at',
                '>=',
                now()->subDays(3)
            );
        }

        if ($range == 'week') {
            $baseClickQuery->where(
                'coupon_clicks.created_at',
                '>=',
                now()->subDays(7)
            );
        }

        if ($range == 'month') {
            $baseClickQuery->whereMonth(
                'coupon_clicks.created_at',
                now()->month
            )->whereYear(
                'coupon_clicks.created_at',
                now()->year
            );
        }

        if ($range == 'year') {
            $baseClickQuery->whereYear(
                'coupon_clicks.created_at',
                now()->year
            );
        }

        /* ===============================
           CLICK COUNTS
        =============================== */
        $totalClicks = (clone $baseClickQuery)->count();

        $todayClicks = DB::table('coupon_clicks')
            ->whereDate('created_at', today())
            ->count();

        $weekClicks = DB::table('coupon_clicks')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        /* ===============================
           RECENT CLICKS
        =============================== */
        $recentClicks = (clone $baseClickQuery)
            ->leftJoin(
                'coupons',
                'coupon_clicks.coupon_id',
                '=',
                'coupons.id'
            )
            ->select(
                'coupon_clicks.id',
                'coupon_clicks.ip',
                'coupon_clicks.created_at',
                DB::raw('COALESCE(coupons.title, "Deleted Coupon") as title')
            )
            ->orderBy('coupon_clicks.id', 'DESC')
            ->take(10)
            ->get();

        /* ===============================
           TOP COUPONS
        =============================== */
        $topCoupons = (clone $baseClickQuery)
            ->leftJoin(
                'coupons',
                'coupon_clicks.coupon_id',
                '=',
                'coupons.id'
            )
            ->select(
                'coupon_clicks.coupon_id',
                DB::raw('COALESCE(coupons.title, "Deleted Coupon") as title'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(
                'coupon_clicks.coupon_id',
                'coupons.title'
            )
            ->orderByDesc('total')
            ->take(5)
            ->get();

        /* ===============================
           RECENT COUPONS
        =============================== */
        $recentCoupons = Coupon::latest()->take(5)->get();

        /* ===============================
           MONTHLY COUPONS
        =============================== */
        $months = [];
        $monthlyCoupons = [];

        for ($i = 1; $i <= 12; $i++) {

            $months[] = date('M', mktime(0, 0, 0, $i, 1));

            $monthlyCoupons[] = Coupon::whereMonth(
                'created_at',
                $i
            )->whereYear(
                'created_at',
                now()->year
            )->count();
        }

        /* ===============================
           LAST 7 DAYS CLICKS
        =============================== */
        $clickDays = [];
        $clickCounts = [];

        for ($i = 6; $i >= 0; $i--) {

            $day = now()->subDays($i);

            $clickDays[] = $day->format('D');

            $clickCounts[] = DB::table('coupon_clicks')
                ->whereDate(
                    'created_at',
                    $day->format('Y-m-d')
                )
                ->count();
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
            'monthlyCoupons',
            'totalClicks',
            'todayClicks',
            'weekClicks',
            'recentClicks',
            'topCoupons',
            'clickDays',
            'clickCounts',
            'range'
        ));
    }

    /* ===============================
       CHART DATA
    =============================== */
    public function chartData()
    {
        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {

            $months[] = date('M', mktime(0, 0, 0, $i, 1));

            $counts[] = Coupon::whereMonth(
                'created_at',
                $i
            )->whereYear(
                'created_at',
                now()->year
            )->count();
        }

        return response()->json([
            'months' => $months,
            'counts' => $counts
        ]);
    }

    /* ===============================
       REMOVE NOTIFICATION
    =============================== */
    public function removeNotification($id)
    {
        DB::table('admin_notifications')
            ->where('id', $id)
            ->delete();

        return back()->with(
            'success',
            'Notification removed successfully'
        );
    }

    /* ===============================
       CLEAR ALL CLICK DATA
    =============================== */
    public function clearClicks()
    {
        DB::table('coupon_clicks')->truncate();

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'All click data cleared successfully'
            );
    }
}