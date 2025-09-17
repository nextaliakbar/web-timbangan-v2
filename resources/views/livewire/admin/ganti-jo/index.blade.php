<div>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Hasil Input di Lapangan
                <span class="badge badge-info p-2">
                    Plant {{strtoupper(auth()->guard('admin')->user()->TEMPAT)}}
                </span>
            </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Daftar JO <span class="badge bg-secondary">{{$dataJo->total()}}</span></h1>
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 card-filters">
              <div class="d-flex align-items-center">
                  <i class="fas fa-info-circle mr-2"></i>
                  <select wire:model.live="interval" class="form-control" style="width: auto;">
                      <option value="2">2 Bulan Terakhir</option>
                      <option value="4">4 Bulan Terakhir</option>
                      <option value="6">6 Bulan Terakhir</option>
                      <option value="8">8 Bulan Terakhir</option>
                      <option value="10">10 Bulan Terakhir</option>
                      <option value="10">12 Bulan Terakhir</option>
                  </select>
              </div>
              <div class="d-flex align-items-center ml-auto">
                  <select wire:model.live="paginate" class="form-control mr-2" style="width: auto;">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                  </select>
                  <div class="input-group input-group">
                      <input wire:model.live="search" type="text" class="form-control" style="width: 300px;" placeholder="Cari berdasarkan id barang, nama barang, uniq id, id jo">
                      <div class="input-group-append">
                          <button type="button" class="btn btn-default">
                          <i class="fas fa-search"></i>
                          </button>
                      </div>
                  </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-striped text-nowrap">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>WAKTU</th>
                    <th>ID BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>BERAT</th>
                    <th>UNIQ ID</th>
                    <th>NO JO</th>
                    <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody>
                   <tr wire:target="search, interval, paginate, nextPage, previousPage, gotoPage" 
                    wire:loading.delay.class="d-table-row" class="d-none">
                        <td colspan="8" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <h5 class="mt-2">Memuat data...</h5>
                        </td>
                    </tr>
                    @forelse ($dataJo as $data)
                        <tr wire:key="{{$data->Id}}"  wire:target="search, interval, paginate, nextPage, previousPage, gotoPage" wire:loading.remove>
                            <td>{{ $dataJo->firstItem() + $loop->index }}</td>
                            <td>{{ date('Y-m-d H:i', strtotime($data->WAKTU)) }}</td>
                            <td>{{ $data->ID_BARANG }}</td>
                            <td>{{ $data->NAMA_BARANG }}</td>
                            <td>{{ $data->BERAT_FILTER }}</td>
                            <td>{{ $data->UNIQ_ID }}</td>
                            <td>{!! empty($data->NO_JO) || $data->NO_JO == '-' 
                            ? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' : $data->NO_JO !!}</td>
                            <td>
                                <button wire:click="edit('{{$data->Id}}')" type="button" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr  wire:target="search, interval, paginate" wire:loading.remove>
                            <td colspan="8" class="text-center text-secondary">
                                <h5>Tidak ada data yang tersedia</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            {{$dataJo->links()}}    
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('livewire.admin.ganti-jo.edit')

  <div wire:target="edit, confirmUpdate, mainUpdate, forceUpdate" wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/ganti-jo.css')}}">
@endassets

@script
    <script>
      $(document).ready(()=> {
        const loadingOverlay = $('#loading-overlay');
        $wire.on('openEditModal', ()=> {
          loadingOverlay.addClass('d-none');
          $('#editModal').modal('show');
        });
  
        $wire.on('confirmUpdate', ()=> {
          Swal.fire({
            title: "Anda yakin?",
            text: "Apakah anda ingin merubah No. JO menjadi kosong?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Lanjutkan",
            cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingOverlay.removeClass('d-none');
                    $wire.call('forceUpdate');
                }
            });
        });
  
        $wire.on('updateData', (evt)=> {
          loadingOverlay.addClass('d-none');
          $('#editModal').modal('hide');
          Swal.fire({
              title: evt.title,
              text: evt.text,
              icon: evt.icon
          });
        });
      });
    </script>
@endscript