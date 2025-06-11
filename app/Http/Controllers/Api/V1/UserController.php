<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
try {
        $data = $request->validated();
        
        // Debug: ver qué datos llegan
        \Log::info('Datos validados:', $data);
        
        // Hash la contraseña si existe
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        // Debug: ver qué datos se van a crear
        \Log::info('Datos para crear:', $data);
        
        $user = User::create($data);
        
        // Debug: ver si se creó el usuario
        \Log::info('Usuario creado:', $user->toArray());

        return response()->json(new UserResource($user));
        
    } catch (\Exception $e) {
        // Capturar cualquier error
        \Log::error('Error creando usuario: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'error' => 'Error creando usuario',
            'message' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json(new UserResource($user));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
