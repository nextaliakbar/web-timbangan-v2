<div wire:ignore.self class="modal fade" id="weightModal">
    <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Masukkan Informasi PIC {{$jenisPic}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form wire:submit.prevent="loginToWeightApp">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>PIC {{$jenisPic}}</label>
                            <input wire:model="pic" type="text" class="form-control" placeholder="Masukkan NIK" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input wire:model="passwordPic" type="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary w-100">
                        <span wire:loading.remove wire:target="loginToWeightApp">Masuk</span>
                        <span wire:loading wire:target="loginToWeightApp">
                            <i class="fas fa-spinner fa-spin mr-2"></i> 
                            Loading...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>