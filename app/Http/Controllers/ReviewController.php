<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $reviews = Review::with(['customer', 'reviewable'])
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        return response()->view('cms.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $customers = Customer::all();
        $products  = Product::all();
        $artisans  = Artisan::all();
        return response()->view('cms.review.create', compact('customers', 'products', 'artisans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'required|string|min:3',
            'customers_id'    => 'required|integer|exists:customers,id',
            'reviewable_type' => 'required|in:product,artisan',
            'reviewable_id'   => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $type = $request->reviewable_type === 'product'
            ? \App\Models\Product::class
            : \App\Models\Artisan::class;

        $review                  = new Review();
        $review->rating          = $request->rating;
        $review->comment         = $request->comment;
        $review->customers_id    = $request->customers_id;
        $review->reviewable_type = $type;
        $review->reviewable_id   = $request->reviewable_id;
        $isSaved = $review->save();

        if ($isSaved) {
            return response()->json([
                'icon'  => 'success',
                'title' => 'Review created successfully',
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $review = Review::with(['customer', 'reviewable'])->findOrFail($id);
        return response()->view('cms.review.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $review    = Review::findOrFail($id);
        $customers = Customer::all();
        $products  = Product::all();
        $artisans  = Artisan::all();
        return response()->view('cms.review.edit', compact('review', 'customers', 'products', 'artisans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $validator = Validator::make($request->all(), [
            'rating'          => 'required|integer|min:1|max:5',
            'comment'         => 'required|string|min:3',
            'customers_id'    => 'required|integer|exists:customers,id',
            'reviewable_type' => 'required|in:product,artisan',
            'reviewable_id'   => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $type = $request->reviewable_type === 'product'
            ? \App\Models\Product::class
            : \App\Models\Artisan::class;

        $review                  = Review::findOrFail($id);
        $review->rating          = $request->rating;
        $review->comment         = $request->comment;
        $review->customers_id    = $request->customers_id;
        $review->reviewable_type = $type;
        $review->reviewable_id   = $request->reviewable_id;
        $review->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('review.index'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Review::destroy($id);
        return response()->json([
            'icon'  => 'success',
            'title' => 'Deleted Successfully',
        ], 200);
    }

    public function trashed()
    {
        $reviews = Review::with(['customer', 'reviewable'])
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
        return response()->view('cms.review.trashed', compact('reviews'));
    }

    public function restore($id)
    {
        Review::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        Review::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        Review::onlyTrashed()->forceDelete();
        return back()->with('success', 'All Deleted Successfully');
    }
}
