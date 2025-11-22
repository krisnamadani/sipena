<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Hitung total akun belanja
        $totalAkunBelanja = AkunBelanja::count();

        // Hitung total users
        $totalUsers = User::count();

        // Ambil 5 akun belanja terbaru
        $recentAkunBelanja = AkunBelanja::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalAkunBelanja',
            'totalUsers',
            'recentAkunBelanja'
        ));
    }
}
