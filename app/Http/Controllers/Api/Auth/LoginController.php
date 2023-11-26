<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function Symfony\Component\Translation\t;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     summary="Log in a user",
     *     description="Logs in a user with the provided email and password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="koxlikyan1995@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="1|yY50zVwAiqd1qmVgpbStZKwYdYTnsLK4Gn0w5yPLe5980e30"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid credentials"),
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
     * @throws ValidationException
     */
    public function __invoke(Request $request, LoginService $service): JsonResponse
    {
        $validator = $service->validator($request->all());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $token = $service->handle($validator->validated());
        return response()->json([
            'status' => true,
            'token' => $token
        ]);
    }
}
