<?php

namespace App\Models\Stand;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 */
class StandAdminRole extends Model
{

    use HasDateTimeFormatter;

    const ADMINISTRATOR = 'administrator';

    const ADMINISTRATOR_ID = 1;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'created_at', 'updated_at'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('stand-admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('stand-admin.database.roles_table'));

        parent::__construct($attributes);
    }


    /**
     * A role belongs to many users.
     *
     * @return BelongsToMany
     */
    public function administrators(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.role_users_table');

        $relatedModel = config('stand-admin.database.users_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'user_id');
    }


    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.role_permissions_table');

        $relatedModel = config('stand-admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'role_id', 'permission_id');
    }


    /**
     * Get id of the permission by id.
     *
     * @param array $roleIds
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getPermissionId(array $roleIds)
    {
        if (! $roleIds) {
            return collect();
        }
        $related = config('stand-admin.database.role_permissions_table');

        $model = new static();
        $keyName = $model->getKeyName();

        return $model->newQuery()
            ->leftJoin($related, $keyName, '=', 'role_id')
            ->whereIn($keyName, $roleIds)
            ->get(['permission_id', 'role_id'])
            ->groupBy('role_id')
            ->map(function ($v) {
                $v = $v instanceof Arrayable ? $v->toArray() : $v;

                return array_column($v, 'permission_id');
            });
    }


    /**
     * @param string $slug
     *
     * @return bool
     */
    public static function isAdministrator(?string $slug)
    {
        return $slug === static::ADMINISTRATOR;
    }


    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->administrators()->detach();

            $model->permissions()->detach();
        });
    }
}
