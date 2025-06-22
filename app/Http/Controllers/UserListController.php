<?php

namespace App\Http\Controllers;

use App\Services\Users\UserListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserListController extends Controller
{
    public function __construct(
        private readonly UserListService $userListService,
    ) {}

    public function index(): Response
    {
        $userList = $this->userListService->getUserList();

        return response()->view('user-list.index', [
            'userList' => $userList,
        ]);
    }

    /**
     * Пошаговая выгрузка пользователей для экспорта в CSV (AJAX)
     */
    public function export(Request $request): JsonResponse
    {
        try {
            $page = $request->get('page', 1);
            $filename = $request->get('filename');

            $result = $this->userListService->exportChunk($page, $filename);

            return response()->json($result);
        } catch (\Throwable $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }

    public function download($filename)
    {
        $path = public_path("exports/{$filename}");

        if (file_exists($path)) {
            return response()->download($path)->deleteFileAfterSend();
        }

        abort(404);
    }
}
