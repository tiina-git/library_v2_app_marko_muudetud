<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try {
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();       // Epost
            $googleSub = $googleUser->getId();      // Google ID
            $raw = $googleUser->user;               // Täistoores payload
            $emailVerified = $raw['email_verified'] ?? true;

            if(!$email || !$emailVerified) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Google e-post puudub või pole kontrollitud.'
                ]);
            }
            // Esimene kasutaja sql tabelist
            $user = User::where('email', $email)->first();
            if(!$user) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Seda Google  e-posti ei leitud.',
                ]);
            }

            // Esmakordsel Google logimisel seome sub-i, Hiljem kontrollime vastavust
            if(empty($user->google_sub)){
                $user->google_sub=$googleSub;
            } elseif ($user->google_sub !== $googleSub){
                return redirect()->route('login')->withErrors([
                    'email' => 'Se google konto ei ole selle kasutajaga seotud. Proovi uuesti'
                ]);
            }
            
            // Audit
            $user->last_login_method = User:: LOGIN_METHOD_GOOGLE ?? 'google';
            $user->last_login_at = now();
            $user->save();

            Auth::login($user, remember: true);

            // Kui on must_change_password, kontrolli siin ja suuna vajadusel
            return redirect()->intended(route('dashboard'));


        } catch (\Throwable $e){
            Log::error('Google OAuth viga: '. $e->getMessage(), ['exc' => $e]);
            return redirect()->route('login')->withErrors([
                'email' => 'Google sisselogimine ebaõnnestus. Proovi uuesti.'
            ]);
        }
            

        
    }
}
