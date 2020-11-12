<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\EventData;
use App\Http\Resources\EventCollection;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $data = Event::withCount('users')->filter($request)
        ->where(function($query) {
            $user = auth()->user();
            if ($user && $user->role == 1) {
                $query->where('created_by', $user->id);
            }
        })
        ->orderBy('created_at', 'desc')->get();
        return new EventCollection($data);
    }

    public function store(Request $request)
    {
        $response = new EventData([]);
        try {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|min:2|max:25',
                'description' => 'required|min:3|max:250',
            ]);

            if ($validator->fails()) {
                $response->setMessages($validator->errors()->toArray());
            }else{
                \DB::beginTransaction();
                $new_data = $request->all();
                $data = Event::create($new_data);
                \DB::commit();
                $response->resource = $data;
            }

        } catch (\Throwable $th) {
            $response->setMessages([
                'error' => $th->getMessage(),
            ]);
        }

        return $response->getResponse();
    }

    public function attend($id)
    {
        $response = new EventData([]);
        try {
            \DB::beginTransaction();
            $data = Event::withCount('users')->find($id);
            $user = auth()->user();
            if ($data && $user) {
                $data->users()->attach($user);
            }
            \DB::commit();
            $response->resource = $data;
        } catch (\Throwable $th) {
            $response->setMessages([
                'error' => $th->getMessage(),
            ]);
        }

        return $response->getResponse();
    }
}
