<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponser
{

    private function response($data = [], $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    protected function successResponse($data = [], $code = Response::HTTP_OK)
    {
        return $this->response([
                'data' => $data
            ],
            $code
        );
    }

    protected function errorResponse($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->response([
                'error' => $message,
                'code' => $code
            ],
            $code
        );
    }

    protected function showAll(ResourceCollection $collection, $code = Response::HTTP_OK)
    {
        return $this->response(
            $collection,
            $code
        );
    }

    protected function showOne(JsonResource $resource, $code = Response::HTTP_OK)
    {
        return $this->response([
                'data' => $resource
            ],
            $code
        );
    }

}