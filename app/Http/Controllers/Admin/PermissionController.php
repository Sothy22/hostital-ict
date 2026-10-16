<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index() {
        $permissions = Permission::all();

        return response()->json([
            'data' => $permissions,
            'message' => 'Get Permissions Successfully'
        ]);
    }

     public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Permission created successfully',
            'permission' => $permission
        ], 201);
    }

    public function update(StorePermissionRequest $request, $id) {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found'
            ], 404);
        }

        $permission->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Permission updated successfully',
            'permission' => $permission
        ]);
    }

    public function destroy($id) {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found'
            ], 404);
        }

        $permission->rolePermissions()->delete();

        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
