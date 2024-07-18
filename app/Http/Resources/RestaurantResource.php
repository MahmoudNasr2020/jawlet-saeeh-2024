<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           =>  $this->id,
            'name'         =>  $this->name,
            'desc'         =>  $this->desc,
            'prise'        =>  $this->prise,
            'rating'       =>  $this->rating,
            'service_fees' =>  $this->service_fees,
            'location'     =>  $this->location,
             'longitude'    =>  floatval($this->longitude),
        	'latitude'     =>  floatval($this->latitude),
            'created_at'   =>  $this->created_at,
            'updated_at'   =>  $this->updated_at,
            'image'        => getIamgesMediaUrl($this->getMedia()),
        ];
    }
}
