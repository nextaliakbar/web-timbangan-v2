<?php

namespace App\Livewire\Main;

use App\Models\UserEsa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.main.navbar');
    }

    public function loginToManagementApp()
    {
        $userEsa = UserEsa::whereId(Auth::guard('user')->user()->Id)
        ->first();

        if(!$userEsa) {
            $this->dispatch('errorModal', title: 'Gagal', text: 'Terjadi kesalahan', icon: 'error');
            return;
        }

        if(empty($userEsa->HAK)) {
            $this->dispatch('errorModal', 'Gagal', 'Akun ini tidak memiliki hak akses');
            return;
        }

        session('guest', 'admin');
        session()->forget('user-pic');
        Auth::guard('user')->logout();
        Auth::guard('admin')->login($userEsa);

        if($userEsa->HAK == 'ADMIN') {
            $this->redirect(route('admin.peran-user'));
        } else {
            $modules = $userEsa->userEsaRole->modules ?? [];

            if($modules[0] == 'User Timbangan') {
                $this->redirect(route('admin.user-timbangan'));
            } elseif($modules[0] == 'Ganti JO') {
                $this->redirect(route('admin.ganti-jo'));
            }

            $routeName = match($modules[0]) {
                'Serah Terima' => 'admin.serah-terima',
                'Timbangan' => 'admin.timbangan',
                'Formula' => 'admin.formula',
                'Kartu Stok' => 'admin.kartu-stok',
            };
            $this->redirect(route($routeName, ['plant' => 'unimos']));
        }
    }

    public function logout()
    {
        session()->flush();
        
        Auth::guard('user')->logout();
        
        $this->redirect(route('login'));
    }
}
