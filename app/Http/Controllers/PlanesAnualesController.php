<?php

namespace App\Http\Controllers;

use App\PlanesAnuales;
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

            $ANIO = 0;
            $BODEGA = 0;
            $CODART = 0;
            $CODSER = 0;
            $C_ENE = 0;
            $C_FEB = 0;
            $C_MAR = 0;
            $C_ABR = 0;
            $C_MAY = 0;
            $C_JUN = 0;
            $C_JUL = 0;
            $C_AGO = 0;
            $C_SEP = 0;
            $C_OCT = 0;
            $C_NOV = 0;
            $C_DIC = 0;
            $C_TOTAL = 0;
            $FECING = 0;
            $NOMART = 0;
            $NOMSER = 0;
            $NROPED = 0;
            $OBS = 0;
            $PRECIO = 0;
            $T_PRECIO = 0;
            $UNIMED = 0;
            $ZGEN = 0;
            $created_at = 0;
            $id = 0;
            $idServicio = 0;
            $updated_at = 0;

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);
            $get = [];
            foreach ($dato as $key=>$a) {
                $get[$key] = ['ANIO' => $a->ANIO,'BODEGA' => $a->BODEGA,'CODART' => $a->CODART,'CODSER' => $a->CODSER,
                'C_ENE' => $a->C_ENE,'C_FEB' => $a->C_FEB,'C_MAR' => $a->C_MAR,'C_ABR' => $a->C_ABR,'C_MAY' => $a->C_MAY,
                'C_JUN' => $a->C_JUN,'C_JUL' => $a->C_JUL,'C_AGO' => $a->C_AGO,'C_SEP' => $a->C_SEP,'C_OCT' => $a->C_OCT,
                'C_NOV' => $a->C_NOV,'C_DIC' => $a->C_DIC,'C_TOTAL' => $a->C_TOTAL,'FECING' => $a->FECING,
                'NOMART' => $a->NOMART,'NOMSER' => $a->NOMSER,'NROPED' => $a->NROPED,'OBS' => $a->OBS,'PRECIO' => $fmt->formatCurrency($a->PRECIO, "CLP"),
                'T_PRECIO' => $fmt->formatCurrency($a->T_PRECIO, "CLP"),'UNIMED' => $a->UNIMED,'ZGEN' => $a->ZGEN,'created_at' => $a->created_at,
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
}
