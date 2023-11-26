<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserProfileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User details",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", example="2023-11-26T15:03:24.000000Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-26T15:03:24.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-11-26T15:03:24.000000Z"),
 * )
 */

class ProfileController extends Controller
{
    public function __construct(private readonly UserProfileRepository $userProfileRepository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get the authenticated user",
     *     tags={"User"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/User"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $this->userProfileRepository->getAuthUser()
        ]);
    }
}
