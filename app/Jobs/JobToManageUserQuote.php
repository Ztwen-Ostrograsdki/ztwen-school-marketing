<?php

namespace App\Jobs;

use App\Models\Quote;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class JobToManageUserQuote implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public string $content,
        public ?Quote $quote = null
    )
    {
        $this->user = $user;

        $this->quote = $quote;

        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->quote){

            $this->quote->update(['content' => $this->content]);

        }
        else{

            $max = config('app.max_quotes_by_user');

            if(count($this->user->quotes) >= $max){

                Notification::sendNow([$this->user], new RealTimeNotification("L'insertion de la citation a échoué vous ne pouvez pas publier plus de {$max} citations!"));

                $this->fail();

            }
            else{
                
                Quote::create(['content' => $this->content, 'user_id' => $this->user->id]);
            }


            
        }
        
    }
}
