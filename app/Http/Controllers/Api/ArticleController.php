<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleRepository $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/article",
     *     summary="Get a list of articles",
     *     tags={"Article"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="Article 1"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="This is a sample article."
     *                         ),
     *                         @OA\Property(
     *                             property="image",
     *                             type="string",
     *                             example="storage/images/articles/article1.jpg"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2023-11-26T13:48:04.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2023-11-26T13:48:04.000000Z"
     *                         ),
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="next_page_url",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/article?page=2"
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/article"
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="prev_page_url",
     *                     type="string",
     *                     example=null
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="integer",
     *                     example=20
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $this->repository->getAllArticles()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/article/{id}",
     *     summary="Get an article by ID",
     *     tags={"Article"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Article 1"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="This is a sample article."
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     example="storage/images/articles/article1.jpg"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2023-11-26T13:48:04.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2023-11-26T13:48:04.000000Z"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Article not found."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "id": {
     *                         "The selected id is invalid."
     *                     }
     *                 }
     *             )
     *         )
     *     )
     * )
     * @throws ValidationException
     */
    public function show($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['required', Rule::exists('articles', 'id')]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return response()->json([
            'status' => true,
            'data' => $this->repository->getArticleByID($id)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/article",
     *     summary="Create a new article",
     *     tags={"Article"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Article data",
     *         @OA\JsonContent(
     *             required={"name", "description", "image"},
     *             @OA\Property(property="name", type="string", example="Test 111"),
     *             @OA\Property(property="description", type="string", example="Lorem"),
     *             @OA\Property(property="image", type="string", format="binary"),
     *         )
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Create new article",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="Article 1"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      example="This is a sample article."
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      example="storage/images/articles/article1.jpg"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time",
     *                      example="2023-11-26T13:48:04.000000Z"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time",
     *                      example="2023-11-26T13:48:04.000000Z"
     *                  ),
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
     *             @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}, "description": {"The description field is required."}, "image": {"The image field is required."}})
     *         )
     *     )
     * )
     * @throws ValidationException
     */
    public function store(Request $request, ArticleService $service): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:2048'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $article = $service->create($validator->validated(), $this->repository);
        return response()->json([
            'status' => true,
            'data' => $article
        ], 201);
    }


    /**
     * @OA\Delete(
     *     path="/api/article/{id}",
     *     summary="Delete an article by ID",
     *     tags={"Article"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the article to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Article not found."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"id": {"The selected id is invalid."}})
     *         )
     *     )
     * )
     * @throws ValidationException
     */
    public function delete($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => ['required', Rule::exists('articles', 'id')]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return response()->json([
            'status' => $this->repository->deleteArticle($id)
        ]);
    }
}
