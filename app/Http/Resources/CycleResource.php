<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CycleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        return[
           'body' =>$this->body,
            'uuid'=>$this->uuid,
            'is_correct' => $this->is_correct
        ];
    }
}
