<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'status' => 'success',
            'message' => 'Ok',
            'data' => $this->collection,
        ];
    }
}
