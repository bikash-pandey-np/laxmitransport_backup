<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function toArray($request)
    {
        if (isset($this->id)){
            return $this->returnArray($this);
        }else{
            $newArray = [];
            if (isset(parent::toArray($request)['data'])){
                foreach (parent::toArray($request)['data'] as $child) {
                    array_push($newArray,$this->returnArray($child));
                }
            }else{
                foreach (parent::toArray($request) as $child) {
                    array_push($newArray,$this->returnArray($child));
                }
            }

            return $newArray;
        }
    }

    public function returnArray($data)
    {
        return [];
    }

}
