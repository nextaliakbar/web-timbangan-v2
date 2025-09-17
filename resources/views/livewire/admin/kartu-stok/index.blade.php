<div>
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kartu Stok <span class="badge bg-primary">Plant UNIMOS</span></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <ul wire:ignore class="nav nav-pills mr-auto p-2">
                  <li class="nav-item">
                      <a wire:navigate href="{{route('admin.kartu-stok', ['plant' => 'unimos'])}}" 
                          class="nav-link {{request()->route()->parameter('plant') == 'unimos' ? 'active' : ''}}">
                          <h5>UNIMOS</h5>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a wire:navigate href="{{route('admin.kartu-stok', ['plant' => 'mgfi'])}}" 
                          class="nav-link {{request()->route()->parameter('plant') == 'mgfi'? 'active' : ''}}">
                          <h5>MGFI</h5>
                      </a>
                  </li>
              </ul>
             <!-- Filter Section -->
            <div class="bg-light p-3 mb-4 rounded border">
                <div class="row">
                    <div class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>Tanggal Mulai:</label>
                        <div class="input-group date" id="startDate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#startDate"/>
                            <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>Tanggal Berakhir:</label>
                        <div class="input-group date" id="endDate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#endDate"/>
                            <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>Tujuan:</label>
                        <select wire:model="dariKe" class="form-control">
                            <option value="" selected>Semua</option>
                            <option disabled>-- Pilih dari tempat awal ke tempat tujuan --</option>
                            @foreach ($dataDariKe as $data)
                                <option value="{{$data->DARI_KE}}">{{$data->DARI_KE}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>Kategori:</label>
                        <select wire:model.live="kategori" class="form-control">
                          <option value="" selected>Semua</option>
                            <option disabled>-- Pilih Kategori --</option>
                          @foreach ($dataKategori as $data)
                              <option value="{{$data->itemCategoryType}}">{{$data->itemCategoryType}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div wire:ignore class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>Sub Kategori:</label>
                        <select class="form-control" id="subkategori-select">
                          <option value="">--Pilih Sub Kategori--</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-2 col-lg-4 col-md-6 col-sm-12">
                        <label>SHIFT</label>
                        <div class="shift-filter-container">
                            <div class="icheck-primary d-inline"><input wire:model="shifts" type="checkbox" value="1" id="shift1" checked><label class="form-check-label" for="shift1">1</label></div>
                            <div class="icheck-primary d-inline"><input wire:model="shifts" type="checkbox" value="2" id="shift2" checked><label class="form-check-label" for="shift2">2</label></div>
                            <div class="icheck-primary d-inline"><input wire:model="shifts" type="checkbox" value="3" id="shift3" checked><label class="form-check-label" for="shift3">3</label></div>
                            <button id="filter-button" type="button" class="btn btn-primary btn-sm" wire:loading.attr="disabled"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h4>Daftar Kartu Stok <span class="badge bg-secondary">{{$dataKartuStok->total()}}</span></h4>
                 <div class="card-tools d-flex align-items-center">
                    <select wire:model.live="paginate" class="form-control form-control-md mr-2" style="width: auto;">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                    <div class="input-group input-group-md" style="width: 400px;">
                        <input wire:model.live="search" type="text" name="table_search" class="form-control" placeholder="Cari berdasarkan nama barang, id sunfish">
                        <div class="input-group-append"><button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button></div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>INFORMASI TANGGAL</th>
                    <th>INFORMASI SHIFT</th>
                    <th>KODE SUNFISH</th>
                    <th>NO.BSTB</th>
                    <th>NAMA BARANG</th>
                    <th>TOTAL BERAT</th>
                    <th>PCS/ROLL</th>
                    <th>INFORMASI LAIN</th>
                  </tr>
                </thead>
                <tbody>
                  <tr wire:target.except="kategori"
                  wire:loading.delay.class="d-table-row" class="d-none">
                      <td colspan="9" class="text-center py-2">
                          <div class="spinner-border text-primary" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                          <h5 class="mt-2">Memuat data...</h5>
                      </td>
                  </tr>
                   @forelse ($dataKartuStok as $data)
                  <tr wire:target.except="kategori" wire:loading.remove wire:key="{{$data->ID}}">
                      <td>{{$dataKartuStok->firstItem() + $loop->index}}</td>
                      <td>
                          <div class="row">
                              <div class="col-auto">
                                  <p>TANGGAL</p>
                                  @if(isset($data->TGL_PRODUKSI))
                                  <p>TANGGAL PRODUKSI</p>
                                  @endif
                              </div>
                              <div class="col-auto">
                                  <p>: {{$data->WKT ?? '-'}}</p>
                                  @if(isset($data->TGL_PRODUKSI))
                                  <p>: {{$data->TGL_PRODUKSI}}</p>
                                  @endif
                              </div>
                          </div>   
                      </td>
                      <td>
                          <div class="row">
                              <div class="col-auto">
                                  <p>SHIFT</p>
                                  @if(isset($data->SHIFT_PRODUKSI))
                                  <p>SHIFT PRODUKSI</p>
                                  @endif
                              </div>
                              <div class="col-auto">
                                  <p>: {{$data->SHIFT}}</p>
                                  @if(isset($data->SHIFT_PRODUKSI))
                                  <p>: {{$data->SHIFT_PRODUKSI}}</p>
                                  @endif
                              </div>
                          </div>
                      </td>
                      <td>{{$data->ID_SUNFISH}}</td>
                      <td>{{$data->UNIQ_ID}}</td>
                      <td>{{$data->NAMA_BARANG}}</td>
                      <td>{{round($data->BF, 2)}}</td>
                      <td>{{$data->JPCS ?? '-'}}</td>
                      <td>
                          {{isset($data->JMLH) ? "JUMLAH : $data->JMLH" : "-"}}
                      </td>
                  </tr>
                  @empty
                      <tr wire:target.except="kategori, nextPage, previousPage, goToPage" wire:loading.remove>
                          <td colspan="9" class="text-center text-secondary">
                              Tidak ada data yang tersedia
                          </td>
                      </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            {{$dataKartuStok->links()}}
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
@assets
  <link rel="stylesheet" href="{{asset('assets/css/kartu-stok.css')}}">
@endassets

@script
  <script>
    $(document).ready(()=> {
      $('#startDate').datetimepicker({
            format: 'YYYY-MM-DD'
      });

      $('#endDate').datetimepicker({
          format: 'YYYY-MM-DD'
      });

      $('#startDate').data('datetimepicker').date(new Date());
      $('#endDate').data('datetimepicker').date(new Date());

      $('#filter-button').on('click', ()=> {
          const startDateValue = $('#startDate').find('input').val();
          const endDateValue = $('#endDate').find('input').val();
          const subKategoriValue = $('#subkategori-select').val() ?? '';
          const data = {
            startDate: startDateValue,
            endDate: endDateValue,
            subKategori: subKategoriValue
          };
  
        $wire.dispatch('filter', {data: data});
  
        });
  
        $wire.on('updateSubKategoriOptions', (evt)=> {
          let selectElement = $('#subkategori-select');
          
          selectElement.empty();
  
          selectElement.append(new Option("--Pilih Sub Kategori--", "", false, false));
  
          const data = evt.data;
  
          data.forEach(item => {
            let option = new Option(item.KATEGORI, item.KATEGORI, false, false)
            selectElement.append(option);
          });
  
        });
    });
  </script>
@endscript

