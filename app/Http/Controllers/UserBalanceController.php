<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyOperationWithdrawRequest;
use App\MoneyOperation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserBalanceController extends Controller
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

    public function deposit(MoneyOperationWithdrawRequest $request)
    {
        try {
            MoneyOperation::deposit($request->all());
            return response()->json(['status' => 'success'], 201);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }
}
