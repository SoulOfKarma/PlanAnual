<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/Login/Salir', 'LoginController@salir');
Route::post('/Login/GetUsers', 'LoginController@getUsuarios');
Route::post('/Login/getpr', 'LoginController@adminPr');
Route::post('/auth/login','LoginController@login');
Route::post('/auth/RefreshToken','AuthJWT@handle');

Route::group(['middleware' => ['jwt.verify']], function() {
    //Gets
    Route::get('/Mantenedor/GetPresupuestosGenerales', ['middleware' => 'cors', 'uses' => 'PresupuestosAnualesController@GetPresupuestosGenerales']);
    Route::get('/Mantenedor/GetUsers', ['middleware' => 'cors', 'uses' => 'LoginController@GetUsers']);
    Route::get('/Mantenedor/GetArticulos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetArticulos']);
    
    //Posts 
    Route::post('/Mantenedor/PostPresupuestoAnual', ['middleware' => 'cors', 'uses' => 'PresupuestosAnualesController@PostPresupuestoAnual']);
    Route::post('/Mantenedor/PostProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PostProveedor']);
    Route::post('/Mantenedor/PostArticulos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostArticulos']);
    Route::post('/PCompra/PostArticuloServ', ['middleware' => 'cors', 'uses' => 'PlanesAnualesController@PostArticuloServ']);
    Route::post('/Mantenedor/RegistrarUsuario', ['middleware' => 'cors', 'uses' => 'LoginController@RegistrarUsuario']);
    
    //Post Como Get
    Route::post('/Mantenedor/GetPresupuestoByServBodega', ['middleware' => 'cors', 'uses' => 'PresupuestosAnualesController@GetPresupuestoByServBodega']);
    Route::post('/PCompra/GetArticulosServ', ['middleware' => 'cors', 'uses' => 'PlanesAnualesController@GetArticulosServ']);
    Route::post('/PCompra/GetTotalArticulosServ', ['middleware' => 'cors', 'uses' => 'PlanesAnualesController@GetTotalArticulosServ']);

    //Post Como Put
    Route::post('/Mantenedor/PutPresupuestoAnual', ['middleware' => 'cors', 'uses' => 'PresupuestosAnualesController@PutPresupuestoAnual']);
    Route::post('/Usuario/PutUsuario', ['middleware' => 'cors', 'uses' => 'LoginController@PutUsuario']);
    Route::post('/Mantenedor/PutArticulos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PutArticulos']);
    Route::post('/PCompra/UpdateArticuloServ', ['middleware' => 'cors', 'uses' => 'PlanesAnualesController@UpdateArticuloServ']);

    //Post como Delete
    Route::post('/PCompra/DestroyArticuloServ', ['middleware' => 'cors', 'uses' => 'PlanesAnualesController@DestroyArticuloServ']);

    //Post Documentos
    Route::post('/Mantenedor/PostDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PostDocumentoAuthUsuario']);

    //Get Reportes
    Route::get('/Reportes/GetSaldosReporte', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosReporte']);

    //Post Reportes
    Route::post('/Reportes/GetBincard', ['middleware' => 'cors', 'uses' => 'Reportes@GetBincard']);
});

//Generar PDF
Route::get('/Recepcion/RecepcionPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GenerarImpresion']);
Route::get('/Despacho/DespachoPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'DespachosController@GenerarImpresion']);
Route::get('/OrdenCompra/OrdenCompraPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GenerarImpresion']);
Route::post('/PDFPrueba', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@TestMultiPdf']);
Route::post('/Firma/TestFirmaDigital', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@TestFirmaDigital']);


