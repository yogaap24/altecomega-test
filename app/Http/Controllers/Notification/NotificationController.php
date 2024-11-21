<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Services\Notification\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    protected NotificationService $service;

    /**
     * @param NotificationService $service
     * @param LoginRequest $request
     */
    public function __construct(NotificationService $service, Request $request)
    {
        $this->service = $service;
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $notifications = $this->service->dataTable($request);
        return $this->sendSuccess($notifications, null, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNotificationRequest $request
     * @return JsonResponse
     */
    public function store(StoreNotificationRequest $request)
    {
        $notification = $this->service->create($request);
        return $this->sendSuccess($notification, null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $notification = $this->service->getById($id);
        return $this->sendSuccess($notification, null, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNotificationRequest $request
     * @param String $id
     * @return JsonResponse
     */
    public function update(UpdateNotificationRequest $request, string $id)
    {
        $notification = $this->service->update($id, $request);
        return $this->sendSuccess($notification, null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $notification = $this->service->delete($id);
        return $this->sendSuccess($notification, null, 200);
    }
}
