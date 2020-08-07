<?php

namespace App\Models\Stand;

use Dcat\Admin\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $http_method
 * @property string $http_path
 * @property int $order
 * @property integer $parent_id
 * @property string $created_at
 * @property string $updated_at
 */
class StandAdminPermission extends Permission
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'http_method', 'http_path', 'order', 'parent_id', 'created_at', 'updated_at'];


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('stand-admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('stand-admin.database.permissions_table'));

        parent::__construct($attributes);
    }


    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.role_permissions_table');

        $relatedModel = config('stand-admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'permission_id', 'role_id');
    }
}
