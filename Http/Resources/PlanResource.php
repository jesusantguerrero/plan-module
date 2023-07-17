<?php

namespace Modules\Plan\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'stages' => $this->stages()->without('items')->get(),
            'color' => $this->color,
            'template'=> $this->planTemplate,
            'type' => $this->planType
        ];
    }
}
