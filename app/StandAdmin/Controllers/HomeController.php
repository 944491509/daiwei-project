<?php

namespace App\StandAdmin\Controllers;

use App\StandAdmin\Metrics\Examples;
use App\Http\Controllers\Controller;
use App\StandAdmin\StandAdmin;
use Dcat\Admin\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(Content $content, Request $request)
    {
        $this->setSession();

        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(Dashboard::title());
                    $column->row(new Examples\Tickets());
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });

                    $column->row(new Examples\Sessions());
                    $column->row(new Examples\ProductOrders());
                });
            });
    }

    public function setSession()
    {
        session(['AreaStandId' => StandAdmin::user()['area_stand_id']]);
    }

}
