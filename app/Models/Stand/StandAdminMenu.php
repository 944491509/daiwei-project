<?php

namespace App\Models\Stand;

use Dcat\Admin\Models\Menu;
use Dcat\Admin\Models\MenuCache;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class StandAdminMenu extends Model implements Sortable
{
    use HasDateTimeFormatter,
        MenuCache,
        ModelTree {
        allNodes as treeAllNodes;
        ModelTree::boot as treeBoot;
    }


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stand_admin_menu';

    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'url', 'created_at', 'updated_at'];


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('stand-admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('stand-admin.database.menu_table'));

        parent::__construct($attributes);
    }

    /**
     * A Menu belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.role_menu_table');

        $relatedModel = config('stand-admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'role_id');
    }


    public function permissions(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.permission_menu_table');

        $relatedModel = config('stand-admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'permission_id');
    }

    /**
     * Get all elements.
     *
     * @param bool $force
     *
     * @return array
     */
    public function allNodes(bool $force = false): array
    {
        if ($force || $this->queryCallbacks) {
            return $this->fetchAll();
        }

        return $this->remember(function () {
            return $this->fetchAll();
        });
    }

    /**
     * Fetch all elements.
     *
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->withQuery(function ($query) {
            if (static::withPermission()) {
                $query = $query->with('permissions');
            }

            return $query->with('roles');
        })->treeAllNodes();
    }

    /**
     * Determine if enable menu bind permission.
     *
     * @return bool
     */
    public static function withPermission()
    {
        return config('stand-admin.menu.bind_permission') && config('admin.permission.enable');
    }

    /**
     * Determine if enable menu bind role.
     *
     * @return bool
     */
    public static function withRole()
    {
        return (bool) config('stand-admin.permission.enable');
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        static::treeBoot();

        static::deleting(function ($model) {
            $model->roles()->detach();
            $model->permissions()->detach();

            $model->flushCache();
        });

        static::saved(function ($model) {
            $model->flushCache();
        });
    }
}
