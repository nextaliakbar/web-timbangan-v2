<div>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Hasil Input di Lapangan 
                <span class="badge bg-primary">{{'Plant ' . strtoupper(request()->route()->parameter('plant'))}}</span>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Timbangan</li>
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
              <div class="card-body">
                <div wire:ignore class="d-flex flex-wrap align-items-center mb-3">
                    <ul class="nav nav-pills mr-auto p-2">
                        <li class="nav-item">
                            <a wire:navigate href="{{route('admin.timbangan', ['plant' => 'unimos'])}}" 
                                class="nav-link {{request()->route()->parameter('plant') == 'unimos' ? 'active' : ''}}">
                                <h5>UNIMOS</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:navigate href="{{route('admin.timbangan', ['plant' => 'mgfi'])}}" 
                                class="nav-link {{request()->route()->parameter('plant') == 'mgfi'? 'active' : ''}}">
                                <h5>MGFI</h5>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-auto mb-md-2 mb-sm-2">
                        <a wire:navigate href="{{route('admin.timbangan.sunfish', ['plant' => is_numeric($plant) ? ($plant == 2 ? 'unimos' : 'mgfi') : $plant])}}" class="mr-2">
                            <button type="button" class="btn btn-secondary">
                                Input No.Sunfish
                            </button>
                        </a>
                    </div>
                    <div class="col-auto mb-md-2 mb-sm-2">
                        <div class="btn-group dropright">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-info"></i>
                            </button>
                            <div class="dropdown-menu p-2" style="width: 500px;">
                                <p class="text-muted">
                                    NB: Cara Penggunaan. Jika ingin mencari bagian Tertentu, langsung saja cari di search 
                                    misal: STC-PRP, QA-GA Atau no BSTBnya langsung.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mb-md-2 mb-sm-2">
                        <select wire:model.live="dariKe" class="form-control">
                            <option value="" selected>Semua</option>
                            <option value="" disabled selected>-- Pilih dari tempat awal ke tempat tujuan --</option>
                            @foreach ($dataDariKe as $data)
                                <option value="{{substr($data->KODE, 1, -1)}}">{{$data->DARI_KE}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto mb-md-2 mb-sm-2">
                        <select wire:model.live="interval" class="form-control">
                            <option value="3">3 Bulan Terakhir</option>
                            <option value="6">6 Bulan Terakhir</option>
                        </select>
                    </div>
                    <div class="col-auto mb-md-2 mb-sm-2">
                        <select wire:model.live="paginate" class="form-control mr-4">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-md-2 mb-sm-2">
                        <div class="input-group input-group-md">
                            <input wire:model.live="search" type="text" class="form-control" placeholder="Cari berdasarkan uniq id, nama barang, id barang">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                 
                <div class="mb-3">
                    <h4>Daftar BSTB Belum di STF kan <span class="badge badge-secondary">{{$dataTimbang->total()}}</span></h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-nowrap">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>WAKTU</th>
                        <th>ID BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>BERAT</th>
                        <th>UNIQ ID</th>
                        <th><i class="fas fa-print"></i></th>
                        <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr wire:target="dariKe, interval, paginate, search, nextPage, previousPage, gotoPage" 
                        wire:loading.delay.class="d-table-row" class="d-none">
                            <td colspan="10" class="text-center py-2">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <h5 class="mt-2">Memuat data...</h5>
                            </td>
                        </tr>
                        @forelse ($dataTimbang as $data)
                            <tr wire:target="dariKe, interval, paginate, search, nextPage, previousPage, gotoPage" wire:loading.remove wire:key="{{$data->ID}}">
                                <td>{{$dataTimbang->firstItem() + $loop->index}}</td>
                                <td>{{$data->ID}}</td>
                                <td>{{$data->WAKTU}}</td>
                                <td>{{$data->ID_BARANG}}</td>
                                <td>{{$data->NAMA_BARANG}}</td>
                                <td>{{$data->BERAT_FILTER}}</td>
                                <td>{{$data->UNIQ_ID}}</td>
                                <td><button wire:click="exportPdf1({{$data->ID}})" type="button" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                                <td class="actions-button">
                                    <button wire:click="edit({{$data->ID}})" type="button" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirm({{$data->ID}})" type="button" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr wire:target="dariKe, interval, paginate, search" wire:loading.remove>
                                <td colspan="9" class="text-center text-secondary">
                                    <h5>Tidak ada data yang tersedia</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{$dataTimbang->links()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

    @include('livewire.admin.timbangan.edit')

    @include('livewire.admin.timbangan.delete')

    <div wire:target="exportPdf1, exportPdf2, edit, confirm, update, destroy" 
    wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/timbangan.css')}}">
@endassets

@script
    <script>
        $(document).ready(()=> {
            $wire.on('openEditModal', ()=> {
                $('#editModal').modal('show');
            });
            
            $wire.on('openDeleteModal', ()=> {
                $('#deleteModal').modal('show');
            });
            
            $('#productionDate').datetimepicker({
                format: 'YYYY-MM-DD HH:mm', 
                icons: {time: 'far fa-clock'} 
            });
    
            $('#weightDate').datetimepicker({
                format: 'YYYY-MM-DD HH:mm', 
                icons: {time: 'far fa-clock'} 
            });
    
            $wire.on('successUpdateData', (evt)=> {
                $('#editModal').modal('hide');
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });
    
            $wire.on('successDeleteData', (evt)=> {
                $('#deleteModal').modal('hide');
                Swal.fire({
                    title: evt.title,
                    text: evt.text,
                    icon: evt.icon
                });
            });
        });
    </script>
@endscript
