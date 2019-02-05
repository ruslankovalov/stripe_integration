<?php

namespace App\Services;

use App\Entity\User;
use App\Model\Card;
use Stripe\Customer;
use Stripe\Token;

class StripeService
{
    /**
     * @var string
     */
    private $stripeSecretKey;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripeSecretKey = $stripeSecretKey;
    }

    public function createStripeCustomer(User $user)
    {
        $customer = Customer::create(
            ['description' => "Customer for {$user->getEmail()}"],
            ['api_key' => $this->stripeSecretKey]
        );

        return $user->setStripeCustomerId($customer->id);
    }

    public function addCardToCustomer(Card $card, User $user)
    {
        $token = Token::create(
            [
                'card' => [
                    'number' => $card->getNumber(),
                    'exp_month' => $card->getExpirationMonth(),
                    'exp_year' => $card->getExpirationYear(),
                    'cvc' => $card->getCvc(),
                ],
            ],
            ['api_key' => $this->stripeSecretKey]
        );

        $customer = Customer::retrieve(
            $user->getStripeCustomerId(),
            ['api_key' => $this->stripeSecretKey]
        );

        $card = $customer->sources->create(['source' => $token->id]);
        $customer->default_source = $card->id;

        $customer->save();

        if ($customer->sources->total_count > 1) {
            foreach ($customer->sources->data as $card) {
                if ($card->id != $customer->default_source) {
                    $card->delete();
                }
            }
        }

        return $user;
    }
}
