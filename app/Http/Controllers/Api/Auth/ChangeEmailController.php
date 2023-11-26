<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\ChangeEmailEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ChangeEmailController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/change-email",
     *     summary="Send confirmation code",
     *     tags={"Authentication"},
     *     security={
     *          {"sanctum": {}}
     *      },
     *     @OA\Response(
     *         response=200,
     *         description="Confirmation code sent successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Check your email address. The confirmation code has been sent successfully."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
    public function send(): JsonResponse
    {
        try {

            $user = auth()->user();
            $code = random_number(4);
            $user->verification_code = $code;
            $user->save();
            event(new ChangeEmailEvent($user->email, $code));
            return response()->json([
                'status' => true,
                'message' => 'Check your email address. The confirmation code has been sent successfully.'
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }catch (\Exception  $e) {
            Log::error($e);
            return response()->json([
                'status' => false,
                'message' => 'Server error'
            ], 500);
        }

    }

    /**
     * @OA\Patch(
     *     path="/api/change-email",
     *     summary="Change email address",
     *     tags={"Authentication"},
     *     security={
     *          {"sanctum": {}}
     *      },
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="Confirmation code",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="New email address",
     *         required=true,
     *         @OA\Schema(type="string", format="email")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email address changed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Email address changed successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"code": {"The code field is required."}})
     *         )
     *     )
     * )
     */
    public function change(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'code' => ['required', 'numeric', Rule::exists('users', 'verification_code')],
                'email' => ['required', 'email', 'unique:users,email'],
            ]);
            $user = auth()->user();
            $user->email = $request->input('email');
            $user->verification_code = null;
            return response()->json([
                'status' => $user->save(),
                'message' => 'Email address changed successfully'
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }catch (\Exception  $e) {
            Log::error($e);
            return response()->json([
                'status' => false,
                'message' => 'Server error'
            ], 500);
        }
    }
}
