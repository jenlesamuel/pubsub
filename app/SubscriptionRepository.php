<?php

declare(strict_types=1);

namespace App;

interface SubscriptionRepository
{
    /**
     * Registers a subscriber
     *
     * @param string $topic
     * @param string $url
     */
    public function addSubscription(string $topic, string $url): void;

    /**
     * Returns a collection of all registered subscriptions
     *
     * @return array
     */
    public function allSubscriptions(): array;
}
