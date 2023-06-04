<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'type' => 'Tasks',
            'attributes' => [
                'name' => $this->name,
                'desc' => $this->desc,
                'piriorty' => $this->piriorty,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'id' => (string)$this->user->id,
                'user name' => $this->user->name,
                'user email' =>$this->user->email
            ]
        ];
    }
    }

