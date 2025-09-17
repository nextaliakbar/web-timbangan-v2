<div>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Column: Input Form -->
                <div class="col-lg-7">
                    <form wire:submit.prevent="store">
                        @csrf
                        <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="alert alert-warning text-center">
                                <h5 class="alert-heading mb-0">{!! $noBstb ?? '<i class="fas fa-exclamation-triangle"></i> Pilih dari tempat awal ke tempat tujuan terlebih dahulu'!!}</h5>
                            </div>
                            
                            <div class="form-group">
                            <select wire:model.live="dariKe" class="form-control form-control-lg">
                                <option value="" selected>-- Pilih dari tempat awal ke tempat tujuan --</option>
                                @foreach ($dataDariKe as $data)
                                    <option value="{{substr($data->KODE, 1, -1)}}">
                                        {{$data->DARI_KE}}
                                    </option>
                                @endforeach
                            </select>
                            </div>
    
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label>Shift Timbang</label>
                                <select wire:model="shiftTimbang" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div wire:ignore class="form-group col-md-4">
                                <label>Tanggal Produksi</label>
                                <div class="input-group date" id="productionDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#productionDate"/>
                                    <div class="input-group-append" data-target="#productionDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Shift Produksi</label>
                                <select wire:model.live="shiftProduksi" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            </div>
    
                            <div wire:ignore class="form-group">
                                <label>Pilih Barang</label>
                                <select class="form-control" id="select-barang" style="width: 100%"></select>
                            </div>
    
                            <div class="input-group mb-3">
                                <div class="input-group">
                                    <input wire:model="berat" type="text" class="form-control text-center" style="font-size: xx-large"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <div class="input-group-append">
                                        <span class="input-group-text">KG</span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div wire:ignore class="form-group col-md-6">
                                    <label>No.JO:</label>
                                    <select multiple="multiple" id="select-no-jo" style="width: 100%"></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>KET:</label>
                                    <select wire:model="keterangan" class="form-control">
                                        <option value="" selected>-- Pilih Keterangan --</option>
                                        <option value="HOLD">HOLD</option>
                                        <option value="SAPUAN">SAPUAN</option>
                                        <option value="GOSONG">GOSONG</option>
                                        <option value="MENTAH">MENTAH</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Qty:</label>
                                    <input wire:model="qty" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Pcs:</label>
                                    <input wire:model="pcs" type="text" class="form-control"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <small class="form-text text-muted">Gunakan tanda titik (.) untuk menggantikan koma</small>
                                </div>
                            </div>
    
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block btn-lg" wire:loading.attr="disabled">
                                <b>Simpan</b>
                            </button>
                        </div>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Data Table -->
                <div class="col-lg-5">
                    <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Cetak Faktur Timbang 
                            <div class="custom-control custom-switch">
                                <input wire:model="cetakFaktur" type="checkbox" class="custom-control-input" id="switcher-control-1">
                                <label class="custom-control-label" for="switcher-control-1"></label>
                            </div>
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ID BARANG</th>
                                <th>NAMA BARANG</th>
                                <th>BERAT FILTER</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr wire:target="nextPage, previousPage, gotoPage" 
                                wire:loading.delay.class="d-table-row" class="d-none">
                                    <td colspan="5" class="text-center py-2">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <h5 class="mt-2">Memuat data...</h5>
                                    </td>
                                </tr>
                                @forelse ($dataTimbang as $data)
                                    <tr wire:target="nextPage, previousPage, gotoPage" 
                                    wire:loading.remove wire:key="{{$data->ID}}">
                                        <td>{{$dataTimbang->firstItem() + $loop->index}}</td>
                                        <td>{{$data->ID}}</td>
                                        <td>{{$data->ID_BARANG}}</td>
                                        <td>{{$data->NAMA_BARANG}}</td>
                                        <td>{{$data->BERAT_FILTER}}</td>
                                        <td>
                                            <button wire:click="printInvc({{$data->ID}})" type="button" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                            <button wire:click="confirm({{$data}})" type="button" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr wire:target="nextPage, previousPage, gotoPage" wire:loading.remove>
                                        <td colspan="5" class="text-center text-secondary">
                                            Tidak ada data saat ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        {{$dataTimbang->links()}}
                    </div>
                    </div>
                    <button id="synchronize" type="submit" class="btn btn-success btn-block btn-lg mt-2" wire:loading.attr="disabled">
                        <b>Hasil Timbang</b>
                    </button>
                </div>
            </div>
        </div>
        </section>
        <div wire:target="store, forceStore, printInvc, confirm, synchronize" wire:loading.delay.class.remove="d-none" id="loading-overlay" class="loading-overlay d-none">
            <div class="spinner-border text-info" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

