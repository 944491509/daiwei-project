<?php

namespace App\Models\Stand;

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $avatar
 * @property string $remember_token
 * @property string $area_stand_id
 */
class StandAdminUser extends Administrator
{
    use Authenticatable,
        HasPermissions,
        HasDateTimeFormatter;
    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'name', 'avatar',
        'remember_token', 'area_stand_id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('stand-admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('stand-admin.database.users_table'));

        parent::__construct($attributes);
    }

    public function getAvatar()
    {

        $avatar = $this->avatar;
        if ($avatar) {
            if (! URL::isValidUrl($avatar)) {
                $avatar = Storage::disk(config('admin.upload.disk'))->url($avatar);
            }

            return $avatar;
        }
        return admin_asset(config('stand-admin.default_avatar') ?: '@admin/images/default-avatar.jpg');
    }


    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $pivotTable = config('stand-admin.database.role_users_table');

        $relatedModel = config('stand-admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }
}
