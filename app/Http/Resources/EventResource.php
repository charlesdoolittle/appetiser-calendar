<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'event_name' => $this->event_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'event_days' => \unserialize($this->event_days),
            'event_key' => md5($this->start_date.$this->end_date)
        ];
    }
}
