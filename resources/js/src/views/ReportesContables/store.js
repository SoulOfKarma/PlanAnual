import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        //Datos Columnas Resumen Item Presupuestario
        ColumnasIP: [
            {
                label: "Codigo Item",
                field: "CODIPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBREIPRE",
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
                label: "TOTAL",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Resumen Item Presupuestario
        headerTitleIP: [
            "Codigo Item",
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
            "TOTAL"
        ],
        //Detalle Reporte Resumen Item Presupuestario
        headerValIP: [
            "CODIPRE",
            "NOMBREIPRE",
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
            "T_PRECIO"
        ],
        //Detalle Reporte Resumen Item Presupuestario Por Servicio
        ColumnasRIPS: [
            {
                label: "Servicio",
                field: "NOMSER",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Codigo Item",
                field: "CODIPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Descripcion",
                field: "NOMBREIPRE",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Enero",
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
                label: "Marzo",
                field: "C_MAR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Abril",
                field: "C_ABR",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Mayo",
                field: "C_MAY",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Junio",
                field: "C_JUN",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Julio",
                field: "C_JUL",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Agosto",
                field: "C_AGO",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Septiembre",
                field: "C_SEP",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Octubre",
                field: "C_OCT",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Noviembre",
                field: "C_NOV",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Diciembre",
                field: "C_DIC",
                filterOptions: {
                    enabled: true
                }
            },
            {
                label: "Total",
                field: "T_PRECIO",
                filterOptions: {
                    enabled: true
                }
            }
        ],
        //Cabecera Reporte Resumen Item Presupuestario Por Servicio
        headerTitleIPS: [
            "Servicio",
            "Codigo Item",
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
            "TOTAL"
        ],
        //Detalle Reporte Resumen Item Presupuestario Por Servicio
        headerValIPS: [
            "NOMSER",
            "CODIPRE",
            "NOMBREIPRE",
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
            "T_PRECIO"
        ]
    },
    mutations: {},
    actions: {}
});
