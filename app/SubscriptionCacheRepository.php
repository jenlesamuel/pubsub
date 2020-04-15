<?php

declare(strict_types=1);

namespace App;

use  Illuminate\Support\Facades\Cache;

final class SubscriptionCacheRepository implements SubscriptionRepository
{

    const SUBSCRIPTIONS = "subscriptions";

    public function addSubscription(
        string $topic,
        string $url
    ): void
    {
        $subscriptions = Cache::get(static::SUBSCRIPTIONS);

        if (!$subscriptions) {
            $subscriptions = [];
        }

        $subscriptions[$topic][$url] = true;

        Cache::put(static::SUBSCRIPTIONS, $subscriptions);
    }

    public function getSubscribers(string $topic): array
    {
        $subscriptions = Cache::get(static::SUBSCRIPTIONS);

        if (!$subscriptions || !isset($subscriptions[$topic])) {
            return [];
        }

        return array_keys($subscriptions[$topic]);
    }
}
