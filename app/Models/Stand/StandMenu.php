<?php

namespace App\Models\Stand;

use Dcat\Admin\Models\Menu;

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
class StandMenu extends Menu
{
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

}
