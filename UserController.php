<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(10); // Assuming you want to paginate the data
        return view('admin.page.user', [
            'name'      => "User Management",
            'title'     => 'Admin User Management',
            'data'      => $data,
        ]);
    }

    public function addModalUser()
    {
        return view('admin.modal.ModalUser', [
            'title' => 'Tambah Data Product',
            'nik'   => date('Ymd') . rand(000, 999),
        ]);
    }

    public function store(UserRequest $request)
    {
        Log::info('Request data: ', $request->all());

        $data = new User;
        $data->nik = $request->nik;
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->alamat = $request->alamat;
        $data->tlp = $request->tlp;
        $data->role = $request->role;
        $data->tglLahir = $request->tglLahir;
        $data->is_active = 1;
        $data->is_mamber = 0;
        $data->is_admin = 1;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }

        $data->save();
        Log::info('Data saved: ', $data->toArray());

        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('userManagement');
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.modal.editUser', [
            'title' => 'Edit data User',
            'data'  => $data,
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $data = User::findOrFail($id);

        // Update only if the input is not empty or changed
        $data->nik       = $request->nik;
        $data->name      = $request->nama;
        $data->email     = $request->email;
        $data->alamat    = $request->alamat;
        $data->tlp       = $request->tlp;
        $data->tglLahir  = $request->tglLahir;
        $data->role      = $request->role;

        // Update password only if it's not empty
        if ($request->filled('password')) {
            $data->password = bcrypt($request->password);
        }

        // Update photo if a new file is uploaded
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }

        $data->save();
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->route('userManagement');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $json = [
            'success' => "Data berhasil dihapus"
        ];

        return response()->json($json);
    }
}
