<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $output = $this->userRepository->users($input)->toArray();

            $response = [
                "draw"            => $input['draw'],
                "recordsTotal"    => intval($output['total']),
                "recordsFiltered" => intval($output['total']),
                "data"            => $output['data']
            ];
            return response()->json($response, 200);
        }

        return view('admin.users.index');
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return view('admin.users.show')->with('user', $user);
    }

    public function edit(Request $request)
    {
        dd($request->all());
        // $user = $this->userRepository->find($id);

        // return view('admin.users.show')->with('user', $user);
    }

}
