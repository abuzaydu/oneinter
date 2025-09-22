<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_bookings')) {
            abort(403);
        }
        
        $bookings = Booking::with(['car', 'category', 'driver'])->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        if (!auth()->user()->can('create_bookings')) {
            abort(403);
        }
        
        $categories = \App\Models\CarCategory::where('is_active', true)->get();
        return view('admin.bookings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_bookings')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'category_id' => 'required|exists:car_categories,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'pickup_location' => 'nullable|string|max:255',       
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'return_time' => 'required|date_format:H:i',
            'special_requests' => 'nullable|string',
            'destination' => 'required|in:within the city,out of the city',
            'region' => 'required_if:destination,out of the city|nullable|string|max:255',
            'nida' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,cancelled,completed,taken',
        ]);

        // Custom validation for datetime comparison
        $pickupDateTime = $validated['pickup_date'] . ' ' . $validated['pickup_time'];
        $returnDateTime = $validated['return_date'] . ' ' . $validated['return_time'];
        
        if (strtotime($returnDateTime) <= strtotime($pickupDateTime)) {
            return redirect()->back()
                ->withErrors(['return_time' => 'Return date and time must be after pickup date and time.'])
                ->withInput();
        }

        try {
            $category = \App\Models\CarCategory::findOrFail($validated['category_id']);

            // Calculate total amount using datetime
            $pickupCarbon = \Carbon\Carbon::parse($pickupDateTime);
            $returnCarbon = \Carbon\Carbon::parse($returnDateTime);
            $days = $pickupCarbon->diffInDays($returnCarbon);
            $dailyRate = $category->daily_rate ?? 0;
            $totalAmount = $dailyRate * $days;

            // Create booking (reference number will be auto-generated in the model)
            $bookingData = [
                'car_id' => null,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'pickup_location' => $validated['pickup_location'],
                'pickup_date' => $pickupDateTime,
                'return_date' => $returnDateTime,
                'special_requests' => $validated['special_requests'],
                'total_amount' => $totalAmount,
                'status' => $validated['status'],
                'destination' => $validated['destination'],
                'region' => $validated['region'],
                'nida' => $validated['nida'],
                'category_id' => $validated['category_id'],
            ];

            $booking = Booking::create($bookingData);

            // Send notification to admin
            \App\Models\Admin::first()?->notify(new \App\Notifications\NewBookingNotification($booking));

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking created successfully with reference number: ' . $booking->reference_number);

        } catch (\Exception $e) {
            \Log::error('Admin booking creation error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while creating the booking. Please try again.')
                ->withInput();
        }
    }

    public function show(Booking $booking)
    {
        if (!auth()->user()->can('view_bookings')) {
            abort(403);
        }
        
        $booking->load(['car', 'category', 'driver']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function checkout(Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }
        
        $booking->load(['car', 'category', 'driver']);
        
        // Get available cars from the same category as the booking
        $availableCars = Car::where('is_available', true)
                           ->where('category_id', $booking->category_id)
                           ->get();
        
        // Get available drivers (both active and available)
        $availableDrivers = Driver::where('is_active', true)
                                 ->where('is_available', true)
                                 ->get();
        
        return view('admin.bookings.checkout', compact('booking', 'availableCars', 'availableDrivers'));
    }

    public function processCheckout(Request $request, Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        try {
            // Check if car is still available
            $car = Car::findOrFail($validated['car_id']);
            if (!$car->is_available) {
                return redirect()->back()
                    ->with('error', 'Selected car is no longer available. Please choose another car.')
                    ->withInput();
            }

            // Check if driver is still available (if provided)
            if ($validated['driver_id']) {
                $driver = Driver::findOrFail($validated['driver_id']);
                if (!$driver->is_available) {
                    return redirect()->back()
                        ->with('error', 'Selected driver is no longer available. Please choose another driver.')
                        ->withInput();
                }
            }

            // Update booking
            $booking->update([
                'car_id' => $validated['car_id'],
                'driver_id' => $validated['driver_id'],
                'status' => 'taken'
            ]);

            // Update car availability
            $car->update(['is_available' => false]);

            // Update driver availability (if assigned)
            if ($validated['driver_id']) {
                $driver->update(['is_available' => false]);
            }

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking checked out successfully. Car and driver have been assigned.');

        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred during checkout. Please try again.')
                ->withInput();
        }
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,taken,completed,cancelled',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking status updated successfully.');
    }

    public function returnCar(Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }
        
        try {
            // Update booking status
            $booking->update(['status' => 'completed']);

            // Free up the car
            if ($booking->car) {
                $booking->car->update(['is_available' => true]);
            }

            // Free up the driver
            if ($booking->driver) {
                $booking->driver->update(['is_available' => true]);
            }

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Car and driver returned successfully. Booking marked as completed.');

        } catch (\Exception $e) {
            \Log::error('Return car error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while returning the car. Please try again.');
        }
    }

    public function returnCarOnly(Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }
        
        try {
            // Free up the car and driver but keep booking active
            if ($booking->car) {
                $booking->car->update(['is_available' => true]);
            }

            if ($booking->driver) {
                $booking->driver->update(['is_available' => true]);
            }

            // Remove car and driver from booking
            $booking->update([
                'car_id' => null,
                'driver_id' => null,
                'status' => 'confirmed'
            ]);

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Car and driver returned successfully. Booking is still active and can be reassigned.');

        } catch (\Exception $e) {
            \Log::error('Return car only error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while returning the car. Please try again.');
        }
    }

    public function destroy(Booking $booking)
    {
        if (!auth()->user()->can('delete_bookings')) {
            abort(403);
        }
        
        try {
            // Free up car and driver if assigned
            if ($booking->car) {
                $booking->car->update(['is_available' => true]);
            }

            if ($booking->driver) {
                $booking->driver->update(['is_available' => true]);
            }

            $booking->delete();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Delete booking error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the booking. Please try again.');
        }
    }

    /**
     * Show the extend trip form
     */
    public function extendTrip(Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }

        if ($booking->status !== 'taken') {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Trip can only be extended when the car is taken.');
        }

        return view('admin.bookings.extend-trip', compact('booking'));
    }

    /**
     * Process the trip extension
     */
    public function processExtendTrip(Request $request, Booking $booking)
    {
        if (!auth()->user()->can('edit_bookings')) {
            abort(403);
        }

        $validated = $request->validate([
            'new_return_date' => 'required|date|after:' . $booking->return_date->format('Y-m-d'),
        ]);

        try {
            DB::beginTransaction();

            $oldReturnDate = $booking->return_date;
            $newReturnDate = Carbon::parse($validated['new_return_date']);
            
            // Calculate additional days
            $additionalDays = $oldReturnDate->diffInDays($newReturnDate);
            
            // Calculate additional amount based on daily rate
            $dailyRate = 0;
            if ($booking->car && $booking->car->category) {
                $dailyRate = $booking->car->category->daily_rate;
            } elseif ($booking->category) {
                $dailyRate = $booking->category->daily_rate;
            }
            
            $additionalAmount = $dailyRate * $additionalDays;
            $newTotalAmount = $booking->total_amount + $additionalAmount;

            // Update booking
            $booking->update([
                'return_date' => $newReturnDate,
                'total_amount' => $newTotalAmount,
            ]);

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', "Trip extended successfully! Return date changed from {$oldReturnDate->format('M d, Y')} to {$newReturnDate->format('M d, Y')}. Additional amount: $" . number_format($additionalAmount, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Trip extension error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while extending the trip. Please try again.')
                ->withInput();
        }
    }

    private function calculateBookingAmount($category, $pickupDate, $returnDate)
    {
        $days = $pickupDate->diffInDays($returnDate);
        $dailyRate = $category->daily_rate ?? 0;
        return $dailyRate * $days;
    }

    /**
     * Export bookings to Excel
     */
    public function exportExcel(Request $request)
    {
        // Only admin users can export
        if (!auth()->user()->can('view_bookings') || !auth()->user()->role || auth()->user()->role->name !== 'admin') {
            abort(403, 'Only administrators can export reports.');
        }

        $status = $request->get('status', 'all');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        
        // Build filename with date range info
        $filename = 'bookings_' . ($status === 'all' ? 'all' : $status);
        if ($fromDate && $toDate) {
            $filename .= '_' . $fromDate . '_to_' . $toDate;
        } elseif ($fromDate) {
            $filename .= '_from_' . $fromDate;
        } elseif ($toDate) {
            $filename .= '_to_' . $toDate;
        }
        $filename .= '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BookingsExport($status, $fromDate, $toDate),
            $filename
        );
    }

    /**
     * Export bookings to PDF
     */
    public function exportPdf(Request $request)
    {
        // Only admin users can export
        if (!auth()->user()->can('view_bookings') || !auth()->user()->role || auth()->user()->role->name !== 'admin') {
            abort(403, 'Only administrators can export reports.');
        }

        $status = $request->get('status', 'all');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        
        $query = Booking::with(['car', 'category', 'driver']);
        
        // Filter by status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Filter by date range
        if ($fromDate) {
            $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($fromDate));
        }
        
        if ($toDate) {
            $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($toDate));
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        // Build filename with date range info
        $filename = 'bookings_' . ($status === 'all' ? 'all' : $status);
        if ($fromDate && $toDate) {
            $filename .= '_' . $fromDate . '_to_' . $toDate;
        } elseif ($fromDate) {
            $filename .= '_from_' . $fromDate;
        } elseif ($toDate) {
            $filename .= '_to_' . $toDate;
        }
        $filename .= '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bookings.export-pdf', compact('bookings', 'status', 'fromDate', 'toDate'));
        
        return $pdf->download($filename);
    }
} 