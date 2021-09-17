<?php

namespace App\Http\Controllers\bms;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PermissionInterface;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Illuminate\Pagination\Paginator;
use App\Traits\ScopeHandlerTrait;

class BmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $payload;
    private $scopes;
    private $paginate =10;
    use ScopeHandlerTrait;

    //TODO::Buat DI utk JwtAuth
    public function __construct()
    {
        $this->payload = JWTAuth::parseToken()->getPayload();
        $this->scopes = JWTAuth::parseToken()->getPayload()->get('scopes');

    }

    // 127.0.0.1:8000/api/bms?page=2&per_page=10
    public function index(Request $request)
    {
        try {
            if($this->validateScope('bms-get' , $this->scopes)){
                $this->validateScope('bms-get' , $this->scopes);
                $currentPage = $request->page;
                $this->paginate = $request->per_page;

                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $status = $this->payload->get('status');
                $result = User::where('status' , $status)->paginate($this->paginate);

                return response()->json($result,200);
            } else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if($this->validateScope('bms-post' , $this->scopes)){
                return response()->json("bms-post has permission success",200);
            }else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if($this->validateScope('bms-get' , $this->scopes)){
                return response()->json("bms-get has permission success",200);
            }else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if($this->validateScope('bms-put' , $this->scopes)){
                return response()->json("bms-put has permission success",200);
            }else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if($this->validateScope('bms-delete' , $this->scopes)){
                return response()->json("bms-delete has permission success",200);
            }else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }
}
