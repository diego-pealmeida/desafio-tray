<?php

namespace App\Mail;

use App\Data\DailyOrderReportData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UsersDailyOrderReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public DailyOrderReportData $report, public string $name)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Chegou seu relatório diário de vendas!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.users-resume',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
