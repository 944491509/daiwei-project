<?php


namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\District\Automobile as AutomobileModel;
class Automobile extends EloquentRepository
{
    protected $eloquentClass = AutomobileModel::class;

}
