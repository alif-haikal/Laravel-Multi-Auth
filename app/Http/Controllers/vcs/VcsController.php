<?php

namespace App\Http\Controllers\vcs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ScopeInterface;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Illuminate\Pagination\Paginator;
use App\Traits\ScopeHandlerTrait;

class VcsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $payload;
    private $Scopes;
    private $paginate =10;
    use ScopeHandlerTrait;

    //TODO::Buat DI utk JwtAuth
    public function __construct()
    {
        $this->payload = JWTAuth::parseToken()->getPayload();
        $this->Scopes = JWTAuth::parseToken()->getPayload()->get('scopes');

    }

    // 127.0.0.1:8000/api/vcs?page=2&per_page=10
    public function index(Request $request)
    {
        try {
            if($this->validateScope('vcs-get' , $this->Scopes)){

                $currentPage = $request->page;
                $this->paginate = $request->per_page;

                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $status = $this->payload->get('status');
                $result = User::where('status' , $status)->paginate($this->paginate);

                return response()->json($result,200);
            }else {
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
            if($this->validateScope('vcs-post' , $this->Scopes)){
                return response()->json("vcs-post has Scope success",200);
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
            if($this->validateScope('vcs-get' , $this->Scopes)){
                return response()->json("vcs-get has Scope success",200);
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
            if($this->validateScope('vcs-put' , $this->Scopes)){
                return response()->json("vcs-put has Scope success",200);
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
            if($this->validateScope('vcs-delete' , $this->Scopes)){
                return response()->json("vcs-delete has Scope success",200);
            }else {
                return response()->json(['error' => 'unauthorized process'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error processing data'], 500);
        }
    }
}
