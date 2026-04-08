<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // ← This is needed for the update method

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:user,staff,admin',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // This is where Rule is used - to ignore the current user's email when checking uniqueness
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id) // ← Rule is used here
                ],
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:user,staff,admin',
            ]);

            // Update user details
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            
            // Only update password if provided
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            
            $user->save();

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validation failed!');
        } catch (\Exception $e) {
            \Log::error('User update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent users from deleting themselves
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'You cannot delete your own account!');
            }
            
            $user->delete();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully!');
                
        } catch (\Exception $e) {
            \Log::error('User deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}