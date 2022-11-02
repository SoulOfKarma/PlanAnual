<?php

namespace App\Http\Controllers;

use App\UsuarioBodegas;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class UsuarioBodegasController extends Controller
{
    public function GetUsuarioBodegas(Request $request){
        try {
            $data = UsuarioBodegas::where('run_usuario', $request->run_usuario)
            ->get();
            return $data;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostUsuarioBodegas(Request $request){
        try {
            UsuarioBodegas::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function DeleteUsuarioBodegas(Request $request){
        try {
            UsuarioBodegas::where('run_usuario',$request->run_usuario)
            ->where('idBodega',$request->idBodega)
            ->delete();
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
