<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {



return[

                'question-text' => $this->body,
                'question-uuid' => $this->uuid,
                'answers' =>  CycleResource::collection($this->answers),

];
    }
}
