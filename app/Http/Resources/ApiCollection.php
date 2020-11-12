<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiCollection extends ResourceCollection
{
    protected $status = false;
    protected $statusCode = 400;
    protected $messages = [];

    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'data' => $this->getCollection(),
            'messages' => $this->messages,
        ];
    }

    public function getCollection()
    {
        return $this->resource->map(function($data, $key) {
            return (new $this->data_class($data))->getData();
        });
    }

    public function setStatus($status = false)
    {
        $this->status = $status;
    }

    public function setStatusCode($code = 400)
    {
        $this->statusCode = $code;
    }

    public function setMessages($messages = [])
    {
        $this->messages = $messages;
    }

    public function getResponse()
    {
        return $this->response()->setStatusCode($this->statusCode);
    }
}
