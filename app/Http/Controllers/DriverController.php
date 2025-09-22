<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view_drivers')) {
            abort(403);
        }
        
        $drivers = Driver::latest()->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create_drivers')) {
            abort(403);
        }
        
        return view('admin.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create_drivers')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:drivers,phone_number',
            'email' => 'nullable|email|max:255|unique:drivers,email',
            'is_active' => 'boolean',
            'is_available' => 'boolean'
        ]);

        Driver::create($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        if (!auth()->user()->can('view_drivers')) {
            abort(403);
        }
        
        return view('admin.drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        if (!auth()->user()->can('edit_drivers')) {
            abort(403);
        }
        
        return view('admin.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        if (!auth()->user()->can('edit_drivers')) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:drivers,phone_number,' . $driver->id,
            'email' => 'nullable|email|max:255|unique:drivers,email,' . $driver->id,
            'is_active' => 'boolean',
            'is_available' => 'boolean'
        ]);

        $driver->update($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        if (!auth()->user()->can('delete_drivers')) {
            abort(403);
        }
        
        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
}
