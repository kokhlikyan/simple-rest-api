<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{

    public function __construct(private readonly CommentRepository $commentRepository)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/comment",
     *     summary="Create a new comment",
     *     tags={"Comment"},
     *      security={
     *          {"sanctum": {}}
     *      },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Comment data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="how are you"),
     *             @OA\Property(property="article_id", type="integer", example=10),
     *             @OA\Property(property="user_id", type="integer", example=3),
     *         )
     *     ),
     *    @OA\Response(
     *          response=201,
     *          description="Comment created successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="boolean", example=true),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="message", type="string", example="test"),
     *                  @OA\Property(property="article_id", type="integer", example=10),
     *                  @OA\Property(property="user_id", type="integer", example=3),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-26T17:45:21.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-11-26T17:45:21.000000Z"),
     *                  @OA\Property(property="id", type="integer", example=3),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"message": {"The message field is required."}})
     *         )
     *     )
     * )
     * @throws ValidationException
     */

    public function add(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make(
            ['user_id' => $user->id,
                ...$request->all()
            ], [
            'message' => ['required', 'string'],
            'article_id' => ['required', Rule::exists('articles', 'id')],
            'user_id' => ['required', Rule::exists('users', 'id')]
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $article = $this->commentRepository->add($validator->validated());
        return response()->json([
            'status' => true,
            'data' => $article
        ], 201);
    }
}
