<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div wire:ignore class="modal-header">
            <h4 class="modal-title">Perbarui Data Serah Terima 
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
            <div class="form-group">
                <label for="uniqId">UNIQ ID</label>
                <input wire:model="uniqId" type="text" class="form-control" id="uniqId" disabled>
                @error('uniqId')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="picSerah">PIC SERAH</label>
                <input wire:model="picSerah" type="text" class="form-control" id="picSerah">
                @error('picSerah')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="picTerima">PIC TERIMA</label>
                <input wire:model="picTerima" type="text" class="form-control" id="picTerima">
                @error('picTerima')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <div class="flex justify-content-between">
                <button type="button" class="btn btn-md btn-secondary mr-2" data-dismiss="modal" wire:loading.attr="disabled">
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