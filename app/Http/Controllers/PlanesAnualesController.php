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
            ->where('BODEGA',$request->idBodega)
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
            ->where('BODEGA',$request->idBodega)
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

    public function DestroyArticuloServ(Request $request){
        try {
            PlanesAnuales::where('id',$request->id)
            ->delete();
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateArticuloServ(Request $request){
        try {
            PlanesAnuales::where('id',$request->id)
            ->update(['CODART'=>$request->CODART,'NOMART'=>$request->NOMART,'UNIMED'=>$request->UNIMED,
                      'PRECIO'=>$request->PRECIO,'C_ENE'=> $request->C_ENE,'C_FEB'=>$request->C_FEB,
                      'C_MAR'=> $request->C_MAR,'C_ABR'=> $request->C_ABR,'C_MAY'=>$request->C_MAY,
                      'C_JUN'=>$request->C_JUN,'C_JUL'=>$request->C_JUL,'C_AGO'=>$request->C_AGO,
                      'C_SEP'=>$request->C_SEP,'C_OCT'=>$request->C_OCT,'C_NOV'=>$request->C_NOV,
                      'C_DIC'=> $request->C_DIC,'C_TOTAL'=>$request->C_TOTAL,'T_PRECIO'=>$request->T_PRECIO,
                      'idServicio'=> $request->idServicio,'FECING'=>$request->FECING,'NOMSER'=>$request->NOMSER,
                      'BODEGA'=>$request->BODEGA,'OBS'=> $request->OBS,'ANIO'=>$request->ANIO]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
