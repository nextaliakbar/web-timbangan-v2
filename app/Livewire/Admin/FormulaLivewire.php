<?php

namespace App\Livewire\Admin;

use App\Models\TbTimbangVt;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class FormulaLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $plant, $search, $idTimbang, $noDok,
    $kodeBarang, $namaBarang, $tglPenimbangan,
    $shiftPenimbangan, $beratFilter, $nomorBarcode,
    $qty, $tglProduksi, $shiftProduksi, $keterangan;

    public $paginate = '10';
    
    public function mount($plant)
    {
        $this->plant = $plant == 'mgfi' ? 2 : 7;
    }

    public function render()
    {
        $data = [
            'dataFormula' => TbTimbangVt::selectRaw("
            tb_timbang_vt_temp.ID, NO_LOT, ITEM_CODE, NAMA_BARANG, NO_DOK, BERAT_FILTER,
            BERAT_PER_LOT, BATCH, KET, WAKTU_TIMBANG
            ")
            ->leftJoin('ms_barang', 'tb_timbang_vt_temp.ITEM_CODE', '=', 'ms_barang.id_barang')
            ->whereNotNull('SERAH')
            ->whereNotNull('VERIFIKATOR')
            ->where('PLANT', '=', $this->plant)
            ->where(function($query) {
                $query->where('NO_DOK', 'like', '%'.$this->search.'%')
                ->orWhere('ITEM_CODE', 'like', '%'.$this->search.'%');
            })
            ->orderByDesc('WAKTU_TIMBANG')
            ->paginate($this->paginate)
        ];
        
        return view('livewire.admin.formula.index', $data);
    }

    public function updatedPaginate()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function getData($id)
    {
        $data = TbTimbangVt::selectRaw("
        tb_timbang_vt_temp.ID, NO_LOT, ITEM_CODE, NAMA_BARANG, NO_DOK, BERAT_FILTER,
        BERAT_PER_LOT, BATCH, KET, WAKTU_TIMBANG
        ")
        ->leftJoin('ms_barang', 'tb_timbang_vt_temp.ITEM_CODE', '=', 'ms_barang.id_barang')
        ->where('tb_timbang_vt_temp.ID', '=', $id)
        ->first();

        $this->idTimbang = $data->IDT;
        $this->noDok = $data->NO_DOK;
        $this->kodeBarang = $data->ID_BARANG;
        $this->namaBarang = $data->NAMA_BARANG;
        $this->tglPenimbangan = date('Y-m-d H:i', strtotime($data->WAKTU_TIMBANG));
        $this->shiftPenimbangan = $data->SHIFT_TIMBANG;
        $this->beratFilter = $data->BERAT_FILTER;
        $this->nomorBarcode = $data->NO_LOT;
        $this->qty = number_format($data->BERAT_PER_LOT, 2, ",");
        $this->tglProduksi = date('Y-m-d H:i', strtotime($data->WAKTU_PROD));
        $this->shiftProduksi = $data->SHIFT_PROD;
        $this->keterangan = $data->KET;
    }

    public function edit($id)
    {
        $this->getData($id);

        $this->dispatch('openEditModal');
    }

    public function update()
    {
        $this->validate([
            'tglPenimbangan' => 'required',
            'shiftPenimbangan' => 'required',
            'tglProduksi' => 'required',
            'shiftProduksi' => 'required',
            'nomorBarcode' => 'required',
            'qty' => ['required', 'regex:/^\\d{1,12}(,\\d{1,2})?$/'],
            'keterangan' => 'required'
        ], [
            'nomorBarcode.required' => 'No.barcode tidak boleh kosong',
            'qty.required' => 'Qty tidak boleh kosong',
            'qty.regex' => 'Gunakan tanda koma (,) untuk bilangan desimal',
            'keteranga.required' => 'Keterangan tidak boleh kosong'
        ]);

        $cleanedQty = str_replace('.', '', $this->qty);
        $qty = str_replace(',', '.', $cleanedQty);
        TbTimbangVt::where('ID', '=', $this->idTimbang)
        ->update([
            'WAKTU_TIMBANG' => $this->tglPenimbangan,
            'SHIFT_TIMBANG' => $this->shiftPenimbangan,
            'WAKTU_PROD' => $this->tglProduksi,
            'SHIFT_PROD' => $this->shiftProduksi,
            'NO_LOT' => $this->nomorBarcode,
            'BERAT_PER_LOT' => (float) $qty,
            'KET' => $this->keterangan
        ]);

        $this->dispatch('successUpdateData', title: 'Sukses', text: 'Data berhasil diperbarui', icon: 'success');
    }

    public function confirm($id)
    {
        $this->getData($id);

        $this->dispatch('openDeleteModal');
    }

    public function destroy()
    {
        TbTimbangVt::where('ID', '=', $this->idTimbang)
        ->delete();

        $this->dispatch('successDeleteData', title: 'Sukses', text: 'Data berhasil dihapus', icon: 'success');

    }

    public function exportPdf($noDok)
    {
        $dataHeader = TbTimbangVt::selectRaw("
            distinct NO_DOK,
            date_format(WAKTU_TIMBANG, '%Y-%m-%d') as WAKTU_TIMBANG,
            SHIFT_TIMBANG,
            date_format(WAKTU_PROD, '%Y-%m-%d') as WAKTU_PROD,
            SHIFT_PROD,
            CASE
                WHEN tb_timbang_vt_temp.PLANT = '1' THEN 'UNIMOS'
                ELSE 'MGFI'
            END AS TEMPAT,
            VERIFIKATOR,
            user_esa.NAMA as NAMA_USER
        ")
        ->leftJoin('ms_barang', 'tb_timbang_vt_temp.ITEM_CODE', '=', 'ms_barang.id_barang')
        ->leftJoin('user_esa', 'tb_timbang_vt_temp.VERIFIKATOR', '=', 'user_esa.USER')
        ->where('tb_timbang_vt_temp.NO_DOK', '=', $noDok)
        ->first();

        $dataTables = TbTimbangVt::query()
        ->select(
            'ms_barang.NAMA_BARANG',
            'tb_timbang_vt_temp.BATCH',
            'tb_timbang_vt_temp.NO_LOT',
            'tb_timbang_vt_temp.BERAT_PER_LOT',
            'ue.NAMA as NAMA_PENIMBANG',
            'u.NAMA as NAMA_VERIFIKATOR',
            'tb_timbang_vt_temp.KET'
        )
        ->leftJoin('ms_barang', 'tb_timbang_vt_temp.ITEM_CODE', '=', 'ms_barang.id_barang')
        ->leftJoin('user_esa as ue', 'tb_timbang_vt_temp.SERAH', '=', 'ue.USER')
        ->leftJoin('user_esa as u', 'tb_timbang_vt_temp.VERIFIKATOR', '=', 'u.USER')
        ->where('tb_timbang_vt_temp.NO_DOK', $noDok)
        ->orderBy('ms_barang.NAMA_BARANG', 'ASC')
        ->orderBy('tb_timbang_vt_temp.BATCH', 'asc')
        ->orderBy('tb_timbang_vt_temp.id', 'asc')
        ->get();

        $pdfContent = Pdf::loadView('livewire.admin.formula.report-formula-pdf', [
            'dataHeader' => $dataHeader,
            'dataTables' => $dataTables
        ])
        ->output();
        $fileName = 'Laporan Formula'.'.pdf';
        return response()->streamDownload(fn() => print($pdfContent),$fileName);
    }
}
