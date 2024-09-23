<?php

namespace App\Http\Controllers;

use App\UseCases\SpecDocSheet\SpecDocSheetFindAction;
use App\UseCases\Tester\TesterFindAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Dashboard画面
     */
    public function index(
        Request $request,
        SpecDocSheetFindAction $specDocSheetFindAction,
        TesterFindAction $testerFindAction,
    ): Response {
        /** @var int */
        $userId = $request->user()?->id;

        $createdSheetDtoArr  = $specDocSheetFindAction->findAllByUserId($userId);
        $executedSheetDtoArr = $testerFindAction->findAllByUserId($userId);

        return Inertia::render('Dashboard', [
            'createdCnt'  => count($createdSheetDtoArr),
            'executedCnt' => count($executedSheetDtoArr),
        ]);
    }
}
