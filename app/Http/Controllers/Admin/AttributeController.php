<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\Attributes\{CreateAttributeRequest, UpdateAttributeRequest};

use App\Services\AttributeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        return response()->json($this->attributeService->getAllAttributes());
    }

    public function store(CreateAttributeRequest $request)
    {
        return response()->json($this->attributeService->createAttribute($request->validated()), 201);
    }

    public function show(int $id)
    {
        return response()->json($this->attributeService->getAttributeById($id));
    }

    public function update(UpdateAttributeRequest $request, int $id)
    {
        return response()->json($this->attributeService->updateAttribute($id, $request->validated()));
    }

    public function destroy(int $id)
    {
        $this->attributeService->deleteAttribute($id);
        return response()->json(['message' => 'Attribute deleted successfully']);
    }
}
