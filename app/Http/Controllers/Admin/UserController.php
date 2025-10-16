<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;



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

    // Näita kasutajaid (välja arvatud admin-id ja id = 1)
    public function index(){
        $users = User::query()
            ->where('id', '<>', 1)            // väldi id = 1
            // ->where(function($q) {
            //     $q->whereNull('is_admin')->orWhere('is_admin', false); // ära näita administraatoreid
            // })
            ->orderBy('name')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // Kustuta kasutaja (turvakontrollid)
    public function destroy(User $user){
        // Turvakontrollid: ära lase kustutada peamist adminit või administraatorit
        if ($user->id === 1 || (bool)$user->is_admin) {
            return redirect()->route('admin.users.index')
                ->with('status', 'Seda kasutajat ei saa kustutada.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'Kasutaja on kustutatud.');
    }
}
