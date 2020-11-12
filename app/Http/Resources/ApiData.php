<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiData extends JsonResource
{
    protected $status = false;
    protected $statusCode = 400;
    protected $messages = [];

    public function toArray($request)
    {
        if ($this->resource) {
            $this->setStatus(true);
        }
        return [
            'status' => $this->status,
            'data' => $this->resource ? $this->getData() : [],
            'messages' => $this->messages,
        ];
    }

    public function setStatus($status = false)
    {
        if ($status) {
            $this->setStatusCode(200);
        }
        $this->status = $status;
    }

    public function setMessages($messages = [])
    {
        $this->messages = $messages;
    }

    public function setStatusCode($code = 400)
    {
        $this->statusCode = $code;
    }

    public function getResponse()
    {
        return $this->response()->setStatusCode($this->statusCode);
    }
}
