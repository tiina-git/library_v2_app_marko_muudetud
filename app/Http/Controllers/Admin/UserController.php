<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

//use Illuminate\Support\Facades\Password;

class UserController extends Controller{
    public function create(){
        return view('admin.users.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed',Password::defaults()],
        ]);
        
        User::create([                      // Loo kasutaja
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'must_change_password' => true, // Märgi, et kasutaja peab parooli muutma
        ]);
        return redirect()->route('admin.users.create')->with('status', 'Kasutaja on loodud!');
    }
}
