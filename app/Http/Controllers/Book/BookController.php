<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Services\Book\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends ApiController
{
    protected BookService $service;

    /**
     * @param BookService $service
     * @param Request $request
     */
    public function __construct(BookService $service, Request $request)
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
        $data = $this->service->dataTable($request);
        return $this->sendSuccess($data, null, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        try {
            $datum = $this->service->create($request);
            return $this->sendSuccess($datum, null, 201);
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        try {
            $datum = $this->service->getById($id);
            return $this->sendSuccess($datum, null, 200);
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookRequest $request
     * @param String $id
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        try {
            $datum = $this->service->update($id, $request);
            return $this->sendSuccess($datum, null, 200);
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $datum = $this->service->delete($id);
            return $this->sendSuccess($datum, null, 200);
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage(), 500);
        }
    }
}
