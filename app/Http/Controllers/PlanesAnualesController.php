<?php

namespace App\Http\Controllers;

use App\PlanesAnuales;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class PlanesAnualesController extends Controller
{
    public function GetArticulosServ(Request $request){
        try {
            $dato = PlanesAnuales::where('idServicio',$request->idServicio)
            ->where('BODEGA',$request->bodega)
            ->where('ANIO',$request->anio)
            ->get();
            return $dato;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetTotalArticulosServ(Request $request){
        try {
            $dato = PlanesAnuales::select(DB::raw('SUM(C_ENE)*PRECIO AS ENERO'),DB::raw('SUM(C_FEB)*PRECIO AS FEBRERO'),
            DB::raw('SUM(C_MAR)*PRECIO AS MARZO'),DB::raw('SUM(C_ABR)*PRECIO AS ABRIL'),DB::raw('SUM(C_MAY)*PRECIO AS MAYO'),
            DB::raw('SUM(C_JUN)*PRECIO AS JUNIO'),DB::raw('SUM(C_JUL)*PRECIO AS JULIO'),DB::raw('SUM(C_AGO)*PRECIO AS AGOSTO'),
            DB::raw('SUM(C_SEP)*PRECIO AS SEPTIEMBRE'),DB::raw('SUM(C_OCT)*PRECIO AS OCTUBRE'),DB::raw('SUM(C_NOV)*PRECIO AS NOVIEMBRE'),
            DB::raw('SUM(C_DIC)*PRECIO AS DICIEMBRE'),DB::raw('SUM(C_ENE)*PRECIO + SUM(C_FEB)*PRECIO + SUM(C_MAR)*PRECIO + SUM(C_ABR)*PRECIO + SUM(C_MAY)*PRECIO + SUM(C_JUN)*PRECIO + SUM(C_JUL)*PRECIO + SUM(C_AGO)*PRECIO +
            SUM(C_SEP)*PRECIO + SUM(C_OCT)*PRECIO + SUM(C_NOV)*PRECIO + SUM(C_DIC)*PRECIO AS TOTAL'))
            ->where('idServicio',$request->idServicio)
            ->where('BODEGA',$request->bodega)
            ->where('ANIO',$request->anio)
            ->groupby('PRECIO')
            ->get();
            return $dato;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostArticuloServ(Request $request){
        try {
            PlanesAnuales::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
