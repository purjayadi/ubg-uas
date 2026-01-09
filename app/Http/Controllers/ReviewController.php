<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk review!');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['restaurant_id'] = $restaurant->id;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('review_photos', 'public');
            $validated['photo'] = $path;
        }

        Review::create($validated);

        // Update rating restaurant
        $restaurant->update(['rating' => $restaurant->averageRating()]);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan!');
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus review ini!');
        }

        $restaurant = $review->restaurant;
        $review->delete();
        $restaurant->update(['rating' => $restaurant->averageRating()]);

        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }
}
