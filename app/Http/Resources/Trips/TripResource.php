<?php

namespace App\Http\Resources\Trips;

use App\Constants\Enum;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $data = parent::toArray($request);
        $data['id'] = view('trips.partial.datatable_cols._id', [
            'item' => $this
        ])->render();
        $data['actions'] = view('trips.partial.datatable_cols._action', [
            'item' => $this
        ])->render();
        $data['from'] = view('trips.partial.datatable_cols._from', [
            'item' => $this
        ])->render();
        $data['to'] = view('trips.partial.datatable_cols._to', [
            'item' => $this
        ])->render();
        $data['status'] = view('trips.partial.datatable_cols._status', [
            'item' => $this
        ])->render();
        $data['amount'] = view('trips.partial.datatable_cols._amount', [
            'item' => $this
        ])->render();
        $data['owner_name'] = view('trips.partial.datatable_cols._owner', [
            'item' => $this
        ])->render();
        $data['captain_name'] = view('place_dashboard.trips.partial.datatable_cols._captain', [
            'item' => $this
        ])->render();;
        $data['payment_type'] = @$this->getType();
        $data['created_at'] = Carbon::parse($data['created_at'])->setTimezone('Asia/Gaza')->format('Y-m-d H:i:s');
        $data['is_success_row'] = $this['status'] == Enum::COMPLETED;
        $data['is_primary_row'] = $this['status'] == Enum::PENDING && (!is_null($this['amount']));
        $data['is_warning_row'] = $this['status'] == Enum::PENDING && (is_null($this['amount']));
        $data['is_danger_row'] = $this['status'] == Enum::CANCELED;



        return $data;
    }

}
