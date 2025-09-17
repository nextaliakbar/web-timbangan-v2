<div>
    <div class="two-factor-form-container">
        <div class="two-factor-form text-center">
            <div wire:ignore id="countdown-container" class="d-none">
                <p id="countdown-info">Kode QR ini hanya akan berlaku</p>
                <p id="countdown-timer" class="text-danger"></p>
            </div>    
            <div class="qr-container">
            @if($isEnableScanQr)
                {!! $qrCodeInline !!}
            @else
                <img wire:loading.remove wire:target="enableTwoFactorAuth" 
                class="qr-image" src="{{asset('assets/images/qr-code.png')}}" alt="qrcode">
                <button wire:loading.remove wire:target="enableTwoFactorAuth"
                    wire:click="enableTwoFactorAuth" class="btn btn-md btn-primary activation-button">
                    <i class="fas fa-undo"></i>
                </button>
                <div wire:loading wire:target="enableTwoFactorAuth" class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div wire:loading.remove wire:target="enableTwoFactorAuth" class="col-12 my-2">
                <button wire:click="activateCode" type="button" class="btn btn-md btn-info w-100">
                    <span wire:loading.remove wire:target="activateCode">
                        Lanjutkan aktivasi kode
                    </span>
                    <span wire:loading wire:target="activateCode">
                        <i class="fas fa-spinner fa-spin mr-2"></i> 
                        Loading...
                    </span>
                </button>
            </div>
            @endif
        </div>    
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/two-factor.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/swal-input.css')}}">
@endassets

@script
    <script>
        $(document).ready(()=> {
            let timer;
            $wire.on('show-2fa-qr-code', (event)=> {
                clearInterval(timer);
                let duration = event.time;
                const display = $('#countdown-timer');
                $('#countdown-container').removeClass('d-none');
                timer = setInterval(function () {
                    let minutes = parseInt(duration / 60, 10);
                    let seconds = parseInt(duration % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
 
                    display.text(minutes + ":" + seconds);

                    duration--;
                    if (duration < 0) {
                        clearInterval(timer);
                        $('#countdown-info').text('Klik untuk mendapatkan kode QR baru');
                        display.text("Waktu Habis");
                        $wire.call('qrCodeExpired');
                    }
                }, 1000); 
            });
            
            $wire.on('activateCode', ()=> {
                Swal.fire({
                title: "Masukkan Kode Aktivasi",
                input: 'text',
                inputAttributes: {
                    inputmode: 'numeric',
                    maxlength: 6,
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                customClass: {
                    input: 'swal-input-custom'
                },
                didOpen: () => {
                    const input = Swal.getInput();
                    input.oninput = () => {
                        input.value = input.value.replace(/[^0-9]/g, '');
                    };
                },
                showCancelButton: true,
                confirmButtonText: "Aktivasi",
                showLoaderOnConfirm: true,
                preConfirm: async (code) => {
                    if(code.length != 6) {
                        Swal.showValidationMessage('Kode verifikasi harus 6 digit');
                        return;
                    }
                    try {
                        const response = await $wire.call('confirmActivateCode', code);
                        
                        if(!response) {
                            Swal.showValidationMessage('Kode aktivasi tidak valid');
                            return;
                        }

                        return response;

                    } catch(error) {
                        Swal.showValidationMessage('Terjadi kesalahan ' + error.message);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if(result.isConfirmed) {
                        $wire.call('directToApp');
                    }
                });
            });
        });
    </script>
@endscript