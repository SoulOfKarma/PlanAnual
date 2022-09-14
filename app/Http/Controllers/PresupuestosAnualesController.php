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
            ->update(['ANIO' => $request->ANIO,'NOMSER' => $request->NOMSER,
                      'P_ANUAL'=>$request->P_ANUAL]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetPresupuestoByServBodega(Request $request){
        try {
            $get = PresupuestosAnuales::select('presupuestos_anuales.ANIO','presupuestos_anuales.NOMSER','presupuestos_anuales.P_ANUAL',
            DB::raw('ROUND((select SUM(planes_anuales.C_ENE)*planes_anuales.PRECIO + SUM(planes_anuales.C_FEB)*planes_anuales.PRECIO + SUM(planes_anuales.C_MAR)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_ABR)*planes_anuales.PRECIO + SUM(planes_anuales.C_MAY)*planes_anuales.PRECIO + SUM(planes_anuales.C_JUN)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_JUL)*planes_anuales.PRECIO + SUM(planes_anuales.C_AGO)*planes_anuales.PRECIO + SUM(planes_anuales.C_SEP)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_OCT)*planes_anuales.PRECIO + SUM(planes_anuales.C_NOV)*planes_anuales.PRECIO + SUM(planes_anuales.C_DIC)*planes_anuales.PRECIO
            FROM planes_anuales WHERE planes_anuales.idServicio = presupuestos_anuales.NOMSER && planes_anuales.ANIO = year(presupuestos_anuales.ANIO) GROUP BY PRECIO),0) AS UTILIZADO'),
            DB::raw('presupuestos_anuales.P_ANUAL - ROUND((select SUM(planes_anuales.C_ENE)*planes_anuales.PRECIO + SUM(planes_anuales.C_FEB)*planes_anuales.PRECIO + SUM(planes_anuales.C_MAR)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_ABR)*planes_anuales.PRECIO + SUM(planes_anuales.C_MAY)*planes_anuales.PRECIO + SUM(planes_anuales.C_JUN)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_JUL)*planes_anuales.PRECIO + SUM(planes_anuales.C_AGO)*planes_anuales.PRECIO + SUM(planes_anuales.C_SEP)*planes_anuales.PRECIO +
            SUM(planes_anuales.C_OCT)*planes_anuales.PRECIO + SUM(planes_anuales.C_NOV)*planes_anuales.PRECIO + SUM(planes_anuales.C_DIC)*planes_anuales.PRECIO
            FROM planes_anuales WHERE planes_anuales.idServicio = presupuestos_anuales.NOMSER && planes_anuales.ANIO = year(presupuestos_anuales.ANIO) GROUP BY PRECIO),0) AS RESTANTE'))
            ->where('NOMSER',$request->idServicio)
            ->where('ANIO',$request->anio)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
