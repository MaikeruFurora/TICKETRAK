<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    protected $dataTable;

    public function __construct(DataTableService $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    public function accountProfile() {
        return view('accounts.profile');
    }

    public function accountUser() {
        return view('accounts.user');
    }

    public function accountCreateUser() {
        $roles = User::ROLES;
        return view('accounts.user-create',compact('roles'));
    }

    public function accountUserStore(Request $request) {

        $request->validate([
            'name'      => 'required|string',
            'username'  => 'required|string|unique:users,username',
            'email'     => 'required|email',
            'password'  => 'required|string',
            'role'      => 'required|string',
            'is_active' => 'required|string',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with(['success' => true, 'message' => 'User created successfully']);
    }

    public function accountEditUser($id) {
        $user = User::findOrFail($id);
        $roles = User::ROLES;
        return view('accounts.user-edit',compact('user','roles'));
    }

    public function accountUpdateUser(Request $request) {

        $request->validate([
            'name'      => 'required|string',
            'username'  => 'required|string',
            'email'     => 'required|email',            
            'role'      => 'required|string',
            'is_active' => 'required|string',            
        ]);
        
        $id = $request->id;
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->is_active;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with(['success' => true, 'message' => 'User updated successfully']);
    }

   public function accountUserList(Request $request){

        $columns = ['id', 'name', 'username', 'email', 'is_active', 'created_at', 'role'];

        $query = User::select($columns);

        $roles = User::ROLES;

        $data = $this->dataTable->handle($request, $query, $columns, [
            'role'      => function ($user) use ($roles) {
                            $options = '';
                            foreach ($roles as $role) {
                                $selected = $user->role === $role['code'] ? 'selected' : '';
                                $options .= "<option value='{$role['code']}' {$selected}>{$role['description']}</option>";
                            }
                            return "<select class='form-select form-select-sm user-role' data-id='{$user->id}'>{$options}</select>";
                        },

            'is_active' => function ($user) {
                            return $user->is_active
                                ? '<span class="badge text-white bg-success">Active</span>'
                                : '<span class="badge text-white bg-danger">Inactive</span>';
                        },
            'action'    => function ($user) {
                            return '<a href="/auth/account/user/'.$user->id.'/edit" class="btn btn-sm w-100 btn-primary">Edit</a>';
                        }
        ]);
        return response()->json($data);
    }


    public function accountUpdateRole(Request $request){

        $request->validate([
            'role' => 'required|string',
            'id'   => 'required'
        ]);

        $id = $request->id;
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }


       public function accountUpdateStatus(Request $request){

        $request->validate([
            'is_active' => 'required|string',
            'id'   => 'required'
        ]);

        $id = $request->id;
        $user = User::findOrFail($id);
        $user->is_active = $request->is_active;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }

}
