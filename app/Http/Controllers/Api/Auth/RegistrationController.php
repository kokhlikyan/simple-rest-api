<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    /**
     * @throws ValidationException
     */
    /**
     * @OA\Post(
     *     path="/api/registration",
     *     operationId="registrationUser",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Registration a new user with the provided information",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "last_name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Norayr"),
     *             @OA\Property(property="last_name", type="string", example="kokhlikyan"),
     *             @OA\Property(property="email", type="string", format="email", example="koxlikyan1995@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="1|yY50zVwAiqd1qmVgpbStZKwYdYTnsLK4Gn0w5yPLe5980e30"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}}),
     *         ),
     *     ),
     * )
     */
    public function __invoke(Request $request, RegistrationService $service): JsonResponse
    {
        $validator = $service->validator($request->all());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $user = $service->handle($validator->validated());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'token' => $token
        ]);
    }
}
