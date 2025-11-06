<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Services\PriorityService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PriorityController extends Controller
{
    /**
     * @var PriorityService
     */
    protected $service;

    /**
     * Inyecta el servicio de prioridades.
     * @param PriorityService $service
     */
    public function __construct(PriorityService $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna un listado de todas las prioridades disponibles.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PriorityResource::collection($this->service->list());
    }
}