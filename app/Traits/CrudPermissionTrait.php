<?php


namespace App\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * CrudPermissionTrait: use Permissions to configure Backpack
 */
trait CrudPermissionTrait
{
    // the operations defined for CRUD controller
    public array $operations = ['list', 'show', 'create', 'update', 'delete'];


    /**
     * set CRUD access using spatie Permissions defined for logged in user
     *
     * @return void
     */
    public function setAccessUsingPermissions()
    {
        $this->crud->denyAccess($this->operations);
        $table = CRUD::getModel()->getTable();
        $user = backpack_auth()->user();

        if (!$user) {
            return;
        }

        foreach ([
            'view' => ['list', 'show'],
            'edit' => ['list', 'show', 'create', 'update', 'delete'],
        ] as $level => $operations) {
            if ($user->hasPermission("$table.$level")) {
                $this->crud->allowAccess($operations);
            }
        }
    }
}
