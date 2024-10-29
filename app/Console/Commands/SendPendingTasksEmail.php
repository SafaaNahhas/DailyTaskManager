<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\PendingTasksMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPendingTasksEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-pending-tasks-email ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send pending tasks email';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    $users = User::with(['tasks' => function ($query) {
        $query->where('status', 'Pending');
    }])->get();

    foreach ($users as $user) {
        if ($user->tasks->isNotEmpty()) {

            Mail::to($user->email)->send(new PendingTasksMail($user, $user->tasks));
            $this->info("Email sent to {$user->email} for pending tasks.");


        }
    }

    $this->info('Daily tasks email sent to all users.');
    }
}
