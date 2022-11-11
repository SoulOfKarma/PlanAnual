import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        headerTitleReporteUsuario: [
            "Codigo Articulo",
            "Descripcion",
            "Unidad Medida",
            "Precio",
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
            "Cantidad Total",
            "Saldo Bodega",
            "Total"
        ],
        headerValReporteUsuario: [
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
        ]
    },
    mutations: {},
    actions: {}
});
