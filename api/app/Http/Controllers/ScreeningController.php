<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreeningRequest;
use App\Http\Requests\UpdateScreeningRequest;
use App\Http\Resources\ScreeningCollection;
use App\Http\Resources\ScreeningResource;
use App\Models\CinemaHall;
use App\Models\Screening;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScreeningController extends Controller
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

        $screenings = new Screening();

        if (request()->has('search') && is_string(request()->input('search'))) {
            $searchTerm = request()->input('search');
            $screenings = $screenings->where(function($query) use ($searchTerm) {
                $query->where('uuid', $searchTerm);
            });
        }

        $screenings = $screenings->orderBy($orderArray[0], $orderArray[1]);
        // logger($screenings->toSql(), $screenings->getBindings());
        $screenings = $screenings->paginate($perPage);
        return new ScreeningCollection($screenings);
    }

    /**
     * Display a listing of the resource for a specific <\App\Models\CinemaHall>
     */
    public function cinemaHallIndex(CinemaHall $cinemaHall)
    {
        $perPage = request()->has('per_page') ? (int) request()->input('per_page') : 10;
        $orderArray = ['id', 'desc'];

        if (request()->has('sort_by')) {
            $tmpOrderArray = Str::of(request()->input('sort_by'))->explode('.');

            if (count($tmpOrderArray) == 2) {
                $orderArray = $tmpOrderArray;
            }
        }

        $screenings = new Screening();

        $screenings = $screenings->where('cinema_hall_id', $cinemaHall->id);

        if (request()->has('search') && is_string(request()->input('search'))) {
            $searchTerm = request()->input('search');
            $screenings = $screenings->where(function($query) use ($searchTerm) {
                $query->where('uuid', $searchTerm);
            });
        }

        $screenings = $screenings->orderBy($orderArray[0], $orderArray[1]);
        // logger($screenings->toSql(), $screenings->getBindings());
        $screenings = $screenings->paginate($perPage);
        return new ScreeningCollection($screenings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreeningRequest $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $cinemaHall)
    {
        return $this->respondWithSuccess(new ScreeningResource($cinemaHall));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreeningRequest $request, Screening $cinemaHall)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $cinemaHall)
    {
        try {
            $cinemaHall->delete();
        } catch (\Throwable $e) {
            return $this->respondError(__('Could not delete the hall, please try again later'));
        }

        return $this->respondOk();
    }
}
