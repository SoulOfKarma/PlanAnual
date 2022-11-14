import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        //Datos Columnas Consolidado
        ColumnasConsolidado: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "FEBRERO",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo Bodega",
                field: "S_BODEGA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Consolidado
        headerTitleConsolidado: [
            "Codigo Articulo",
            "Descripcion",
            "Unidad Medida",
            "Precio",
            "ENERO",
            "FEBRERO",
            "MARZO",
            "ABRIL",
            "MAYO",
            "JUNIO",
            "JULIO",
            "AGOSTO",
            "SEPTIEMBRE",
            "OCTUBRE",
            "NOVIEMBRE",
            "DICIEMBRE",
            "C. TOTAL",
            "Saldo Bodega",
            "TOTAL"
        ],
        //Detalle Reporte Consolidado
        headerValConsolidado: [
            "CODART",
            "NOMART",
            "UNIMED",
            "PRECIO",
            "C_ENE",
            "C_FEB",
            "C_MAR",
            "C_ABR",
            "C_MAY",
            "C_JUN",
            "C_JUL",
            "C_AGO",
            "C_SEP",
            "C_OCT",
            "C_NOV",
            "C_DIC",
            "C_TOTAL",
            "S_BODEGA",
            "T_PRECIO"
        ],
        //Datos Columnas Consolidado Vs Despacho
        ColumnasConsolidadoDespacho: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo Bodega",
                field: "S_BODEGA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Consolidado Vs Despacho
        headerTitleConsolidadoDespacho: [
            "Codigo Articulo",
            "Descripcion",
            "Unidad Medida",
            "Precio",
            "ENERO",
            "Despachado",
            "FEBRERO",
            "Despachado",
            "MARZO",
            "Despachado",
            "ABRIL",
            "Despachado",
            "MAYO",
            "Despachado",
            "JUNIO",
            "Despachado",
            "JULIO",
            "Despachado",
            "AGOSTO",
            "Despachado",
            "SEPTIEMBRE",
            "Despachado",
            "OCTUBRE",
            "Despachado",
            "NOVIEMBRE",
            "Despachado",
            "DICIEMBRE",
            "Despachado",
            "C. TOTAL",
            "Saldo Bodega",
            "TOTAL"
        ],
        //Detalle Reporte Consolidado Vs Despacho
        headerValConsolidadoDespacho: [
            "CODART",
            "NOMART",
            "UNIMED",
            "PRECIO",
            "C_ENE",
            "D_ENE",
            "C_FEB",
            "D_FEB",
            "C_MAR",
            "D_MAR",
            "C_ABR",
            "D_ABR",
            "C_MAY",
            "D_MAY",
            "C_JUN",
            "D_JUN",
            "C_JUL",
            "D_JUL",
            "C_AGO",
            "D_AGO",
            "C_SEP",
            "D_SEP",
            "C_OCT",
            "D_OCT",
            "C_NOV",
            "D_NOV",
            "C_DIC",
            "D_DIC",
            "C_TOTAL",
            "S_BODEGA",
            "T_PRECIO"
        ],
        //Datos Columnas Total Mensual
        ColumnasTM: [
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "DESBOD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Enero",
                field: "ENERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "FEBRERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Marzo",
                field: "MARZO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Abril",
                field: "ABRIL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mayo",
                field: "MAYO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Junio",
                field: "JUNIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Julio",
                field: "JULIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Agosto",
                field: "AGOSTO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Septiembre",
                field: "SEPTIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Octubre",
                field: "OCTUBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Noviembre",
                field: "NOVIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Diciembre",
                field: "DICIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Total Mensual
        headerTitleTM: [
            "Servicio",
            "Bodega",
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
            "TOTAL"
        ],
        //Detalle Reporte Total Mensual
        headerValTM: [
            "NOMSER",
            "DESBOD",
            "ENERO",
            "FEBRERO",
            "MARZO",
            "ABRIL",
            "MAYO",
            "JUNIO",
            "JULIO",
            "AGOSTO",
            "SEPTIEMBRE",
            "OCTUBRE",
            "NOVIEMBRE",
            "DICIEMBRE",
            "T_PRECIO"
        ],
        //Datos Columnas Total Servicio
        ColumnasPorServicio: [
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "DESBOD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Enero",
                field: "ENERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "FEBRERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Marzo",
                field: "MARZO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Abril",
                field: "ABRIL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mayo",
                field: "MAYO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Junio",
                field: "JUNIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Julio",
                field: "JULIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Agosto",
                field: "AGOSTO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Septiembre",
                field: "SEPTIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Octubre",
                field: "OCTUBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Noviembre",
                field: "NOVIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Diciembre",
                field: "DICIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnas Consulta Por Servicio Detalle
        ColumnasPorServicioDetalle: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo Bodega",
                field: "S_BODEGA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnos Consolidado Por Despacho
        ColumnasPorDespacho: [
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "DESBOD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Enero",
                field: "ENERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "FEBRERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Marzo",
                field: "MARZO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Abril",
                field: "ABRIL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mayo",
                field: "MAYO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Junio",
                field: "JUNIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Julio",
                field: "JULIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Agosto",
                field: "AGOSTO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Septiembre",
                field: "SEPTIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Octubre",
                field: "OCTUBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Noviembre",
                field: "NOVIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Diciembre",
                field: "DICIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnas Despacho Detalle
        ColumnasPorDespachoDetalle: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo Bodega",
                field: "S_BODEGA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnas Despacho y Fecha
        ColumnasPorDespachoFecha: [
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Bodega",
                field: "DESBOD",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Enero",
                field: "ENERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "FEBRERO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Marzo",
                field: "MARZO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Abril",
                field: "ABRIL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mayo",
                field: "MAYO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Junio",
                field: "JUNIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Julio",
                field: "JULIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Agosto",
                field: "AGOSTO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Septiembre",
                field: "SEPTIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Octubre",
                field: "OCTUBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Noviembre",
                field: "NOVIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Diciembre",
                field: "DICIEMBRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnas Despacho y Fecha Detalle
        ConsultaPorDespachoFechaDetalle: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Unidad Medida",
                field: "UNIMED",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Precio",
                field: "PRECIO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Despachado",
                field: "D_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Saldo Bodega",
                field: "S_BODEGA",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Datos Columnas Total Plan Anual
        ColumnasTPA: [
            {
                label: "Codigo Articulo",
                field: "CODART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMART",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ENERO",
                field: "C_ENE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Febrero",
                field: "C_FEB",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MARZO",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "ABRIL",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "MAYO",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JUNIO",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "JULIO",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "AGOSTO",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "SEPTIEMBRE",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "OCTUBRE",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "NOVIEMBRE",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "DICIEMBRE",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "C. TOTAL",
                field: "C_TOTAL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Total Plan Anual
        headerTitleTPA: [
            "Codigo Articulo",
            "Descripcion",
            "ENERO",
            "FEBRERO",
            "MARZO",
            "ABRIL",
            "MAYO",
            "JUNIO",
            "JULIO",
            "AGOSTO",
            "SEPTIEMBRE",
            "OCTUBRE",
            "NOVIEMBRE",
            "DICIEMBRE",
            "C. TOTAL",
            "Saldo Bodega",
            "TOTAL"
        ],
        //Detalle Reporte Total Plan Anual
        headerValTPA: [
            "CODART",
            "NOMART",
            "C_ENE",
            "C_FEB",
            "C_MAR",
            "C_ABR",
            "C_MAY",
            "C_JUN",
            "C_JUL",
            "C_AGO",
            "C_SEP",
            "C_OCT",
            "C_NOV",
            "C_DIC",
            "C_TOTAL",
            "S_BODEGA",
            "T_PRECIO"
        ]
    },
    mutations: {},
    actions: {}
});
