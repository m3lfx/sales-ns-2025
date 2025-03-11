<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\UsersDataTable;
use App\DataTables\CustomersDataTable;
use App\DataTables\OrdersDataTable;
use DB;
use App\Charts\MonthlySales;

class DashboardController extends Controller
{
    public function __construct()
    {

        $this->bgcolor = collect([
            '#7158e2',
            '#3ae374',
            '#ff3838',
            "#FF851B",
            "#7FDBFF",
            "#B10DC9",
            "#FFDC00",
            "#001f3f",
            "#39CCCC",
            "#01FF70",
            "#85144b",
            "#F012BE",
            "#3D9970",
            "#111111",
            "#AAAAAA",
        ]);
    }
    public function index()
    {
        // SELECT monthname(o.date_placed), sum(i.sell_price * ol.quantity) as total FROM orderinfo o inner join orderline ol on o.orderinfo_id = ol.orderinfo_id inner join item i on ol.item_id = i.item_id group by month(o.date_placed);
        $orders = DB::table('orderinfo as o')
            ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item as i', 'i.item_id', '=', 'ol.item_id')
            ->groupBy(DB::raw('month(o.date_placed)'))
            ->pluck(DB::raw('sum(i.sell_price * ol.quantity) AS total'), DB::raw('monthname(o.date_placed) as month'))
            ->all();


        // dd(array_values($orders));

        $salesChart = new MonthlySales;
        $dataset = $salesChart->labels(array_keys($orders));
        $dataset = $salesChart->dataset(
            'Monthly sales 2025',
            'line',
            array_values($orders)
        );
        $dataset = $dataset->backgroundColor($this->bgcolor);
        $salesChart->options([
            'indexAxis' => 'x',
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                    ],
                ],
                'xAxes' => [
                    [
                        'gridLines' => ['display' => false],
                        'display' => true,
                    ],
                ],
            ],
        ]);

        return view('dashboard.index', compact('salesChart'));
    }
    public function getUsers(UsersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.users');
    }

    public function getCustomers(CustomersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.customers');
    }

    public function getOrders(OrdersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.orders');
    }
}
