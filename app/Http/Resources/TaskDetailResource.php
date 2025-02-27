<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => $this->whenLoaded('user'),
            'project' => $this->whenLoaded('project'),
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date
            
        ];
    }
}
