<?php

use Stripe\Stripe;
use App\classes\Session;

$stripe = array(
    'secret_key' => $_ENV['STRIPE_SECRET'],
    'publishable_key' => $_ENV['STRIPE_PUBLISHER_KEY']
);

Session::add('publishable_key', $stripe['publishable_key']);

Stripe::setApiKey($stripe['secret_key']);