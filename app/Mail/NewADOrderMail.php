<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewADOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $ad;
    public $item;
    public $dealer;

    public function __construct($transaction, $ad, $item, $dealer)
    {
        $this->transaction = $transaction;
        $this->ad = $ad;
        $this->item = $item;
        $this->dealer = $dealer;
    }

    public function build()
    {
        return $this->subject('New Order')
                    ->view('emails.ad_order');
    }
}
