<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Store a newly created resource
     *
     * @param StoreUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUser $request)
    {
        try {
            $user = User::create($request->all());
            /**
             * We have no support for user view method, but response should be commited
             * with a Location header pointing to the location of the new resource
             **/
            return response()->json(['status' => 'success'], 201, ['Location' => $request->getUri() . '/' . $user->id]);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }
}
