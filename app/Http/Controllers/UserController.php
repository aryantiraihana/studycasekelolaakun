<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        $passEmailPrefix = $request->email;
        $passNamePrefix = $request->name;
        $password = substr($passEmailPrefix, 0, 3) . substr($passNamePrefix, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $password,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data user!');
    
    }

    public function show(string $id)
    {

    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        $DataBaru = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            
        ];

        if($request->filled('password')){
            $DataBaru['password'] = bcrypt($request->password);
        }

        User::where('id', $id)->update($DataBaru);

        return redirect()->route('user.home')->with('success', 'Berhasil mengubah data!');
        
    }
    
    public function destroy($id)
    {
        //
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
}
