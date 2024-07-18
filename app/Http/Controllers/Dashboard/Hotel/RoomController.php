<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Hotel\Room\RoomRequest;
use App\Models\City;
use App\Models\Hotel;
use App\Models\HotelReservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function index($hotel_id)
    {
        $hotel = Hotel::select('id','name')->findOrFail($hotel_id);
        $search = '';
        if (request()->has('search')) {
            $search = request('search');
            $rooms = Room::where('hotel_id',$hotel_id)
            ->where('type', 'LIKE', "%{$search}%")
                ->orderBy('id','desc')
                ->paginate(10);
            $rooms->appends(['search' => $search]);
        }
        else
        {
            $rooms = Room::where('hotel_id',$hotel_id)->orderBy('id','desc')->paginate(10);
        }

        return view('dashboard.pages.hotels.rooms.index', compact('rooms','hotel'));
    }


    public function create($hotel_id)
    {
        $hotel = Hotel::select('id','name')->findOrFail($hotel_id);
        return view('dashboard.pages.hotels.rooms.create',compact('hotel'));
    }

    public function store(RoomRequest $request)
    {

        Room::create([
            'type' => $request->type,
            'count' => $request->count,
            'price_per_day' => $request->price_per_day,
            'hotel_id' => $request->hotel_id,
        ]);

        Alert::success('Success', 'تمت الإضافة بنجاح');
        return redirect()->route('dashboard.rooms.index', $request->hotel_id);
    }


    public function edit($hotel_id,$id)
    {
        $room = Room::findOrFail($id);
        return view('dashboard.pages.hotels.rooms.edit', compact('room'));
    }

    // تحديث القسم في قاعدة البيانات
    public function update(RoomRequest $request, $id)
    {

        $room = Room::findOrFail($id);

        $room->update([
            'type' => $request->type,
            'count' => $request->count,
            'price_per_day' => $request->price_per_day,
        ]);

        Alert::success('Success', 'تم التعديل بنجاح');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return 'done';
    }

    public function available_rooms(Request $request)
    {

        $hotels = Hotel::select('id', 'name')->get();

        $availableRooms = collect();
        $searchedHotel = null;

        if ($request->filled(['hotel_id', 'start_datetime', 'end_datetime'])) {

            $validator = Validator::make($request->all(), [
                'start_datetime' => 'required|date',
                'end_datetime' => 'required|date|after:start_datetime',
            ],[
                'end_datetime.after' => 'تاريخ الانتهاء يجب ان يكون اكبر من تاريح البداية'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $searchedHotel = Hotel::findOrFail($request->hotel_id);
            $start_datetime = Carbon::parse($request->start_datetime);
            $end_datetime = Carbon::parse($request->end_datetime);

            $reservations = HotelReservation::where('is_canceled','0')
            ->where('hotel_id', $searchedHotel->id)
                ->where(function($query) use ($start_datetime, $end_datetime) {
                    $query->whereBetween('start_datetime', [$start_datetime, $end_datetime])
                        ->orWhereBetween('end_datetime', [$start_datetime, $end_datetime])
                        ->orWhere(function($query) use ($start_datetime, $end_datetime) {
                            $query->where('start_datetime', '<', $start_datetime)
                                ->where('end_datetime', '>', $end_datetime);
                        });
                })
                ->get();

            $roomsBooked = [];

            // حساب عدد الغرف المحجوزة من كل نوع
            foreach ($reservations as $reservation) {
                foreach ($reservation->getRooms() as $room) {
                    if (!isset($roomsBooked[$room->id])) {
                        $roomsBooked[$room->id] = 0;
                    }
                    $roomsBooked[$room->id]++;
                }
            }

            // إيجاد الغرف المتاحة في الفندق
            $rooms = $searchedHotel->rooms;
            foreach ($rooms as $room) {
                $booked = $roomsBooked[$room->id] ?? 0;
                $available = $room->count - $booked;
                $room->booked = $booked;
                $room->available = $available > 0 ? $available : 0; // لا تسمح بقيم سالبة
                $availableRooms->push($room);
            }
        }

        return view('dashboard.pages.hotels.rooms.available_room', compact('hotels', 'availableRooms', 'searchedHotel'));
    }

}
