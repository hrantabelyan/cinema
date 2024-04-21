<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Screening;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->has('per_page') ? (int) request()->input('per_page') : 10;
        $orderArray = ['id', 'desc'];

        if (request()->has('sort_by')) {
            $tmpOrderArray = Str::of(request()->input('sort_by'))->explode('.');

            if (count($tmpOrderArray) == 2) {
                $orderArray = $tmpOrderArray;
            }
        }

        $reservations = new Reservation();

        if (request()->has('search') && is_string(request()->input('search'))) {
            $searchTerm = request()->input('search');
            $reservations = $reservations->where(function($query) use ($searchTerm) {
                $query->where('uuid', $searchTerm);
            });
        }

        $reservations = $reservations->orderBy($orderArray[0], $orderArray[1]);
        // logger($reservations->toSql(), $reservations->getBindings());
        $reservations = $reservations->paginate($perPage);
        return new ReservationCollection($reservations);
    }

    /**
     * Display a listing of the resource for a specific <\App\Models\Screening>
     */
    public function screeningIndex(Screening $screening)
    {
        $perPage = request()->has('per_page') ? (int) request()->input('per_page') : 10;
        $orderArray = ['id', 'desc'];

        if (request()->has('sort_by')) {
            $tmpOrderArray = Str::of(request()->input('sort_by'))->explode('.');

            if (count($tmpOrderArray) == 2) {
                $orderArray = $tmpOrderArray;
            }
        }

        $reservations = new Reservation();

        $reservations = $reservations->where('screening_id', $screening->id);

        if (request()->has('search') && is_string(request()->input('search'))) {
            $searchTerm = request()->input('search');
            $reservations = $reservations->where(function($query) use ($searchTerm) {
                $query->where('uuid', $searchTerm);
            });
        }

        $reservations = $reservations->orderBy($orderArray[0], $orderArray[1]);
        // logger($reservations->toSql(), $reservations->getBindings());
        $reservations = $reservations->paginate($perPage);
        return new ReservationCollection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $screening = Screening::where('slug', $request->input('screening'))->first();
        if (!$screening) {
            return $this->respondError(__('Screening not found'));
        }

        DB::beginTransaction();

        try {
            $reservation = Reservation::create([
                'uuid' => Str::uuid()->toString(),
                'screening_id' => $screening->id,
                ...$request->only([
                    'row_number',
                    'column_number',
                ]),
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e);
            return $this->respondError(__('Could not create the reservation'));
        }

        return $this->respondCreated(new ReservationResource($reservation));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $this->respondWithSuccess(new ReservationResource($reservation));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $reservation->delete();
        } catch (\Throwable $e) {
            return $this->respondError(__('Could not delete the reservation, please try again later'));
        }

        return $this->respondOk();
    }
}
