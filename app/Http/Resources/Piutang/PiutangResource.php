<?php

namespace App\Http\Resources\Piutang;

use Illuminate\Http\Resources\Json\JsonResource;

class PiutangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
