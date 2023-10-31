<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AudioSupplicationResource extends JsonResource
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
            'id' => $this['id'],
            'url' => getFilePath($this['audio'], 'AudioSupplications'),
            'title' => $this['title'],
        ];
    }
}
