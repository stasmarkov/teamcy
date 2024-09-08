<?php

namespace App\Http\Controllers;

use App\Charts\LoginsChart;
use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller {

  public function show() {
    if (!auth()->check()) {
      return view('welcome');
    }
    else {
//      if (session()->has('tenant_id')) {
//        return view('dashboard');
//      }

      $subscribersCount = Tenant::count();
      $usersCount = User::count();
      $loginsCount = Login::count();

      $logins = [
        // 2 hour ago.
        Login::whereBetween('created_at', [now()->subHour(3), now()->subHour(2)])->count(),
        // 1 hour ago.
        Login::whereBetween('created_at', [now()->subHour(2), now()->subHour(1)])->count(),
        // Pash hour.
        Login::whereBetween('created_at', [now()->subHour(1), now()])->count(),
      ];

      $chart = new LoginsChart();
      $chart->labels(['2 hours ago', '1 hour ago', 'Past gour']);
      $chart->dataset('Logins', 'line', $logins);

      return view('super.dashboard', [
        'subscribersCount' => $subscribersCount,
        'usersCount' => $usersCount,
        'loginsCount' => $loginsCount,
        'chart' => $chart,
      ]);
    }
  }

}
