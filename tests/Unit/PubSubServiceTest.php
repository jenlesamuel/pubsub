<?php

//declare(strict_types=1);

namespace Tests\Unit;

use App\PubSubService;
use Tests\TestCase;
use Mockery as m;

class PubSubServiceTest extends TestCase
{
    /**
     * @var SubscriptionRepository
     */
    protected $subscriptionRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->subscriptionRepository = m::mock("App\SubscriptionRepository");
    }

    public function testSubscriptionSuccessfullyRegistered()
    {
        $topic = "notification";
        $url = "http://localhost:8000/event";

        $this->subscriptionRepository
            ->shouldReceive("addSubscription")
            ->with($topic, $url)
            ->once();

        $service = new PubSubService($this->subscriptionRepository);

        $service->registerSubscription($topic, $url);
    }
}
