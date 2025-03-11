<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\UsersDataTable;
use App\DataTables\CustomersDataTable;
use App\DataTables\OrdersDataTable;
use DB;
use App\Charts\MonthlySales;
use App\Charts\CustomerChart;
use App\Charts\ItemChart;

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
        // $dataset = $dataset->backgroundColor('#AAAAAA');
        $salesChart->options([
            'indexAxis' => 'y',
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

        $customer = DB::table('customer')
            ->whereNotNull('addressline')
            ->groupBy('addressline')
            ->orderBy('total')
            ->pluck(DB::raw('count(addressline) as total'), 'addressline')->all();

        // dd($customer);
        // dd(array_values($customer));
        $customerChart = new CustomerChart;
        $dataset = $customerChart->labels(array_keys($customer));
        $dataset = $customerChart->dataset(
            'Customer Demographics',
            'bar',
            array_values($customer)
        );
        $dataset = $dataset->backgroundColor($this->bgcolor);

        $customerChart->options([
            
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

        $items = DB::table('orderline AS ol')
        ->join('item AS i', 'ol.item_id', '=', 'i.item_id')
        ->groupBy('i.description')
        ->orderBy('total', 'DESC')
        ->pluck(DB::raw('sum(ol.quantity) AS total'), 'description')
        ->all();

        $itemChart = new ItemChart;
        $dataset = $itemChart->labels(array_keys($items));
        // dd($dataset);
        $dataset = $itemChart->dataset(
            'Item sold',
            'pie',
            array_values($items)
        );
       
        $dataset = $dataset->backgroundColor($this->bgcolor);
       
        $dataset = $dataset->fill(false);
        $itemChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
    ]);


        return view('dashboard.index', compact('salesChart', 'customerChart', 'itemChart'));
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
