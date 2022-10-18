<?php

namespace App\Http\Controllers;

use App\PlanesAnuales;
use App\ItemPresupuestarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use \NumberFormatter;

class PlanesAnualesController extends Controller
{
    public function GetArticulosServ(Request $request){
        try {
            $dato = PlanesAnuales::where('idServicio',$request->idServicio)
            ->where('BODEGA',$request->idBodega)
            ->where('ANIO',$request->anio)
            ->get();

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);
            $get = [];
            foreach ($dato as $key=>$a) {
                $get[$key] = ['ANIO' => $a->ANIO,'BODEGA' => $a->BODEGA,'CODART' => $a->CODART,'CODSER' => $a->CODSER,
                'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'FECING' => $a->FECING,
                'NOMART' => $a->NOMART,'NOMSER' => $a->NOMSER,'NROPED' => $a->NROPED,'OBS' => $a->OBS,'PRECIO' => $fmt->formatCurrency($a->PRECIO, "CLP"),
                'PRECIO2' => $a->PRECIO,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),'UNIMED' => $a->UNIMED,'ZGEN' => $a->ZGEN,'created_at' => $a->created_at,
                'id' => $a->id,'idServicio' => $a->idServicio,'updated_at' => $a->updated_at];
            }

            return $get;
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
            DB::raw('SUM(C_DIC)*PRECIO AS DICIEMBRE'),DB::raw('SUM(T_PRECIO) AS TOTAL'))
            ->where('idServicio',$request->idServicio)
            ->where('BODEGA',$request->idBodega)
            ->where('ANIO',$request->anio)
            ->groupby('PRECIO')
            ->get();

            $enero = 0;
            $febrero = 0;
            $marzo = 0;
            $abril = 0;
            $mayo = 0;
            $junio = 0;
            $julio = 0;
            $agosto = 0;
            $septiembre = 0;
            $octubre = 0;
            $noviembre = 0;
            $diciembre = 0;
            $total = 0;

            foreach ($dato as $key=>$a) {
                $enero = $enero + $a->ENERO;
                $febrero = $febrero + $a->FEBRERO;
                $marzo = $marzo + $a->MARZO;
                $abril = $abril + $a->ABRIL;
                $mayo = $mayo + $a->MAYO;                
                $junio = $junio + $a->JUNIO;
                $julio = $julio + $a->JULIO;
                $agosto = $agosto + $a->AGOSTO;
                $septiembre = $septiembre + $a->SEPTIEMBRE;
                $octubre = $octubre + $a->OCTUBRE;
                $noviembre = $noviembre + $a->NOVIEMBRE;
                $diciembre = $diciembre + $a->DICIEMBRE;
                $total = $total + $a->TOTAL;
            }

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);
            $enero = $fmt->formatCurrency($enero, "CLP");
            $febrero = $fmt->formatCurrency($febrero, "CLP");
            $marzo = $fmt->formatCurrency($marzo, "CLP");
            $abril = $fmt->formatCurrency($abril, "CLP");
            $mayo = $fmt->formatCurrency($mayo, "CLP");
            $junio = $fmt->formatCurrency($junio, "CLP");
            $julio = $fmt->formatCurrency($julio, "CLP");
            $agosto = $fmt->formatCurrency($agosto, "CLP");
            $septiembre = $fmt->formatCurrency($septiembre, "CLP");
            $octubre = $fmt->formatCurrency($octubre, "CLP");
            $noviembre = $fmt->formatCurrency($noviembre, "CLP");
            $diciembre = $fmt->formatCurrency($diciembre, "CLP");
            $total = $fmt->formatCurrency($total, "CLP");

            $get[0] = ['ENERO' => $enero, 'FEBRERO' => $febrero, 'MARZO' => $marzo, 'ABRIL' => $abril,
                        'MAYO' => $mayo,'JUNIO' => $junio,'JULIO' => $julio,'AGOSTO' => $agosto,'SEPTIEMBRE' => $septiembre,
                        'OCTUBRE' => $octubre,'NOVIEMBRE' => $noviembre,'DICIEMBRE' => $diciembre,'TOTAL' => $total
                    ];
       

            return $get;
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
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ENE,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 2){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_FEB,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 3){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAR,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 4){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ABR,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 5){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAY,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 6){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUN,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 7){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUL,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->where('idServicio',$request->idServicio)
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 8){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_AGO,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 9){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_SEP,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 10){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_OCT,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 11){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_NOV,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 12){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_DIC,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'))
                ->whereRaw('MONTH(FECDES)',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0];
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
    public function ReporteDPADB(Request $request){
        try {
            $getall = [];
            $getDespachos = [];
            $get = [];
            if($request->mes == 1){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ENE,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }

            }elseif($request->mes == 2){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_FEB,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 3){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAR,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 4){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_ABR,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 5){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_MAY,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 6){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUN,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 7){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_JUL,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 8){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_AGO,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){           
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 9){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_SEP,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 10){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_OCT,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 11){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_NOV,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
                        $val = 0;
                    }
                }
            }elseif($request->mes == 12){
                $getall = PlanesAnuales::select('CODART','NOMART','UNIMED',DB::raw('ROUND(PRECIO,0) AS PRECIO'),DB::raw('COALESCE(C_DIC,0) as SOLART'))
                ->where('idServicio',$request->idServicio)
                ->where('BODEGA',$request->BODEGA)
                ->get();

                $getDespachos = DB::table('DBSiab.despacho_detalles')
                ->select('CODART',DB::raw('ROUND(COALESCE(CANTIDAD,0),0) AS DESART'),
                DB::raw('CASE WHEN DAY(FECDES) = 1 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY1'),
                DB::raw('CASE WHEN DAY(FECDES) = 2 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY2'),
                DB::raw('CASE WHEN DAY(FECDES) = 3 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY3'),
                DB::raw('CASE WHEN DAY(FECDES) = 4 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY4'),
                DB::raw('CASE WHEN DAY(FECDES) = 5 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY5'),
                DB::raw('CASE WHEN DAY(FECDES) = 6 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY6'),
                DB::raw('CASE WHEN DAY(FECDES) = 7 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY7'),
                DB::raw('CASE WHEN DAY(FECDES) = 8 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY8'),
                DB::raw('CASE WHEN DAY(FECDES) = 9 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY9'),
                DB::raw('CASE WHEN DAY(FECDES) = 10 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY10'),
                DB::raw('CASE WHEN DAY(FECDES) = 11 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY11'),
                DB::raw('CASE WHEN DAY(FECDES) = 12 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY12'),
                DB::raw('CASE WHEN DAY(FECDES) = 13 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY13'),
                DB::raw('CASE WHEN DAY(FECDES) = 14 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY14'),
                DB::raw('CASE WHEN DAY(FECDES) = 15 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY15'),
                DB::raw('CASE WHEN DAY(FECDES) = 16 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY16'),
                DB::raw('CASE WHEN DAY(FECDES) = 17 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY17'),
                DB::raw('CASE WHEN DAY(FECDES) = 18 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY18'),
                DB::raw('CASE WHEN DAY(FECDES) = 19 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY19'),
                DB::raw('CASE WHEN DAY(FECDES) = 20 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY20'),
                DB::raw('CASE WHEN DAY(FECDES) = 21 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY21'),
                DB::raw('CASE WHEN DAY(FECDES) = 22 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY22'),
                DB::raw('CASE WHEN DAY(FECDES) = 23 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY23'),
                DB::raw('CASE WHEN DAY(FECDES) = 24 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY24'),
                DB::raw('CASE WHEN DAY(FECDES) = 25 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY25'),
                DB::raw('CASE WHEN DAY(FECDES) = 26 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY26'),
                DB::raw('CASE WHEN DAY(FECDES) = 27 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY27'),
                DB::raw('CASE WHEN DAY(FECDES) = 28 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY28'),
                DB::raw('CASE WHEN DAY(FECDES) = 29 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY29'),
                DB::raw('CASE WHEN DAY(FECDES) = 30 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY30'),
                DB::raw('CASE WHEN DAY(FECDES) = 31 THEN ROUND(COALESCE(CANTIDAD,0),0) ELSE 0 END AS DAY31'))
                ->where('idServicio',$request->idServicio)
                ->whereMonth('FECDES','=',$request->mes)
                ->get();

                foreach ($getall as $key=>$a) {
                    $val = 0;
                    foreach ($getDespachos as $b) {
                        if($a->CODART == $b->CODART){                  
                            $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => $b->DESART,'DAY1' => $b->DAY1,'DAY2' => $b->DAY2,
                            'DAY3' => $b->DAY3,'DAY4' => $b->DAY4,'DAY5' => $b->DAY5,'DAY6' => $b->DAY6,'DAY7' => $b->DAY7,
                            'DAY8' => $b->DAY8,'DAY9' => $b->DAY9,'DAY10' => $b->DAY10,'DAY11' => $b->DAY11,
                            'DAY12' => $b->DAY12,'DAY13' => $b->DAY13,'DAY14' => $b->DAY14,'DAY15' => $b->DAY15,
                            'DAY16' => $b->DAY16,'DAY17' => $b->DAY17,'DAY18' => $b->DAY18,'DAY19' => $b->DAY19,
                            'DAY20' => $b->DAY20,'DAY21' => $b->DAY21,'DAY22' => $b->DAY22,'DAY23' => $b->DAY23,
                            'DAY24' => $b->DAY24,'DAY25' => $b->DAY25,'DAY26' => $b->DAY26,'DAY27' => $b->DAY27,
                            'DAY28' => $b->DAY28,'DAY29' => $b->DAY29,'DAY30' => $b->DAY30,'DAY31' => $b->DAY31];
                            $val = 1;
                            
                        }
                    }
                    if($val == 0){
                        $get[$key] = ['CODART' => $a->CODART, 'NOMART' => $a->NOMART, 'UNIMED' => $a->UNIMED, 'PRECIO' => $a->PRECIO,
                            'SOLART' => $a->SOLART,'DESART' => 0,'DAY1' => 0,'DAY2' => 0,
                            'DAY3' => 0,'DAY4' => 0,'DAY5' => 0,'DAY6' => 0,'DAY7' => 0,
                            'DAY8' => 0,'DAY9' => 0,'DAY10' => 0,'DAY11' => 0,
                            'DAY12' => 0,'DAY13' => 0,'DAY14' => 0,'DAY15' => 0,
                            'DAY16' => 0,'DAY17' => 0,'DAY18' => 0,'DAY19' => 0,
                            'DAY20' => 0,'DAY21' => 0,'DAY22' => 0,'DAY23' => 0,
                            'DAY24' => 0,'DAY25' => 0,'DAY26' => 0,'DAY27' => 0,
                            'DAY28' => 0,'DAY29' => 0,'DAY30' => 0,'DAY31' => 0];
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
    public function ReporteConsolidado(Request $request){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->where('planes_anuales.BODEGA',$request->idBodega)
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            return $get7;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    public function ReporteConsolidadoDespachado(Request $request){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->where('planes_anuales.BODEGA',$request->idBodega)
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            $get8 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 1 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ENERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 2 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS FEBRERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 3 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MARZO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 4 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ABRIL'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 5 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MAYO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 6 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JUNIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 7 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JULIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 8 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS AGOSTO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 9 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS SEPTIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 10 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS OCTUBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 11 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS NOVIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 12 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS DICIEMBRE'))
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get8 = json_decode(json_encode($get8));

            $get9 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get7 as $key=>$a) {
                $val = 0;
                foreach ($get8 as $b) {
                    if($a->CODART == $b->CODART){
                        $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => $b->ENERO,'C_FEB' => $a->C_FEB,'D_FEB' => $b->FEBRERO,'C_MAR' => $a->C_MAR,'D_MAR' => $b->MARZO,'C_ABR' => $a->C_ABR,'D_ABR' => $b->ABRIL,'C_MAY' => $a->C_MAY,'D_MAY' => $b->MAYO,
                        'C_JUN' => $a->C_JUN,'D_JUN' => $b->JUNIO,'C_JUL' => $a->C_JUL,'D_JUL' => $b->JULIO,'C_AGO' => $a->C_AGO,'D_AGO' => $b->AGOSTO,'C_SEP' => $a->C_SEP,'D_SEP' => $b->SEPTIEMBRE,'C_OCT' => $a->C_OCT,'D_OCT' => $b->OCTUBRE,
                        'C_NOV' => $a->C_NOV,'D_NOV' => $b->NOVIEMBRE,'C_DIC' => $a->C_DIC,'D_DIC' => $b->DICIEMBRE,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => 0,'C_FEB' => $a->C_FEB,'D_FEB' => 0,'C_MAR' => $a->C_MAR,'D_MAR' => 0,'C_ABR' => $a->C_ABR,'D_ABR' => 0,'C_MAY' => $a->C_MAY,'D_MAY' => 0,
                        'C_JUN' => $a->C_JUN,'D_JUN' => 0,'C_JUL' => $a->C_JUL,'D_JUL' => 0,'C_AGO' => $a->C_AGO,'D_AGO' => 0,'C_SEP' => $a->C_SEP,'D_SEP' => 0,'C_OCT' => $a->C_OCT,'D_OCT' => 0,
                        'C_NOV' => $a->C_NOV,'D_NOV' => 0,'C_DIC' => $a->C_DIC,'D_DIC' => 0,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                    $val = 0;
                }
            }

            return $get9;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Reporte Total Servicios
    public function ReporteTotalServicio(Request $request){
        try {
            $get = [];
            $get = PlanesAnuales::select('idServicio','BODEGA',DB::raw('ROUND(sum(C_ENE * PRECIO),0) AS ENERO'),
            DB::raw('ROUND(sum(C_FEB * PRECIO),0) AS FEBRERO'),DB::raw('ROUND(sum(C_MAR * PRECIO),0) AS MARZO'),
            DB::raw('ROUND(sum(C_ABR * PRECIO),0) AS ABRIL'),DB::raw('ROUND(sum(C_MAY * PRECIO),0) AS MAYO'),
            DB::raw('ROUND(sum(C_JUN * PRECIO),0) AS JUNIO'),DB::raw('ROUND(sum(C_JUL * PRECIO),0) AS JULIO'),
            DB::raw('ROUND(sum(C_AGO * PRECIO),0) AS AGOSTO'),DB::raw('ROUND(sum(C_SEP * PRECIO),0) AS SEPTIEMBRE'),
            DB::raw('ROUND(sum(C_OCT * PRECIO),0) AS OCTUBRE'),DB::raw('ROUND(sum(C_NOV * PRECIO),0) AS NOVIEMBRE'),
            DB::raw('ROUND(sum(C_DIC * PRECIO),0) AS DICIEMBRE'),DB::raw('ROUND(SUM(T_PRECIO),0) AS T_PRECIO'))
            ->where('BODEGA',$request->idBodega)
            ->groupby('idServicio','BODEGA')
            ->get();

            $servicios = DB::table('DBSiab.servicios')
            ->select('*')
            ->get();

            $bodegas = DB::table('DBSiab.bodega')
            ->select('*')
            ->get();

            $get1 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get as $key=>$a) {
                foreach ($servicios as $b) {
                    if($a->idServicio == $b->id){
                        $get1[$key] = ['NOMSER' => $b->descripcionServicio,'BODEGA' => $a->BODEGA,'ENERO' => $fmt->formatCurrency($a->ENERO, "CLP"),'FEBRERO' => $fmt->formatCurrency($a->FEBRERO, "CLP"),
                        'MARZO' => $fmt->formatCurrency($a->MARZO, "CLP"),'ABRIL' => $fmt->formatCurrency($a->ABRIL, "CLP"),
                        'MAYO' => $fmt->formatCurrency($a->MAYO, "CLP"),'JUNIO' => $fmt->formatCurrency($a->JUNIO, "CLP"),
                        'JULIO' => $fmt->formatCurrency($a->JULIO, "CLP"),'AGOSTO' => $fmt->formatCurrency($a->AGOSTO, "CLP"),
                        'SEPTIEMBRE' => $fmt->formatCurrency($a->SEPTIEMBRE, "CLP"),'OCTUBRE' => $fmt->formatCurrency($a->OCTUBRE,"CLP"),
                        'NOVIEMBRE' => $fmt->formatCurrency($a->NOVIEMBRE, "CLP"),'DICIEMBRE' => $fmt->formatCurrency($a->DICIEMBRE, "CLP"),
                        'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP")];
                    }
                }
            }

            $get1 = json_decode(json_encode($get1));
            $get2 = [];

            foreach ($get1 as $key=>$a) {
                foreach ($bodegas as $b) {
                    if($a->BODEGA == $b->id){
                        $get2[$key] = ['NOMSER' => $a->NOMSER,'DESBOD' => $b->descripcionBodega,'ENERO' => $a->ENERO,
                        'FEBRERO' => $a->FEBRERO,'MARZO' => $a->MARZO,'ABRIL' => $a->ABRIL,'MAYO' => $a->MAYO,'JUNIO' => $a->JUNIO,
                        'JULIO' => $a->JULIO,'AGOSTO' => $a->AGOSTO,'SEPTIEMBRE' => $a->SEPTIEMBRE,'OCTUBRE' => $a->OCTUBRE,
                        'NOVIEMBRE' => $a->NOVIEMBRE,'DICIEMBRE' => $a->DICIEMBRE,'T_PRECIO' => $a->T_PRECIO];
                    }
                }
            }

            $get2 = json_decode(json_encode($get2));

            return $get2;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Reporte Por Servicio
    public function ReporteTotalByServicio(Request $request){
        try {
            $get = [];
            $get = PlanesAnuales::select('idServicio','BODEGA',DB::raw('ROUND(sum(C_ENE * PRECIO),0) AS ENERO'),
            DB::raw('ROUND(sum(C_FEB * PRECIO),0) AS FEBRERO'),DB::raw('ROUND(sum(C_MAR * PRECIO),0) AS MARZO'),
            DB::raw('ROUND(sum(C_ABR * PRECIO),0) AS ABRIL'),DB::raw('ROUND(sum(C_MAY * PRECIO),0) AS MAYO'),
            DB::raw('ROUND(sum(C_JUN * PRECIO),0) AS JUNIO'),DB::raw('ROUND(sum(C_JUL * PRECIO),0) AS JULIO'),
            DB::raw('ROUND(sum(C_AGO * PRECIO),0) AS AGOSTO'),DB::raw('ROUND(sum(C_SEP * PRECIO),0) AS SEPTIEMBRE'),
            DB::raw('ROUND(sum(C_OCT * PRECIO),0) AS OCTUBRE'),DB::raw('ROUND(sum(C_NOV * PRECIO),0) AS NOVIEMBRE'),
            DB::raw('ROUND(sum(C_DIC * PRECIO),0) AS DICIEMBRE'),DB::raw('ROUND(SUM(T_PRECIO),0) AS T_PRECIO'))
            ->where('BODEGA',$request->idBodega)
            ->where('idServicio',$request->idServicio)
            ->groupby('idServicio','BODEGA')
            ->get();

            $servicios = DB::table('DBSiab.servicios')
            ->select('*')
            ->get();

            $bodegas = DB::table('DBSiab.bodega')
            ->select('*')
            ->get();

            $get1 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get as $key=>$a) {
                foreach ($servicios as $b) {
                    if($a->idServicio == $b->id){
                        $get1[$key] = ['NOMSER' => $b->descripcionServicio,'BODEGA' => $a->BODEGA,
                        'ENERO' => $fmt->formatCurrency($a->ENERO, "CLP"),'FEBRERO' => $fmt->formatCurrency($a->FEBRERO, "CLP"),
                        'MARZO' => $fmt->formatCurrency($a->MARZO, "CLP"),'ABRIL' => $fmt->formatCurrency($a->ABRIL, "CLP"),
                        'MAYO' => $fmt->formatCurrency($a->MAYO, "CLP"),'JUNIO' => $fmt->formatCurrency($a->JUNIO, "CLP"),
                        'JULIO' => $fmt->formatCurrency($a->JULIO, "CLP"),'AGOSTO' => $fmt->formatCurrency($a->AGOSTO, "CLP"),
                        'SEPTIEMBRE' => $fmt->formatCurrency($a->SEPTIEMBRE, "CLP"),'OCTUBRE' => $fmt->formatCurrency($a->OCTUBRE,"CLP"),
                        'NOVIEMBRE' => $fmt->formatCurrency($a->NOVIEMBRE, "CLP"),'DICIEMBRE' => $fmt->formatCurrency($a->DICIEMBRE, "CLP"),
                        'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP")];
                    }
                }
            }

            $get1 = json_decode(json_encode($get1));
            $get2 = [];

            foreach ($get1 as $key=>$a) {
                foreach ($bodegas as $b) {
                    if($a->BODEGA == $b->id){
                        $get2[$key] = ['NOMSER' => $a->NOMSER,'DESBOD' => $b->descripcionBodega,'ENERO' => $a->ENERO,
                        'FEBRERO' => $a->FEBRERO,'MARZO' => $a->MARZO,'ABRIL' => $a->ABRIL,'MAYO' => $a->MAYO,'JUNIO' => $a->JUNIO,
                        'JULIO' => $a->JULIO,'AGOSTO' => $a->AGOSTO,'SEPTIEMBRE' => $a->SEPTIEMBRE,'OCTUBRE' => $a->OCTUBRE,
                        'NOVIEMBRE' => $a->NOVIEMBRE,'DICIEMBRE' => $a->DICIEMBRE,'T_PRECIO' => $a->T_PRECIO];
                    }
                }
            }

            $get2 = json_decode(json_encode($get2));

            return $get2;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    public function ReporteConsolidadoPorServicio(Request $request){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->where('planes_anuales.BODEGA',$request->idBodega)
            ->where('idServicio',$request->idServicio)
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            return $get7;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //
    //Reporte por Servicio Despachado
    public function ReporteConsolidadoPorServicioDespachado(Request $request){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->where('planes_anuales.BODEGA',$request->idBodega)
            ->where('planes_anuales.idServicio',$request->idServicio)
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->where('DBSiab.despacho_detalles.idServicio',$request->idServicio)
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            $get8 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 1 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ENERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 2 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS FEBRERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 3 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MARZO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 4 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ABRIL'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 5 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MAYO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 6 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JUNIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 7 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JULIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 8 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS AGOSTO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 9 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS SEPTIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 10 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS OCTUBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 11 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS NOVIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 12 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS DICIEMBRE'))
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get8 = json_decode(json_encode($get8));

            $get9 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get7 as $key=>$a) {
                $val = 0;
                foreach ($get8 as $b) {
                    if($a->CODART == $b->CODART){
                        $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => $b->ENERO,'C_FEB' => $a->C_FEB,'D_FEB' => $b->FEBRERO,'C_MAR' => $a->C_MAR,'D_MAR' => $b->MARZO,'C_ABR' => $a->C_ABR,'D_ABR' => $b->ABRIL,'C_MAY' => $a->C_MAY,'D_MAY' => $b->MAYO,
                        'C_JUN' => $a->C_JUN,'D_JUN' => $b->JUNIO,'C_JUL' => $a->C_JUL,'D_JUL' => $b->JULIO,'C_AGO' => $a->C_AGO,'D_AGO' => $b->AGOSTO,'C_SEP' => $a->C_SEP,'D_SEP' => $b->SEPTIEMBRE,'C_OCT' => $a->C_OCT,'D_OCT' => $b->OCTUBRE,
                        'C_NOV' => $a->C_NOV,'D_NOV' => $b->NOVIEMBRE,'C_DIC' => $a->C_DIC,'D_DIC' => $b->DICIEMBRE,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => 0,'C_FEB' => $a->C_FEB,'D_FEB' => 0,'C_MAR' => $a->C_MAR,'D_MAR' => 0,'C_ABR' => $a->C_ABR,'D_ABR' => 0,'C_MAY' => $a->C_MAY,'D_MAY' => 0,
                        'C_JUN' => $a->C_JUN,'D_JUN' => 0,'C_JUL' => $a->C_JUL,'D_JUL' => 0,'C_AGO' => $a->C_AGO,'D_AGO' => 0,'C_SEP' => $a->C_SEP,'D_SEP' => 0,'C_OCT' => $a->C_OCT,'D_OCT' => 0,
                        'C_NOV' => $a->C_NOV,'D_NOV' => 0,'C_DIC' => $a->C_DIC,'D_DIC' => 0,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                    $val = 0;
                }
            }

            return $get9;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //
    //Reporte Por Servicio Despachado/Fecha
    public function ReporteConsolidadoPorServicioDespachadoFecha(Request $request){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->where('planes_anuales.BODEGA',$request->idBodega)
            ->where('planes_anuales.idServicio',$request->idServicio)
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->where('DBSiab.despacho_detalles.idServicio',$request->idServicio)
            ->whereBetween('DBSiab.despacho_detalles.FECDES', [$request->fechaInicio, $request->fechaTermino])
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $a->T_PRECIO,
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            $get8 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 1 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ENERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 2 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS FEBRERO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 3 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MARZO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 4 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS ABRIL'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 5 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS MAYO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 6 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JUNIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 7 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS JULIO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 8 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS AGOSTO'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 9 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS SEPTIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 10 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS OCTUBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 11 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS NOVIEMBRE'),
            DB::raw('(select COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0)
            FROM DBSiab.despacho_detalles WHERE MONTH(DBSiab.despacho_detalles.FECDES) = 12 && DBSiab.recepcion_detalles.CODART = DBSiab.despacho_detalles.CODART
            ) AS DICIEMBRE'))
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get8 = json_decode(json_encode($get8));

            $get9 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get7 as $key=>$a) {
                $val = 0;
                foreach ($get8 as $b) {
                    if($a->CODART == $b->CODART){
                        $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => $b->ENERO,'C_FEB' => $a->C_FEB,'D_FEB' => $b->FEBRERO,'C_MAR' => $a->C_MAR,'D_MAR' => $b->MARZO,'C_ABR' => $a->C_ABR,'D_ABR' => $b->ABRIL,'C_MAY' => $a->C_MAY,'D_MAY' => $b->MAYO,
                        'C_JUN' => $a->C_JUN,'D_JUN' => $b->JUNIO,'C_JUL' => $a->C_JUL,'D_JUL' => $b->JULIO,'C_AGO' => $a->C_AGO,'D_AGO' => $b->AGOSTO,'C_SEP' => $a->C_SEP,'D_SEP' => $b->SEPTIEMBRE,'C_OCT' => $a->C_OCT,'D_OCT' => $b->OCTUBRE,
                        'C_NOV' => $a->C_NOV,'D_NOV' => $b->NOVIEMBRE,'C_DIC' => $a->C_DIC,'D_DIC' => $b->DICIEMBRE,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get9[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'D_ENE' => 0,'C_FEB' => $a->C_FEB,'D_FEB' => 0,'C_MAR' => $a->C_MAR,'D_MAR' => 0,'C_ABR' => $a->C_ABR,'D_ABR' => 0,'C_MAY' => $a->C_MAY,'D_MAY' => 0,
                        'C_JUN' => $a->C_JUN,'D_JUN' => 0,'C_JUL' => $a->C_JUL,'D_JUL' => 0,'C_AGO' => $a->C_AGO,'D_AGO' => 0,'C_SEP' => $a->C_SEP,'D_SEP' => 0,'C_OCT' => $a->C_OCT,'D_OCT' => 0,
                        'C_NOV' => $a->C_NOV,'D_NOV' => 0,'C_DIC' => $a->C_DIC,'D_DIC' => 0,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $a->S_BODEGA];
                    $val = 0;
                }
            }

            return $get9;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Reporte Consolidado Completo
    public function ReporteConsolidadoCompleto(){
        try {
            $get = PlanesAnuales::select('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO',
            DB::raw('SUM(planes_anuales.C_ENE) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB) AS C_FEB'),DB::raw('SUM(planes_anuales.C_MAR) AS C_MAR'),
            DB::raw('SUM(planes_anuales.C_ABR) AS C_ABR'),DB::raw('SUM(planes_anuales.C_MAY) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO) AS C_AGO'),DB::raw('SUM(planes_anuales.C_SEP) AS C_SEP'),
            DB::raw('SUM(planes_anuales.C_OCT) AS C_OCT'),DB::raw('SUM(planes_anuales.C_NOV) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC) AS C_DIC'),
            DB::raw('SUM(planes_anuales.C_TOTAL) AS C_TOTAL'),
            DB::raw('ROUND(SUM(planes_anuales.T_PRECIO),0) AS T_PRECIO'))
            ->groupby('planes_anuales.CODART','planes_anuales.NOMART','planes_anuales.UNIMED','planes_anuales.PRECIO')
            ->get(); 

            $get2 = DB::table('DBSiab.recepcion_detalles')
            ->select('DBSiab.recepcion_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.recepcion_detalles.CANREC),0),0) AS SALDO'))
            ->whereraw('DBSiab.recepcion_detalles.CODMOT IS NULL && DBSiab.recepcion_detalles.FOLIO IS NOT NULL')
            ->groupby('DBSiab.recepcion_detalles.CODART')
            ->get();

            $get3 = DB::table('DBSiab.saldo_inventario')
            ->select('DBSiab.saldo_inventario.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.saldo_inventario.SALDO),0),0) AS SALDO'))
            ->groupby('DBSiab.saldo_inventario.CODART')
            ->get();

            $get4 = [];

            foreach ($get2 as $key=>$a) {
                $val = 0;
                foreach ($get3 as $b) {
                    if($a->CODART == $b->CODART){
                        $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO + $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get4[$key] = ['CODART' => $a->CODART,'SALDO' => $a->SALDO];
                    $val = 0;
                }
            }

            $get4 = json_decode(json_encode($get4));

            $get5 = DB::table('DBSiab.despacho_detalles')
            ->select('DBSiab.despacho_detalles.CODART',
            DB::raw('ROUND(COALESCE(SUM(DBSiab.despacho_detalles.CANTIDAD),0),0) AS SALDO'))
            ->groupby('DBSiab.despacho_detalles.CODART')
            ->get();

            $get6 = [];

            foreach ($get4 as $key=>$a) {
                $val = 0;
                foreach ($get5 as $b) {
                    if($a->CODART == $b->CODART){
                        $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO) - intval($b->SALDO)];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get6[$key] = ['CODART' => $a->CODART,'SALDO' => intval($a->SALDO)];
                    $val = 0;
                }
            }

            $get6 = json_decode(json_encode($get6));

            $get7 = [];

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            foreach ($get as $key=>$a) {
                $val = 0;
                foreach ($get6 as $b) {
                    if($a->CODART == $b->CODART){
                        $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => $b->SALDO];
                        $val = 1;
                    }
                }
                if($val == 0){
                    $get7[$key] = ['CODART' => $a->CODART,'NOMART' => $a->NOMART,'UNIMED' => $a->UNIMED,'PRECIO' => $a->PRECIO,
                        'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                        'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                        'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),
                        'S_BODEGA' => 0];
                    $val = 0;
                }
            }

            $get7 = json_decode(json_encode($get7));

            return $get7;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Reporte Contable
    public function ReporteItemPresupuestario(){
        try {
            $get = PlanesAnuales::select(DB::raw('SUM(planes_anuales.C_ENE * planes_anuales.PRECIO) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB * planes_anuales.PRECIO) AS C_FEB'),
            DB::raw('SUM(planes_anuales.C_MAR * planes_anuales.PRECIO) AS C_MAR'),DB::raw('SUM(planes_anuales.C_ABR * planes_anuales.PRECIO) AS C_ABR'),
            DB::raw('SUM(planes_anuales.C_MAY * planes_anuales.PRECIO) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN * planes_anuales.PRECIO) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL * planes_anuales.PRECIO) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO * planes_anuales.PRECIO) AS C_AGO'),
            DB::raw('SUM(planes_anuales.C_SEP * planes_anuales.PRECIO) AS C_SEP'),DB::raw('SUM(planes_anuales.C_OCT * planes_anuales.PRECIO) AS C_OCT'),
            DB::raw('SUM(planes_anuales.C_NOV * planes_anuales.PRECIO) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC * planes_anuales.PRECIO) AS C_DIC'),
            DB::raw('SUM(planes_anuales.T_PRECIO) AS T_PRECIO'),DB::raw('COALESCE(item_presupuestarios.CODIPRE,0) AS CODIPRE'),
            DB::raw('COALESCE(item_presupuestarios.NOMBREIPRE,0) AS NOMBREIPRE'))
            ->join('item_presupuestarios','planes_anuales.CODART','=', 'item_presupuestarios.CODART')
            ->groupby('item_presupuestarios.CODIPRE','item_presupuestarios.NOMBREIPRE')
            ->get();

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            $dato = [];

            foreach ($get as $key=>$b) {
                    $dato[$key] = ['C_ENE' => $fmt->formatCurrency($b->C_ENE, "CLP"),'C_FEB' => $fmt->formatCurrency($b->C_FEB, "CLP"),
                    'C_MAR' => $fmt->formatCurrency($b->C_MAR, "CLP"),'C_ABR' => $fmt->formatCurrency($b->C_ABR, "CLP"),
                    'C_MAY' => $fmt->formatCurrency($b->C_MAY, "CLP"),'C_JUN' => $fmt->formatCurrency($b->C_JUN, "CLP"),
                    'C_JUL' => $fmt->formatCurrency($b->C_JUL, "CLP"),'C_AGO' => $fmt->formatCurrency($b->C_AGO, "CLP"),
                    'C_SEP' => $fmt->formatCurrency($b->C_SEP, "CLP"),'C_OCT' => $fmt->formatCurrency($b->C_OCT, "CLP"),
                    'C_NOV' => $fmt->formatCurrency($b->C_NOV, "CLP"),'C_DIC' => $fmt->formatCurrency($b->C_DIC, "CLP"),
                    'C_TOTAL' => $fmt->formatCurrency($b->C_TOTAL, "CLP"),'T_PRECIO' => $fmt->formatCurrency($b->T_PRECIO, "CLP"),
                    'CODIPRE' => $b->CODIPRE,'NOMBREIPRE' => $b->NOMBREIPRE];
            }

            return $dato;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    //Reporte Contable
    public function ReporteItemPresupuestarioServicios(){
        try {
            $get = PlanesAnuales::select(DB::raw('SUM(planes_anuales.C_ENE * planes_anuales.PRECIO) AS C_ENE'),DB::raw('SUM(planes_anuales.C_FEB * planes_anuales.PRECIO) AS C_FEB'),
            DB::raw('SUM(planes_anuales.C_MAR * planes_anuales.PRECIO) AS C_MAR'),DB::raw('SUM(planes_anuales.C_ABR * planes_anuales.PRECIO) AS C_ABR'),
            DB::raw('SUM(planes_anuales.C_MAY * planes_anuales.PRECIO) AS C_MAY'),DB::raw('SUM(planes_anuales.C_JUN * planes_anuales.PRECIO) AS C_JUN'),
            DB::raw('SUM(planes_anuales.C_JUL * planes_anuales.PRECIO) AS C_JUL'),DB::raw('SUM(planes_anuales.C_AGO * planes_anuales.PRECIO) AS C_AGO'),
            DB::raw('SUM(planes_anuales.C_SEP * planes_anuales.PRECIO) AS C_SEP'),DB::raw('SUM(planes_anuales.C_OCT * planes_anuales.PRECIO) AS C_OCT'),
            DB::raw('SUM(planes_anuales.C_NOV * planes_anuales.PRECIO) AS C_NOV'),DB::raw('SUM(planes_anuales.C_DIC * planes_anuales.PRECIO) AS C_DIC'),
            DB::raw('SUM(planes_anuales.T_PRECIO) AS T_PRECIO'),DB::raw('COALESCE(item_presupuestarios.CODIPRE,0) AS CODIPRE'),
            DB::raw('COALESCE(item_presupuestarios.NOMBREIPRE,0) AS NOMBREIPRE'),
            DB::raw('COALESCE(planes_anuales.NOMSER,0) AS NOMSER'))
            ->join('item_presupuestarios','planes_anuales.CODART','=', 'item_presupuestarios.CODART')
            ->groupby('item_presupuestarios.CODIPRE','item_presupuestarios.NOMBREIPRE','planes_anuales.NOMSER')
            ->get();

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            $dato = [];

            foreach ($get as $key=>$b) {
                    $dato[$key] = ['C_ENE' => $fmt->formatCurrency($b->C_ENE, "CLP"),'C_FEB' => $fmt->formatCurrency($b->C_FEB, "CLP"),
                    'C_MAR' => $fmt->formatCurrency($b->C_MAR, "CLP"),'C_ABR' => $fmt->formatCurrency($b->C_ABR, "CLP"),
                    'C_MAY' => $fmt->formatCurrency($b->C_MAY, "CLP"),'C_JUN' => $fmt->formatCurrency($b->C_JUN, "CLP"),
                    'C_JUL' => $fmt->formatCurrency($b->C_JUL, "CLP"),'C_AGO' => $fmt->formatCurrency($b->C_AGO, "CLP"),
                    'C_SEP' => $fmt->formatCurrency($b->C_SEP, "CLP"),'C_OCT' => $fmt->formatCurrency($b->C_OCT, "CLP"),
                    'C_NOV' => $fmt->formatCurrency($b->C_NOV, "CLP"),'C_DIC' => $fmt->formatCurrency($b->C_DIC, "CLP"),
                    'C_TOTAL' => $fmt->formatCurrency($b->C_TOTAL, "CLP"),'T_PRECIO' => $fmt->formatCurrency($b->T_PRECIO, "CLP"),
                    'CODIPRE' => $b->CODIPRE,'NOMBREIPRE' => $b->NOMBREIPRE,'NOMSER' => $b->NOMSER];
            }

            return $dato;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
