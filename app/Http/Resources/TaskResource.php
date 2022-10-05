<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'description' => $this->description,
            'estimation' => $this->estimation,
            'order' => $this->order,
            'due_date' => $this->due_date,

            'column' => $this->column,
            'user' => UserResource::make($this->user),
            'comments' => CommentResource::collection($this->comments),
            'project' => $this->project,
            'collaborators' => UserResource::collection($this->collaborators),
            'files' => $this->files,
            'tags' => $this->tags,
        ];
    }
}
