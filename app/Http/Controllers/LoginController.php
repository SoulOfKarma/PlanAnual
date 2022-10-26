<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LoginCollection;
use App\Users;
use App\tblPermisoUsuarios;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function getUsuarios(Request $request){
        $rut = str_replace('.', '', $request->input('rut'));
        $rut = strtoupper($rut);

        $get_all = Users::where('run',$rut)
        ->get();

        $hashedpassword = "";

        foreach ($get_all as $p){
            $hashedpassword = $p->password;
            if(Hash::check($request->password,$hashedpassword)){
                return $get_all;
            }
            else{
                return 1;
            }
        }

    }

    public function getTodo(Request $request){
       $getall = Users::all();
        return $getall;
    }

    public function login(Request $request){
        $request->validate([
            'run' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = request(['run','password']);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function adminPr(Request $request)
  {
    $run = str_replace('.', '', $request->input('rut'));
    $run = strtoupper($run);
    $salida = DB::table('tbl_permiso_usuarios')
      ->where('run_usuario', '=', $run)
      ->get(['run_usuario', 'permiso_usuario', 'estado_login']);
    foreach ($salida as $p) {
      if ($p->estado_login == 1) {
        $request->session()->put('login', '1');
        $request->session()->put('run_usuario', $request->input('rut'));
        $request->session()->put('permiso_usuario', $p->permiso_usuario);
      }
    }
    return $salida;
  }

    public function salir(Request $request){
        $request->session()->forget('login');
        $request->session()->forget('run_usuario');
        $request->session()->forget('permiso_usuario');
        $request->session()->forget('token');
        $request->session()->flush();

        return response()->json(['message' => 'Se a cerrado sesion corectamente']);
    }

    public function RegistrarUsuario(Request $request){
        try
        {       
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
                Users::create([
                   'run' =>  $run,
                   'correo_usuario' => $request->correo_usuario,
                   'nombre_usuario' => $request->nombre_usuario,
                   'apellido_usuario' => $request->apellido_usuario,
                   'anexo' => $request->anexo,
                   'bodega' => $request->bodega,
                   'password' => Hash::make($request->password),
                   'idServicio' => $request->idServicio,
                   'NOMSER' => $request->NOMSER,
                   'idEstado' => $request->idEstado,
                   'api_token' => Str::random(60),
                ]);
       
                 tblPermisoUsuarios::create([
                   'run_usuario' => $run,
                   'permiso_usuario' => $request->permiso_usuario,
                   'estado_login' =>  $request->estado_login
                ]); 
            
            
         return true;
        }
        catch(\Throwable $th){
          log::info($th);
          return false;
        }
        
    }

    public function GetUsers(){
        try {
            $get = Users::select('users.id','users.run','users.nombre_usuario','users.apellido_usuario','users.anexo',
            'users.correo_usuario','users.idServicio','users.idEstado','users.NOMSER')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutUsuario(Request $request){
        try {
                $run = $request->run_usuario;
                $run = str_replace('.', '', $run);
                $run = strtoupper($run); 
                Users::where('id',$request->id)
                    ->update(['run' => $run,'correo_usuario' => $request->correo_usuario,'nombre_usuario' => $request->nombre_usuario,
                    'apellido_usuario' => $request->apellido_usuario,'anexo' => $request->anexo,'bodega' => $request->bodega,
                    'password' => Hash::make($request->password),'idServicio' => $request->idServicio,'NOMSER' => $request->NOMSER,'idEstado' => $request->idEstado]);
                tblPermisoUsuarios::where('run_usuario',$run)
                ->update(['permiso_usuario' => $request->permiso_usuario]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }


}
