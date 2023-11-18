<?php

namespace Modules\Patient\app\Emails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FileImportSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly User $user) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('iago3220@gmail.com', 'Iago Souto Developer'),
            subject: 'File Import Success',
        );
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('mails.file-import-success', [
            'userName' => $this->user->name
        ]);
    }
}
