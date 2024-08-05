<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'autor' => $this->autor,
            'data_publicacao' => $this->data_publicacao,
        ];
    }
}
