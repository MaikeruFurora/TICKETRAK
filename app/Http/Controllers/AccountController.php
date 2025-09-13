<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketUpdateNotification;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    protected $dataTable;

    public function __construct(DataTableService $dataTable)
    {
        $this->dataTable = $dataTable;
    }

   public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'username' => 'nullable|unique:users,username,' . auth()->id(),
            'password' => 'nullable|min:8|confirmed', 
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
 

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
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

     public function userSearch(Request $request)
     {
       $q = $request->get('q');

        $users = User::where('name', 'like', "%$q%")
            ->select('id', 'name as text') // <-- 'text' is required by Select2
            ->paginate(10);

        return response()->json([
            'results' => $users->items(),
            'pagination' => [
                'more' => $users->hasMorePages()
            ]
        ]);
    }

    public function userAssign(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'assigned_to' => 'required|exists:users,id',
            'assigned_by' => 'required|exists:users,id',
        ]);

        $assignedTo = $request->input('assigned_to');
        $assignedBy = $request->input('assigned_by');
        $ticketId   = $request->input('ticket_id');

        $ticket = \App\Models\Ticket::findOrFail($ticketId);
        $ticket->assigned_to = $assignedTo;
        $ticket->assigned_by = $assignedBy;
        $ticket->save();

        TicketReply::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => $assignedBy,
            'description' => 'Your support ticket has been successfully assigned. Rest assured, our team is reviewing it and will respond soon.',
        ]); 

        $user = User::findOrFail($assignedTo);
        $user->notify(new TicketUpdateNotification($ticket, 'assigned', 'You have been assigned a ticket.'));

        return response()->json(['success' => true, 'message' => 'Ticket assigned successfully']);

    }
  

}
