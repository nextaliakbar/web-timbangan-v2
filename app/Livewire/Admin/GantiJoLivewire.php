<?php

namespace App\Livewire\Admin;

use App\Models\JoTimbang;
use App\Models\StfStatus;
use App\Models\TbTimbang;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GantiJoLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search, $idJo, $uniqId, 
    $idBarang, $namaBrg, $beratFilter, $waktu, 
    $noJoLama, $noJoBaru;

    
    public $paginate = "10";

    public $interval = "2";

    public $jenisEdit = "1";
    public function render()
    {
        $relevantKeys = TbTimbang::select('UNIQ_ID', 'IDX_TB')
            ->where('PLANT', '=', Auth::guard('admin')->user()->TEMPAT == 'UNIMOS' ? 2 : 7)
            ->whereRaw("WAKTU between(date_sub(now(), interval ? month)) and now()", [$this->interval])
            ->get();

        $uniqIds = $relevantKeys->pluck('UNIQ_ID')->unique()->toArray();
        $idxTbs = $relevantKeys->pluck('IDX_TB')->unique()->toArray();

        $dataJo = JoTimbang::query()
        ->from('jo_timbang_temp as jo')
        ->selectRaw("
            jo.Id,
            tb_timbang.WAKTU,
            tb_timbang.ID_BARANG,
            tb_timbang.NAMA_BARANG,
            tb_timbang.BERAT_FILTER,
            tb_timbang.UNIQ_ID,
            jo.NO_JO
        ")
        ->leftJoin('tb_timbang_temp as tb_timbang', function($join) {
            $join->on('jo.UNIQ_ID', '=', 'tb_timbang.UNIQ_ID')
                ->on('jo.IDX_TB', '=', 'tb_timbang.IDX_TB');
        })
        ->whereIn('jo.UNIQ_ID', $uniqIds)
        ->whereIn('jo.IDX_TB', $idxTbs)
        ->where('jo.NO_JO', 'not like', 'MGF%')
        ->where('jo.NO_JO', 'not like', 'UMS%')
        ->where(function($query) {
            $query->where('tb_timbang.ID_BARANG', 'like', '%'.$this->search.'%')
            ->orWhere('tb_timbang.NAMA_BARANG', 'like', '%'.$this->search.'%')
            ->orWhere('jo.UNIQ_ID', 'like', '%'.$this->search.'%')
            ->orWhere('jo.NO_JO', 'like', '%'.$this->search.'%');
        })
        ->orderByDesc('WAKTU')
        ->get();


        // Hapus duplikat berdasarkan kombinasi kolom dan simpan data sebagai uniqe berdasarkan  kunci yang ditentukan
        $uniqueDataJo = $dataJo->unique(function($item) {
            return $item->WAKTU . $item->ID_BARANG . $item->NAMA_BARANG . $item->BERAT . $item->UNIQ_ID . $item->NO_JO;
        });

        // Buat collection dari data yang sudah dibersihkan
        $perPage = $this->paginate;
        $currentPage = Paginator::resolveCurrentPage('page');

        // Potong collection sesuai halaman saat ini
        $currentPageItems = $uniqueDataJo->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Buat instance paginator baru
        $paginatedData = new LengthAwarePaginator($currentPageItems, $uniqueDataJo->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        return view('livewire.admin.ganti-jo.index', ['dataJo' => $paginatedData]);
    }

    public function updatedInterval()
    {
        $this->resetPage();
    }
    
    public function updatedPaginate()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $joTimbang = JoTimbang::query()
        ->from('jo_timbang_temp as jo')
        ->selectRaw("
        jo.Id,
        tb_timbang.WAKTU,
        tb_timbang.ID_BARANG,
        tb_timbang.NAMA_BARANG,
        tb_timbang.BERAT_FILTER,
        tb_timbang.UNIQ_ID,
        jo.NO_JO
        ")
        ->leftJoin("tb_timbang_temp as tb_timbang", function($join) {
            $join->on("jo.UNIQ_ID", '=', 'tb_timbang.UNIQ_ID')
            ->on('jo.IDX_TB', '=', 'tb_timbang.IDX_TB');
        })
        ->where('jo.ID', '=', $id)
        ->first();
        
        $this->idJo = $joTimbang->Id;
        $this->waktu = date('Y-m-d H:i', strtotime($joTimbang->WAKTU));
        $this->idBarang = $joTimbang->ID_BARANG;
        $this->namaBrg = $joTimbang->NAMA_BARANG;
        $this->beratFilter = $joTimbang->BERAT_FILTER;
        $this->uniqId = $joTimbang->UNIQ_ID;
        $this->noJoLama = $joTimbang->NO_JO;

        $this->dispatch('openEditModal');
    }

    private function update()
    {
        $count = StfStatus::where('NO_JO', '=', $this->noJoBaru)
        ->where('STATUS', '=', '1')
        ->count();

        if($count > 1) {
            $this->dispatch('updateData', title: 'Perbarui No JO', text: 'No JO sudah di STFkan', icon: 'error');
            return;
        }

        JoTimbang::when(intval($this->jenisEdit) == 1, function($query) {
            $query->where('ID_BARANG', '=', $this->idBarang);

        })
        ->when(intval($this->jenisEdit) == 2, function($query) {
            $query->where('ID', '=', $this->idJo);
        })
        ->where('UNIQ_ID', '=', $this->uniqId)
        ->where('NO_JO', '=', $this->noJoLama)
        ->update([
            'NO_JO' => $this->noJoBaru ?? '-',
            'NIK_GANTI_JO' => Auth::guard('admin')->user()->USER,
            'FLAG' => '1',
            'TGL_GANTI_NO_JO' => Carbon::now()
        ]);
        $this->reset([
            'waktu', 'idBarang', 'namaBrg',
            'beratFilter', 'uniqId',
            'noJoLama', 'noJoBaru'
        ]);            
        $this->dispatch('updateData', title:'Perbarui No JO', text: 'No JO berhasil diperbarui', icon: 'success');
    }

    public function mainUpdate()
    {
        if(filled($this->noJoBaru)) {
            $this->update();
        } else {
            $this->dispatch('confirmUpdate');
        }
    }

    public function forceUpdate()
    {
        $this->update();
    }
}
