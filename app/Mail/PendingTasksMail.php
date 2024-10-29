<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingTasksMail extends Mailable
//  implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;
    public $tasks;

    /**
     * Create a new message instance.
     */
    public function __construct( $user,$tasks)
    {
        $this->user= $user;
        $this->tasks = $tasks;

    }

      /**
     * Define the envelope for the email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Pending Tasks for Today',
        );
    }

    /**
     * Define the content for the email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pendingtasks',
            with: [
                'tasks' => $this->tasks,
            ],
        );
    }

    /**
     * Define any attachments for the email.
     */
    public function attachments(): array
    {
        return [];
    }
    /**
     * Build the email message for pending tasks.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->subject('Your Pending Tasks for Today')
    //                 ->view('emails.pendingtasks')
    //                 ->with([
    //                     'tasks' => $this->tasks,
    //                 ]);
    // }
}
