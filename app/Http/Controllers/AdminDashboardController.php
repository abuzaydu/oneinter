<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Driver;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Bookings per month for the last 12 months
        $months = collect(range(0, 11))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        })->reverse();

        $bookingsPerMonth = $months->mapWithKeys(function ($month) {
            $count = Booking::whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
            return [$month => $count];
        });

        $completedPerMonth = $months->mapWithKeys(function ($month) {
            $count = Booking::where('status', 'completed')
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
            return [$month => $count];
        });

        $completedBookings = Booking::where('status', 'completed')->count();
        $takenBookings = Booking::where('status', 'taken')->count();
        $totalCars = Car::count();
        $totalDrivers = Driver::count();

        return view('admin.dashboard', [
            'bookingsPerMonth' => $bookingsPerMonth,
            'completedPerMonth' => $completedPerMonth,
            'completedBookings' => $completedBookings,
            'takenBookings' => $takenBookings,
            'totalCars' => $totalCars,
            'totalDrivers' => $totalDrivers,
        ]);
    }
} 