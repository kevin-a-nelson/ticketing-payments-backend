<h1>Prep Network Ticket Reciept</h1>
<p><strong>team name:</strong> {{$ticketPayment->team_name}}</p>
<p><strong>total cost:</strong> {{$ticketPayment->total_cost}}</p>
<p><strong>number of tickets:</strong> {{$ticketPayment->number_of_tickets}}</p>
<img src="{!!$message->embedData($QrCode, 'QrCode.png', 'image/png')!!}">