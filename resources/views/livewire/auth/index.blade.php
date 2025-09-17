<div>
    <div class="login-form-container">
        <div class="login-form">
        <div class="text-center">
            <img src="{{asset('assets/images/pattern_kokola.png')}}" alt="Kokola Logo" class="login-logo">
        </div>
        
        <form wire:submit.prevent="login">
            @csrf
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input wire:model="nik" type="text" class="form-control" placeholder="Masukkan NIK" required>
            </div>
            
            <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input wire:model="password" type="password" class="form-control" placeholder="Masukkan Password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block btn-login">
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">
                    <i class="fas fa-spinner fa-spin mr-2"></i> 
                    Loading...
                </span>
            </button>

            <div class="text-center text-secondary my-2">atau</div>

        </form>
        <a href="{{route('google.redirect')}}">
            <button type="submit" class="btn btn-block btn-login border">
                <img class="mx-2" src="{{asset('assets/images/google.png')}}" alt="google">
                Masuk dengan google
                {{-- <span wire:loading wire:target="login">
                    <i class="fas fa-spinner fa-spin mr-2"></i> 
                    Loading...
                </span> --}}
            </button>
        </a>
        </div>
        
    </div>

    <div wire:ignore.self class="modal fade" id="selectPurposeModal">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Tujuan Masuk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button wire:click="goToWeightApp" type="button" class="btn btn-md btn-info w-100">
                                <span wire:loading.remove wire:target="goToWeightApp">
                                    <i class="fas fa-weight mr-2"></i>
                                    Masuk ke Aplikasi Timbangan
                                </span>
                                <span wire:loading wire:target="goToWeightApp">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> 
                                    Loading...
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <button wire:click="loginToManagementApp" type="button" class="btn btn-md btn-success w-100">
                                <span wire:loading.remove wire:target="loginToManagementApp">
                                    <i class="fas fa-window-restore mr-2"></i>
                                    Masuk ke Aplikasi Manajemen
                                </span>
                                <span wire:loading wire:target="loginToManagementApp">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> 
                                    Loading...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    @include('livewire.auth.weight-modal')
</div>
@assets
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/swal-input.css')}}">
@endassets
@script
    <script>
        $(document).ready(()=> {
            $wire.on('openSelectPurposeModal', ()=> {
                $('#selectPurposeModal').modal('show');
            });
            
            $wire.on('openWeightModal', ()=> {
                $('#selectPurposeModal').modal('hide');
                $('#weightModal').modal('show');
            });
    
            $wire.on('errorModal', (evt)=> {
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon,
                    heightAuto: false
                });
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
                        $wire.call('openSelectPurposeModal');
                    }
                });
            });
        });
    </script>
@endscript

@if(session()->has('openSelectPurposeModal'))
    @script
        <script>
            $(document).ready(()=> {
                $('#selectPurposeModal').modal('show');
            });
        </script>
    @endscript
@endif