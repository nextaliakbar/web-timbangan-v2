<?php

namespace App\Http\Controllers;

use App\Models\JoTimbang;
use App\Models\MBarang;
use App\Models\TbTimbang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainAppController extends Controller
{
    public function searchItem(Request $request)
    {
        $searchItem = $request->searchItem;

        $mBarang = MBarang::where('NAMA_BARANG', 'like', '%'.$searchItem.'%')
        ->get(['ID_SUNFISH as id', 'NAMA_BARANG as text']);

        return response()->json($mBarang, 200);
    }

    public function printInvc(Request $request)
    {
        $companyId = Auth::guard('user')->user()->TEMPAT == 'UNIMOS' 
        ? 2 : (Auth::guard('user')->user()->TEMPAT == 'MGFI' ? 7 : 0);

        $dataTimbang = TbTimbang::select('UNIQ_ID', 'WAKTU', 'NAMA_BARANG', 'DARI', 'PCS','BERAT_FILTER')
        ->where('ID', '=', $request->id)
        ->where('PLANT', '=', $companyId)
        ->first();

        $dataJo = JoTimbang::select('NO_JO')
        ->where('UNIQ_ID', '=', $dataTimbang->UNIQ_ID)
        ->get();

        return view('livewire.main.faktur', compact('dataTimbang', 'dataJo'));
    }
}
