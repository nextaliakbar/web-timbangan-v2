<div>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 d-flex align-items-center">
            <h1 class="mr-3 h3">Edit No. Sunfish <span class="badge bg-primary">Plant {{strtoupper($plant)}}</span></h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
             <a wire:navigate href="{{route('admin.timbangan', ['plant' => is_numeric($plant) ? ($plant == 2 ? 'unimos' : 'mgfi') : $plant])}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- First Table Card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">NO BSTB Belum Serah Terima</h3>
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 card-filters">
                <select wire:model.live="dariKe" class="form-control form-control-sm" style="width: auto;">
                    <option value="" selected>Semua</option>
                    <option disabled>-- Pilih dari tempat awal ke tempat tujuan --</option>
                    @foreach ($dataDariKe as $data)
                        <option value="{{substr($data->KODE, 1, -1)}}">{{$data->DARI_KE}}</option>
                    @endforeach
                </select>
                <div class="d-flex align-items-center ml-auto">
                    <select wire:model.live="paginate1" class="form-control form-control-sm mr-2" style="width: auto;">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option>50</option>
                    </select>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input wire:model.live="search1" type="text" name="table_search" class="form-control" placeholder="Cari berdasarkan no.bstb">
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
                    <th>NO BSTB Belum Serah Terima</th>
                    <th>Waktu Timbang</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <tr wire:target="dariKe, paginate1, search1, nextPage, previousPage, gotoPage" 
                  wire:loading.delay.class="d-table-row" class="d-none">
                      <td colspan="4" class="text-center py-2">
                          <div class="spinner-border text-primary" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                          <h5 class="mt-2">Memuat data...</h5>
                      </td>
                </tr>
                @forelse ($dataTimbang1 as $data)
                  <tr wire:target="dariKe, paginate1, search1, nextPage, previousPage, gotoPage" wire:loading.remove wire:key="{{$data->UNIQ_ID}}" id="data-timbang-1">
                      <td>{{$dataTimbang1->firstItem() + $loop->index}}</td>
                      <td>{!! $data->after_two_month 
                      ? '<span class="text-dark">'.$data->UNIQ_ID.'</span>'
                      : '<span class="text-danger">'.$data->UNIQ_ID.'</span>' !!}
                      </td>
                      <td>{!! $data->after_two_month 
                      ? '<span class="text-dark">'.date("Y-m-d H:i", strtotime($data->WAKTU)).'</span>'
                      : '<span class="text-danger">'.date("Y-m-d H:i", strtotime($data->WAKTU)).'</span>' !!}
                      </td>
                      <td>{{empty($data->WTA) ? 'Belum kirim ' . $data->before_total . ' item' : (empty($data->WHT) ? 'Belum terima ' . $before_total . ' item' : '')}}</td>
                  </tr>
                @empty
                  <tr wire:target="dariKe, paginate1, search1" wire:loading.remove>
                      <td colspan="4" class="text-center text-secondary">
                          <h5>Tidak ada data yang tersedia</h5>
                      </td>
                  </tr>
                @endforelse
                  <!-- More data rows -->
                </tbody>
              </table>
            </div>
             <!-- Pagination -->
             {{$dataTimbang1->links()}}
          </div>
        </div>

        <!-- Second Table Card -->
        <div class="card">
            <div class="card-body">
                 <div class="d-flex flex-wrap justify-content-end align-items-center mb-3 card-filters">
                    <div class="d-flex align-items-center ml-auto">
                        <select wire:model.live="paginate2" class="form-control form-control-sm mr-2" style="width: auto;">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                        </select>
                        <div class="input-group input-group-sm" style="width: 350px;">
                            <input wire:model.live="search2" type="text" name="table_search_2" class="form-control" placeholder="Cari berdasarkan id sunfish, no.bstb, nama barang, tanggal, berat, wht">
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
                                <th>TGL</th>
                                <th>ID SUNFISH</th>
                                <th>NO.BSTB</th>
                                <th>NAMA BARANG</th>
                                <th>BERAT</th>
                                <th>WTA</th>
                                <th>WHT</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr wire:target="paginate2, search2" 
                            wire:loading.delay.class="d-table-row" class="d-none">
                                <td colspan="9" class="text-center py-2">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <h5 class="mt-2">Memuat data...</h5>
                                </td>
                          </tr>
                        @forelse ($dataTimbang2 as $data)
                            <tr wire:target="paginate2, search2" wire:loading.remove wire:key="{{$data->UNIQ_ID}}">
                                <td>{{$dataTimbang2->firstItem() + $loop->index}}</td>
                                <td>{{date('Y-m-d H:i', strtotime($data->WAKTU))}}</td>
                                <td>{{$data->ID_BARANG}}</td>
                                <td>{{$data->UNIQ_ID}}</td>
                                <td>{{$data->NAMA_BARANG}}</td>
                                <td>{{$data->BERAT_FILTER}}</td>
                                <td>{{$data->WTA}}</td>
                                <td>{{$data->WHT}}</td>
                                <td class="action-buttons">
                                    <button wire:click="exportPdf('{{$data->UNIQ_ID}}')" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                    <button wire:click="edit('{{$data->UNIQ_ID}}')" type="button" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr wire:target="paginate2, search2" wire:loading.remove>
                                <td colspan="10" class="text-center text-secondary">
                                    Tidak ada data yang tersedia
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                {{$dataTimbang2->links()}}
            </div>
        </div>

      </div>
    </section>
    <!-- /.content -->
  </div>
  @include('livewire.admin.timbangan.sunfish.edit')

  <div wire:target="edit, update, exportPdf" wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
      <div class="spinner-border text-info" role="status">
          <span class="sr-only">Loading...</span>
      </div>
  </div>
</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/sunfish.css')}}">
@endassets

@script
    <script>
        $(document).ready(()=> {
            $wire.on('openEditModal', ()=> {
                $('#loading-overlay').addClass('d-none');
                $('#editModal').modal('show');
            });
    
            $wire.on('successUpdateData', (evt)=> {
                $('#loading-overlay').addClass('d-none');
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