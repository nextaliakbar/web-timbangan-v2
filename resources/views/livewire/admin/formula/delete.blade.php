<!-- Modal -->
<div wire:ignore.self class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Data Formula</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-3">NO TIMBANG</div>
                <div class="col-9">: {{$idTimbang}}</div>
            </div>

            <div class="form-group row">
                <div class="col-3">KODE BARANG</div>
                <div class="col-9">: {{$kodeBarang}}</div>
            </div>

            <div class="form-group row">
                <div class="col-3">Nama Barang</div>
                <div class="col-9">: {{$namaBarang}}</div>
            </div>
            
            <div class="form-group row">
                <div class="col-3">BERAT</div>
                <div class="col-9">: {{$beratFilter}}</div>
            </div>

            <div class="form-group row">
                <div class="col-3">NO LOT</div>
                <div class="col-9">: {{$nomorBarcode}}</div>
            </div>

            <div class="form-group row">
                <div class="col-3">BERAT PER LOT</div>
                <div class="col-9">: {{$beratFilter}}</div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button wire:click="destroy" type="button" class="btn btn-danger">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->