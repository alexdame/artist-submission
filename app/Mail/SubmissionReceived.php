<?php

// app/Mail/SubmissionReceived.php

namespace App\Mail;

use App\Models\SongSubmission; // Make sure to import your SongSubmission model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $submission; // Public property to pass data to the view

    /**
     * Create a new message instance.
     */
    public function __construct(SongSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Song Submission to Artistt Has Been Received!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.submissions.received', // Points to resources/views/emails/submissions/received.blade.php
            with: [
                'artistName' => $this->submission->artist_name,
                'songTitle' => $this->submission->song_title,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}