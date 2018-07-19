<?php

namespace App;

use Laratrust\Models\LaratrustRole;

/**
 * Class Role
 */
class Role extends LaratrustRole
{
    /**
     * Get role by name
     *
     * @param $name
     * @return mixed
     */
    public static function getByName($name)
    {
        return Role::where('name', '=', $name)->firstOrFail();
    }

    /**
     * Get permission id of a role
     *
     * @return array An array of permission ids of selected role
     */
    public function getPermissionIds()
    {
        $permissions = $this->permissions();
        return $permissions->pluck('id')->all();
    }
}
