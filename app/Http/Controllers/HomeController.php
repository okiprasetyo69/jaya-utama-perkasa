<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use App\Models\Transactions;

class HomeController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('layout.home');
    }

    // Admin Page
    public function adminDashboardPage(){
        return view('user.admin.index');
    }
    // public function managementStockPage(){
    //     return view('user.admin.management_stock');
    // }

    // public function managementTransactionPage(){
    //     return view('user.admin.transaction');
    // }
    
    public function managementCategory(){
        return view('user.admin.management_category');
    }
    
    public function managementProduct(){
        return view('user.admin.management_product');
    }

    public function managementInventory(){
        return view('user.admin.management_inventory');
    }
}
