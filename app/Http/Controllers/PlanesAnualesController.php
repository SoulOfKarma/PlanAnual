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

    public function ReporteDSM(Request $request){
        try {
            $getall = [];
            $getDespachos = [];
            $get = [];
            if($request->mes == 1){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ENE,0) as C_ENE'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_ENE' => $a->C_ENE,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_ENE' => $a->C_ENE,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 2){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_FEB,0) as C_FEB'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_FEB' => $a->C_FEB,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_FEB' => $a->C_FEB,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 3){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAR,0) as C_MAR'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_MAR' => $a->C_MAR,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_MAR' => $a->C_MAR,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 4){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ABR,0) as C_ABR'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_ABR' => $a->C_ABR,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_ABR' => $a->C_ABR,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 5){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAY,0) as C_MAY'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_MAY' => $a->C_MAY,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_MAY' => $a->C_MAY,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 6){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUN,0) as C_JUN'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_JUN' => $a->C_JUN,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_JUN' => $a->C_JUN,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 7){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUL,0) as C_JUL'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'),DB::raw('MONTH(FECDES) as MES'))
                ->where('idServicio',$request->idServicio)
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                log::info($getDespachos);

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_JUL' => $a->C_JUL,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_JUL' => $a->C_JUL,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 8){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_AGO,0) as C_AGO'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                log::info($getall);
                log::info($getDespachos);

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_AGO' => $a->C_AGO,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_AGO' => $a->C_AGO,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 9){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_SEP,0) as C_SEP'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_SEP' => $a->C_SEP,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_SEP' => $a->C_SEP,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 10){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_OCT,0) as C_OCT'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_OCT' => $a->C_OCT,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_OCT' => $a->C_OCT,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 11){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_NOV,0) as C_NOV'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_NOV' => $a->C_NOV,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_NOV' => $a->C_NOV,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 12){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_DIC,0) as C_DIC'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('laravel.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESPACHADO'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_DIC' => $a->C_DIC,'DESPACHADO' => $b->DESPACHADO];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'C_DIC' => $a->C_DIC,'DESPACHADO' => 0];
                        $val = 0;
                    }
                }
            }
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
