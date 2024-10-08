<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends BaseResource
{
    public function returnArray($data)
    {
        return [
            'id' => $data->id ?? $data['id'] ?? '',
            'picked_up_address' => $data->pickup_street_name ?? $data['pickup_street_name'] ?? '',
            'drip_address' => $data->drop_street_name ?? $data['drop_street_name'] ?? '',
            'work_id' => $data->work_id ?? $data['work_id'] ?? '',
            'status' => $data->status ?? $data['status'] ?? '',
            'amount' => $data->amount ?? $data['amount'] ?? '',
            'pieces' => $data->pieces ?? $data['pieces'] ?? '',
            'weight' => $data->weight ?? $data['weight'] ?? '',
            'miles' => $data->miles ?? $data['miles'] ?? '',
            'pro_number' => $data->pro_number ?? $data['pro_number'] ?? '',
            'origin_destination' => $data->origin_destination ?? $data['origin_destination'] ?? '',
            'drop_destination' => $data->drop_destination ?? $data['drop_destination'] ?? '',
            'company_name' => $data->company_name ?? $data['company_name'] ?? '',
            'admin_load_notes' => $data->admin_load_notes ?? $data['admin_load_notes'] ?? '',
        ];

    }
}
