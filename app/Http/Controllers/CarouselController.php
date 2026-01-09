<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $images = CarouselImage::orderBy('order')->get();
        return view('carousel.index', compact('images'));
    }

    public function create()
    {
        return view('carousel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('carousel', 'public');
        }

        $validated['active'] = isset($validated['active']) ? (bool)$validated['active'] : true;

        CarouselImage::create($validated);
        return redirect()->route('carousel.index')->with('success', 'Carousel image berhasil ditambahkan!');
    }

    public function edit(CarouselImage $image)
    {
        return view('carousel.edit', compact('image'));
    }

    public function update(Request $request, CarouselImage $image)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('carousel', 'public');
        }

        $validated['active'] = isset($validated['active']) ? (bool)$validated['active'] : $image->active;

        $image->update($validated);
        return redirect()->route('carousel.index')->with('success', 'Carousel image berhasil diperbarui!');
    }

    public function destroy(CarouselImage $image)
    {
        $image->delete();
        return redirect()->route('carousel.index')->with('success', 'Carousel image berhasil dihapus!');
    }
}
