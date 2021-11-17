<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponser
{

    /**
     * @method response(array $data = [], int $code = Response::HTTP_OK)
     *
     * @param  ResourceCollection|JsonResource|array $data
     * @param  int $code
     * 
     * @return string|false
     */
    private function response($data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * @method successResponse($data = [], $code = Response::HTTP_OK)
     *
     * @param  array $data
     * @param  int $code
     * 
     * @return string|false
     */
    protected function successResponse(array $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->response([
                'data' => $data
            ],
            $code
        );
    }

    /**
     * @method noContentResponse(int $code = Response::HTTP_NO_CONTENT)
     *
     * @param  int $code
     * 
     * @return string|false
     */
    protected function noContentResponse(int $code = Response::HTTP_NO_CONTENT): JsonResponse
    {
        return $this->response(null, $code);
    }

    /**
     * @method errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
     *
     * @param  string|array $message
     * @param  int $code
     * 
     * @return string|false
     */
    protected function errorResponse($messages, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->response([
                'error' => $messages,
                'code' => $code
            ],
            $code
        );
    }

    /**
     * @method showAll(ResourceCollection $collection, int $code = Response::HTTP_OK)
     *
     * @param  ResourceCollection $collection
     * @param  int $code
     * 
     * @return string|false
     */
    protected function showAll(ResourceCollection $collection, int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->response(
            $collection,
            $code
        );
    }

    /**
     * @method showOne(JsonResource $resource, int $code = Response::HTTP_OK)
     *
     * @param  JsonResource $resource
     * @param  int $code
     * 
     * @return string|false
     */
    protected function showOne(JsonResource $resource, int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->response([
                'data' => $resource
            ],
            $code
        );
    }

}