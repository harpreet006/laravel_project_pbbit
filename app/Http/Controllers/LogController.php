<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteLog;


class LogController extends Controller
{
    //
    public function index()
    {
    	$logs = SiteLog::paginate(20);
    	return view('admin.pages.logs.index',compact('logs'));
    }


    public function destroy()
    {
    	 SiteLog::where([['id','!=' , 0]])->delete();
    	 return redirect()->back();
    }
}
