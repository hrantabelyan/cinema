<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaHallRequest;
use App\Http\Requests\UpdateCinemaHallRequest;
use App\Http\Resources\CinemaHallCollection;
use App\Http\Resources\CinemaHallResource;
use App\Models\CinemaHall;
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
                $query->where('id', $searchTerm);
                $query->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
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
        DB::beginTransaction();

        try {
            $cinemaHall = CinemaHall::create($request->only([
                'name',
            ]));
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e);
            return $this->respondError(__('Could not create the hall'));
        }

        try {
            foreach ($request->phone_numbers as $phoneNumber) {
                $cinemaHall->numbers()->create([
                    'number' => $phoneNumber,
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e);
            return $this->respondError(__('Could not add the phone number'));
        }

        try {
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            logger($e);
            return $this->respondError(__('Could not insert to database'));
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
