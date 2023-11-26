<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LogoutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     summary="Log the user out",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *         ),
     *     ),
     * )
     */
    public function __invoke(): JsonResponse
    {
        $user = auth()->user();
        if ($user) {
            return response()->json([
                'status' => boolval($user->tokens()->delete())
            ]);
        }
        throw new UnauthorizedHttpException('Unauthorized');
    }
}
