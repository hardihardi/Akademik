<?php

if (!function_exists('has_permission')) {
    /**
     * Check if the currently logged-in user has a specific permission.
     * 
     * @param string $permissionName
     * @return bool
     */
    function has_permission(string $permissionName): bool
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return false;
        }

        $userId = $session->get('id');
        $db = \Config\Database::connect();

        // Admin always has all permissions
        if ($session->get('role') === 'admin') {
            return true;
        }

        // Check if permission exists for the user's role
        return $db->table('permissions')
            ->select('permissions.id')
            ->join('role_permissions', 'role_permissions.permission_id = permissions.id')
            ->join('users_roles', 'users_roles.role_id = role_permissions.role_id')
            ->where('users_roles.user_id', $userId)
            ->where('permissions.name', $permissionName)
            ->countAllResults() > 0;
    }
}
