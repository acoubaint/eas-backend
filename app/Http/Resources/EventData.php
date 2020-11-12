<?php

namespace App\Http\Resources;

class EventData extends ApiData
{
    public function getData()
    {
        $user = auth()->user();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('d F Y'),
            'created_by' => $this->creator ? $this->creator->name : null,
            'users_count' => $this->users_count,
            'attended' => ($user && $user->role == 0) ? !!$this->users()->where('users.id', $user->id)->count() : null,
        ];
    }
}
