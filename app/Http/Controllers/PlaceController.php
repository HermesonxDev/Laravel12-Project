<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller {
    
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'slug'  => 'nullable|string',
            'city'  => 'required|string',
            'state' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error in creating place',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $place = new Place();

            $place->name = $request->name;
            $place->slug = $request->slug ?? $this->generateSlug($request->name);
            $place->city = $request->city;
            $place->state = $request->state;

            $place->save();

            return response()->json([
                'message' => 'place created successfully'
            ], 201, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error in creating place',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function places(Request $request) {
        try {
            $name = $request->query('name');

            $query = Place::query();

            if ($name) {
                try {
                    $query->where('name', $name);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error listing places',
                        'error' => $e->getMessage()
                    ], 400);
                }
            }

            $places = $query->get();
            
            return response()->json($places, 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error listing places',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request, int $placeID) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'slug'  => 'nullable|string',
            'city'  => 'required|string',
            'state' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error while editing place',
                'errors' => $validator->errors()
            ]);
        }

        try {
            
            $place = Place::where('id', $placeID)->first();

            if (!$place) {
                return response()->json([
                    'message' => 'error while editing place',
                    'error' => 'place not found'
                ], 404);
            }

            $place->name = $request->name;
            $place->slug = $request->slug ?? $this->generateSlug($request->name);
            $place->city = $request->city;
            $place->state = $request->state;

            $place->save();

            return response()->json([
                'message' => 'place edited successfully'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error while editing place',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, int $placeID) {
        try {

            $place = Place::where('id', $placeID)->first();

            if (!$place) {
                return response()->json([
                    'message' => 'error in deleting place',
                    'error' => 'place not found'
                ], 404);
            }

            $place->delete();

            return response()->json([
                'message' => 'place deleted successfully'
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error in deleting place',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateSlug(string $value) {
        $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        $value = strtolower($value);
        $value = str_replace(' ', '-', $value);
        $value = preg_replace('/[^a-z0-9\-]/', '', $value);
        $value = preg_replace('/-+/', '-', $value);
        $value = trim($value, '-');

        return $value;
    }

}