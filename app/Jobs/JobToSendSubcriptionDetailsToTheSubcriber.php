<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\MailToSendSubscriptionRefCodeToUser;
use App\Models\Subscription;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobToSendSubcriptionDetailsToTheSubcriber implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public Subscription $subscription, public bool $to_upgrade = false)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscription = $this->subscription;

        $school = $subscription->school;

        $subscriber = $subscription->subscriber;

        $lien = $subscriber->to_subscribes_route();

        $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

        if(!$this->to_upgrade) :

            $receiver_html = EmailTemplateBuilder::render('email-to-validate-pack-subscription', [
                'lien' => $lien,
                'greating' => $greating,
                'key' => $subscription->ref_key,
                'subscriber_name' => $subscriber->getFullName(true),
                'school_name' => $school->name,
                'amount' => $subscription->amount,
                'pack_name' => $subscription->pack->name,
                'mtn_phone_number' => config('app.mtn_phone_number'),
                'celtiis_phone_number' => config('app.celtiis_phone_number'),
            ]);

            Mail::to($subscriber->email)->send(new MailToSendSubscriptionRefCodeToUser($subscriber, $subscription->ref_key, $receiver_html));

        else : 

            $subscription_request = $subscription->active_upgrading_request;

            $receiver_html = EmailTemplateBuilder::render('email-to-validate-subscription-upgrade', [
                'lien' => $lien,
                'greating' => $greating,
                'subscription_ref_key' => $subscription->ref_key,
                'key' => $subscription_request->ref_key,
                'subscriber_name' => $subscriber->getFullName(true),
                'school_name' => $school->name,
                'amount' => $subscription_request->amount,
                'pack_name' => $subscription->pack->name,
                'mtn_phone_number' => config('app.mtn_phone_number'),
                'celtiis_phone_number' => config('app.celtiis_phone_number'),
            ]);

            Mail::to($subscriber->email)->send(new MailToSendSubscriptionRefCodeToUser($subscriber, $subscription->ref_key, $receiver_html, true));
            
        endif;
    }


    
}
