<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div wire:ignore class="modal-header">
            <h4 class="modal-title"> Perbarui No. JO </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form wire:submit.prevent="mainUpdate">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <select wire:model="jenisEdit" class="form-control">
                    <option value="1">ID Barang Per BSTB</option>
                    <option value="2">Urutan Timbang Per BSTB</option>
                </select>
            </div>
            <div class="form-group">
                <label>UNIQ ID</label>
                <input wire:model="uniqId" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>ID BARANG</label>
                <input wire:model="idBarang" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>NAMA BARANG</label>
                <input wire:model="namaBrg" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>BERAT</label>
                <input wire:model="beratFilter" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>WAKTU</label>
                <input wire:model="waktu" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>NO.JO LAMA</label>
                <input wire:model="noJoLama" type="text" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>NO.JO BARU</label>
                <input wire:model="noJoBaru" type="text" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <div class="flex justify-content-between">
                <button type="button" class="btn btn-md btn-secondary mr-2" wire:loading.attr="disabled" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-md btn-warning" wire:loading.attr="disabled">
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