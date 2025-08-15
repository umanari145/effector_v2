<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\Cart;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public Cart $cart;
    public array $cartItems;

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, Cart $cart, array $cartItems)
    {
        $this->customer = $customer;
        $this->cart = $cart;
        $this->cartItems = $cartItems;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('ご注文ありがとうございました')
                    ->view('emails.order_confirmation')
                    ->with([
                        'customer' => $this->customer,
                        'cart' => $this->cart,
                        'cartItems' => $this->cartItems
                    ]);
    }
}
