<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\NoSubscriberFoundException;

class PubSubService
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct(
        SubscriptionRepository $subscriptionRepository,
        HttpClient $httpClient)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->httpClient = $httpClient;
    }

    /**
     * Orchestrates a subscription registration
     *
     * @param string $topic
     * @param string $url
     *
     * @return array
     */
    public function registerSubscription(string $topic, string $url): array
    {
        $this->subscriptionRepository
            ->addSubscription($topic, $url);

        return [
            "topic" => $topic,
            "url" => $url
        ];
    }

    /**
     * Orchestrates publishing an event
     *
     * @param string $topic
     * @param string $content
     * @throws NoSubscriberFoundException
     */
    public function publish(string $topic, string $content)
    {
        $subscribers = $this->subscriptionRepository
            ->getSubscribers($topic);


        if (empty($subscribers)) {
            throw new NoSubscriberFoundException(
                "No registered subscriber for topic {$topic}");
        }

        $data = json_encode(
            [
                "topic" => $topic,
                "data" => json_decode($content, true)
            ]
        );

        // Send message to all subscribers
        $this->httpClient->concurrentRequest(
            "POST",
            $data,
            $subscribers
        );
    }
}
