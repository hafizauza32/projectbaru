<?php

namespace App\Http\Controllers;

use App\Models\modelDetailTransaksi;
use App\Models\product;
use App\Models\tblCart;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function shope()
    {
        $data = product::paginate(15);
        return view('costumer.page.shope', [
            'title' => 'Shope',
            'data' => $data
        ]);
    }
    public function transaksi()
    {
        return view('costumer.page.transaksi',[
            'title'  => 'Transaksi',
        ]);
    }
    public function contact()
    {
        return view('costumer.page.contact',[
            'title'  => 'Contact US',
        ]);
    }
     public function checkout()
    {
        return view('costumer.page.checkout',[
            'title'  => 'Check Out',
        ]);
    }
    public function admin()
    {
        return view('admin.page.dashboard', [
            'name'  => 'Dashboard',
            'title' => 'Admin Dashboard',
        ]);
    }
    public function userManagement()
    {
        return view('admin.page.user', [
            'name'  => 'User Management',
            'title' => 'Admin User Management',
        ]);
    }
    public function report()
    {
        return view('admin.page.report', [
            'name'  => 'Report',
            'title' => 'Admin Report',
        ]);
    }
    public function login()
    {
        return view('admin.page.login', [
            'name'  => 'Login',
            'title' => 'Admin Login',
        ]);
    }
    public function loginProses(Request $request)
{
    $dataLogin = [
        'email' => $request->email,
        'password' => $request->password,
    ];

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        Alert::toast('Email dan Password salah', 'error');
        return back()->withInput();
    }

    if ($user->is_admin === 0) {
        Alert::toast('Kamu bukan admin', 'error');
        return back()->withInput();
    }

    if (Auth::attempt($dataLogin)) {
        Alert::toast('Kamu berhasil login', 'success');
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    } else {
        Alert::toast('Email dan Password salah', 'error');
        return back()->withInput();
    }
}

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('admin');
    }
}
