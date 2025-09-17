<?php

namespace App\Livewire\Admin;

use App\Models\TbTimbang;
use Livewire\Component;
use Livewire\WithPagination;

class SerahTerimaLivewire extends Component
{
    use WithPagination;

    public $plant, $paginate, $search, 
    $uniqId, $picSerah, $picTerima;

    protected $paginationTheme = 'bootstrap';

    public function mount($plant)
    {
        $this->plant = $plant == 'mgfi' ? 2 : 7;   
    }

    public function render()
    {
        $data = [
            'dataSerahTerima' => TbTimbang::select('UNIQ_ID', 'WAKTU', 'NAMA_USER', 'PIC_SERAH', 'PIC_TERIMA', 'PLANT')
            ->where(function ($query) {
                $query->whereNull('PIC_SERAH')
                ->orWhereNull('PIC_TERIMA')
                ->orWhere('PIC_SERAH', '=', '')
                ->orWhere('PIC_TERIMA', '=', '');
            })
            ->where(function($query) {
                $query->where('UNIQ_ID', 'like', '%'.$this->search.'%')
                ->orWhere('NAMA_USER', 'like', '%'.$this->search.'%');
            })
            ->where('PLANT', '=', $this->plant)
            ->groupBy('UNIQ_ID', 'WAKTU', 'NAMA_USER', 'PIC_SERAH', 'PIC_TERIMA', 'PLANT')
            ->paginate($this->paginate ?? 10)
        ];

        return view('livewire.admin.serah-terima.index', $data);
    }

    public function updatedPaginate()
    {
        $this->resetPage();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($uniqId)
    {
        $tbTimbang = TbTimbang::where('UNIQ_ID', '=', $uniqId)->first();

        $this->uniqId = $tbTimbang->UNIQ_ID;
        $this->picSerah = $tbTimbang->PIC_SERAH;
        $this->picTerima = $tbTimbang->PIC_TERIMA;

        $this->dispatch('openEditModal');
    }

    public function rules()
    {
        return [
            'picSerah' => 'required',
            'picTerima' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'picSerah.required' => 'PIC serah tidak boleh kosong',
            'picTerima.required' => 'PIC terima tidak boleh kosong'
        ];
    }

    public function update()
    {
        TbTimbang::where('UNIQ_ID', '=', $this->uniqId)->update([
            'PIC_SERAH' => $this->picSerah,
            'PIC_TERIMA' => $this->picTerima
        ]);
        
        $this->dispatch('successUpdateData', title: 'Sukses', text: 'Data berhasil diperbarui', icon: 'success');
    }
}
