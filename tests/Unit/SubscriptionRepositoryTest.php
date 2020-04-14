<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\PubSubService;
use Tests\TestCase;
use Mockery as m;
use App\SubscriptionInMemoryRepository;

class SubscriptionRepositoryTest extends TestCase
{

    public function testNewSubscriptionSuccessfullyAdded()
    {
        $subscriptionRepository = new SubscriptionInMemoryRepository();
        $this->assertEquals(0, count($subscriptionRepository->allSubscriptions()));

        $subscriptionRepository->addSubscription("notification", "http://localhost:8000/event");
        $this->assertEquals(1, count($subscriptionRepository->allSubscriptions()));
    }
}
