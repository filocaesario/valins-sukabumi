<?php

namespace App\Jobs;

use App\Mail\WelcomeRegistrationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeRegistrationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    public array $details;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, array $details = [])
    {
        $this->user = $user;
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(new WelcomeRegistrationMail($this->user, $this->details));
            Log::info("Official welcome email successfully dispatched to {$this->user->email}");
        } catch (\Throwable $e) {
            Log::warning("Email dispatch notice: " . $e->getMessage());
        }
    }
}
