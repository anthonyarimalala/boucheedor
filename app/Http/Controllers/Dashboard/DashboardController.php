<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\class\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function showDashboard(){
        $data['notifications'] = Notification::orderBy('produit')->get();

        return view('dashboard')->with($data);
    }
}
