<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index() {
        $department = Department::get();

        return response()->json([
            'data' => $department,
            'message' => 'Get Role Successfully'
        ]);
    }

    public function store(StoreDepartmentRequest $req) {
        $department = Department::create(
            $req->validated()
        );

        return response()->json([
            'data' => $department,
            'message' => 'Create Role Successfully'
        ]);
    }

    public function update(StoreDepartmentRequest $req, $id) {
        $department = Department::find($id);

        if(!$department) {
            return response()->json([
                'message' => 'Create Not Found'
            ]);
        }

        $department->update(
            $req->validated()
        );

        return response()->json([
            'data' => $department,
            'message' => 'Update Role Successfully'
        ]);
    }

    public function destroy($id) {
        $department = Department::find($id);

        if(!$department) {
            return response()->json([
                'message' => 'Create Not Found'
            ]);
        }

       $department->delete();

        return response()->json([
            'message' => 'Deleted Role Successfully'
        ]);
    }
}
