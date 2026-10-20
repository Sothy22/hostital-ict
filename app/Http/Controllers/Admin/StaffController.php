<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    // public function create()
    // {
    //     return view('dashboard.admin.add_staff_page', [
    //         'roles' => Role::all(),
    //         'departments' => Department::all(),
    //     ]);
    // }

    public function store(Request $request)
    {
        $roles = Role::all();
        $departments = Department::all();

        $roleNames = $roles
            ->pluck('name')
            ->map(fn ($name) => (string) $name)
            ->all();

        $departmentIds = $departments
            ->map(fn ($department) => (string) $department->getKey())
            ->all();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->exists()) {
                        $fail('This email is already in use.');
                    }
                },
            ],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
            // 'nic' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'status' => ['required', Rule::in(['Active', 'Reject'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role' => ['required', Rule::in($roleNames)],
            'department_id' => ['required', Rule::in($departmentIds)],
        ]);

        $department = $departments->first(
            fn ($item) => (string) $item->getKey() === $validated['department_id']
        );

        if (!$department) {
            return back()
                ->withErrors(['department_id' => 'Please select a valid department.'])
                ->withInput();
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('staff', 'public');
        }

        User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
            // 'nic' => $validated['nic'],
            'date_of_birth' => $validated['date_of_birth'],
            'status' => $validated['status'],
            'password' => $validated['password'],
            'image' => $imagePath,
            'role' => $validated['role'],
            'department_id' => $department->getKey(),
            'permissions' => [],
        ]);

        return back()->with('success', 'Staff member added successfully.');
    }

    public function update (Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $departments = Department::all();

        $roleNames = $roles
            ->pluck('name')
            ->map(fn ($name) => (string) $name)
            ->all();

        $departmentIds = $departments
            ->map(fn ($department) => (string) $department->getKey())
            ->all();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    if (User::where('email', $value)
                        ->where('_id', '!=', $user->getKey())
                        ->exists()) {
                        $fail('This email is already in use.');
                    }
                },
            ],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:2000'],
            // 'nic' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'status' => ['required', Rule::in(['Active', 'Reject'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'role' => ['required', Rule::in($roleNames)],
            'department_id' => ['required', Rule::in($departmentIds)],
        ]);

        $department = $departments->first(
            fn ($item) => (string) $item->getKey() === $validated['department_id']
        );

        if (!$department) {
            return back()
                ->withErrors(['department_id' => 'Please select a valid department.'])
                ->withInput();
        }

        $data = [
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'],
            // 'nic' => $validated['nic'],
            'date_of_birth' => $validated['date_of_birth'],
            'status' => $validated['status'],
            'role' => $validated['role'],
            'department_id' => $department->getKey(),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $oldImagePath = $user->image;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('staff', 'public');
        }

        $user->update($data);

        if (isset($data['image']) && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return back()->with(
            'success',
            'User Deleted Successfully'
        );
    }
}
