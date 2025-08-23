<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        $users = User::all();
        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();
        $ordersYday  = Order::whereDate('created_at', Carbon::yesterday())->count();

        // % delta vs yesterday (with sign and %). If yesterday is 0, show "+0%"
        $ordersDelta = '+0%';
        if ($ordersYday > 0) {
            $pct = (($ordersToday - $ordersYday) / $ordersYday) * 100;
            $ordersDelta = sprintf('%+d%%', round($pct));
        }

        // --- Last 7 days trend (single SQL + fill missing days) ---
        $start = Carbon::today()->subDays(6);      // 6,5,4,3,2,1,0 => 7 bars
        $end   = Carbon::today();

        // One query grouped by DATE(created_at)
        $raw = Order::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->groupBy('d')
            ->pluck('c', 'd'); // ['2025-08-03' => 12, ...]

        // Build exact 7-length array in chronological order, filling zeros
        $ordersTrend = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $key = $cursor->toDateString();
            $ordersTrend[] = (int) ($raw[$key] ?? 0);
            $cursor->addDay();
        }

        // --- Revenue today ---
        $revenueToday = Order::whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // --- Last 7 days revenue trend (sum per day, oldest -> newest) ---
        $start = Carbon::today()->subDays(6);
        $end   = Carbon::today();

        $raw = Order::selectRaw('DATE(created_at) as d, SUM(total_amount) as s')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->groupBy('d')
            ->pluck('s', 'd'); // ['2025-08-03' => 120.50, ...]

        $revenueTrend = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $key = $cursor->toDateString();
            $revenueTrend[] = (float) ($raw[$key] ?? 0);
            $cursor->addDay();
        }

        return view('admin.dashboard',
            compact('products', 'users', 'ordersToday'), [
                'ordersToday'  => $ordersToday,
                'ordersDelta'  => $ordersDelta,
                'ordersTrend'  => $ordersTrend,
                'revenueToday' => $revenueToday,
                'revenueTrend' => $revenueTrend,
            ]
        );
    }
}
