<?php

namespace App\Http\Controllers\spikpa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Illuminate\Pagination\Paginator;

class SpikpaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $payload;
    private $paginate =10;

    //TODO::Buat DI utk JwtAuth
    public function __construct()
    {
        $this->payload = JWTAuth::parseToken()->getPayload();

    }

    // 127.0.0.1:8000/api/get_user?page=2&per_page=30
    public function index(Request $request)
    {
        $currentPage = $request->page;
        $this->paginate = $request->per_page;

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $status = $this->payload->get('status');
        $result = User::where('status' , $status)->paginate($this->paginate);

        return response()->json($result,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
