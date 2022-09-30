<?php

namespace App\Http\Controllers;

use App\siabArticulos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class SiabArticulosController extends Controller
{
    public function GetArticulos(){
        try {
            $data = siabArticulos::select('CODART','NOMBRE','UNIMED','PRECIO','idEstado','idBodega')
            ->distinct()
            ->get();
            return $data;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetArticulosActivos(){
        try {
            $data = siabArticulos::select('CODART','NOMBRE','UNIMED','PRECIO','idEstado','idBodega')
            ->distinct()
            ->where('idEstado',1)
            ->get();
            return $data;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostArticulos(Request $request){
        try {
            $data = siabArticulos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    
    public function PutArticulos(Request $request){
        try {
            $data = siabArticulos::where('id', $request->id)
            ->update(['CODART' => $request->CODART,'NOMBRE' => $request->NOMBRE,'UNIMED' => $request->UNIMED,
            'PRECIO' => $request->PRECIO,'idEstado' => $request->idEstado]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
