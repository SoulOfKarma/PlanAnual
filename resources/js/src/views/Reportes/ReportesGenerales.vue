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
                <!-- Despacho por Servicio Mensual -->
                <div class="vx-row" v-if="despachomes">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Mes</h6>
                        <v-select
                            taggable
                            v-model="seleccionMes"
                            placeholder="Ej. Enero"
                            class="w-full select-large"
                            label="descripcionMes"
                            :options="listadoMes"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Bodega</h6>
                        <v-select
                            taggable
                            v-model="seleccionBodega"
                            placeholder="Ej. Medicamentos"
                            class="w-full select-large"
                            label="descripcionBodega"
                            :options="listaBodega"
                        ></v-select>
                    </div>
                    <div class="vx-col w-full mt-5">
                        <h6>.</h6>
                        <vs-button
                            @click="CargaDespachoSM"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Despacho Plan Anual V/S Despacho Bodega -->
                <div class="vx-row" v-if="despachopab">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Mes</h6>
                        <v-select
                            taggable
                            v-model="seleccionMes"
                            placeholder="Ej. Enero"
                            class="w-full select-large"
                            label="descripcionMes"
                            :options="listadoMes"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Bodega</h6>
                        <v-select
                            taggable
                            v-model="seleccionBodega"
                            placeholder="Ej. Medicamentos"
                            class="w-full select-large"
                            label="descripcionBodega"
                            :options="listaBodega"
                        ></v-select>
                    </div>
                    <div class="vx-col w-full mt-5">
                        <h6>.</h6>
                        <vs-button
                            @click="CargaDespachoPADB"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
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
import store from "./store.js";
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
            despachomes: false,
            despachopab: false,
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
                            "Mi??rcoles",
                            "Jueves",
                            "Viernes",
                            "S??bado"
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
                            "??ct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "??arzo",
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
                            "Mi??rcoles",
                            "Jueves",
                            "Viernes",
                            "S??bado"
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
                            "??ct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "??arzo",
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
                    descripcionReporte: "Despacho Por Servicio Mensual"
                },
                {
                    id: 2,
                    descripcionReporte:
                        "Despacho Plan Anual V/S Despacho Bodega"
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
        cargaServicioBodega() {
            try {
                let c = this.listadoServicios;
                c.forEach((value, ind) => {
                    if (
                        value.descripcionServicio ==
                        sessionStorage.getItem("NOMSER")
                    ) {
                        this.seleccionServicio.id = value.id;
                        this.seleccionServicio.descripcionServicio =
                            value.descripcionServicio;
                    }
                });

                c = [];
                c = this.listaBodega;
                c.forEach((value, ind) => {
                    if (value.id == sessionStorage.getItem("idBodega")) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });
            } catch (error) {
                console.log();
            }
        },
        GetReporteEspecifico() {
            try {
                //despachomes
                if (this.seleccionReporte.id == 1) {
                    this.despachomes = true;
                    this.despachopab = false;
                    this.validadorLista = true;
                    this.listadoGeneral = [];
                    this.column = [
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
                            label: "Solicitado",
                            field: "SOLART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Despachado",
                            field: "DESART",
                            filterOptions: {
                                enabled: true
                            }
                        }
                    ];
                    this.headerVal = store.state.headerValDSM;
                    this.headerTitle = store.state.headerTitleDSM;
                } else if (this.seleccionReporte.id == 2) {
                    this.despachomes = false;
                    this.despachopab = true;
                    this.validadorLista = true;
                    this.listadoGeneral = [];
                    this.column = [
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
                            label: "Solicitado",
                            field: "SOLART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Despachado",
                            field: "DESART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "01",
                            field: "DAY1",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "02",
                            field: "DAY2",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "03",
                            field: "DAY3",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "04",
                            field: "DAY4",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "05",
                            field: "DAY5",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "06",
                            field: "DAY6",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "07",
                            field: "DAY7",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "08",
                            field: "DAY8",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "09",
                            field: "DAY9",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "10",
                            field: "DAY10",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "11",
                            field: "DAY11",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "12",
                            field: "DAY12",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "13",
                            field: "DAY13",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "14",
                            field: "DAY14",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "15",
                            field: "DAY15",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "16",
                            field: "DAY16",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "17",
                            field: "DAY17",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "18",
                            field: "DAY18",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "19",
                            field: "DAY19",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "20",
                            field: "DAY20",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "21",
                            field: "DAY21",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "22",
                            field: "DAY22",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "23",
                            field: "DAY23",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "24",
                            field: "DAY24",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "25",
                            field: "DAY25",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "26",
                            field: "DAY26",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "27",
                            field: "DAY27",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "28",
                            field: "DAY28",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "29",
                            field: "DAY29",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "30",
                            field: "DAY30",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "31",
                            field: "DAY31",
                            filterOptions: {
                                enabled: true
                            }
                        }
                    ];
                    this.headerVal = store.state.headerValDPADB;
                    this.headerTitle = store.state.headerTitleDPADB;
                }
            } catch (error) {
                console.log(error);
            }
        },
        CargaDespachoSM() {
            try {
                if (this.seleccionMes.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un mes para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        mes: this.seleccionMes.id,
                        NOMSER: sessionStorage.getItem("NOMSER"),
                        BODEGA: this.seleccionBodega.id
                    };
                    axios
                        .post(
                            this.localVal + "/api/Reportes/ReporteDSM",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.rows =;
                            this.listadoGeneral = res.data;
                            if (this.listadoGeneral.length < 0) {
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        CargaDespachoPADB() {
            try {
                if (this.seleccionMes.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un mes para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        mes: this.seleccionMes.id,
                        NOMSER: sessionStorage.getItem("NOMSER"),
                        BODEGA: this.seleccionBodega.id
                    };
                    axios
                        .post(
                            this.localVal + "/api/Reportes/ReporteDPADB",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            //this.rows =;
                            this.listadoGeneral = res.data;
                            if (this.listadoGeneral.length < 0) {
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
                        let c = res.data;
                        let valor = 0;

                        let nombre = "";
                        let d = [];
                        c.forEach((val, index) => {
                            if (valor == 0) {
                                d.push(val);
                                valor = 1;
                                nombre = val.descripcionServicio;
                            } else if (nombre != val.descripcionServicio) {
                                d.push(val);
                                nombre = "";
                                nombre = val.descripcionServicio;
                            }
                        });

                        this.listadoServicios = d;
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
        }
    },
    beforeMount() {
        this.TraerBodega();
        this.TraerServicio();
        setTimeout(() => {
            this.cargaServicioBodega();
            //this.TraerUsuarios();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="scss"></style>