</div>

@assets
    <link rel="stylesheet" href="{{asset('assets/css/main-app.css')}}">
@endassets

@script
    <script>
        $(document).ready(()=> {

        function getDataBarang(){
                $('#select-barang').select2({
                    theme: 'bootstrap4',
                    ajax: {
                        type: 'GET',
                        url: "{{route('main-app.search-item')}}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchItem: params.term
                            }
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            }
                        },
                        cache: true
                    }
                });
            }

        getDataBarang();

        let productionDate = $('#productionDate').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: @json($tglProduksi)
        });

        $wire.on('resetItems', ()=> {
            let selectBarang = $('#select-barang').select2({
                theme: 'bootstrap4'
            });
            selectBarang.empty();

            getDataBarang();

            $('#productionDate').data('datetimepicker').date(new Date());
        });

        $('#productionDate').on('change.datetimepicker', function(e){
            let date = e.date ? e.date.format('YYYY-MM-DD') : null;
            $wire.set('tglProduksi', date);
        });

        let selectNoJo = $('#select-no-jo').select2({
            theme: 'bootstrap4'
        });

        function getDataNoJo(data) {
            if(data) {
                selectNoJo.empty();

                data.forEach(item => {
                    let option = new Option(item.NO_JO, item.NO_JO, false, false);

                    selectNoJo.append(option);
                });

                selectNoJo.trigger('change');
            }
        }

        const data = $wire.dataNoJo;

        getDataNoJo(data);

        $wire.on('loadDataNoJo', (event)=> {
            const data = event.data;
            getDataNoJo(data);
        });

        $('#select-barang').on('change', function() {
            let data = $(this).val();
            $wire.set('idSunfish', data);
        });

        $('#select-no-jo').on('change', function() {
            let data = $(this).val();
            $wire.set('dataNoJo', data);
        });

        $wire.on('validationError', (evt)=> {
            $('#loading-overlay').addClass('d-none');
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });

        $wire.on('confirmSave', function() {
            $('#loading-overlay').addClass('d-none');

            Swal.fire({
                title: "Anda yakin?",
                text: "Nomor JO belum dipilih, apakah anda ingin menyimpan hasil timbang bs tanpa Nomor Jo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Lanjutkan",
                cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loading-overlay').removeClass('d-none');
                        $wire.dispatch('forceStore');
                    }
                });
        });

        $wire.on('successSaveData', (evt)=> {
            $('#loading-overlay').addClass('d-none');
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });

        $wire.on('confirmDestroy', function(evt) {
            $('#loading-overlay').addClass('d-none');
            Swal.fire({
                title: "Anda yakin?",
                html: `
                    <p class="swal-text">Ingin menghapus data timbang barang dengan detail:</p>
                    <div class="swal-details">
                        <div><span class="label">ID</span>: ${evt.data.ID}</div>
                        <div><span class="label">ID Barang</span>: ${evt.data.ID_BARANG}</div>
                        <div><span class="label">Nama Barang</span>: ${evt.data.NAMA_BARANG}</div>
                        <div><span class="label">Berat</span>: ${evt.data.BERAT_FILTER}</div>
                    </div>
                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Lanjutkan",
                cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loading-overlay').removeClass('d-none');
                        $wire.dispatch('destroy', {data: evt.data});
                    }
                });
        });

        $wire.on('successDeleteData', (evt)=> {
            $('#loading-overlay').addClass('d-none');
            Swal.fire({
                title: evt.title,
                text: evt.text,
                icon: evt.icon
            });
        });

        $wire.on('printInvc', (evt)=> {
            $('#loading-overlay').addClass('d-none');
            window.open(evt.url, '_blank');
        });
    
        $('#synchronize').on('click', ()=> {
            Swal.fire({
                title: 'Peringatan',
                text: 'Development',
                icon: 'warning'
            });
        });

        });
    </script>
@endscript