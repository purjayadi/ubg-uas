<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->paginate(12);
        return view('restaurants.index', compact('restaurants'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $restaurants = Restaurant::where('name', 'like', "%{$search}%")
            ->orWhere('cuisine_type', 'like', "%{$search}%")
            ->orWhere('address', 'like', "%{$search}%")
            ->latest()
            ->paginate(12);

        return view('restaurants.index', compact('restaurants', 'search'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load('reviews.user');
        return view('restaurants.show', compact('restaurant'));
    }

    public function create()
    {
        return view('restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cuisine_type' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurants', 'public');
        }

        Restaurant::create($validated);
        return redirect()->route('restaurants.index')->with('success', 'Restoran berhasil ditambahkan!');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cuisine_type' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update($validated);
        return redirect()->route('restaurants.show', $restaurant)->with('success', 'Restoran berhasil diperbarui!');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('restaurants.index')->with('success', 'Restoran berhasil dihapus!');
    }
}
