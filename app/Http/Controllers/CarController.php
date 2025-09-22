<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarCategory;
use Illuminate\Http\Request;


class CarController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_cars')) {
            abort(403);
        }
        
        $cars = Car::with('category')->latest()->paginate(10);
        return view('admin.cars.cars', compact('cars'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_cars')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:cars',
            'color' => 'required|string|max:50',
            'chassis_number' => 'required|string|max:50|unique:cars',
        ]);

        // Find the category ID based on the selected car name
        $category = CarCategory::where('name', $validated['name'])->first();
        if (!$category) {
            return redirect()->back()
                ->withErrors(['name' => 'Selected car name does not match any category.'])
                ->withInput();
        }

        // Create car with only required fields
        $carData = [
            'name' => $validated['name'],
            'category_id' => $category->id,
            'plate_number' => $validated['plate_number'],
            'color' => $validated['color'],
            'chassis_number' => $validated['chassis_number'],
            'is_available' => true, // Default to available
        ];

        Car::create($carData);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car added successfully.');
    }

    public function update(Request $request, Car $car)
    {
        if (!auth()->user()->can('edit_cars')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $car->id,
            'color' => 'required|string|max:50',
            'chassis_number' => 'required|string|max:50|unique:cars,chassis_number,' . $car->id,
        ]);

        // Find the category ID based on the selected car name
        $category = CarCategory::where('name', $validated['name'])->first();
        if (!$category) {
            return redirect()->back()
                ->withErrors(['name' => 'Selected car name does not match any category.'])
                ->withInput();
        }

        // Update car with only required fields
        $carData = [
            'name' => $validated['name'],
            'category_id' => $category->id,
            'plate_number' => $validated['plate_number'],
            'color' => $validated['color'],
            'chassis_number' => $validated['chassis_number'],
        ];

        $car->update($carData);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        if (!auth()->user()->can('delete_cars')) {
            abort(403);
        }
        
        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully.');
    }

    public function create()
    {
        if (!auth()->user()->can('create_cars')) {
            abort(403);
        }
        
        $categories = CarCategory::where('is_active', true)->get();
        $seatOptions = Car::getSeatOptions();
        $doorOptions = Car::getDoorOptions();
        
        return view('admin.cars.create', compact('categories', 'seatOptions', 'doorOptions'));
    }

    public function edit(Car $car)
    {
        if (!auth()->user()->can('edit_cars')) {
            abort(403);
        }
        
        $categories = CarCategory::where('is_active', true)->get();
        $seatOptions = Car::getSeatOptions();
        $doorOptions = Car::getDoorOptions();
        
        return view('admin.cars.edit', compact('car', 'categories', 'seatOptions', 'doorOptions'));
    }

    /**
     * Export cars to Excel
     */
    public function exportExcel(Request $request)
    {
        // Only admin users can export
        if (!auth()->user()->can('view_cars') || !auth()->user()->role || auth()->user()->role->name !== 'admin') {
            abort(403, 'Only administrators can export reports.');
        }

        $status = $request->get('status', 'all');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        
        // Build filename with date range info
        $filename = 'cars_' . ($status === 'all' ? 'all' : $status);
        if ($fromDate && $toDate) {
            $filename .= '_' . $fromDate . '_to_' . $toDate;
        } elseif ($fromDate) {
            $filename .= '_from_' . $fromDate;
        } elseif ($toDate) {
            $filename .= '_to_' . $toDate;
        }
        $filename .= '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CarsExport($status, $fromDate, $toDate),
            $filename
        );
    }

    /**
     * Export cars to PDF
     */
    public function exportPdf(Request $request)
    {
        // Only admin users can export
        if (!auth()->user()->can('view_cars') || !auth()->user()->role || auth()->user()->role->name !== 'admin') {
            abort(403, 'Only administrators can export reports.');
        }

        $status = $request->get('status', 'all');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        
        $query = Car::with(['category']);
        
        // Filter by status
        if ($status && $status !== 'all') {
            if ($status === 'available') {
                $query->where('is_available', true);
            } elseif ($status === 'unavailable') {
                $query->where('is_available', false);
            }
        }
        
        // Filter by date range
        if ($fromDate) {
            $query->whereDate('created_at', '>=', \Carbon\Carbon::parse($fromDate));
        }
        
        if ($toDate) {
            $query->whereDate('created_at', '<=', \Carbon\Carbon::parse($toDate));
        }
        
        $cars = $query->orderBy('created_at', 'desc')->get();
        
        // Build filename with date range info
        $filename = 'cars_' . ($status === 'all' ? 'all' : $status);
        if ($fromDate && $toDate) {
            $filename .= '_' . $fromDate . '_to_' . $toDate;
        } elseif ($fromDate) {
            $filename .= '_from_' . $fromDate;
        } elseif ($toDate) {
            $filename .= '_to_' . $toDate;
        }
        $filename .= '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cars.export-pdf', compact('cars', 'status', 'fromDate', 'toDate'));
        
        return $pdf->download($filename);
    }
}
