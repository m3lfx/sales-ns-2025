<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DataTables\UsersDataTable;
use App\DataTables\CustomersDataTable;

class DashboardController extends Controller
{
    public function getUsers(UsersDataTable $dataTable) {
        return $dataTable->render('dashboard.users');
    }

    public function getCustomers(CustomersDataTable $dataTable) {
        return $dataTable->render('dashboard.customers');
    }
}
