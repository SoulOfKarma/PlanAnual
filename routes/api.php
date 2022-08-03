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
    Route::get('/Mantenedor/GetProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@GetProveedor']);
    
    //Posts 
    Route::post('/Mantenedor/PostProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PostProveedor']);
    
    //Post Como Get
    Route::post('/Mantenedor/GetListadoArticulosByCodInterno', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetListadoArticulosByCodInterno']);

    //Post Como Put
    Route::post('/Mantenedor/PutProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PutProveedor']);

    //Post como Delete
    Route::post('/Mantenedor/DeleteArticuloDetalle', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DeleteArticuloDetalle']);

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


