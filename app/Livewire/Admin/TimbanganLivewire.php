<?php

namespace App\Livewire\Admin;

use App\Models\DariKe;
use App\Models\JoTimbang;
use App\Models\TbTimbang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TimbanganLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $plant, $search, $paginate,
    $interval, $dariKe, $id, $uniqId, $idBarang, 
    $namaBarang, $beratFilter, $kategori,
    $qty, $dari, $pcs, $shift, $tglProduksi, 
    $shiftProduksi, $tglTimbang;

    public function mount($plant)
    {
        $this->plant = $plant == 'unimos' ? 2 : 7;
        $this->interval = 3;
    }

    public function render()
    {
        $data = [
            'dataDariKe' => DariKe::where('PLANT', '=', $this->plant)
            ->get(),
            'dataTimbang' => TbTimbang::where(function($query) {
                $query->where('UNIQ_ID', 'like', '%'.$this->search.'%')
                    ->orWhere('NAMA_BARANG', 'like', '%'.$this->search.'%')
                    ->orWhere('ID_BARANG', 'like', '%'.$this->search.'%');
            })
            ->where('PLANT', '=', $this->plant)
            ->when($this->dariKe, function($query) {
                $query->where('UNIQ_ID', 'like', '%'.$this->dariKe.'%');
            })
            ->whereRaw('WAKTU > SUBDATE(now(), INTERVAL ? month)', [$this->interval ?? 3])
            ->orderByDesc('ID_BARANG')
            ->paginate($this->paginate ?? 10),
        ];

        return view('livewire.admin.timbangan.index', $data);
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
        $data = TbTimbang::where('ID', '=', $id)->first();
        
        $this->id = $data->ID;
        $this->uniqId = $data->UNIQ_ID;
        $this->idBarang = $data->ID_BARANG;
        $this->namaBarang = $data->NAMA_BARANG;
        $this->beratFilter = $data->BERAT_FILTER;
        $this->kategori = $data->KATEGORI;
        $this->qty = $data->QTY;
        $this->dari = $data->DARI;
        $this->pcs = $data->PCS;
        $this->shift = $data->SHIFT;
        $this->tglProduksi = date('Y-m-d H:i', strtotime($data->TGL_PRODUKSI));
        $this->shiftProduksi = $data->SHIFT_PRODUKSI;
        $this->tglTimbang = date('Y-m-d H:i', strtotime($data->WAKTU));
    
        $this->dispatch('openEditModal');
    }

    public function update()
    {
        $sql = "UPDATE tb_timbang_temp t
        LEFT JOIN jo_timbang_temp j on t.UNIQ_ID=j.UNIQ_ID and t.IDX_TB=j.IDX_TB
        SET 
        t.ID_BARANG = ?, 
        t.QTY = ?,
        t.NAMA_BARANG = ?, 
        t.KATEGORI = ?, 
        t.PCS = ?,
        t.TGL_PRODUKSI = ?, 
        t.SHIFT_PRODUKSI = ?,
        j.ID_BARANG = ?,
        j.FLAG='1'
        WHERE t.ID = ?";

        DB::update($sql, [
            $this->idBarang,
            $this->qty,
            $this->namaBarang,
            $this->kategori,
            $this->pcs,
            $this->tglProduksi,
            $this->shiftProduksi,
            $this->idBarang,
            $this->id
        ]);

        $this->dispatch('successUpdateData', title: 'Sukses', text: 'Data berhasil diperbarui', icon: 'success');
    }

    public function confirm($id)
    {
        $data = TbTimbang::where('ID', '=', $id)->first();

        $this->uniqId = $data->UNIQ_ID;
        $this->idBarang = $data->ID_BARANG;
        $this->namaBarang = $data->NAMA_BARANG;
        $this->beratFilter = $data->BERAT_FILTER;
        $this->qty = $data->QTY;
        $this->pcs = $data->PCS;

        $this->dispatch('openDeleteModal');
    }

    public function destroy()
    {
        TbTimbang::where('UNIQ_ID', '=', $this->uniqId)->delete();

        JoTimbang::where('UNIQ_ID', '=', $this->uniqId)->delete();

        $this->dispatch('successDeleteData', title: 'Sukses', text: 'Data berhasil dihapus', icon: 'success');
    }

     public function exportPdf1($id)
    {
        $plant = $this->plant == 2 ? 'UNIMOS' : 'MGFI';

        $pdfContent = Pdf::loadView('livewire.admin.timbangan.report-timbangan-pdf-1')
        ->output();
        $fileName = 'Laporan Timbangan Plant ' . strtoupper($plant . '.pdf');
        return response()->streamDownload(fn() => print($pdfContent),$fileName);   
    }

    public function exportPdf2($id)
    {
        $data = TbTimbang::where('ID', '=', $id)->first();

        $plant = $this->plant == 2 ? 'UNIMOS' : 'MGFI';

        $pdfContent = Pdf::loadView('livewire.admin.timbangan.report-timbangan-pdf-2', [
            'plant' => $plant,
            'bstbNumber' => $data->UNIQ_ID,
            'date' => Carbon::now()->format('Y-m-d H:i'),
            'itemName' => $data->NAMA_BARANG,
            'updateDate' => date('Y-m-d H:i', strtotime($data->WAKTU)),
            'dimension' => $data->BERAT_FILTER . ' x ' . $data->QTY
        ])
        ->output();
        $fileName = 'Informasi Barang Plant ' . strtoupper($plant . '.pdf');
        return response()->streamDownload(fn() => print($pdfContent),$fileName);
    }
}
