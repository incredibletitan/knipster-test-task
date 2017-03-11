<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Store a newly created resource
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
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

    /**
     * Updates resource
     *
     * @param integer $id - User id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        if (!($user = User::find($id))) {
            return response()->json(['status' => 'fail'], 404);
        }

        try {
            $user->update($request->all());
            return response()->json(['status' => 'success'], 204);
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        }
        return response()->json(['status' => 'fail'], 500);
    }
}
