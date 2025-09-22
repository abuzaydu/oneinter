<?php

namespace App\Http\Controllers;

use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarCategoryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_cars')) {
            abort(403);
        }
        
        $categories = CarCategory::latest()->paginate(10);
        return view('admin.cars.category', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create_cars')) {
            abort(403);
        }
        
        // Debug: Log the request data
        \Log::info('Category creation request:', $request->all());
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_categories',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_favorite' => 'boolean',
            'number_of_cars' => 'required|integer|min:0',
            'seats' => 'nullable|integer|min:1',
            'daily_rate' => 'nullable|numeric|min:0',
            'picture' => 'nullable|image|max:2048',
        ]);

        // Debug: Log validated data
        \Log::info('Validated data:', $validated);

        if ($request->hasFile('picture')) {
            // Store new category picture in public directory for better accessibility
            $file = $request->file('picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $publicPath = 'category-pictures/' . $filename;
            
            // Move file to public directory
            $file->move(public_path('category-pictures'), $filename);
            
            $validated['picture'] = $publicPath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // Debug: Log final data before creation
        \Log::info('Final data for creation:', $validated);
        
        try {
            $category = CarCategory::create($validated);
            \Log::info('Category created successfully:', $category->toArray());
        } catch (\Exception $e) {
            \Log::error('Category creation failed:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create category: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('admin.car-categories.index')
            ->with('success', 'Car category created successfully.');
    }

    public function update(Request $request, CarCategory $carCategory)
    {
        if (!auth()->user()->can('edit_cars')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_categories,name,' . $carCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_favorite' => 'boolean',
            'number_of_cars' => 'required|integer|min:0',
            'seats' => 'nullable|integer|min:1',
            'daily_rate' => 'nullable|numeric|min:0',
            'picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($carCategory->picture) {
                $oldPath = public_path($carCategory->picture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Store new category picture in public directory for better accessibility
            $file = $request->file('picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $publicPath = 'category-pictures/' . $filename;
            
            // Move file to public directory
            $file->move(public_path('category-pictures'), $filename);
            
            $validated['picture'] = $publicPath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        $carCategory->update($validated);

        return redirect()->route('admin.car-categories.index')
            ->with('success', 'Car category updated successfully.');
    }

    public function destroy(CarCategory $carCategory)
    {
        if (!auth()->user()->can('delete_cars')) {
            abort(403);
        }
        
        $carCategory->delete();

        return redirect()->route('admin.car-categories.index')
            ->with('success', 'Car category deleted successfully.');
    }

    public function toggleFavorite(CarCategory $carCategory)
    {
        if (!auth()->user()->can('edit_cars')) {
            abort(403);
        }
        
        $carCategory->update([
            'is_favorite' => !$carCategory->is_favorite
        ]);

        return redirect()->route('admin.car-categories.index')
            ->with('success', 'Car category favorite status updated successfully.');
    }
}
