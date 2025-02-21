<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * ユーザー一覧
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('');
    }
}
