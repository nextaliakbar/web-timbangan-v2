<div>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Timbangan <span class="badge bg-secondary">{{$userEsa->total()}}</span></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Timbangan</li>
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
            <div class="card">
              <div class="card-header">
                <button wire:click="create" id="button-create" type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                  <i class="fas fa-plus"></i> Tambah
                </button>

                <div class="card-tools d-flex align-items-center">
                    <div class="col-auto">
                        <select wire:model.live="paginate" class="form-control mr-2">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="input-group" style="width: 400px;">
                        <input wire:model.live="search" type="text" name="table_search" class="form-control" placeholder="Cari berdasarkan nik, nama">
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped text-nonwrap">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>NIK</th>
                          <th>NAMA USER</th>
                          <th>PLANT</th>
                          <th>PIC</th>
                          <th>BAGIAN</th>
                          <th>PROGRAM</th>
                          <th>DEPARTMENT</th>
                          <th>HAK</th>
                          <th><i class="fas fa-cog"></i></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr wire:target="paginate, search, nextPage, previousPage, gotoPage" 
                        wire:loading.delay.class="d-table-row" class="d-none">
                            <td colspan="10" class="text-center py-2">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <h5 class="mt-2">Memuat data...</h5>
                            </td>
                        </tr>
                        @forelse ($userEsa as $usrEsa)
                        <tr wire:target="paginate, search, nextPage, previousPage, gotoPage" wire:loading.remove wire:key="{{$usrEsa->USER}}">
                            <td>{{$userEsa->firstItem() + $loop->index}}</td>
                            <td>{{$usrEsa->USER}}</td>
                            <td>{{$usrEsa->NAMA}}</td>
                            <td>{!! $usrEsa->TEMPAT == '' || empty($usrEsa->TEMPAT) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $usrEsa->TEMPAT !!}</td>
                            <td>{!! $usrEsa->PIC == '' || empty($usrEsa->PIC) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $usrEsa->PIC !!}</td>
                            <td>{!! $usrEsa->BAGIAN == '' || empty($usrEsa->BAGIAN) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $usrEsa->BAGIAN !!}</td>
                            <td>{!! $usrEsa->AKSES == 1 ? 'Desktop' : ($usrEsa->AKSES == 2 ? 'Web' : ($usrEsa->AKSES == 3 ? 'Desktop & Web' : '<span class="badge badge-danger p-2">Tidak Tersedia</span>')) !!}</td>
                            <td>{!! $usrEsa->DEPT == '' || empty($usrEsa->DEPT) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $usrEsa->DEPT !!}</td>
                            <td>{!! $usrEsa->HAK == '' || empty($usrEsa->HAK) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $usrEsa->HAK !!}</td>
                            <td>
                                <button type="button" wire:click="edit('{{$usrEsa->USER}}')" class="btn btn-warning btn-sm mr-1 mb-2 mb-md-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" wire:click="confirm('{{$usrEsa->USER}}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                            <tr wire:loading.remove>
                                <td colspan="10" class="text-center text-secondary">
                                    Tidak ada data yang tersedia
                                </td>
                            </tr>
                        @endforelse
                      </tbody>
                    </table>
                    <div class="col-auto">
                        {{$userEsa->links()}}
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
    @include('livewire.admin.user-timbangan.create')
    @include('livewire.admin.user-timbangan.edit')
    @include('livewire.admin.user-timbangan.delete')

    <div wire:target="edit, store, update, confirm, destroy" wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/user-timbangan.css')}}">
@endassets

@script
    <script>
        $(document).ready(()=> {
            const loadingOverlay = $('#loading-overlay');
            
            $wire.on('validationError', (evt)=> {
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });

            $wire.on('successSaveData', (evt)=> {
                loadingOverlay.addClass('d-none');
                $('#createModal').modal('hide');
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });

            $wire.on('openEditModal', ()=> {
                loadingOverlay.addClass('d-none');
                $('#editModal').modal('show');
            });
            
            $wire.on('successUpdateData', (evt)=> {
                loadingOverlay.addClass('d-none');
                $('#editModal').modal('hide');
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });

            $wire.on('openDeleteModal', ()=> {
                loadingOverlay.addClass('d-none');
                $('#deleteModal').modal('show');
            });

            $wire.on('successDeleteData', (evt)=> {
                loadingOverlay.addClass('d-none');
                $('#deleteModal').modal('hide');
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });


            let selectTujuanCreate = $('#select-tujuan-create').select2({
                theme:'bootstrap4',
            });

            let selectTujuanEdit = $('#select-tujuan-edit').select2({
                theme: 'bootstrap4'
            });

            $wire.on('loadDataDariKeCreate', (event) => {
                const data = event.data;

                selectTujuanCreate.empty();

                data.forEach(item => {
                    let newOption = new Option(item.DARI_KE, item.KODE, false, false);
                    
                    selectTujuanCreate.append(newOption);
                });

                selectTujuanCreate.trigger('change');
            });

            $wire.on('loadDataDariKeEdit', (event)=> {
                const data = event.data;
                const destinations = event.destination ?? [];
                
                selectTujuanEdit.empty();

                data.forEach(item => {
                    let newOption = new Option(item.DARI_KE, item.KODE, false, false);
                    selectTujuanEdit.append(newOption);
                });
                if(destinations) {
                    selectTujuanEdit.val(destinations);
                }
                selectTujuanEdit.trigger('change');
            });

            $('#select-tujuan-create').on('change', function() {
                let data = $(this).val();

                $wire.set('tujuan', data); 
            });

            $('#select-tujuan-edit').on('change', function() {
                let data = $(this).val();

                $wire.set('tujuan', data);
            });

            $('#button-create').on('click', ()=> {
                selectTujuanCreate.empty();
            });
        });
    </script>
@endscript
