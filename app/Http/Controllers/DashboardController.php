<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;

class DashboardController extends Controller
{
    // Middleware aplicado nas rotas em web.php

    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $totalStudents = Student::count();
        $recentStudents = Student::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalUsers',
            'activeUsers', 
            'totalStudents',
            'recentStudents'
        ));
    }
}
