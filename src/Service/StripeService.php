<?php

namespace App\Service;

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class StripeService
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
        Stripe::setApiKey($secretKey);
    }

    public function createCustomer($email, $source)
    {
        $customer = Customer::create([
            'email' => $email,
            'source' => $source
        ]);
        return $customer;
    }

    public function createCharge($amount, $currency, $description, $customer)
    {
        $charge = Charge::create([
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
        ]);
        return $charge;
    }
}
