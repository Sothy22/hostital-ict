<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRolePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function getRolePermissions($roleId)
    {
        $role = Role::find($roleId);

        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        // Get role_permissions
        $rolePermissions = RolePermission::where(
            'role_id',
            $roleId
        )->get();

        $permissions = [];

        foreach ($rolePermissions as $rolePermission) {

            $permission = Permission::find(
                $rolePermission->permission_id
            );

            if ($permission) {
                $permissions[] = $permission;
            }
        }

        return response()->json([
            'role' => $role,
            'permissions' => $permissions
        ], 200);
    }

     public function store(StoreRolePermissionRequest $request, $roleId) {
        $role = Role::find($roleId);

        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        $assigned = [];

        foreach ($request->validated()['permission_ids'] as $permissionId) {

            $permission = Permission::find($permissionId);

            if (!$permission) {
                continue;
            }

            $exists = RolePermission::where(
                'role_id',
                $role->_id
            )
            ->where(
                'permission_id',
                $permission->_id
            )
            ->exists();

            if (!$exists) {

                $rolePermission = RolePermission::create([
                    'role_id' => $role->_id,
                    'permission_id' => $permission->_id,
                ]);

                $assigned[] = $rolePermission;
            }
        }

        return response()->json([
            'message' => 'Permissions assigned successfully',
            'role' => $role,
            'assigned_permissions' => $assigned
        ], 201);
    }


    public function destroy($roleId, $permissionId) {
        $rolePermission = RolePermission::where(
            'role_id',
            $roleId
        )->where(
            'permission_id',
            $permissionId
        )->first();

        if (!$rolePermission) {
            return response()->json([
                'message' => 'Role permission not found'
            ], 404);
        }

        $rolePermission->delete();

        return response()->json([
            'message' => 'Role permission deleted successfully'
        ]);
    }
}
