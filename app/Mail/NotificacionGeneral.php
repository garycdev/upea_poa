<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionGeneral extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $titulo;
    public $url;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titulo, $mensaje, $url, $color)
    {
        $this->titulo  = $titulo;
        $this->mensaje = $mensaje;
        $this->url     = $url;
        $this->color   = $color;
    }

    public function build()
    {
        return $this->subject($this->titulo)
            ->markdown('emails.notificacion');
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notificacion General',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.notificacion',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
