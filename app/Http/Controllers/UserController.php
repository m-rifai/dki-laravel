<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Supervisor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('role')->select(['id', 'name', 'email', 'role_id', 'is_blocked']);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    return $user->role->name;
                })
                ->addColumn('blocked', function ($user) {
                    return $user->is_blocked
                    ? '<span class="badge bg-danger">Yes</span>'
                    : '<span class="badge bg-success">No</span>';
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('users.edit', $user->id);
                    $deleteUrl = route('users.destroy', $user->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    $buttons = '<a href="' . $editUrl . '" class="btn btn-sm btn-warning me-1">Edit</a>';

                    if (auth()->id() !== $user->id) {
                        $buttons .= '
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</button>
                            </form>
                        ';
                    }

                    return $buttons;
                })
                ->rawColumns(['blocked', 'actions'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'is_blocked' => 'sometimes|boolean',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_blocked' => $request->is_blocked ?? false,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'is_blocked' => 'sometimes|boolean',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->is_blocked = $request->is_blocked ?? false;
        $user->role_id = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function blockedUsers()
    {
        $blockedUsers = User::where('is_blocked', true)->get();
        return view('users.blocked', compact('blockedUsers'));
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_blocked' => false,
            'failed_login_attempts' => 0,
        ]);

        return redirect()->route('users.blocked')->with('success', 'User berhasil diblokir.');
    }
}
