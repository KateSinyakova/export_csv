<?php

namespace App\Services\Users;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserListService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    const CHUNK_SIZE = 10000;

    public function getUserList(): LengthAwarePaginator
    {
        return $this->userRepository
            ->getBuilder()
            ->select(['id', 'name', 'last_name', 'email', 'phone'])
            ->paginate(50);
    }

    public function exportChunk(int $page, string $filename = null): array
    {
        $exportPath = public_path('exports');

        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        if (!$filename) {
            $filename = 'users_export_' . time() . '.csv';
            $header = "Фамилия,Имя,Телефон,Email\n";
            $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);
            file_put_contents("{$exportPath}/{$filename}", $bom . $header);
        }

        $users =$this->userRepository
            ->getBuilder()
            ->select(['name', 'last_name', 'email', 'phone'])
            ->offset(($page - 1) * self::CHUNK_SIZE)
            ->limit(self::CHUNK_SIZE)
            ->get();

        if ($users->isEmpty()) {
            return ['done' => true, 'filename' => $filename];
        }

        $lines = $users->map(fn($user) => "{$user->last_name},{$user->name},{$user->phone},{$user->email}")
                ->implode("\n") . "\n";

        file_put_contents("{$exportPath}/{$filename}", $lines, FILE_APPEND);

        return ['done' => false, 'filename' => $filename, 'nextPage' => $page + 1];
    }
}
