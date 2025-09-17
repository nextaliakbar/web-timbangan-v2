<div>
    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item user-info-header d-none d-md-flex">
        <span class="navbar-text">Anda Masuk Sebagai PIC {{auth('user')->user()->PIC == 'PIC_SERAH' ? 'Serah' : 'Terima'}} : 
            <strong class="text-success">{{auth('user')->user()->USER}}</strong></span>
        <span class="navbar-text">PIC {{session()->get('user-pic')->PIC == 'PIC_SERAH' ? 'Serah' : 'Terima'}} Anda Adalah : 
            <strong class="text-info">{{session()->get('user-pic')->USER}}</strong></span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button wire:click="loginToManagementApp" type="button" class="btn btn-primary btn-sm">
            <span wire:loading.remove wire:target="loginToManagementApp">
                <i class="fas fa-cogs mr-1"></i>
                Masuk Ke Aplikasi Manajemen
            </span>
            <span wire:loading.delay wire:target="loginToManagementApp">
                <i class="fas fa-spinner fa-spin mr-2"></i> 
                Loading...
            </span>
        </button>
      </li>
      <li class="nav-item ml-2">
        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-1"></i> 
            Keluar
        </button>
      </li>
       <li class="nav-item ml-2">
        <a class="nav-link" href="#">
          <i class="far fa-user-circle fa-lg"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
    <div class="modal fade" id="logoutModal">
      <div class="modal-dialog">
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
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
</div>
