<div>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daftar Serah Terima <span class="badge bg-primary">{{'Plant ' . strtoupper(request()->route()->parameter('plant'))}}</span> <span class="badge bg-secondary">{{$dataSerahTerima->total()}}</span></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Serah Terima</li>
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
                <div class="card-header d-flex align-items-center">
                     <ul class="nav nav-pills card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{request()->route()->parameter('plant') == 'unimos' ? 'active' : ''}}" wire:navigate href="{{route('admin.serah-terima', ['plant' => 'unimos'])}}">UNIMOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{request()->route()->parameter('plant') == 'mgfi' ? 'active' : ''}}" wire:navigate href="{{route('admin.serah-terima', ['plant' => 'mgfi'])}}">MGFI</a>
                        </li>
                    </ul>
                    <div class="card-tools d-flex align-items-center ml-auto">
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
                            <input wire:model.live="search" type="text" name="table_search" class="form-control" placeholder="Cari berdasarkan uniq id, nama user">
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped text-nowrap">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>UNIQ ID</th>
                        <th>NAMA USER</th>
                        <th>WAKTU</th>
                        <th>PIC SERAH</th>
                        <th>PIC TERIMA</th>
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
                      @forelse ($dataSerahTerima as $data)
                          <tr wire:target="paginate, search, nextPage, previousPage, gotoPage" wire:loading.delay wire:key="{{$data->UNIQ_ID}}">
                              <td>{{$dataSerahTerima->firstItem() + $loop->index}}</td>
                              <td>{{$data->UNIQ_ID}}</td>
                              <td>{{$data->NAMA_USER}}</td>
                              <td>{{$data->WAKTU}}</td>
                              <td>{!! $data->PIC_SERAH == '' || empty($data->PIC_SERAH) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $data->PIC_SERAH !!}</td>
                              <td>{!! $data->PIC_TERIMA == '' || empty($data->PIC_TERIMA) ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $data->PIC_TERIMA !!}</td>
                              <td>
                                  <button wire:click="edit({{$data->UNIQ_ID}})" 
                                      type="button" class="btn btn-sm btn-warning">
                                      <i class="fas fa-edit"></i>
                                  </button>
                              </td>
                          </tr>
                      @empty
                          <tr wire:target="paginate, search" wire:loading.remove>
                              <td colspan="7" class="text-center text-secondary">
                                  <h5>Tidak ada data yang tersedia</h5>
                              </td>
                          </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                {{$dataSerahTerima->links()}}    
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    @include('livewire.admin.serah-terima.edit')

    <div wire:target="edit, update" wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/serah-terima.css')}}">
@endassets

@script
    <script>
      $(document).ready(()=> {
        $wire.on('openEditModal', ()=> {
            $('#loading-overlay').addClass('d-none');
            $('#editModal').modal('show');
        });
  
        $wire.on('successUpdateData', (evt)=>{
            $('#loading-overlay').addClass('d-none');
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });

      });
    </script>
@endscript
