<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCompanyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {

        return [

            'data' => $this->collection['data']->map(function ($item) {
                return [
                    'name' => $item->name,
                    'uid' => $item->uid,
                ];
            }),
            'meta' => $this->collection['meta']


        ];
    }
}
