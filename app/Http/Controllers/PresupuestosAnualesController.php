<?php

namespace App\Http\Controllers;

use App\PresupuestosAnuales;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class PresupuestosAnualesController extends Controller
{
    public function GetPresupuestosGenerales(){
        try {
            $data = PresupuestosAnuales::all();
            return $data;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostPresupuestoAnual(Request $request){
        try {
            PresupuestosAnuales::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutPresupuestoAnual(Request $request){
        try {
            PresupuestosAnuales::where('id',$request->id)
            ->update(['ANIO' => $request->ANIO,'NOMSER' => $request->NOMSER,'BODEGA' => $request->BODEGA,
                      'P_ANUAL'=>$request->P_ANUAL,'P_ENE'=>$request->P_ENE,'P_FEB'=>$request->P_FEB,
                      'P_MAR'=>$request->P_MAR,'P_ABR'=>$request->P_ABR,'P_MAY'=>$request->P_MAY,
                      'P_JUN'=>$request->P_JUN,'P_JUL'=>$request->P_JUL,'P_AGO'=>$request->P_AGO,
                      'P_SEP'=>$request->P_SEP,'P_OCT'=>$request->P_OCT,'P_NOV'=>$request->P_NOV,
                      'P_DIC'=>$request->P_DIC]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetPresupuestoByServBodega(Request $request){
        try {
            $get = PresupuestosAnuales::where('NOMSER',$request->idServicio)
            ->where('BODEGA',$request->idBodega)
            ->where('ANIO',$request->anio)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
