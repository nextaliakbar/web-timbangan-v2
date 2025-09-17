<?php

namespace App\Livewire\Admin;

use App\Models\DariKe;
use App\Models\UserEsa;
use App\Models\UserRole;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class UserTimbanganLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = "10";

    public $search, $nik, $user, $plant, $pic, $departemen, $bagian, $tempat, 
    $program, $hak, $userEsaNik, $passwordLogin, $konfirmasiPasswordLogin,
    $passwordSerahTerima, $konfirmasiPasswordSerahTerima;
    public $dataDariKe = [];

    public $tujuan = [];

    private $isEditModal = false;

    public $placeOptions = [];

    public $departementOptions = [];

    public $sectionOptions = [];

    protected $options = [
        'MGFI' => [
            'RnD' => ['PREPARATION', 'MGFI Gudang Formulasi'],
            'QA' => ['QUALITY ASSURANCE', 'MGFI Gudang GA'],
            'Warehouse' => ['NDM', 'GUDANG_RETUR'],
            'Produksi' => ['PRODUKSI', 'MGFI Gudang Formulasi'],
            'Maintenance' => ['PRODUKSI'],
            'Personalia & Legal' => [],
            'TAC GA' => [],
        ],
        'UNIMOS' => [
            'RnD' => ['Unimos Gudang Formulasi', 'Unimos Gudang Biskuit', 'RnD', 'Unimos Preparation'],
            'Produksi Biskuit' => ['Unimos Gudang Biskuit'],
            'Maintenance' => ['Unimos Gudang Maintenance', 'Unimos Gudang Wafer'],
            'Produksi Wafer' => ['Unimos Gudang Wafer'],
            'QA' => ['Unimos Gudang QA'],
            'MIS' => [],
            'TAC GA' => ['Unimos Gudang NDM'],
            'Personalia & Legal' => ['Unimos Gudang Maintenance'],
        ],
        'OS' => [
            'RnD' => ['Unimos Gudang Formulasi'],
            'QA' => [],
            'Maintenance' => ['Unimos Gudang Maintenance', 'Unimos Gudang Biskuit', 'Unimos Gudang Wafer'],
            'Produksi Wafer' => ['Unimos Gudang Wafer'],
            'Warehouse' => ['Unimos Gudang Retur', 'Unimos Gudang NDM'],
            'TAC GA' => ['GENERAL AFFAIR'],
            'Produksi Biskuit' => ['Unimos Gudang Biskuit'],
        ]
    ];

    public function render()
    {
        $data = [
            'userEsa' => UserEsa::where('FLAG', '=', '1')
            ->where(function($query) {
                $query->where('USER', 'like', '%' . $this->search . '%')
                ->orWhere('NAMA', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->paginate ?? 10),
            'userRoles' => UserRole::select('role')->get()
        ];

        return view('livewire.admin.user-timbangan.index', $data);
    }

    public function updatedPaginate()
    {
        $this->resetPage();
    }

    public function updatedTempat($value)
    {
        $this->departementOptions = isset($this->options[$value]) ? array_keys($this->options[$value]) : [];
        $this->reset(['departemen', 'bagian', 'sectionOptions']);
        
        $plant = $this->tempat == 'UNIMOS' ? 2 : ($this->tempat == 'MGFI' ? 7 : 0);
        
        $dataDariKe = DariKe::where('PLANT', '=', $plant)
        ->get();

        $this->dispatch('loadDataDariKeCreate', data: $dataDariKe);

        if($this->tujuan) {
            $formatedDataTujuan = array_map(function($code) {
                return "($code)";
            }, $this->tujuan);
            $this->dispatch('loadDataDariKeEdit', data: $dataDariKe, destination: $formatedDataTujuan);
        }
    }

    public function updatedDepartemen($value)
    {
        $this->sectionOptions = $this->options[$this->tempat][$value] ?? [];
        $this->reset(['bagian']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function refresh()
    {
        $this->resetValidation();
        $this->reset([
            'nik', 
            'user', 
            'pic',
            'tempat',
            'departemen',
            'bagian',
            'program',
            'hak',
            'passwordLogin',
            'konfirmasiPasswordLogin',
            'passwordSerahTerima',
            'konfirmasiPasswordSerahTerima',
            'tujuan'
        ]);
    }
    
    protected function rules()
    {
        $rules = [
            'user' => 'required',
            'pic' => 'required',
            'tempat' => 'required',
            'departemen' => 'required',
            // 'bagian' => 'required',
            'program' => 'required',
            'hak' => 'required',
            'tujuan' => 'required|array'
        ];

        if($this->isEditModal) {
            if(filled($this->passwordLogin)) {
                $rules['passwordLogin'] = 'same:konfirmasiPasswordLogin';
                $rules['konfirmasiPasswordLogin'] = 'required';
            }
    
            if(filled($this->passwordSerahTerima)) {
                $rules['passwordSerahTerima'] = 'same:konfirmasiPasswordSerahTerima';
                $rules['konfirmasiPasswordSerahTerima'] = 'required';
            }
        } else {
            $rules['nik'] = 'required|unique:user_esa,USER';
            $rules['passwordLogin'] = 'required';
            $rules['konfirmasiPasswordLogin'] = 'required|same:passwordLogin';
            $rules['passwordSerahTerima'] = 'required';
            $rules['konfirmasiPasswordSerahTerima'] = 'required|same:passwordSerahTerima';
        }


        return $rules;
    }

    protected function messages()
    {
        return [
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK sudah tersedia',
            'user.required' => 'Nama tidak boleh kosong',
            'pic.required' => 'Tentukan PIC',
            'tempat.required' => 'Tentukan PT',
            'departemen.required' => 'Tentukan departemen',
            // 'bagian.required' => 'Tentukan bagian',
            'program.required' => 'Tentukan program',
            'hak.required' => 'Tentukan hak',
            'passwordLogin.required' => 'Password login tidak boleh kosong',
            'konfirmasiPasswordLogin.required' => 'Konfirmasi password login tidak boleh kosong',
            'konfirmasiPasswordLogin.same' => 'Konfirmasi password login tidak cocok',
            'passwordSerahTerima.required' => 'Password serah terima tidak boleh kosong',
            'konfirmasiPasswordSerahTerima.required' => 'Konfirmasi password serah terima tidak boleh kosong',
            'konfirmasiPasswordSerahTerima.same' => 'Konfirmasi password serah terima tidak cocok',
            'tujuan.required' => 'Tentukan minimal 1 pengaturan tujuan user'
        ];
    }

    public function create()
    {
        $this->refresh();
    }

    public function store()
    {
        $this->isEditModal = false;

        try {
            $this->validate();
        } catch(ValidationException $ex) {
            if($ex->validator->errors()->has('tujuan')) {
                $errorMessage = $ex->validator->errors()->first('tujuan');

                $this->dispatch('validationError', title: 'Gagal', text: $errorMessage, icon: 'error');
            }

            throw $ex;
        }

        $akses = match($this->program) {
            'Desktop' => 1,
            'Web' => 2,
            'Desktop & Web' => 3
        };
        
        $id = UserEsa::max('Id');
        $id += 1;

        $formatedDataTujuan = array_map(function($code) {
            return substr($code, 1, -1);   
        }, $this->tujuan);

        $userEsa = [
            'Id' => $id,
            'USER' => $this->nik,
            'NAMA' => $this->user,
            'PIC' => $this->pic,
            'TEMPAT' => $this->tempat,
            'DEPT' => $this->departemen,
            'BAGIAN' => $this->bagian,
            'AKSES' => $akses,
            'HAK' => $this->hak,
            'PASS' => hash('sha256',$this->passwordLogin),
            'PICPASS' => hash('sha256',$this->passwordSerahTerima),
            'TUJUAN' => $formatedDataTujuan
        ];

        UserEsa::create($userEsa);

        $this->dispatch('successSaveData', title: 'Sukses', text: 'Data berhasil ditambah', icon: 'success');
    }

    public function edit($userEsaNik)
    {
        $this->refresh();

        $userEsa = UserEsa::whereUser($userEsaNik)->firstOrFail();

        $this->nik = $userEsa->USER;
        $this->user = $userEsa->NAMA;
        $this->pic = $userEsa->PIC;
        $this->tempat = $userEsa->TEMPAT;

        if($this->tempat) {
            $this->departementOptions = isset($this->options[$this->tempat]) ? array_keys($this->options[$this->tempat]) : [];
        }

        if($this->departementOptions) {
            $this->departemen = $userEsa->DEPT;
        }
        

        if($this->departemen) {
            $this->sectionOptions = $this->options[$this->tempat][$this->departemen] ?? [];
        }

        if($this->sectionOptions) {
            $this->bagian = $userEsa->BAGIAN;
        }

        $this->program = match($userEsa->AKSES) {
            '1' => 'Desktop',
            '2' => 'Web',
            '3' => 'Desktop & Web',
            default => ''
        };

        $this->hak = $userEsa->HAK;

        $plant = $this->tempat == 'UNIMOS' ? 2 : ($this->tempat == 'MGFI' ? 7 : 0);

        $dataDariKe = DariKe::select('KODE', 'DARI_KE')
        ->where('PLANT', '=', $plant)
        ->get();

        if($userEsa->TUJUAN) {
            $formatedDataTujuan = array_map(function($code) {
                return "($code)";
            }, $userEsa->TUJUAN);
    
            $this->dispatch('loadDataDariKeEdit', data: $dataDariKe, destination: $formatedDataTujuan);
    
            $this->tujuan = $userEsa->TUJUAN;
        } else {
            $this->dispatch('loadDataDariKeEdit', data: $dataDariKe);
        };

        $this->userEsaNik = $userEsa->USER;

        $this->dispatch('openEditModal');
    }

    public function update()
    {
        $this->isEditModal = true;

        try {
            $this->validate();
        } catch(ValidationException $ex) {
            if($ex->validator->errors()->has('tujuan')) {
                $errorMessage = $ex->validator->errors()->first('tujuan');

                $this->dispatch('validationError', title: 'Gagal', text: $errorMessage, icon: 'error');
            }

            throw $ex;
        }
        
        $akses = match($this->program) {
            'Desktop' => 1,
            'Web' => 2,
            'Desktop & Web' => 3
        };

        $formatedDataTujuan = array_map(function($code) {
            return substr($code, 1, -1);   
        }, $this->tujuan);

        $dataToUpdate = [
            'NAMA' => $this->user,
            'PIC' => $this->pic,
            'TEMPAT' => $this->tempat,
            'DEPT' => $this->departemen,
            'BAGIAN' => $this->bagian,
            'AKSES' => $akses,
            'HAK' => $this->hak,
            'TUJUAN' => $formatedDataTujuan
        ];

        if(filled($this->passwordLogin)) {
            $dataToUpdate['PASS'] = hash('sha256',$this->passwordLogin);
        }

        if(filled($this->passwordSerahTerima)) {
            $dataToUpdate['PICPASS'] = hash('sha256',$this->passwordSerahTerima);
        }

        UserEsa::whereUser($this->userEsaNik)->update($dataToUpdate);

        $this->dispatch('successUpdateData', title: 'Sukses', text: 'Data berhasil diperbarui', icon: 'success');
    }

    public function confirm($userEsaNik)
    {
        $userEsa = UserEsa::whereUser($userEsaNik)->firstOrFail();

        $this->nik = $userEsa->USER;
        $this->user = $userEsa->NAMA;
        $this->plant = $userEsa->TEMPAT;
        $this->pic = $userEsa->PIC;
        $this->hak = $userEsa->HAK;
        $this->userEsaNik = $userEsa->USER;

        $this->dispatch('openDeleteModal');
    }

    public function destroy()
    {
        UserEsa::whereUser($this->userEsaNik)
        ->update(['FLAG' => '0']);

        $this->dispatch('successDeleteData', title: 'Sukses', text: 'Data berhasil dihapus', icon: 'success');
    }
}
