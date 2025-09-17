<?php

namespace App\Livewire\Admin;

use App\Models\DariKe;
use App\Models\PushDaftarBarang;
use App\Models\TbTimbang;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class KartuStokLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = "10";

    public $plant, $search, $tglMulai,
    $tglBerakhir, $dariKe, $kategori, 
    $subKategori, $shifts, 
    $dataSubKategori;

    public function mount($plant)
    {
        $this->plant = $plant;
        $this->shifts = [];
        $this->tglMulai = Carbon::now()->toDateString();
        $this->tglBerakhir = Carbon::now()->toDateString();
        $this->shifts[0] = '1';
        $this->dataSubKategori = $this->subKategoriList();
    }

    public function render()
    {
        $subKalimat = substr($this->dariKe, -3);
        if($this->plant == 'mgfi') {
            if($subKalimat == 'NDM') {
                $this->dariKe = $this->dariKe .','.str_replace('NDM', 'GENERAL AFFAIR', $this->dariKe);
            }
        }
        
        if($this->plant == 'unimos') {
            if($subKalimat == 'NDM') {
                $this->dariKe = $this->dariKe .','.str_replace('NDM', 'GA', $this->dariKe);
            }
        }

        if(($this->dariKe && $this->kategori) || ($this->dariKe && empty($this->kategori))) {
            $dataKartuStok = TbTimbang::query()
            ->from('tb_timbang_temp as tb_timbang')
            ->selectRaw("
                COUNT(tb_timbang.ID_BARANG) AS JMLH, 
                SUM(tb_timbang.berat_filter * tb_timbang.qty) AS BF, 
                SUM(COALESCE(NULLIF(tb_timbang.PCS, ''), '0')) AS JPCS, 
                tb_timbang.TGL_PRODUKSI, 
                tb_timbang.ID_BARANG,
                tb_timbang.NAMA_BARANG,
                push_daftar_brg.ID_SUNFISH,
                tb_timbang.UNIQ_ID,
                tb_timbang.SHIFT_PRODUKSI,
                tb_timbang.SHIFT,
                MAX(DATE(tb_timbang.WAKTU)) AS WKT")
            ->leftJoin('push_daftar_barang_temp as push_daftar_brg', 'tb_timbang.ID_BARANG', '=', 'push_daftar_brg.ID_SUNFISH')
            ->when($this->shifts, function($query) {
                $query->whereIn('tb_timbang.SHIFT_PRODUKSI',  $this->shifts);
            })
            ->whereRaw('DATE(tb_timbang.TGL_PRODUKSI) BETWEEN ? AND ?', [$this->tglMulai, $this->tglBerakhir])
            ->when($this->dariKe, function($query) {
                $query->whereIn('tb_timbang.DARI' , explode(',', $this->dariKe));
            })
            ->when($this->subKategori, function($query) {
                $query->where('tb_timbang.KATEGORI', '=', $this->subKategori);
            })
            ->where('PLANT', '=', $this->plant == 'mgfi' ? 2 : 7)
            ->where(function($query) {
                $query->where('tb_timbang.NAMA_BARANG', 'like', '%'.$this->search.'%')
                ->orWhere('push_daftar_brg.ID_SUNFISH', 'like', '%'.$this->search.'%');
            })
            ->groupBy('tb_timbang.TGL_PRODUKSI', 'tb_timbang.ID_BARANG', 'tb_timbang.NAMA_BARANG', 'tb_timbang.UNIQ_ID', 'tb_timbang.SHIFT_PRODUKSI', 'tb_timbang.SHIFT')
            ->orderBy('tb_timbang.UNIQ_ID', 'ASC')
            ->paginate($this->paginate);
        } else {
            $dataKartuStok = TbTimbang::query()
            ->from('tb_timbang_temp as tb_timbang')
            ->selectRaw("*, (BERAT_FILTER * QTY) as BF,
                COALESCE(NULLIF(tb_timbang.PCS, ''), '0') as JUDUL")
            ->leftJoin('push_daftar_barang_temp as push_daftar_brg', 'tb_timbang.ID_BARANG', '=', 'push_daftar_brg.ID_SUNFISH')
            ->when($this->shifts, function($query) {
                $query->whereIn('tb_timbang.SHIFT_PRODUKSI', $this->shifts);
            })
            ->whereRaw('DATE(tb_timbang.TGL_PRODUKSI) BETWEEN ? AND ?', [$this->tglMulai, $this->tglBerakhir])
            ->when($this->subKategori, function($query) {
                $query->where('tb_timbang.KATEGORI', '=', $this->subKategori);
            })
            ->where('PLANT', '=', $this->plant == 'mgfi' ? 2 : 7)
            ->paginate($this->paginate);
        }

        $data = [
            'dataKategori' => PushDaftarBarang::selectRaw('distinct (itemCategoryType)')
            ->where('STATUS', '=', 1)
            ->get(),
            'dataDariKe' => DariKe::where('PLANT', '=', $this->plant == 'mgfi' ? 2 : 7)
            ->get(),
            'dataKartuStok' => $dataKartuStok
        ];

        return view('livewire.admin.kartu-stok.index', $data);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPaginate()
    {
        $this->resetPage();
    }

    #[On('filter')]
    public function filter($data)
    {
        $this->tglMulai = $data['startDate'];
        $this->tglBerakhir = $data['endDate'];
        $this->subKategori = $data['subKategori'];
        $this->resetPage();
    }

    public function subKategoriList()
    {
        return PushDaftarBarang::selectRaw('distinct (KATEGORI)')
        ->where('itemCategoryType', '=', $this->kategori)
        ->where('STATUS', '=', 1)
        ->get();
    }

    public function updatedKategori()
    {
        $this->dispatch('updateSubKategoriOptions', data: $this->subKategoriList());
        $this->skipRender();
    }
}
