<?php

namespace App\Http\Controllers;

use App\siabArticulos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use \NumberFormatter;

class SiabArticulosController extends Controller
{
    public function GetArticulos(){
        try {
            $data = siabArticulos::select('id','CODART','NOMBRE','UNIMED','PRECIO','PRE_PROM','idEstado','idBodega')
            ->distinct()
            ->get();

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            $get = [];

            foreach ($data as $key=>$a) {
                $get[$key] = ['id' => $a->id,'CODART' => $a->CODART,'NOMBRE' => $a->NOMBRE,'UNIMED' => $a->UNIMED,
                'PRE_PROM' => $fmt->formatCurrency($a->PRE_PROM, "CLP"),'PRE_PROM2' => $a->PRE_PROM,
                'idEstado' => $a->idEstado,'idBodega' => $a->idBodega];
            }

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function ValidarArticulo(Request $request){
        try {
            $data = siabArticulos::where('CODART',$request->CODART)
            ->limit(1)
            ->get();

            $dato = count($data);

            if($dato > 0){
                return 1;
            }else{
                return 2;
            }
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetArticulosActivos(){
        try {
            $data = siabArticulos::select('CODART','NOMBRE','UNIMED',DB::raw('PRE_PROM as PRECIO'),'idEstado','idBodega')
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
            log::info($request);
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
            'PRECIO' => $request->PRECIO,'PRE_PROM' => $request->PRE_PROM,'idEstado' => $request->idEstado,'idBodega' => $request->idBodega]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function EliminarArticulo(Request $request){
        try {
            $data = siabArticulos::where('id', $request->id)
            ->delete();
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
