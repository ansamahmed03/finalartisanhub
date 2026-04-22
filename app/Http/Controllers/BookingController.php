<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $bookings = Booking::with(['customer', 'team'])
             ->orderBy('id', 'desc')
             ->simplePaginate(10);
             return response()->view('cms.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
              $customers = Customer::all();
        $teams     = Team::all();
        return response()->view('cms.booking.create', compact('customers', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'status'       => 'required|in:pending,confirmed,completed,cancelled',
            'notes'        => 'nullable|string',
            'customer_id'  => 'required|integer|exists:customers,id',
            'team_id'      => 'required|integer|exists:teams,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }
        // 1. فحص التعارض
    $exists = Booking::where('team_id', $request->team_id)
        ->where('booking_date', $request->booking_date)
        ->whereNotIn('status', ['cancelled'])
        ->exists();

    if ($exists) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'This team is already booked on this date',
        ], 400);
    }

        $booking               = new Booking();
        $booking->booking_date = $request->booking_date;
        $booking->status       = $request->status;
        $booking->notes        = $request->notes;
        $booking->customer_id  = $request->customer_id;
        $booking->team_id      = $request->team_id;
        $isSaved = $booking->save();

        if ($isSaved) {
            return response()->json([
                'icon'  => 'success',
                'title' => 'Booking created successfully',
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }

    //     if ($isSaved) {
    // // إشعار للكستومر
    // NotificationController::send(
    //     Customer::find($request->customer_id),
    //     'Booking Confirmed',
    //     'Your booking has been confirmed for ' . $request->booking_date
    // );

    // // إشعار للفرقة
    // NotificationController::send(
    //     Team::find($request->team_id),
    //     'New Booking',
    //     'You have a new booking on ' . $request->booking_date
    // );

    // return response()->json(['icon' => 'success', 'title' => 'Booking created successfully'], 200);


    //     }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
          $booking = Booking::with(['customer', 'team'])->findOrFail($id);
        return response()->view('cms.booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking   = Booking::findOrFail($id);
        $customers = Customer::all();
        $teams     = Team::all();
        return response()->view('cms.booking.edit', compact('booking', 'customers', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
        'booking_date' => 'required|date',
        'status'       => 'required|in:pending,confirmed,completed,cancelled',
        'notes'        => 'nullable|string',
        'customer_id'  => 'required|integer|exists:customers,id',
        'team_id'      => 'required|integer|exists:teams,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }
     $exists = Booking::where('team_id', $request->team_id)
        ->where('booking_date', $request->booking_date)
        ->whereNotIn('status', ['cancelled'])
        ->where('id', '!=', $id) // استثني الحجز الحالي
        ->exists();

    if ($exists) {
        return response()->json([
            'icon'  => 'error',
            'title' => 'This team is already booked on this date',
        ], 400);
    }
     $booking               = Booking::findOrFail($id);
    $booking->booking_date = $request->booking_date;
    $booking->status       = $request->status;
    $booking->notes        = $request->notes;
    $booking->customer_id  = $request->customer_id;
    $booking->team_id      = $request->team_id;
    $booking->save();

    return response()->json([
        'icon'     => 'success',
        'title'    => 'Updated Successfully',
       'redirect' => route('booking.index'),
    ], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->json([
            'icon'  => 'success',
            'title' => 'Deleted Successfully',
        ], 200);
    }


     public function trashed()
    {
        $bookings = Booking::with(['customer', 'team'])
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
        return response()->view('cms.booking.trashed', compact('bookings'));
    }

    public function restore($id)
    {
        Booking::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        Booking::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        Booking::onlyTrashed()->forceDelete();
        return back()->with('success', 'All Deleted Successfully');
    }
}
