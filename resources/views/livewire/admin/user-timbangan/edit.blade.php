<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Perbarui Data User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="update">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input wire:model="nik" type="text" class="form-control" disabled>
                            </div>
        
                            <div class="form-group">
                                <label>User</label>
                                <input wire:model="user" type="text" class="form-control 
                                @error('user') is-invalid @enderror">
                                @error('user')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror 
                            </div>
        
                            <div class="form-group">
                                <label>Pilih PIC</label>
                                <select wire:model="pic" class="form-control
                                @error('pic') is-invalid @enderror"
                                >
                                    <option value="" selected>-- Pilih PIC --</option>
                                    <option value="PIC_SERAH">PIC Serah</option>
                                    <option value="PIC_TERIMA">PIC Terima</option>
                                </select>
                                @error('pic')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label>Pilih Tempat</label>
                                <select wire:model.live="tempat" class="form-control
                                @error('tempat') is-invalid @enderror"
                                >
                                    <option value="" selected>-- Pilih PT --</option>
                                    <option value="MGFI" {{$tempat == 'MGFI' ? 'selected' : ''}}>PT. MGFI</option>
                                    <option value="UNIMOS" {{$tempat == 'UNIMOS' ? 'selected' : ''}}>PT. UNIMOS</option>
                                    <option value="OS" {{$tempat == 'OS' ? 'selected' : ''}}>OS</option>
                                </select>
                                @error('tempat')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label>Pilih Departemen</label>
                                <select wire:model.live="departemen" wire:key="{{$tempat}}" class="form-control
                                @error('departemen') is-invalid @enderror"
                                >
                                    <option value="" selected>-- Pilih Departemen --</option>
                                    @foreach ($departementOptions as $dept)
                                        <option value="{{$dept}}" {{$dept == $departemen ? 'selected' : ''}}>{{$dept}}</option>
                                    @endforeach
                                </select>
                                @error('departemen')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label>Pilih Bagian</label>
                                <select wire:model="bagian" wire:key="{{$departemen}}" class="form-control"
                                    {{-- @error('bagian') is-invalid @enderror" --}}
                                    >
                                        <option value="" selected>-- Pilih Bagian --</option>
                                        @foreach ($sectionOptions as $sect)
                                            <option value="{{$sect}}" {{$sect == $bagian ? 'selected' : ''}}>{{$sect}}</option>
                                        @endforeach
                                </select>
                                {{-- @error('bagian')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Program</label>
                                <select wire:model="program" class="form-control 
                                @error('program') is-invalid @enderror"
                                >
                                    <option value="" selected>-- Pilih Program --</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Web">Web</option>
                                    <option value="Desktop & Web">Desktop & Web</option>
                                </select>
                                @error('program')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label>Pilih Hak</label>
                                <select wire:model="hak" class="form-control 
                                @error('hak') is-invalid @enderror"
                                >
                                    <option value="" selected>-- Pilih Hak --</option>
                                    @foreach ($userRoles as $data)
                                        <option value="{{$data->role}}">{{$data->role}}</option>
                                    @endforeach
                                </select>
                                @error('hak')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label for="passwordLogin">Password Login</label>
                                <input wire:model="passwordLogin" type="password" class="form-control 
                                @error('passwordLogin') is-invalid @enderror" 
                                id="passwordLogin">
                                @error('passwordLogin')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label for="konfirmasiPasswordLogin">Konfirmasi Password Login</label>
                                <input wire:model="konfirmasiPasswordLogin" type="password" class="form-control 
                                @error('passwordLogin') is-invalid @enderror"
                                id="konfirmasiPasswordLogin">
                                @error('konfirmasiPasswordLogin')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label for="passwordSerahTerima">Password Serah / Terima</label>
                                <input wire:model="passwordSerahTerima" type="password" class="form-control 
                                @error('passwordSerahTerima') is-invalid @enderror" 
                                id="passwordSerahTerima">
                                @error('passwordSerahTerima')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label for="konfirmasiPasswordSerahTerima">Konfirmasi Password Serah / Terima</label>
                                <input wire:model="konfirmasiPasswordSerahTerima" type="password" class="form-control 
                                @error('konfirmasiPasswordSerahTerima') is-invalid @enderror" 
                                id="konfirmasiPasswordSerahTerima">
                                @error('konfirmasiPasswordSerahTerima')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div wire:ignore class="col-md-12">
                        <div class="form-group">
                            <label>Tentukan Tujuan User</label>
                                <select id="select-tujuan-edit" multiple="multiple" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary mr-2" wire:loading.attr="disabled" data-dismiss="modal">
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