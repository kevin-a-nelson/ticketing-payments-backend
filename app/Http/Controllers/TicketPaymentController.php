<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Mail\TicketPaymentMail;
use App\Models\TicketPayment;

use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

\Stripe\Stripe::setApiKey('sk_test_8ToiQqln2VawmSzMhXxCYsYM00yJNTpbQS');

class TicketPaymentController extends Controller
{
    public function store(Request $request)
    {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $request->total_cost,
            'currency' => 'usd',
        ]);

        $output = [
            'publishableKey' => 'sk_test_8ToiQqln2VawmSzMhXxCYsYM00yJNTpbQS',
            'clientSecret' => $paymentIntent->client_secret,
        ];

        $ticketPayment = new TicketPayment($request->all()); 
        $ticketPayment->save();

        Mail::send(new TicketPaymentMail($ticketPayment));
         
        return $ticketPayment;
    }

    public function claimTicket($id) {
        $ticketPayment = TicketPayment::findOrFail($id);

        if($ticketPayment->claimed) {
            return  json_encode([ 
                "alreadyClaimed" => True,
                "claimedDate" => $ticketPayment->claimed_date,
                "message" => "This ticket was already claimed"
                ]);
        }

        $ticketPayment->claimed_date = Carbon::now()->toDateTimeString();
        $ticketPayment->claimed = True;

        $ticketPayment->save();
        return json_encode([ 
            "alreadyClaimed" => False,
            "claimedDate" => $ticketPayment->claimed_date,
            "message" => "This ticket has now been claimed"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return 204;
    }
}
