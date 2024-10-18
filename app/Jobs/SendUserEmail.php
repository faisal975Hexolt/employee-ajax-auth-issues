<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $post = null;
    public $tries = 1;

    /**
     * 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = User::whereIn('id',array(1,21))->get()->toArray();
           foreach ($subscribers as $subscriber)
        {
            \Mail::send('maillayouts.test', ['post' => "Posts", 'subscriber' => $subscriber], function ($m) use($subscriber) {
                $m->to($subscriber['email'], $subscriber['name']);
                $m->subject('A new article has been published.');
            });
        }
      
    }
}
