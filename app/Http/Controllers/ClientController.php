<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\CarCategory;
use App\Notifications\NewBookingNotification;
use App\Models\Admin;

class ClientController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $favoriteCategories = CarCategory::where('is_active', true)
                                        ->where('is_favorite', true)
                                        ->get();
        return view('client.index', compact('favoriteCategories'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('client.about');
    }

    /**
     * Display the cars page
     */
    public function cars()
    {
        $categories = CarCategory::where('is_active', true)->get();
        return view('client.cars', compact('categories'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('client.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Here you can add logic to send email, save to database, etc.
        // For now, we'll just redirect with a success message
        
        \Log::info('Contact form submission:', $validated);

        return redirect()->route('client.contact')
            ->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }

    /**
     * Display the quick booking page
     */
    public function quickBooking(Request $request)
    {
        $categories = CarCategory::where('is_active', true)->get();
        $selectedCategory = $request->get('category');
        
        return view('client.quick-booking', compact('categories', 'selectedCategory'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:car_categories,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'pickup_location' => 'required|string|max:255',       
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'return_time' => 'required|date_format:H:i',
            'special_requests' => 'nullable|string',
            'destination' => 'required|in:within the city,out of the city',
            'region' => 'required_if:destination,out of the city|nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'organization' => 'nullable|string|max:255',
            'id_type' => 'required|in:nida,passport',
            'id_number' => 'required|string|max:255',
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
            DB::beginTransaction();

            $category = CarCategory::findOrFail($validated['category_id']);

            // Create booking with category data
            $bookingData = [
                'car_id' => null, // We'll need to assign an available car later      
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'pickup_location' => $validated['pickup_location'],
                'pickup_date' => $pickupDateTime, // Combined date and time
                'return_date' => $returnDateTime, // Combined date and time
                'special_requests' => $validated['special_requests'],
                'total_amount' => $this->calculateBookingAmount($category, $pickupDateTime, $returnDateTime),
                'status' => 'pending',
                'destination' => $validated['destination'],
                'region' => $validated['region'],
                'color' => $validated['color'],
                'organization' => $validated['organization'],
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],
                'category_id' => $validated['category_id'],
            ];

            $booking = Booking::create($bookingData);

            // Commit the transaction first to ensure booking is saved
            DB::commit();

            // Send notification to all admins (users with role_id = 1) - but don't fail if it doesn't work
            try {
                $admins = \App\Models\User::getAdmins();
                \Log::info('Sending booking notification to ' . $admins->count() . ' admins');
                
                foreach ($admins as $admin) {
                    try {
                        \Log::info('Sending notification to admin: ' . $admin->name . ' (' . $admin->email . ')');
                        $admin->notify(new \App\Notifications\NewBookingNotification($booking));
                    } catch (\Exception $notificationError) {
                        // Log the notification error but don't fail the entire process
                        \Log::warning('Failed to send notification to admin ' . $admin->email . ': ' . $notificationError->getMessage());
                    }
                }
            } catch (\Exception $notificationError) {
                // Log the general notification error but don't fail the entire process
                \Log::warning('Failed to process admin notifications: ' . $notificationError->getMessage());
            }

            return redirect()->route('client.quick-booking')
                ->with('success', 'Your booking has been submitted successfully with reference number: ' . $booking->reference_number . '. We will contact you shortly.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the detailed error for debugging
            \Log::error('Booking error: ' . $e->getMessage());
            \Log::error('Booking error trace: ' . $e->getTraceAsString());
            \Log::error('Booking data: ' . json_encode($validated));
            
            return redirect()->back()
                ->with('error', 'An error occurred while processing your booking. Please try again.')
                ->withInput();
        }
    }

    /**
     * Get available colors for a specific category
     */
    public function getAvailableColors(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json(['colors' => []]);
        }

        $colors = Booking::getAvailableColors($categoryId);
        
        return response()->json(['colors' => $colors]);
    }

    private function calculateBookingAmount($category, $pickupDate, $returnDate)
    {
        $days = \Carbon\Carbon::parse($pickupDate)->diffInDays(\Carbon\Carbon::parse($returnDate));
        $dailyRate = $category->daily_rate ?? 0;
        return $dailyRate * $days;
    }
} 