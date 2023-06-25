<?php

namespace App\Jobs;

use App\Constants\Enum;
use App\Models\Trip;
use App\Notifications\RequestSahmNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RequestSahmNotificationQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $come_at = null;
        if($this->data['come_at']){
            $come_at = Carbon::now()->addMinutes($this->data['come_at']);
        }
        for($i = 1; $i <= $this->data['qty'] ; $i++){
            Trip::query()->create([
                'owner_id' => $this->data['place_id'],
                'is_owner_place' =>1,
                'from' => $this->data['address'],
                'type' => $this->data['type']??Enum::IMMEDIATELY,
                'come_at' => $come_at,
            ]);
        }
        Notification::send($this->data['user'], new RequestSahmNotification([
            'place_id' => $this->data['place_id'],
            'title' => 'طلب جديد',
            'body' => $this->data['place']." طلب ".$this->data['qty']." كابتن",
            'type' => 'new_request_sahm',
        ]));
    }
}
