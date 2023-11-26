<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ResetPasswordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/reset",
     *     operationId="resetPassword",
     *     tags={"Authentication"},
     *     summary="Reset user password",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid token or validation error."),
     *             @OA\Property(property="errors", type="object", example={"password": {"The password field is required."}}),
     *         ),
     *     ),
     * )
     */
    public function __invoke()
    {
        $user = auth()->user();
        $status = Password::sendResetLink(['email' => $user->email]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => true])
            : response()->json(['status' => false], 422);
    }
}
