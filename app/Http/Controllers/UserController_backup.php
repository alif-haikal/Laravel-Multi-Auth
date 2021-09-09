<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Traits\ResponseHandler;
use Exception;
use Illuminate\Http\Request;
class UserController extends Controller
{
    use ResponseHandler;

    private $userRepository;

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

    //TODO:RESOURCES->GET
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return view('admin.users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('admin.users.edit')->with('user', $user);
    }

    //TODO:RESOURCES->PUT
    public function update($id , Request $request)
    {
        try {
            $input = $request->all();
            $user = $this->userRepository->updateUser($input , $id );
            return $this->successResponse('Successfully Update Data');

        } catch (\Throwable $th) {
			throw new Exception($th->getMessage(), $th->getCode());
        }

    }

}
