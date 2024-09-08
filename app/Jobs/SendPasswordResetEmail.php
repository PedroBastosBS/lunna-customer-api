<?php

namespace App\Jobs;

use App\Mail\PasswordResetMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected string $email;
    protected string $name;
    protected string $url;
    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $name, string $url)
    {
        $this->email = $email;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new PasswordResetMail( $this->name, $this->url));
    }
}
