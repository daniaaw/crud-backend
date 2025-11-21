<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role === 'admin') {
        return view('dashboard.admin');
        } 
        elseif (auth()->user()->role === 'staff') {
            return view('dashboard.staff');
        }
        else {
        return view('dashboard.user');
        }
       }
}
