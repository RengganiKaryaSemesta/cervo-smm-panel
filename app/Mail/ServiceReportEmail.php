<?php
namespace App\Mail;

use App\Models\ServiceReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ServiceReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(public ServiceReport $serviceReport)
    {
        $this->pdfPath = storage_path('app/public/' . $this->serviceReport->file_pdf_generated);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Service Report - '.$this->serviceReport->service_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.service-report-email', // Replace with the actual view path
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)->withMime('application/pdf'),
        ];
    }
}
