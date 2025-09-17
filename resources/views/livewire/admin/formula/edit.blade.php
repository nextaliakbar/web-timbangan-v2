<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div wire:ignore class="modal-header">
            <h4 class="modal-title"> Perbarui Data Formula di 
                <span class="badge badge-info p-2">
                    {{'Plant ' . strtoupper(request()->route()->parameter('plant'))}}
                </span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form wire:submit.prevent="update">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="noDok">NOMOR PENIMBANGAN</label>
                        <input wire:model="noDok" type="text" class="form-control" id="noDok" disabled>
                    </div>

                    <div class="form-group">
                        <label for="kodeBarang">KODE Barang</label>
                        <input wire:model="kodeBarang" type="text" class="form-control" id="kodeBarang" disabled>
                    </div>
    
                    <div class="form-group">
                        <label for="namaBarang">NAMA BARANG</label>
                        <input wire:model="namaBarang" type="text" class="form-control" id="namaBarang" disabled>
                    </div>

                    <div class="form-group">
                        <label for="tglPenimbangan">TANGGAL PENIMBANGAN</label>
                        <div class="input-group date" id="weighingDate" data-target-input="nearest">
                            <input wire:model="tglPenimbangan" type="text" class="form-control datetimepicker-input" data-target="#weighingDate"/>
                            <div class="input-group-append" data-target="#weighingDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0"><b>Catatan :</b></p>
                        <p class="text-muted medium mb-0">AM = Dimulai dari pukul 12:00 hingga 23:59</p>
                        <p class="text-muted medium mb-0">PM = Dimulai dari pukul 00:00 hingga 11:59</p>
                    </div>

                    <div class="form-group">
                        <label for="select-order-type">SHIFT PENIMBANGAN</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftPenimbangan" type="radio" name="shiftPenimbangan" id="shiftPenimbangan1" value="1">
                                <label for="shiftPenimbangan1">1</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftPenimbangan" type="radio" name="shiftPenimbangan" id="shiftPenimbangan2" value="2">
                                <label for="shiftPenimbangan2">2</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftPenimbangan" type="radio" name="shiftPenimbangan" id="shiftPenimbangan3" value="3">
                                <label for="shiftPenimbangan3">3</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="beratFilter">BERAT</label>
                        <input wire:model="beratFilter" type="text" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="nomorBarcode">NOMOR BARCODE/LOT</label>
                        <input wire:model="nomorBarcode" type="text" class="form-control">
                    </div>
                
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input wire:model="qty" type="text"  class="form-control @error('qty') is-invalid @enderror" id="qty">
                        @error('qty')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tglProduksi">TANGGAL PRODUKSI</label>
                        <div class="input-group date" id="productionDate" data-target-input="nearest">
                            <input wire:model="tglProduksi" type="text" class="form-control datetimepicker-input" data-target="#productionDate"/>
                            <div class="input-group-append" data-target="#productionDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0"><b>Catatan :</b></p>
                        <p class="text-muted medium mb-0">AM = Dimulai dari pukul 12:00 hingga 23:59</p>
                        <p class="text-muted medium mb-0">PM = Dimulai dari pukul 00:00 hingga 11:59</p>
                    </div>

                    <div class="form-group">
                        <label for="select-order-type">SHIFT PRODUKSI</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftProduksi" type="radio" name="shiftProduksi" id="shiftProduksiRadio1" value="1">
                                <label for="shiftProduksiRadio1">1</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftProduksi" type="radio" name="shiftProduksi" id="shiftProduksiRadio2" value="2">
                                <label for="shiftProduksiRadio2">2</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shiftProduksi" type="radio" name="shiftProduksi" id="shiftProduksiRadio3" value="3">
                                <label for="shiftProduksiRadio3">3</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="note">Keterangan</label>
                        <textarea wire:model="keterangan" id="note" class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                        @error('keterangan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="flex justify-content-between">
                <button type="button" class="btn btn-md btn-secondary mr-2" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-md btn-warning">
                    <i class="fas fa-edit mr-2"></i>Perbarui
                </button>
            </div>
        </div>
        </form>
    </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->