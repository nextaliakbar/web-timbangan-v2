<div>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item mr-2">
          <button class="btn btn-primary" data-toggle="modal" data-target="#weightModal">
            <i class="fas fa-rocket mr-2"></i>
            Masuk Ke Aplikasi Timbangan
          </button>
      </li>
      <!-- User Account Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle fa-lg"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            {{auth()->guard('admin')->user()->USER}} | {{auth()->guard('admin')->user()->userEsaRole->role}}
          </span>
          <div class="dropdown-divider"></div>
          @if(auth()->guard('admin')->user()->userEsaRole->role == 'ADMIN')
          <button wire:click="refresh" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Pengaturan 2FA
          </button>
          @endif
          <button class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </button>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <div wire:ignore.self class="modal fade" id="faModal">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-body text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <label>Hari</label>
            <input wire:model="timeOut2FA" type="text" class="form-control text-center"
            oninput="this.value = this.value.replace(/[^1-9]/g, '').replace(/(\..*)\./g, '$1')">
            <p>
              Atur batas waktu agar pengguna yang diizinkan verifikasi 2FA melakukan kembali aktivasi kode
            </p>
            <button wire:click="updateTimeOut2FA" class="btn btn-md btn-primary w-100">
              <span wire:loading.remove wire:target="updateTimeOut2FA">
                  <i class="fas fa-undo mr-2"></i>
                  Perbarui
              </span>
              <span wire:loading wire:target="updateTimeOut2FA">
                  <i class="fas fa-spinner fa-spin mr-2"></i> 
                  Loading...
              </span>
            </button>
          </div>
        </div>
      </div>
  </div>
  <div wire:ignore.self class="modal fade" id="logoutModal">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-body text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title mb-2">Anda yakin ingin keluar?</h4>
            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Tidak</button>
            <button wire:click="logout" type="button" class="btn btn-danger">Ya</button>
          </div>
        </div>
      </div>
  </div>

  @include('livewire.auth.weight-modal')
</div>

@script
  <script>
    $(document).ready(()=>{
      $wire.on('openFaModal', ()=> {
        $('#faModal').modal('show');
      });

      $wire.on('successUpdateTimeOut2FA', (evt)=> {
        $('#faModal').modal('hide');
        Swal.fire({
            title: evt.title,
            text: evt.text,
            icon: evt.icon,
            heightAuto: false
        });
      });

      $wire.on('errorModal', (evt)=> {
        Swal.fire({
            title: evt.title,
            text: evt.text,
            icon: evt.icon,
            heightAuto: false
        });
      });
    });
  </script>
@endscript


