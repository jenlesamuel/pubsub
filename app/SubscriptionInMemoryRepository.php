<?php

declare(strict_types=1);

namespace App;

final class SubscriptionInMemoryRepository implements SubscriptionRepository
{
    /**
     * @var array
     */
    private $subscriptions =  [];

    public function addSubscription(
        string $topic,
        string $url
    ): void
    {
        $this->subscriptions [$topic] = $url;
    }

    public function allSubscriptions(): array
    {
        return $this->subscriptions;
    }
}
