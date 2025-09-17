<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div wire:ignore class="modal-header">
            <h4 class="modal-title"> Perbarui Data BSTB di 
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
                        <label for="uniqId">UNIQ ID</label>
                        <input wire:model="uniqId" type="text" class="form-control" id="uniqId" disabled>
                        @error('uniqId')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="idBarang">ID Barang</label>
                        <input wire:model="idBarang" type="text" class="form-control" id="idBarang">
                        @error('idBarang')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="namaBarang">Nama Barang</label>
                        <input wire:model="namaBarang" type="text" class="form-control" id="namaBarang">
                        @error('namaBarang')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        <label for="beratFilter">BERAT</label>
                        <input wire:model="beratFilter" type="text" class="form-control" disabled>
                    </div>
        
                    <div class="form-group">
                        <label for="tglTimbang">TANGGAL TIMBANG</label>
                        <div class="input-group date" id="weightDate" data-target-input="nearest">
                            <input wire:model="tglTimbang" type="text" class="form-control datetimepicker-input" data-target="#weightDate" readonly/>
                            <div class="input-group-append" data-target="#weightDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0"><b>Catatan :</b></p>
                        <p class="text-muted medium mb-0">AM = Dimulai dari pukul 12:00 hingga 23:59</p>
                        <p class="text-muted medium mb-0">PM = Dimulai dari pukul 00:00 hingga 11:59</p>
                    </div>

                    <div class="form-group">
                        <label for="select-order-type">SHIFT</label>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shift" type="radio" name="shift" id="shiftRadio1" value="1">
                                <label for="shiftRadio1">1</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shift" type="radio" name="shift" id="shiftRadio2" value="2">
                                <label for="shiftRadio2">2</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="shift" type="radio" name="shift" id="shiftRadio3" value="3">
                                <label for="shiftRadio3">3</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kategori">KATEGORI</label>
                        <input wire:model="kategori" type="text" class="form-control" id="kategori">
                        @error('kategori')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input wire:model="qty" type="text"  class="form-control" id="qty">
                        @error('qty')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="dari">DARI KE</label>
                        <input wire:model="dari" type="text" class="form-control" readonly>
                        @error('dari')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
        
                    <div class="form-group">
                        <label for="pcs">PCS</label>
                        <input wire:model="pcs" type="text" class="form-control">
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