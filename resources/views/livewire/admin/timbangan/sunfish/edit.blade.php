<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Perbarui Data WTA & WHT</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="update">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="uniqId">NO.BSTB</label>
                        <input wire:model="uniqId" type="text" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="idBarang">ID BARANG</label>
                        <input wire:model="idBarang" type="text" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="namaBarang">NAMA BARANG</label>
                        <input wire:model="namaBarang" type="text" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="wta">WTA</label>
                        <input wire:model="wta" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')">
                        @error('wta')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="wht">WHT</label>
                        <input wire:model="wht" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')">
                        @error('wht')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger mr-2" wire:loading.attr="disabled" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                            <i class="fas fa-edit mr-2"></i>Perbarui
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->