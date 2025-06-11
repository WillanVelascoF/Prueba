<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TicketType;
use Illuminate\Http\Request;
use App\Http\Requests\TicketTypeRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketTypeResource;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ticketTypes = TicketType::paginate();

        return TicketTypeResource::collection($ticketTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketTypeRequest $request): JsonResponse
    {
        $ticketType = TicketType::create();

        return response()->json(new TicketTypeResource($ticketType));
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType): JsonResponse
    {
        return response()->json(new TicketTypeResource($ticketType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketTypeRequest $request, TicketType $ticketType): JsonResponse
    {
        $ticketType->update($request->validated());

        return response()->json(new TicketTypeResource($ticketType));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(TicketType $ticketType): Response
    {
        $ticketType->delete();

        return response()->noContent();
    }
}
