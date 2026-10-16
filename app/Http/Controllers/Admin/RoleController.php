<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    public function index() {
        $role = Role::all();

        return response()->json([
            'data' => $role,
            'message' => 'Get Role Successfully'
        ]);
    }


    public function store(StoreRoleRequest $req) {
        $role = Role::create(
            $req->validated()
        );

        return response()->json([
            'data' => $role,
            'message' => 'Create Role Successfully'
        ]);
    }

    public function update(StoreRoleRequest $req, $id) {
        $role = Role::find($id);

        if(!$role) {
            return response()->json([
                'message' => 'Create Not Found'
            ]);
        }

        $role->update(
            $req->validated()
        );

        return response()->json([
            'data' => $role,
            'message' => 'Update Role Successfully'
        ]);
    }

    public function destroy($id) {
        $role = Role::find($id);

        if(!$role) {
            return response()->json([
                'message' => 'Create Not Found'
            ]);
        }

        $role->rolePermissions()->delete();

       $role->delete();

        return response()->json([
            'message' => 'Deleted Role Successfully'
        ]);
    }
}
