<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Services\PriorityService;

class PriorityController extends Controller
{
    protected $service;

    public function __construct(PriorityService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PriorityResource::collection($this->service->list());
    }
}
