<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyOperationReportRequest;
use App\Http\Requests\MoneyOperationWithdrawRequest;
use App\MoneyOperation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FinancialOperationsController extends Controller
{
    public function withdraw(MoneyOperationWithdrawRequest $request)
    {
        try {
            MoneyOperation::withdraw($request->all());
            return response()->json(['status' => 'success'], 201);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }

    public function deposit(Request $request)
    {
        try {
            MoneyOperation::deposit($request->all());
            return response()->json(['status' => 'success'], 201);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }

    public function index(MoneyOperationReportRequest $request)
    {
        if (!($dateStart = $request->input('date_start'))
            || !($dateEnd = $request->input('date_end'))
        ) {
            $dateEnd = date('Y-m-d', strtotime('now'));
            $dateStart = date('Y-m-d', strtotime('-7 days'));
        }

        try {
            return response()->json(MoneyOperation::report($dateStart, $dateEnd));
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }
}
