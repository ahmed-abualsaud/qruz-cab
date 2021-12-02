<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\FirebasePushNotification as Firebase;

class SendPushNotification implements ShouldQueue
{
    private $devices;
    private $message;
    private $title;
    private $data;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($devices, $message, $data = null, $title = 'Qruz Cab')
    {
        $this->devices = $devices;
        $this->message = $message; 
        $this->title = $title;
        $this->data = $data;
        $this->queue = 'high';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Firebase::push($this->devices, $this->title, $this->message, $this->data);
    }
}
