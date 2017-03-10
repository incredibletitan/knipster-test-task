<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created resource
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUser $request)
    {
        return response()->json([
            'ololo'
        ]);
    }
}
