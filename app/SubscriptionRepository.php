<?php

declare(strict_types=1);

namespace App;

interface SubscriptionRepository
{
    /**
     * Registers a subscription
     *
     * @param string $topic
     * @param string $url
     */
    public function addSubscription(string $topic, string $url): void;

    /**
     * Returns a collection of all subscribers to a topic
     *
     * @param string $topic
     * @return array
     */
    public function getSubscribers(string $topic): array;
}
