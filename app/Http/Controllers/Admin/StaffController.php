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
    public static function departmentsForRole(string $role)
    {
        $roleDepartmentNames = [
            'doctor' => null,
            'receptionist' => 'Receptionist',
            'accountant' => 'Accountant',
            'pharmacy' => 'Pharmacy',
        ];

        if (!array_key_exists($role, $roleDepartmentNames)) {
            return Department::orderBy('name')->get();
        }

        $roleDepartmentName = $roleDepartmentNames[$role];
        if ($roleDepartmentName !== null) {
            $department = Department::firstOrCreate(
                ['name' => $roleDepartmentName],
                [
                    'description' => $roleDepartmentName . ' department',
                    'status' => true,
                ],
            );

            return collect([$department]);
        }

        $operationalNames = ['Receptionist', 'Accountant', 'Pharmacy'];
        $doctorDepartments = Department::orderBy('name')
            ->get()
            ->reject(fn (Department $department) => in_array(
                trim((string) $department->name),
                $operationalNames,
                true,
            ));

        if ($doctorDepartments->isEmpty()) {
            $cardiology = Department::firstOrCreate(
                ['name' => 'Cardiology'],
                [
                    'description' => 'Cardiology department',
                    'status' => true,
                ],
            );
            $doctorDepartments = collect([$cardiology]);
        }

        return $doctorDepartments;
    }

    public static function suggestEmployeeId(string $role): string
    {
        $prefixes = [
            'doctor' => 'DOC',
            'receptionist' => 'REC',
            'accountant' => 'ACC',
            'pharmacy' => 'PHA',
        ];

        $prefix = $prefixes[$role] ?? strtoupper(substr($role, 0, 3));
        $nextNumber = 1;

        foreach (User::where('role', $role)->get(['employee_id']) as $user) {
            $employeeId = (string) ($user->employee_id ?? '');
            if (preg_match('/^' . preg_quote($prefix, '/') . '-(\d+)$/', $employeeId, $matches)) {
                $nextNumber = max($nextNumber, (int) $matches[1] + 1);
            }
        }

        return sprintf('%s-%03d', $prefix, $nextNumber);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
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
            'mobile' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:2000'],
            'doctor_id' => ['nullable', 'string', 'max:50'],
            'employee_id' => ['nullable', 'string', 'max:50'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $nameParts = preg_split('/\s+/', trim($validated['full_name']), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
        $submittedEmployeeId = trim((string) ($validated['employee_id'] ?? ''));
        $existingEmployeeId = trim((string) ($user->employee_id ?? $user->doctor_id ?? ''));
        $employeeId = $submittedEmployeeId !== ''
            ? $submittedEmployeeId
            : ($existingEmployeeId !== ''
                ? $existingEmployeeId
                : self::suggestEmployeeId('doctor'));

        $data = [
            'name' => trim($validated['full_name']),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'address' => $validated['address'] ?? null,
            'doctor_id' => $employeeId,
            'employee_id' => $employeeId,
            'specialization' => $validated['specialization'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'biography' => $validated['biography'] ?? null,
        ];

        if (!empty($validated['department_id'])) {
            $department = Department::find($validated['department_id']);
            if ($department) {
                $data['department_id'] = $department->getKey();
            }
        }

        $oldImagePath = $user->image;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('staff', 'public');
        }

        $user->update($data);

        if (isset($data['image']) && $oldImagePath && $oldImagePath !== $data['image']) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function create()
    {
        return redirect()->route('main_admin');
    }

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
            'employee_id' => ['nullable', 'string', 'max:50'],
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
            'employee_id' => ($validated['employee_id'] ?? '') ?: self::suggestEmployeeId($validated['role']),
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
            'employee_id' => ['nullable', 'string', 'max:50'],
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
            'employee_id' => ($validated['employee_id'] ?? '')
                ?: ($user->employee_id ?? null)
                ?: self::suggestEmployeeId($validated['role']),
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
