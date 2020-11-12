<?php

namespace App\Http\Resources;

class UserData extends ApiData
{
    public function getData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role_name' => $this->role_name,
        ];
    }
}
