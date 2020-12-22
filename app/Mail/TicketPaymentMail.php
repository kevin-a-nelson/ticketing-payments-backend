<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;
use App\Models\TicketPayment;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketPaymentMail extends Mailable
{

    use Queueable, SerializesModels;

    protected $ticketPayment;
    protected $QrCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function createQRCode($ticketPaymentId) {

        $ticketPaymentQRCodeData = "{
            \"ticket_id\": $ticketPaymentId
        }";

        return QrCode::format('png')->size(300)->generate($ticketPaymentQRCodeData);
    }

    public function __construct(TicketPayment $ticketPayment)
    {
        $this->ticketPayment = $ticketPayment;
        $this->QrCode = $this->createQRCode($ticketPayment->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from('nelson67@stolaf.edu')
                ->to($this->ticketPayment->email)
                ->subject("PrepNetwork Ticket Reciept")
                ->view('mail')
                ->with([
                    'ticketPayment' => $this->ticketPayment,
                    'QrCode' => $this->QrCode
                ]);
    }
}
