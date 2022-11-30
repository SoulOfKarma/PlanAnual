<?php

namespace App\Http\Controllers;

use App\PlanAnualReprogramadosAntiguos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class PlanAnualReprogramadosAntiguosController extends Controller
{
    public function GetUltimaReprogramacion(){
        try {
            $get = PlanAnualReprogramadosAntiguos::select('plan_anual_reprogramados_antiguos.NOMSER','DBSiab.bodega.descripcionBodega',DB::raw('MAX(plan_anual_reprogramados_antiguos.idReprogramado) as ULTIMAREPROG'))
            ->join('DBSiab.bodega','plan_anual_reprogramados_antiguos.BODEGA','=','DBSiab.bodega.id')
            ->where('plan_anual_reprogramados_antiguos.idReprogramado','>',1)
            ->groupby('plan_anual_reprogramados_antiguos.NOMSER','plan_anual_reprogramados_antiguos.BODEGA')
            ->orderby('plan_anual_reprogramados_antiguos.NOMSER','ASC')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
    
}
