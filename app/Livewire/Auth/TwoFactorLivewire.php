<?php

namespace App\Livewire\Auth;
use Carbon\Carbon;
use Livewire\Component;

class TwoFactorLivewire extends Component
{
    public $timeForScan = 10;
    public $isQrCodeExpired = false;

    public $isEnableScanQr = false;
    public $qrCodeInline;
    public function render()
    {
        return view('livewire.auth.two-factor');
    }

    public function enableTwoFactorAuth()
    {
        $user = session()->get('user-esa-from-2fa');
        $google2fa = app('pragmarx.google2fa');
        
        $secretKey = $google2fa->generateSecretKey();
        $user->google2fa_secret = $secretKey;
        $user->save();
        $this->qrCodeInline = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->USER,
            $secretKey
        );

        $this->isQrCodeExpired = false;

        $this->isEnableScanQr = true;

        $this->dispatch('show-2fa-qr-code', time: $this->timeForScan);
    }

    public function qrCodeExpired(): void
    {
        $this->isQrCodeExpired = true;

        $this->isEnableScanQr = false;
    }

    public function activateCode()
    {
        $this->dispatch('activateCode');
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

    public function directToApp()
    {
        session()->flash('openSelectPurposeModal');
        $this->redirect(route('login'));
    }
}
