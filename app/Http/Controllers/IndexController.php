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
     * @return void
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
        $subscriberUrl = $request->input("callback_url");

        if (! $subscriberUrl) {
            return response()->json(
                "callback_url query parameter is required",
                400
            );
        }

        $this->pubSubService->registerSubscription($topic, $subscriberUrl);

        return response()->json(
            "Success",
            201
        );
    }
}
