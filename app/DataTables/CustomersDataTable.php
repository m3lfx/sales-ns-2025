<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;
use DB;

class CustomersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('role',  function ($row) {
                return view('users.role', compact('row'));
               
            })
            ->rawColumns(['role'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $users = DB::table('users')
            ->join('customer', 'users.id', '=', 'customer.user_id')
            ->select(
                'users.id AS id',
                'users.name',
                'users.email',
                'customer.addressline',
                'customer.phone',
                'users.created_at'
            )
            ->where('users.id', '<>', Auth::id());
        //  dd($users);
         return $users;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('customers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id')->title('user id'),

            Column::make('name'),
            Column::make('email'),
            Column::make('addressline')->title('address'),
            Column::make('phone')->searchable(false),
            Column::make('created_at')->searchable(false),
            Column::computed('role')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customers_' . date('YmdHis');
    }
}
