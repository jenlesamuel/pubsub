<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\PubSubService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @var PubSubService
     */
    public $pubSubService;

    /**
     * Create a new controller instance.
     *
     * @param PubSubService $pubSubService
     */
    public function __construct(PubSubService $pubSubService)
    {
        $this->pubSubService = $pubSubService;
    }

    /**
     * Handles the registration of a subscriber
     * @param Request $request
     * @param string $topic
     *
     * @return JsonResponse
     */
    public function registerSubscription(Request $request, string $topic): JsonResponse
    {
        $content = $request->getContent();

        if (! $content) {
            return response()->json(
                ["error" => "Empty request body", "status" => false], 400
            );
        }

        $content = json_decode($content, true);
        if (!isset($content["url"])) {
            return response()->json(
                ["error" => "Url parameter is required", "status" => false], 400
            );
        }

        $subscriberUrl = $content["url"];
        $data = $this->pubSubService->registerSubscription($topic, $subscriberUrl);

        return response()->json(["data" => $data, "status" => true],201);
    }

    /**
     * Handles publishing an event
     *
     * @param Request $request
     * @param string $topic
     * @throws \App\Exceptions\NoSubscriberFoundException
     * @return JsonResponse
     */
    public function publish(Request $request, string $topic): JsonResponse
    {
        $content = $request->getContent();
        $this->pubSubService->publish($topic, $content);

        return response()->json(["data" => "success", "status" => true],200);
    }

    /**
     * Prints out event data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function event(Request $request)
    {
        echo $request->getContent();
        return response()->json(["data" => "success", "status" => true], 200);
    }
}
