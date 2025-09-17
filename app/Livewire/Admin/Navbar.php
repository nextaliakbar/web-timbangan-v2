<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Models\UserEsa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public $jenisPic, $pic, $passwordPic,
    $timeOut2FA;

    public UserEsa $userEsa;

    public function mount()
    {
        $this->userEsa = UserEsa::whereId(Auth::guard('admin')->user()->Id)
        ->first();

        $this->jenisPic = Auth::guard('admin')->user()->PIC == 'PIC_SERAH' ? 'Terima' : 'Serah';
    }

    public function render()
    {
        return view('livewire.admin.navbar');
    }

    public function refresh()
    {
        $this->timeOut2FA = Setting::where('key', '=', '2fa_timeout')
        ->value('value');
        $this->dispatch('openFaModal');
    }

    public function updateTimeOut2FA()
    {
        Setting::where('key', '=', '2fa_timeout')
        ->update(['value' => $this->timeOut2FA]);

        $this->dispatch('successUpdateTimeOut2FA', title: 'Sukses', text: 'Batas waktu berhasil diperbarui', icon: 'success');
    }

    public function loginToWeightApp()
    {
        $userEsa = UserEsa::where('PIC', '=', $this->jenisPic == 'Serah' ? 'PIC_SERAH' : 'PIC_TERIMA')
        ->where('USER', '=', $this->pic)
        ->first();

        if($userEsa && hash('sha256', $this->passwordPic) === $userEsa->PASS) {
            session()->put('guest', 'user');
            session()->put('user-pic', $userEsa);
            Auth::guard('admin')->logout();
            Auth::guard('user')->login($this->userEsa);
            $this->redirect(route('main-app.index'));
        } else {
            $this->dispatch('errorModal', title: 'Gagal', text: 'NIK atau Password Salah', icon: 'error');
        }
    }

    public function logout()
    {
        session()->flush();

        Auth::guard('admin')->logout();

        $this->redirect(route('login'));
    }
}
