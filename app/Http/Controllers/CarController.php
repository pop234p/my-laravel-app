<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Booking;
use Carbon\Carbon;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::query();

        if ($request->price_sort == 'asc') {
            $cars->orderBy('price_per_day', 'asc');
        }

        if ($request->price_sort == 'desc') {
            $cars->orderBy('price_per_day', 'desc');
        }

        $cars = $cars->get();

        return view('home', compact('cars'));
    }

    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('car', compact('car'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'regex:/^[А-Яа-яA-Za-z]+\\s[А-Яа-яA-Za-z]+$/u'],
            'phone' => ['required', 'regex:/^(\+7|8)[0-9]{10}$/'],
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $car = Car::findOrFail($request->car_id);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $today = Carbon::today();

        if ($start < $today || $end < $today) {
            return back()->with('error', 'Нельзя бронировать в прошлом');
        }

        if ($end <= $start) {
            return back()->with('error', 'Дата окончания должна быть позже начала');
        }

        // проверка пересечений
        $exists = Booking::where('car_id', $car->id)
            ->where('status', '!=', 'canceled')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end]);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'Авто уже забронировано на эти даты');
        }

        $days = $start->diffInDays($end);
        if ($days < 1) $days = 1;

        $price = $days * $car->price_per_day;

        if ($request->insurance) {
            $price += $price * 0.2;
        }

        Booking::create([
            'car_id' => $car->id,
            'user_id' => auth()->id(),

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,

            'insurance' => $request->insurance ? 1 : 0,
            'total_price' => $price,

            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'comment' => $request->comment,

            'status' => 'new'
        ]);

        return redirect('/success');
    }

    public function success()
    {
        return view('success');
    }

    public function myBookings()
    {
        $bookings = Booking::with('car')->latest()->get();
        return view('bookings', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'canceled';
        $booking->save();

        return back();
    }
}