<?php


namespace App\Services;

use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Token;

class StripeTokenService
{
    /**
     * StripeService constructor.
     */
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * @param array $card
     *
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getToken(array $card): string
    {
        $tokenObject = Token::create(['card' => $card]);

        return $tokenObject->id;
    }
}
