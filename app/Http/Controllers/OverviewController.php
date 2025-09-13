<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index(){
        $total_tickets = auth()->user()->tickets()->count();
        $tickets = auth()->user()->tickets()->count();
        $tickets = auth()->user()->tickets()->count();
        
        return view('overview.index',compact('tickets'));
    }

    
}
