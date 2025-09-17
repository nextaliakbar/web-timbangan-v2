<!-- Modal -->
<div wire:ignore.self class="modal fade" id="deleteModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Data User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-2">NIK</div>
                <div class="col-10">: {{$nik}}</div>
            </div>

            <div class="form-group row">
                <div class="col-2">Nama</div>
                <div class="col-10">: {!!$user ?? '<span class="badge badge-danger p-2">Tidak Tersedia</span>'!!}</div>
            </div>
            
            <div class="form-group row">
                <div class="col-2">PLANT</div>
                <div class="col-10">: {!!$plant ?? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' !!}</div>
            </div>
            
            <div class="form-group row">
                <div class="col-2">PIC</div>
                <div class="col-10">: {!! $pic ?? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' !!}</div>
            </div>
            
            <div class="form-group row">
                <div class="col-2">HAK</div>
                <div class="col-10">: {!! $hak ?? '<span class="badge badge-danger p-2">Tidak Tersedia</span>' !!}</div>
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