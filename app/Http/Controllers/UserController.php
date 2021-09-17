<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Traits\ResponseHandlerTrait;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ResponseHandlerTrait;

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

    //TODO:RESOURCES->PUT
    public function scopes($id)
    {
        try {
            $userScopes = $this->userRepository->find($id)->permissions->pluck('name')->toArray();
            $scopes = Permission::all()->pluck('name');
            $userRole = $this->userRepository->find($id)->roles->pluck('name')->toArray();
            $roles = Role::all()->pluck('name');

            return view('admin.users.scopes')->with(compact('id', 'userRole' , 'userScopes' , 'scopes' , 'roles'));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), $th->getCode());
        }

    }

    public function scopesUpdate(Request $request , $id)
    {
        try {
            $user = User::find($id);

            
            //revoke and reassign role to user
            $user->syncRoles([$request->input("roles")]);
            
            //revoke and reassign permission to user
            $newPermissions = array_keys(array_diff_key($request->all(), array_flip(['roles','_token'])));
            $user->syncPermissions($newPermissions);

            return new Response(['message' => 'success update'], 200);

        } catch (\Throwable $th) {
            return new Response([ 'message' => $th->getMessage() ], $th->getCode()); 
        }

    }

    public function getScopeByRole(Request $request)
    {
        try {
            $permissions = Role::findByName($request->role)->permissions->pluck('name')->toArray();

             return new Response(['permissions' => $permissions], 200);
        } catch (\Throwable $th) {
            return new Response([ 'message' => $th->getMessage() ], $th->getCode()); 

        }

    }
    
}
