<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function index()
    {
    	# code...
        return view('admin.pages.payments.index');
    }

    public function create(){
    	# code...
    	return view('admin.pages.payments.add');
    }

    public function store(){
    	# code...
    }
}
