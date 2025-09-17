<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\UserEsa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google = Socialite::driver('google')->user();
            
            $userEsa = UserEsa::updateOrCreate([
                'email' => $google->getEmail()
            ], [
                'name' => $google->getName(),
                'google_id' => $google->getId(),
                'password' => Hash::make(Str::random(16))
            ]);

            session()->flash('openSelectPurposeModal');
            session()->put('user-esa-from-oauth2', $userEsa);
            return redirect()->route('login');
        } catch(Exception $ex) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat proses autentikasi dengan google');
        }
    }
}
