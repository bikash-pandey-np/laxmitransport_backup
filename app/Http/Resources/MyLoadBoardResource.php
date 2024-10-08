<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyLoadBoardResource extends BaseResource
{
    public function returnArray($data)
    {
        if(($data['load_board']['table'] ?? null) == null && ($data['load_board']['table_id'] ?? null) == null){
            $status = 'Under Review';
        }elseif(($data['load_board']['table'] ?? null) == \App\Models\Driver::class && ($data['load_board']['table_id'] ?? null) == auth('driver_api')->id()){
            $status = 'Approved';
        }else {
            $status = 'Rejected';
        }

        return [
            'id' => $data['load_board']['id'] ?? $data->loadBoard->id ?? $data['id'] ?? '',
            'pickup_location' => $data['load_board']['pickup_city_st_zip_code'] ?? $data->loadBoard->pickup_city_st_zip_code ?? $data['pickup_city_st_zip_code'] ?? '',
            'drop_location' => $data['load_board']['drop_city_st_zip_code'] ?? $data->loadBoard->drop_city_st_zip_code ?? $data['drop_city_st_zip_code'] ?? '',
            'pickup_date' => $data['load_board']['pickup_date'] ?? $data->loadBoard->pickup_date ?? $data['pickup_date'] ?? '',
            'pickup_time' => $data['load_board']['pickup_time'] ?? $data->loadBoard->pickup_time ?? $data['pickup_time'] ?? '',
            'drop_date' => $data['load_board']['drop_date'] ?? $data->loadBoard->drop_date ?? $data['drop_date'] ?? '',
            'drop_time' => $data['load_board']['drop_time'] ?? $data->loadBoard->drop_time ?? $data['drop_time'] ?? '',


            'pieces' => $data['load_board']['pieces'] ?? $data->loadBoard->pieces ?? $data['pieces'] ?? "",
            'weight' => $data['load_board']['weight'] ?? $data->loadBoard->weight ?? $data['weight'] ?? "",
            'amount' => $data['amount'] ?? $data->amount ?? $data['amount'] ?? "",
            'dims' => $data['load_board']['dims'] ?? $data->loadBoard->dims ?? $data['dims'] ?? '',
            'miles' => $data['load_board']['miles'] ?? $data->loadBoard->miles ?? $data['miles'] ?? "",
            'vehicle_type' => $data['load_board']['vehicle_type'] ?? $data->loadBoard->vehicle_type ?? $data['vehicle_type'] ?? '',
            'status' => $status,

        ];
    }
}
