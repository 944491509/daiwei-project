<?php

namespace App\Models\Stand\Repositories;

use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Pagination\AbstractPaginator;

class StandAdminUser extends EloquentRepository
{
    public function __construct($relations = [])
    {
        $this->eloquentClass = config('stand-admin.database.users_model');

        parent::__construct($relations);
    }

    public function get(Grid\Model $model)
    {
        $results = parent::get($model);

        $isPaginator = $results instanceof AbstractPaginator;

        $items = collect($isPaginator ? $results->items() : $results)->toArray();

        if (! $items) {
            return $results;
        }

        $roleModel = config('stand-admin.database.roles_model');

        $items = collect($items);

        $roleKeyName = (new $roleModel())->getKeyName();

        $roleIds = $items
            ->pluck('roles')
            ->flatten(1)
            ->pluck($roleKeyName)
            ->toArray();

        $permissions = $roleModel::getPermissionId($roleIds);

        if (! $permissions->isEmpty()) {
            $items = $items->map(function ($v) use ($roleKeyName, $permissions) {
                $v['permissions'] = [];

                foreach (array_column($v['roles'], $roleKeyName) as $roleId) {
                    $v['permissions'] = array_merge($v['permissions'], $permissions->get($roleId, []));
                }

                $v['permissions'] = array_unique($v['permissions']);

                return $v;
            });
        }

        if ($isPaginator) {
            $results->setCollection($items);

            return $results;
        }

        return $items;
    }
}