<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /*Dashboard page access */
    public function index()
    {
        $data = [
            'pageName' => "Dashboard",
            'active' => 1,
        ];

        return view('web.dashboard.index', $data);
    }
}
