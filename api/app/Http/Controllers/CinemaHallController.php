<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaHallRequest;
use App\Http\Requests\UpdateCinemaHallRequest;
use App\Http\Resources\CinemaHallCollection;
use App\Http\Resources\CinemaHallResource;
use App\Models\CinemaHall;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CinemaHallController extends Controller
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

        $cinemaHalls = new CinemaHall();

        if (request()->has('search') && is_string(request()->input('search'))) {
            $searchTerm = request()->input('search');
            $cinemaHalls = $cinemaHalls->where(function($query) use ($searchTerm) {
                $query->where('uuid', $searchTerm);
                $query->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('number_of_rows', $searchTerm);
                $query->orWhere('number_of_columns', $searchTerm);
            });
        }

        $cinemaHalls = $cinemaHalls->orderBy($orderArray[0], $orderArray[1]);
        // logger($cinemaHalls->toSql(), $cinemaHalls->getBindings());
        $cinemaHalls = $cinemaHalls->paginate($perPage);
        return new CinemaHallCollection($cinemaHalls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaHallRequest $request)
    {
        $color = Color::where('slug', $request->input('color'))->first();
        if (!$color) {
            return $this->respondError(__('Color not found'));
        }

        DB::beginTransaction();

        try {
            $cinemaHall = CinemaHall::create([
                'uuid' => Str::uuid()->toString(),
                'color_id' => $color->id,
                ...$request->only([
                    'name',
                    'number_of_rows',
                    'number_of_columns',
                ]),
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e);
            return $this->respondError(__('Could not create the hall'));
        }

        return $this->respondCreated(new CinemaHallResource($cinemaHall));
    }

    /**
     * Display the specified resource.
     */
    public function show(CinemaHall $cinemaHall)
    {
        return $this->respondWithSuccess(new CinemaHallResource($cinemaHall));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCinemaHallRequest $request, CinemaHall $cinemaHall)
    {
        try {
            $cinemaHall->update($request->validated());
            $cinemaHall->save();
        } catch (\Exception $e) {
            return $this->respondError(__('Could not update the hall, please try again later'));
        }

        return $this->respondWithSuccess(new CinemaHallResource($cinemaHall));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CinemaHall $cinemaHall)
    {
        try {
            $cinemaHall->delete();
        } catch (\Throwable $e) {
            return $this->respondError(__('Could not delete the hall, please try again later'));
        }

        return $this->respondOk();
    }
}
