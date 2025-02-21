<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

/**
 * 管理者プロジェクト
 */
class ProjectController extends Controller
{
    /**
     * プロジェクト一覧
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('');
    }
}
