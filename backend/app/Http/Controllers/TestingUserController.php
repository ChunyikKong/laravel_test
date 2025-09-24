<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestingUser;
use Illuminate\Validation\Rule;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class TestingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TestingUser::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10);
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:testing_users,email',
            'phone_number'=> 'required|string|max:20|unique:testing_users,phone_number',
            'password'    => 'required|string|min:6',
            'status'      => 'required|in:active,inactive',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = TestingUser::create($validated);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TestingUser $testing_user)
    {
        return response()->json($testing_user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestingUser $testing_user)
    {
        $data = $request->validate([
            'name'         => ['nullable', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255', Rule::unique('testing_users')->ignore($testing_user->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('testing_users')->ignore($testing_user->id)],
            'password'     => ['nullable', 'string', 'min:6'],
            'status'       => ['nullable', 'in:active,inactive'],
        ]);
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $testing_user->fill($data)->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user'    => $testing_user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestingUser $testing_user)
    {
        $testing_user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:testing_users,id',
        ]);

        TestingUser::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Users deleted']);
    }

}
