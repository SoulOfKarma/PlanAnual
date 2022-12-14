<?php

namespace App\Http\Controllers;

use App\PresupuestosAnuales;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use \NumberFormatter;

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

    public function DeletePresupuestoAnual(Request $request){
        try {
            PresupuestosAnuales::where('id',$request->id)
            ->delete();
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetPresupuestoByServBodega(Request $request){
        try {
            $get = PresupuestosAnuales::select('presupuestos_anuales.ANIO','presupuestos_anuales.NOMSER','presupuestos_anuales.P_ANUAL',
            DB::raw('ROUND((select SUM(planes_anuales.C_ENE*planes_anuales.PRECIO + planes_anuales.C_FEB*planes_anuales.PRECIO + planes_anuales.C_MAR*planes_anuales.PRECIO +
            planes_anuales.C_ABR*planes_anuales.PRECIO + planes_anuales.C_MAY*planes_anuales.PRECIO + planes_anuales.C_JUN*planes_anuales.PRECIO +
            planes_anuales.C_JUL*planes_anuales.PRECIO + planes_anuales.C_AGO*planes_anuales.PRECIO + planes_anuales.C_SEP*planes_anuales.PRECIO +
            planes_anuales.C_OCT*planes_anuales.PRECIO + planes_anuales.C_NOV*planes_anuales.PRECIO + planes_anuales.C_DIC*planes_anuales.PRECIO)
            FROM planes_anuales WHERE planes_anuales.NOMSER = presupuestos_anuales.NOMSER && planes_anuales.ANIO = year(presupuestos_anuales.ANIO)),0) AS UTILIZADO'),
            DB::raw('presupuestos_anuales.P_ANUAL - ROUND((select SUM(planes_anuales.C_ENE*planes_anuales.PRECIO + planes_anuales.C_FEB*planes_anuales.PRECIO + planes_anuales.C_MAR*planes_anuales.PRECIO +
            planes_anuales.C_ABR*planes_anuales.PRECIO + planes_anuales.C_MAY*planes_anuales.PRECIO + planes_anuales.C_JUN*planes_anuales.PRECIO +
            planes_anuales.C_JUL*planes_anuales.PRECIO + planes_anuales.C_AGO*planes_anuales.PRECIO + planes_anuales.C_SEP*planes_anuales.PRECIO +
            planes_anuales.C_OCT*planes_anuales.PRECIO + planes_anuales.C_NOV*planes_anuales.PRECIO + planes_anuales.C_DIC*planes_anuales.PRECIO)
            FROM planes_anuales WHERE planes_anuales.NOMSER = presupuestos_anuales.NOMSER && planes_anuales.ANIO = year(presupuestos_anuales.ANIO)),0) AS RESTANTE'))
            ->where('NOMSER',$request->NOMSER)
            ->where('ANIO',$request->anio)
            ->groupBy('presupuestos_anuales.ANIO','presupuestos_anuales.NOMSER','presupuestos_anuales.P_ANUAL')
            ->get();

            $anio = 0;
            $nomser = '';
            $panual = 0;
            $utilizado = 0;
            $restante = 0;
            $panualVal = 0;

            foreach ($get as $key=>$a) {
                $anio = $a->ANIO;
                $nomser = $a->NOMSER;
                $panual = $a->P_ANUAL;
                $utilizado = $a->UTILIZADO;
                $restante = $a->RESTANTE;
                $panualVal = $a->P_ANUAL;
                $utilizadoVal = $a->UTILIZADO;
                $restanteVal = $a->RESTANTE;             
            }

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);
            $panual = $fmt->formatCurrency($panual, "CLP");
            $utilizado = $fmt->formatCurrency($utilizado, "CLP");
            $restante = $fmt->formatCurrency($restante, "CLP");

            $get = [];
            $get[0] = ['ANIO' => $anio, 'NOMSER' => $nomser, 'P_ANUAL' => $panual, 'UTILIZADO' => $utilizado,
            'RESTANTE' => $restante,'PANUALVAL' => $panualVal,'UTILIZADOVAL' => $utilizadoVal,'RESTANTEVAL' => $restanteVal];

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetPresupuestosFormato(){
        try {
            $data = PresupuestosAnuales::select('id','NOMSER','ANIO','P_ANUAL')
            ->get();

            $fmt = numfmt_create('es_CL', NumberFormatter::CURRENCY);

            $get = [];

            foreach ($data as $key=>$a) {
                $get[$key] = ['id' => $a->id,'NOMSER' => $a->NOMSER,'ANIO' => $a->ANIO,
                'P_ANUAL' => $fmt->formatCurrency($a->P_ANUAL, "CLP"),'P_ANUAL2' => $a->P_ANUAL];
            }

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
