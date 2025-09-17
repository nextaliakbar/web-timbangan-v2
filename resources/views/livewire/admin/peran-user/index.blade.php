<div>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengaturan Peran User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Peran User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Form Card -->
            <form wire:submit.prevent="storeOrUpdate">
              @csrf
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pengaturan Peran User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="namaPeran">Nama Peran</label>
                    <input wire:model="role" type="text" class="form-control" id="namaPeran" placeholder="Misal : User">
                  </div>
                  <div class="form-group">
                    <label>Modul :</label>
                    <div class="d-flex flex-wrap">
                      <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="User Timbangan" id="checkUserTimbangan">
                          <label class="form-check-label" for="checkUserTimbangan">User Timbangan</label>
                      </div>
                      <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="Serah Terima" id="checkSerahTerima">
                          <label class="form-check-label" for="checkSerahTerima">Serah Terima</label>
                      </div>
                      <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="Timbangan" id="checkTimbangan">
                          <label class="form-check-label" for="checkTimbangan">Timbangan</label>
                      </div>
                      <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="Ganti JO" id="checkGantiJo">
                          <label class="form-check-label" for="checkGantiJo">Ganti JO</label>
                      </div>
                      <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="Formula" id="checkFormula">
                          <label class="form-check-label" for="checkFormula">Formula</label>
                      </div>
                       <div class="icheck-primary d-inline mr-4 mb-2">
                          <input wire:model="modules" type="checkbox" value="Kartu Stok" id="checkKartuStok">
                          <label class="form-check-label" for="checkKartuStok">Kartu Stok</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save mr-2"></i>Simpan</button>
                </div>
              </div>
            </form>
            <!-- /.card -->

            <!-- Data Table Card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Daftar Peran 
                  <span class="badge badge-secondary p-2">{{$userRoles->total()}}</span>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="col-auto">
                            <select wire:model.live="paginate" class="form-control">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="input-group search-form">
                            <input wire:model.live="search" type="text" class="form-control" placeholder="Cari berdasarkan nama peran">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama Peran</th>
                        <th>Daftar Module</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status Peran</th>
                        <th style="width: 40px"><i class="fas fa-cog"></i></th>
                      </tr>
                      </thead>
                      <tbody>
                        @forelse ($userRoles as $data)
                          <tr wire:key="{{$data->id}}">
                            <td>{{$userRoles->firstItem() + $loop->index}}</td>
                            <td>{{$data->role}}</td>
                            <td>
                                <div style="display: flex;">
                                      @foreach (collect($data->modules)->chunk(3) as $chunk)
                                          <div>
                                              <ul>
                                                  @foreach ($chunk as $module)
                                                      <li>{{ $module }}</li>
                                                  @endforeach
                                              </ul>
                                          </div>
                                      @endforeach
                                  </div>
                            </td>
                            <td>{{date('Y-m-d H:i', strtotime($data->created_at))}}</td>
                            <td>
                              <div class="custom-control custom-switch">
                                <input wire:click="updateStatus({{$data->id}})" type="checkbox" class="custom-control-input" id="customSwitch1" 
                                {{$data->status ? 'checked' : ''}}>
                                <label class="custom-control-label" for="customSwitch1"></label>
                              </div>
                            </td>
                            <td><button wire:click="edit({{$data->id}})" type="button" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button></td>
                          </tr>
                        @empty
                          <tr>
                              <td colspan="4" class="text-center text-secondary">
                                  Tidak ada data yang tersedia
                              </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                </div>
                {{$userRoles->links()}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>

@assets
  <link rel="stylesheet" href="{{asset('assets/css/peran-user.css')}}">
@endassets

@script
  <script>
      $(document).ready(()=> {
        $wire.on('validationError', (evt)=> {
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });
        
        $wire.on('successUpdateStatus', (evt)=> {
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });
  
        $wire.on('successStoreOrUpdate', (evt)=> {
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });
      });
  </script>
@endscript