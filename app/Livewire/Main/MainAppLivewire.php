<?php

namespace App\Livewire\Main;

use App\Models\Bstb;
use App\Models\DariKe;
use App\Models\JoTimbang;
use App\Models\MBarang;
use App\Models\TbTimbang;
use App\Models\TbWarehouseSf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;

class MainAppLivewire extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $companyId;

    public $userSerah, $userTerima;

    public $dgJo, $dariKe, $noBstb, 
    $shiftTimbang, $shiftProduksi,
    $tglProduksi, $idSunfish, $berat,
    $keterangan, $qty, $pcs;
    public $dataNoJo = [];
    public $cetakFaktur;

    private function getDataNoJo()
    {
        $cmpKode = $this->userSerah->TEMPAT == 'UNIMOS' 
                    ? 'UMS' : ($this->userSerah->TEMPAT == 'MGFI' ? 'MGFI' : '');

        $tglProduksi = Carbon::parse($this->tglProduksi)->format('dmY');

        return DB::select("
        select * from (select NO_JO from job_order_temp 
        where FLAG='1' and SHIFT=? and COMPANY_ID=? and JO_DATE=? 
        union select concat(?,?,?,line) from mesin_temp where company=?)
        as tabel_jo ", [
            $this->shiftProduksi,
            $this->companyId,
            $this->tglProduksi,
            "'$cmpKode-'",
            "$tglProduksi",
            "-'$this->shiftProduksi'-",
            $this->companyId
        ]);
    }

    private function init()
    {
        if(Auth::guard('user')->user()->PIC == 'PIC_SERAH' && session()->get('user-pic')->PIC == 'PIC_TERIMA') {
            $userSerah = Auth::guard('user')->user();
            $userTerima = session()->get('user-pic');
        } else if(Auth::guard('user')->user()->PIC == 'PIC_TERIMA' && session()->get('user-pic')->PIC == 'PIC_SERAH') {
            $userSerah = session()->get('user-pic');
            $userTerima = Auth::guard('user');
        }
        $this->userSerah = $userSerah;
        $this->userTerima = $userTerima;
        $this->companyId = $this->userSerah->TEMPAT == 'UNIMOS' 
        ? 2 : ($this->userSerah->TEMPAT == 'MGFI' ? 7 : 0);
        $this->shiftTimbang = 1;
        $this->shiftProduksi = 1;
        $this->tglProduksi = Carbon::now()->format('Y-m-d');

        $this->dataNoJo = $this->getDataNoJo();
        $this->cetakFaktur = false;
    }

    public function mount()
    {
        $this->init();   
    }
    public function render()
    {
        $formattedCodes = array_map(function($code) {
            return "($code)";
        }, $this->userSerah->TUJUAN);

        $data = [
            'dataDariKe' => DariKe::select('DARI_KE', 'KODE')
            ->whereIn('KODE', $formattedCodes)
            ->where('PLANT', '=', $this->companyId)
            ->get(),
            'dataTimbang' => TbTimbang::select(
                'ID', 'UNIQ_ID','ID_BARANG', 'NAMA_BARANG',
                'BERAT_FILTER','IDX_TB')
            ->where('PLANT', '=', $this->companyId)
            ->whereDate('WAKTU', '=', Carbon::now()->toDateString())
            ->orderByDesc('WAKTU')
            ->paginate(7)
        ];

        return view('livewire.main.index', $data);
    }

    private function convertMonth($char)
    {
        $mapping = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII'
        ];

        $result = '';

        foreach($mapping as $key => $data) {
            if($char == $key) {
                $result = $data;
                break;
            }
        }

        return $result;
    }

    public function updatedDariKe($value)
    {
        $bstb = Bstb::select('NO')
        ->where('DARIKE', '=', $value)
        ->where('PLANT', '=', $this->companyId)
        ->first();
                
        $year = Carbon::now()->format('y');

        $uniqId = strval(rand(10000, 99999));

        if($value) {
            $noBstb = "{$this->userSerah->TEMPAT}/1/{$bstb->NO}/{$value}/{$this->convertMonth(Carbon::now()->format('m'))}/{$year}/{$uniqId}";
            $cekNoBstb = TbTimbang::select('UNIQ_ID')
            ->distinct()
            ->where('UNIQ_ID', '=', $noBstb)
            ->get();

            if($cekNoBstb && empty($cekNoBstb[0])) {
                $this->noBstb = $noBstb;
            } else {
                $this->noBstb = null;
            }
        } else {
            $this->noBstb = null;
        }
        


        $this->dgJo = DariKe::where('KODE', '=', "($value)")
        ->value('DG_JO');
    }

    public function updatedShiftProduksi()
    {
        $dataNoJo = $this->getDataNoJo();
        $this->dispatch('loadDataNoJo', data: $dataNoJo);
    }

    private function saveData()
    {
        $dataTimbang = null;

        DB::transaction(function() use(&$dataTimbang){
            $dateTime = Carbon::now();
            if($this->shiftTimbang > 1) {
                if(Carbon::now()->between(Carbon::now()->startOfDay(), Carbon::now()->startOfDay()->addHours(9))) {
                    $dateTime = $dateTime->subDay();
                }
            }
            
            $dariKe =  DariKe::where('KODE', '=', "({$this->dariKe})")
            ->where('PLANT', '=', $this->companyId)
            ->first();
            
            $mBarang = MBarang::where('ID_SUNFISH', '=', $this->idSunfish)
            ->first();
    
            $max = TbTimbang::where('UNIQ_ID', '=', $this->noBstb)
            ->where('PLANT', '=', $this->companyId)
            ->max('IDX_TB');
    
            $warehouseSerahId= TbWarehouseSf::where('WAREHOUSE_NAME', '=', $dariKe->DARI)
            ->value('WAREHOUSE_ID_SF');
    
            $warehouseTerimaId = TbWarehouseSf::where('WAREHOUSE_NAME', '=', $dariKe->KE)
            ->value('WAREHOUSE_ID_SF');

            $dataTimbang = TbTimbang::create([
                'WAKTU' => $dateTime,
                'DARI' => $dariKe->DARI_KE,
                'UNIQ_ID' => $this->noBstb,
                'ID_BARANG' => $this->idSunfish,
                'KATEGORI' => $mBarang->KATEGORI,
                'NAMA_BARANG' => $mBarang->NAMA_BARANG,
                'NAMA_USER' => $this->userSerah->USER,
                'SHIFT' => $this->shiftTimbang,
                'PIC_SERAH' => $this->userSerah->USER,
                'PIC_TERIMA' => $this->userTerima->USER,
                'QTY' => $this->qty,
                'BERAT' => $this->berat,
                'BERAT_FILTER' => "{$this->berat} KG",
                'ID_PRINT' => str_replace('-', '', Uuid::uuid4()->toString()),
                'SATUAN' => $mBarang->SATUAN,
                'PCS' => $this->pcs,
                'TGL_PRODUKSI' => $this->tglProduksi,
                'SHIFT_PRODUKSI' => $this->shiftProduksi,
                'KETERANGAN' => $this->keterangan,
                'IDX_TB' => empty($max) ? '1' : strval($max + 1),
                'ASAL' => $warehouseSerahId,
                'TUJUAN' => $warehouseTerimaId,
                'PLANT' => $this->companyId
            ]);
    
            if(empty($this->dataNoJo)) {
                JoTimbang::create([
                    'NO_JO' => '-',
                    'UNIQ_ID' => $this->noBstb,
                    'ID_BARANG' => $this->idSunfish,
                    'BERAT_TOTAL' => "{$this->berat} KG",
                    'BERAT_PER_JO' => strval($this->berat),
                    'IDX_TB' => empty($max) ? '1' : strval($max + 1)
                ]);
            } else {
                foreach($this->dataNoJo as $data) {
                    JoTimbang::create([
                        'NO_JO' => $data,
                        'UNIQ_ID' => $this->noBstb,
                        'ID_BARANG' => $this->idSunfish,
                        'BERAT_TOTAL' => "{$this->berat} KG",
                        'BERAT_PER_JO' => strval($this->berat / count($this->dataNoJo)),
                        'IDX_TB' => empty($max) ? '1' : strval($max + 1)
                    ]);
                }
    
                JoTimbang::where('UNIQ_ID', '=', $this->noBstb)
                ->update([
                    'NO_JO' => DB::raw("REPLACE(REPLACE(NO_JO, CHAR(13), ''), CHAR(10), '')")
                ]);
            }
        });


        $this->dispatch('successSaveData', title: 'Sukses', text: 'Proses timbang berhasil disimpan', icon: 'success');
        
        if($this->cetakFaktur) {
            $url = route('main-app.print-invc', ['id' => $dataTimbang?->ID]);

            $this->dispatch('printInvc', url: $url);
        }

        $this->resetValidation();
        

        $this->reset([
            'dgJo', 'dariKe', 'noBstb',
            'shiftTimbang', 'shiftProduksi',
            'tglProduksi', 'idSunfish', 'berat',
            'keterangan', 'qty', 'pcs',
            'dataNoJo'
        ]);

        $this->init();

        $this->dispatch('resetItems');
    }

    public function rules()
    {
        return [
            'noBstb' => 'required',
            'shiftTimbang' => 'required',
            'tglProduksi' => 'required',
            'shiftProduksi' => 'required',
            'idSunfish' => 'required',
            'berat' => 'required',
            'keterangan' => 'required',
            'pcs' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'noBstb.required' => 'No.BSTB tidak boleh kosong',
            'shiftTimbang.required' => 'Shift timbang tidak boleh kosong',
            'tglProduksi.required' => 'Tanggal produksi tidak boleh kosong',
            'shiftProduksi.required' => 'Shift produksi tidak boleh kosong',
            'idSunfish.required' => 'Tidak ada barang yang dipilih',
            'berat.required' => 'Berat tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'pcs.required' => 'Pcs tidak boleh kosong'
        ];
    }

    public function store()
    {

        try {
            $this->validate();
        } catch(ValidationException $ex) {
            $errorMessage = collect($ex->errors())->flatten()->first();
            $this->dispatch('validationError', title: 'Gagal', text: $errorMessage, icon: 'error');
            throw $ex;
        }

        if(empty($this->dgJo)) {
            $this->saveData();
        } else {
            if(empty($this->dataNoJo)) {
                $this->dispatch('confirmSave');
            } else {
                $this->saveData();
            }
        }        
    }

    #[On('forceStore')]
    public function forceStore()
    {
        $this->saveData();
    }

    public function confirm($data)
    {
        $this->dispatch('confirmDestroy', data: $data);
    }

    #[On('destroy')]
    public function destroy($data)
    {
        DB::transaction(function() use($data) {
            JoTimbang::where('UNIQ_ID', '=', $data['UNIQ_ID'])
            ->where('IDX_TB', '=', $data['IDX_TB'])
            ->delete();

            TbTimbang::where('ID', '=', $data['ID'])
            ->where('PLANT', '=', $this->companyId)
            ->delete();
        });
        $this->dispatch('successDeleteData', title: 'Sukses', text: 'Data barang berhasil dihapus', icon: 'success');
    }

    public function printInvc($id)
    {
        $url = route('main-app.print-invc', ['id' => $id]);

        $this->dispatch('printInvc', url: $url);
    }
}
