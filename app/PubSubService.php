<?php

declare(strict_types=1);

namespace App;

class PubSubService
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Orchestrates a subscription registration
     *
     * @param string $topic
     * @param string $url
     */
    public function registerSubscription(string $topic, string $url)
    {
        $this->subscriptionRepository
            ->addSubscription($topic, $url);
    }
}
