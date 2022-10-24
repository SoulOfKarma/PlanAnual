<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Reportes">
                <vs-prompt
                    title="Exportar a Excel"
                    class="export-options"
                    @cancle="clearFields"
                    @accept="exportToExcel"
                    accept-text="Export"
                    @close="clearFields"
                    :active.sync="activePrompt"
                >
                    <vs-input
                        v-model="fileName"
                        placeholder="Escriba el nombre del archivo..."
                        class="w-full"
                    />
                    <v-select
                        v-model="selectedFormat"
                        :options="formats"
                        class="my-4"
                    />
                    <div class="flex">
                        <span class="mr-4">Cell Auto Width:</span>
                        <vs-switch v-model="cellAutoWidth"
                            >Cell Auto Width</vs-switch
                        >
                    </div>
                </vs-prompt>
                <div class="vx-row mb-12">
                    <div class="vx-col w-full mt-5">
                        <vs-button @click="activePrompt = true"
                            >Exportar</vs-button
                        >
                    </div>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <div class="vx-col w-full mt-5">
                        <h6>Seleccione Reporte</h6>
                        <br />
                        <v-select
                            taggable
                            v-model="seleccionReporte"
                            placeholder="Ej. Despacho Por Servicio Mensual"
                            class="w-full select-large"
                            label="descripcionReporte"
                            :options="listadoReportes"
                            @input="GetReporteEspecifico"
                        ></v-select>
                    </div>
                </div>
                <!-- Resumen Item Pre -->
                <div class="vx-row" v-if="resumenitempre"></div>
                <!-- Resumen Item Pre Servicio -->
                <div class="vx-row" v-if="resumenitempreServicio"></div>
                <br />
                <!-- Lista Tabla Segun Reporte -->
                <div class="vx-row" v-if="validadorLista">
                    <vue-good-table
                        class="w-full"
                        :columns="column"
                        :rows="listadoGeneral"
                        :pagination-options="{
                            enabled: true,
                            perPage: 10
                        }"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <span v-else-if="props.column.field === 'action'">
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </vx-card>
        </div>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import router from "@/router";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
//import store from "./store.js";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        flatPickr
    },
    data() {
        return {
            localVal: process.env.MIX_APP_URL,
            siabVal: process.env.MIX_APP_URL_API_SIAB,
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            //Datos Generales
            resumenitempre: false,
            resumenitempreServicio: false,
            solicitudpdb: false,
            despachopadbt: false,
            validadorLista: false,
            seleccionReporte: {
                id: 0,
                descripcionReporte: "Ej. Despacho Por Servicio Mensual"
            },
            seleccionServicio: {
                id: 1,
                descripcionServicio: "MEDICINA-CIRUGIA"
            },
            seleccionMes: {
                id: 0,
                descripcionMes: "Seleccione Mes"
            },
            seleccionBodega: {
                id: 1,
                descripcionBodega: "Medicamentos"
            },
            //Datos para Exportar
            fileName: "",
            formats: ["xlsx", "csv", "txt"],
            cellAutoWidth: true,
            selectedFormat: "xlsx",
            headerTitle: [],
            headerVal: [],
            activePrompt: false,
            //Datos Fechas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: "today",
                dateFormat: "d/m/Y",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configTodateTimePicker: {
                minDate: "today",
                maxDate: null,
                dateFormat: "d/m/Y",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configdateTimePicker: {
                enableTime: false,
                //enableSeconds: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            configdateToTimePicker: {
                enableTime: false,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            //Listados de datos
            rows: [],
            column: [],
            listadoGeneral: [],
            listadoServicios: [],
            listaBodega: [],
            listadoReportes: [
                {
                    id: 1,
                    descripcionReporte: "Resumen Item Presupuestario"
                },
                {
                    id: 2,
                    descripcionReporte:
                        "Resumen Item Presupuestario Por Servicio"
                }
            ],
            listadoMes: [
                {
                    id: 1,
                    descripcionMes: "Enero"
                },
                {
                    id: 2,
                    descripcionMes: "Febrero"
                },
                {
                    id: 3,
                    descripcionMes: "Marzo"
                },
                {
                    id: 4,
                    descripcionMes: "Abril"
                },
                {
                    id: 5,
                    descripcionMes: "Mayo"
                },
                {
                    id: 6,
                    descripcionMes: "Junio"
                },
                {
                    id: 7,
                    descripcionMes: "Julio"
                },
                {
                    id: 8,
                    descripcionMes: "Agosto"
                },
                {
                    id: 9,
                    descripcionMes: "Septiembre"
                },
                {
                    id: 10,
                    descripcionMes: "Octubre"
                },
                {
                    id: 11,
                    descripcionMes: "Noviembre"
                },
                {
                    id: 12,
                    descripcionMes: "Diciembre"
                }
            ]
        };
    },
    methods: {
        //Datos Generales
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        exportToExcel() {
            import("@/vendor/Export2Excel").then(excel => {
                const list = this.listadoGeneral;
                const data = this.formatJson(this.headerVal, list);
                excel.export_json_to_excel({
                    header: this.headerTitle,
                    data,
                    filename: this.fileName,
                    autoWidth: this.cellAutoWidth,
                    bookType: this.selectedFormat
                });
                this.clearFields();
            });
        },
        formatJson(filterVal, jsonData) {
            return jsonData.map(v =>
                filterVal.map(j => {
                    // Add col name which needs to be translated
                    // if (j === 'timestamp') {
                    //   return parseTime(v[j])
                    // } else {
                    //   return v[j]
                    // }
                    return v[j];
                })
            );
        },
        clearFields() {
            this.filename = "";
            this.cellAutoWidth = true;
            this.selectedFormat = "xlsx";
        },
        GetReporteEspecifico() {
            try {
                //resumenitempre
                if (this.seleccionReporte.id == 1) {
                    this.resumenitempre = true;
                    this.resumenitempreServicio = false;
                    this.solicitudpdb = false;
                    this.despachopadbt = false;
                    this.validadorLista = true;
                    this.column = [
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
                    ];
                    this.CargarResumenItemPresupuestario();
                } else if (this.seleccionReporte.id == 2) {
                    this.resumenitempre = false;
                    this.resumenitempreServicio = true;
                    this.solicitudpdb = false;
                    this.despachopadbt = false;
                    this.validadorLista = true;
                    this.column = [
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
                    ];
                    this.CargarResumenItemPresupuestarioServicio();
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Traer Datos por API
        TraerServicio() {
            try {
                axios
                    .get(this.siabVal + "/api/Mantenedor/GetServiciosActivos", {
                        headers: {
                            Authorization:
                                `Bearer ` +
                                sessionStorage.getItem("token_externo")
                        }
                    })
                    .then(res => {
                        this.listadoServicios = res.data;
                        if (this.listadoServicios.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerBodega() {
            try {
                axios
                    .get(this.siabVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` +
                                sessionStorage.getItem("token_externo")
                        }
                    })
                    .then(res => {
                        this.listaBodega = res.data;
                        if (this.listaBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de las Bodegas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        CargarResumenItemPresupuestario() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteItemPresupuestario",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        CargarResumenItemPresupuestarioServicio() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteItemPresupuestarioServicios",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        setTimeout(() => {
            this.TraerBodega();
            this.TraerServicio();
            //this.TraerUsuarios();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="scss"></style>
