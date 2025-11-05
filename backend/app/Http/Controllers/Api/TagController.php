<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    /**
     * @var TagService
     */
    protected $service;

    /**
     * Inyecta el servicio de etiquetas.
     * @param TagService $service
     */
    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna un listado de todas las etiquetas (tags) disponibles.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection($this->service->list());
    }
}