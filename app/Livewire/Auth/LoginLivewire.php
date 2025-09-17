<?php

namespace App\Livewire\Auth;

use App\Models\Setting;
use App\Models\UserEsa;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginLivewire extends Component
{
    /**
     * Summary of nik, password, jenisPic,
     * pic, passwordPic
     * @var 
     */
    public $nik, $password, $jenisPic,
    $pic, $passwordPic, $qrCodeUrl;

    public UserEsa $userEsa;

    public function render()
    {
        return view('livewire.auth.index');
    }

    /**
     * Summary of login
     * Jika izin 2fa pengguna diizinkan dan timeout 2fa belum melewati waktu sekarang
     * Aktivasi kode tidak dilakukan.
     * Jika izin 2fa pengguna diizinkan dan timeout 2fa sudah melewati waktu sekarang
     * Aktivasi kode dilakukan.
     * @return void
     */
    public function login()
    {
        $this->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);
        
        $userEsa = UserEsa::where('USER', '=',$this->nik)->first();

        if ($userEsa && hash('sha256', $this->password) === $userEsa->PASS) {

            $dayTimeOutFa = Setting::where('key', '=', '2fa_timeout')
            ->value('value');
            $timeOut2FA = Carbon::parse($userEsa->google2fa_timeout)->addDays((int) $dayTimeOutFa);
            
            if(!$userEsa->google2fa_enable || ($userEsa->google2fa_enable && !empty($userEsa->google2fa_secret) && Carbon::now()->isBefore($timeOut2FA))) {
                $this->userEsa = $userEsa;
                $this->dispatch('openSelectPurposeModal');
                return;
            }
            
            if(($userEsa->google2fa_enable && !empty($userEsa->google2fa_secret) && Carbon::now()->isAfter($timeOut2FA))) {
                $this->dispatch('activateCode');
                return;
            }
            
            session()->put('user-esa-from-2fa', $userEsa);
            session()->flash('2fa-auth');
            $this->redirect(route('two-factor'));

        } else {
            $this->dispatch('errorModal', title: 'Gagal', text: 'NIK atau Password Salah', icon: 'error');
        }
    }

    public function confirmActivateCode($activateCode)
    {
        $user = session()->get('user-esa-from-2fa');
        $user->google2fa_timeout = Carbon::now();
        $user->save();

        $google2fa = app('pragmarx.google2fa');
        
        $scretKey = $user->google2fa_secret;

        return $google2fa->verifyKey($scretKey, $activateCode);
    }

    public function openSelectPurposeModal()
    {
        $this->dispatch('openSelectPurposeModal');
    }

    private function loginToManageApp($userEsa)
    {
        if(empty($userEsa)) {
            $this->dispatch('errorModal', title: 'Gagal', text: 'Akun tidak ditemukan', icon: 'error');
            return;
        }

        if(empty($userEsa->USER)) {
            UserEsa::where('Id', '=', $userEsa->Id)->delete();
            $this->dispatch('errorModal', title: 'Gagal', text: 'Akun tidak ditemukan', icon: 'error');
            return;
        }

        if(empty($userEsa->HAK)) {
            $this->dispatch('errorModal', title: 'Gagal', text: 'Akun ini tidak memiliki hak akses', icon: 'error');
            return;
        }        

        $userRoles = UserRole::whereStatus(true)->get();

        $roles = [];

        foreach($userRoles as $userRole) {
            $roles[] = $userRole->role;
        }

        if(!in_array($userEsa->HAK, $roles)) {
            $this->dispatch('errorModal', title: 'Gagal', text: 'Hak akses untuk akun ini belum diatur', icon: 'error');
            return;
        }

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

    /**
     * Summary of loginToManagementApp
     * @return void
     */
    public function loginToManagementApp()
    {
        if(session()->has('user-esa-from-oauth2')) {
            $userEsa = session()->get('user-esa-from-oauth2');
            $this->loginToManageApp($userEsa);
        } else if(session()->has('user-esa-from-2fa')) {
            $userEsa = session()->get('user-esa-from-2fa');
            $this->loginToManageApp($userEsa);
        } else {
            $this->loginToManageApp($this->userEsa);
        }
    }

    /**
     * Summary of goToWeightApp
     * @return void
     */
    public function goToWeightApp()
    {
        session()->put('guest', 'user');

        if(session()->has('user-esa-from-oauth2')) {
            $userEsa = session()->get('user-esa-from-oauth2');
            if(empty($userEsa)) {
                $this->dispatch('errorModal', title: 'Gagal', text: 'Akun tidak ditemukan', icon: 'error');
                return;
            }

            if(empty($userEsa->USER)) {
                UserEsa::where('Id', '=', $userEsa->Id)->delete();
                $this->dispatch('errorModal', title: 'Gagal', text: 'Akun tidak ditemukan', icon: 'error');
                return;
            }
            if(empty($userEsa->PIC)) {
                $this->dispatch('errorModal', title: 'Gagal', text: 'Jenis PIC akun ini belum ditentukan', icon: 'error');
                return;
            }

            $this->jenisPic = $userEsa->PIC == 'PIC_SERAH' ? 'Terima' : 'Serah';
        } else if(session()->has('user-esa-from-2fa')) {
            $userEsa = session()->get('user-esa-from-2fa');
            $this->jenisPic = $userEsa->PIC == 'PIC_SERAH' ? 'Terima' : 'Serah';
        } else {
            $this->jenisPic = $this->userEsa->PIC == 'PIC_SERAH' ? 'Terima' : 'Serah';
        }

        $this->dispatch('openWeightModal');
    }

    /**
     * Summary of loginToWeightApp
     * @return void
     */
    public function loginToWeightApp()
    {
        $userEsa = UserEsa::where('PIC', '=', $this->jenisPic == 'Serah' ? 'PIC_SERAH' : 'PIC_TERIMA')
        ->where('USER', '=', $this->pic)
        ->first();

        if($userEsa && hash('sha256', $this->passwordPic) === $userEsa->PASS) {
            session()->put('user-pic', $userEsa);

            if(session()->has('user-esa-from-oauth2')) {
                Auth::guard('user')->login(session()->get('user-esa-from-oauth2'));
            } else if(session()->has('user-esa-from-2fa')) {
                Auth::guard('user')->login(session()->get('user-esa-from-2fa'));
            } else {
                Auth::guard('user')->login($this->userEsa);
            }
            $this->redirect(route('main-app.index'));
        } else {
            $this->dispatch('errorModal', title: 'Gagal', text: 'NIK atau Password Salah', icon: 'error');
        }
    }
}
