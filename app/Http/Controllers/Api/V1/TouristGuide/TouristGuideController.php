<?php

namespace App\Http\Controllers\Api\V1\TouristGuide;


use App\Http\Controllers\Controller;
use App\Models\TouristGuide;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\ApiTrait;

class TouristGuideController extends Controller
{
    use ApiTrait;

    public function index(Request $request): JsonResponse
    {
        try {
            $guides = TouristGuide::with('places')->get();

            $guides = $guides->map(function ($guide) {
                return [
                    'id' => $guide->id,
                    'name' => $guide->name,
                    'email' => $guide->email,
                    'image' => $guide->image,
                    'phone' => $guide->phone,
                    'places' => $guide->places->select('id','name')
                ];
            });

            return $this->response($guides, 'Tourist guides fetched successfully', 200);
        }
        catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch tourist guides', 500);
        }
    }

    public function reservation_data($id): JsonResponse
    {
        try {
            $guide = TouristGuide::with('places')->find($id);

            if (!$guide) {
                return $this->response(null, 'Tourist guide not found', 404);
            }

            return $this->response([
                'id' => $guide->id,
                'name' => $guide->name,
                'places' => $guide->places->select('id','name')
            ], 'Tourist guide fetched successfully', 200);
        } catch (\Exception $e) {
            return $this->response(null, 'Failed to fetch tourist guide', 500);
        }
    }
}
