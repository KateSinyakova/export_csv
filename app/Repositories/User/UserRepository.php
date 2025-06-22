<?php

namespace App\Repositories\User;



use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function getBuilder(): Builder
    {
        return $this->user::query();
    }

}
