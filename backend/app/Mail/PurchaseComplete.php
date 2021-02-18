<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseComplete extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $total)
    {
        $this->data = $data;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.purchase-complete')
            ->with('data', $this->data)
            ->with('total', $this->total);
    }
}
