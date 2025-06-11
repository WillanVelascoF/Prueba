<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TicketType;
use Illuminate\Http\Request;
use App\Http\Requests\TicketTypeRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketTypeResource;
use Illuminate\Support\Facades\Log;

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
        $ticketType = TicketType::create($request->validated());

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

    
 public function updateStatus(Request $request, $id): JsonResponse
    {
        
        try {
        // Debug: Verificar qué datos llegan
        Log::info('updateStatus called', [
            'id' => $id,
            'request_data' => $request->all(),
            'status' => $request->status
        ]);
        
        $ticket = TicketType::findOrFail($id);
        
        // Debug: Verificar que se encuentra el ticket
        Log::info('Ticket found', [
            'ticket_id' => $ticket->id,
            'current_status' => $ticket->status
        ]);
        
        $updateData = ['status' => $request->status];
        
        // Debug: Verificar datos a actualizar
        Log::info('Update data', $updateData);
        
        // Verificar que el campo status esté en $fillable
        Log::info('Ticket fillable fields', $ticket->getFillable());
        
        $result = $ticket->update($updateData);
        
        // Debug: Verificar si la actualización fue exitosa
        Log::info('Update result', [
            'success' => $result,
            'new_status' => $ticket->fresh()->status
        ]);
        
        return response()->json([
            'message' => 'Status updated successfully',
            'data' => [
                'id' => $ticket->id,
                'new_status' => $ticket->status,
                'update_result' => $result
            ]
        ]);
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Ticket not found', ['id' => $id]);
        return response()->json([
            'error' => 'Ticket no encontrado',
            'message' => 'El ticket con ID ' . $id . ' no existe'
        ], 404);
        
    } catch (\Exception $e) {
        Log::error('Error updating ticket status', [
            'id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'error' => 'Error updating status',
            'message' => $e->getMessage()
        ], 500);
    }
    }
}
