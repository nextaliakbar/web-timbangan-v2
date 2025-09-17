<div>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan Hasil Input Formula <span class="badge bg-primary">Plant MGFI</span> <span class="badge bg-secondary">72</span></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-end align-items-center mb-3 card-filters">
              <ul wire:ignore class="nav nav-pills mr-auto p-2">
                  <li class="nav-item">
                      <a wire:navigate href="{{route('admin.formula', ['plant' => 'unimos'])}}" 
                          class="nav-link {{request()->route()->parameter('plant') == 'unimos' ? 'active' : ''}}">
                          <h5>UNIMOS</h5>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a wire:navigate href="{{route('admin.formula', ['plant' => 'mgfi'])}}" 
                          class="nav-link {{request()->route()->parameter('plant') == 'mgfi'? 'active' : ''}}">
                          <h5>MGFI</h5>
                      </a>
                  </li>
              </ul>
              <div class="d-flex align-items-center ml-auto">
                  <select wire:model.live="paginate" class="form-control form-control mr-2" style="width: auto;">
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                  </select>
                  <div class="input-group" style="width: 400px;">
                      <input wire:model.live="search" type="text" name="table_search" class="form-control" placeholder="Cari berdasarkan no timbang, id barang">
                      <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                  </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>WAKTU</th>
                    <th>NO TIMBANG</th>
                    <th>ID BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>NO LOT</th>
                    <th>BATCH</th>
                    <th>BERAT</th>
                    <th>BERAT PER LOT</th>
                    <th>KET</th>
                    <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr wire:target="paginate, search, nextPage, previousPage, gotoPage" 
                  wire:loading.delay.class="d-table-row" class="d-none">
                      <td colspan="11" class="text-center py-2">
                          <div class="spinner-border text-primary" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                          <h5 class="mt-2">Memuat data...</h5>
                      </td>
                  </tr>
                  @forelse ($dataFormula as $data)
                  <tr wire:target="paginate, search, nextPage, previousPage, gotoPage" wire:loading.remove 
                  wire:key="{{$data->ID}}">
                      <td>{{$dataFormula->firstItem() + $loop->index}}</td>
                      <td>{{date('Y-m-d H:i', strtotime($data->WAKTU_TIMBANG))}}</td>
                      <td>
                          <div class="row">
                              <div class="col-md-10">
                                  {{$data->NO_DOK}}
                              </div>
                              <div class="col-auto">
                                  <button wire:click="exportPdf('{{$data->NO_DOK}}')" type="button" class="btn btn-sm btn-danger">
                                      <i class="fas fa-file-pdf"></i>
                                  </button>
                              </div>
                          </div>
                      </td>
                      <td>{{$data->ITEM_CODE}}</td>
                      <td>{{$data->NAMA_BARANG}}</td>
                      <td>{{$data->NO_LOT}}</td>
                      <td>{{$data->BATCH}}</td>
                      <td>{{$data->BERAT_FILTER}}</td>
                      <td>{{number_format($data->BERAT_PER_LOT, 2, ",")}}</td>
                      <td>{{$data->KET}}</td>
                      <td>
                          <button wire:click="edit({{$data->ID}})" 
                              type="button" class="btn btn-sm btn-warning mb-md-2 mb-2">
                              <i class="fas fa-edit"></i>
                          </button>
                          <button wire:click="confirm({{$data->ID}})" 
                              type="button" class="btn btn-sm btn-danger">
                              <i class="fas fa-trash"></i>
                          </button>
                      </td>
                  </tr>
                  @empty
                      <tr wire:target="paginate, search" wire:loading.remove>
                          <td colspan="11" class="text-center text-secondary">
                              <h5>Tidak ada data yang tersedia</h5>
                          </td>
                      </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <!-- Pagination can be added here if needed -->
            {{$dataFormula->links()}}
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('livewire.admin.formula.edit')

  @include('livewire.admin.formula.delete')

  <div wire:target="exportPdf, edit, confirm, update, destroy" 
    wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
        <div class="spinner-border text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

@assets
  <link rel="stylesheet" href="{{asset('assets/css/formula.css')}}">
@endassets

@script
  <script>
    $(document).ready(()=> {
      const loadingOverlay = $('#loading-overlay');
  
      $wire.on('openEditModal', ()=> {
          loadingOverlay.addClass('d-none');
          $('#editModal').modal('show');
      });
      
      $wire.on('openDeleteModal', ()=> {
          loadingOverlay.addClass('d-none');
          $('#deleteModal').modal('show');
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
  
      $wire.on('successDeleteData', (evt)=> {
          loadingOverlay.addClass('d-none');
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

