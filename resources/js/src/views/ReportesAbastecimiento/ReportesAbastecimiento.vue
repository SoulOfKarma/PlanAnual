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
                <!-- Consolidado -->
                <div class="vx-row" v-if="consolidado">
                    <div class="vx-col w-full mt-5">
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
                            @click="CargaConsolidadoByBodega"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Consolidado V/S Despacho Bodega -->
                <div class="vx-row" v-if="consolidadodesp">
                    <div class="vx-col w-full mt-5">
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
                            @click="CargaConsolidadoDespachadoByBodega"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Total Mensual -->
                <div class="vx-row" v-if="totalMensual">
                    <div class="vx-col w-full mt-5">
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
                            @click="CargaTotalPorServicio"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Consulta por Servicio -->
                <div class="vx-row" v-if="consultaServicio">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Servicio</h6>
                        <v-select
                            taggable
                            v-model="seleccionServicio"
                            placeholder="Ej. Abastecimeinto"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
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
                            @click="cargaConsultaxServicio"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Consulta por Servicio por Despacho-->
                <div class="vx-row" v-if="consultaServicioDesp">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Servicio</h6>
                        <v-select
                            taggable
                            v-model="seleccionServicio"
                            placeholder="Ej. Abastecimeinto"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
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
                            @click="cargaConsultaxServicioDetalle"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Consulta por Servicio por Despacho Fecha -->
                <div class="vx-row" v-if="consultaServicioDespFecha">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Seleccione Servicio</h6>
                        <v-select
                            taggable
                            v-model="seleccionServicio"
                            placeholder="Ej. Abastecimeinto"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
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
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Fecha Inicio</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaInicio"
                            placeholder="Fecha Inicio"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>Fecha Termino</h6>
                        <flat-pickr
                            :config="configTodateTimePicker"
                            v-model="fechaTermino"
                            placeholder="Fecha Termino"
                            @on-change="onToChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-full mt-5">
                        <h6>.</h6>
                        <vs-button
                            @click="cargaConsultaxServicioDetalleFecha"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar</vs-button
                        >
                    </div>
                </div>
                <!-- Lista Plan Anual -->
                <div class="vx-row" v-if="listapanual"></div>
                <!-- Consulta por Articulo -->
                <div class="vx-row" v-if="consultaporArticulo"></div>
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
                <br />
                <!-- Lista Tabla Segun Reporte Detalle -->
                <div class="vx-row" v-if="validadorListaDetalle">
                    <vue-good-table
                        class="w-full"
                        :columns="columnDetalle"
                        :rows="listadoGeneralDetalle"
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
            consolidado: false,
            fechaInicio: null,
            fechaTermino: null,
            consolidadodesp: false,
            totalMensual: false,
            consultaServicio: false,
            consultaServicioDesp: false,
            consultaServicioDespFecha: false,
            listapanual: false,
            consultaporArticulo: false,
            validadorLista: false,
            validadorListaDetalle: false,
            seleccionReporte: {
                id: 0,
                descripcionReporte: "Ej. Consolidado"
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
            columnDetalle: [],
            listadoGeneral: [],
            listadoGeneralDetalle: [],
            listadoServicios: [],
            listaBodega: [],
            listadoReportes: [
                {
                    id: 1,
                    descripcionReporte: "Consolidado"
                },
                {
                    id: 2,
                    descripcionReporte: "Consolidado v/s Despacho"
                },
                {
                    id: 3,
                    descripcionReporte: "Total Mensual"
                },
                {
                    id: 4,
                    descripcionReporte: "Consulta por Servicio"
                },
                {
                    id: 5,
                    descripcionReporte: "Consulta por despacho "
                },
                {
                    id: 6,
                    descripcionReporte: "Consulta por despacho y fecha"
                },
                {
                    id: 7,
                    descripcionReporte: "Lista plan Anual"
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
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
        },
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
        cargaConsultaxServicio() {
            try {
                this.CargaConsolidadoPorServicio();
                this.CargaConsolidadoPorServicioDetalle();
            } catch (error) {
                console.log(error);
            }
        },
        cargaConsultaxServicioDetalle() {
            try {
                this.CargaConsolidadoPorServicio();
                this.CargaConsolidadoPorServicioDespachoDetalle();
            } catch (error) {
                console.log(error);
            }
        },
        cargaConsultaxServicioDetalleFecha() {
            try {
                this.CargaConsolidadoPorServicio();
                this.CargaConsolidadoPorServicioDespachoDetalleFecha();
            } catch (error) {
                console.log(error);
            }
        },
        cargaServicioBodega() {
            try {
                let c = this.listadoServicios;
                c.forEach((value, ind) => {
                    if (value.id == sessionStorage.getItem("idServicio")) {
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
                //consolidado
                if (this.seleccionReporte.id == 1) {
                    this.consolidado = true;
                    this.consolidadodesp = false;
                    this.totalMensual = false;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = false;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
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
                    ];
                } else if (this.seleccionReporte.id == 2) {
                    this.consolidado = false;
                    this.consolidadodesp = true;
                    this.totalMensual = false;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
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
                    ];
                } else if (this.seleccionReporte.id == 3) {
                    this.consolidado = false;
                    this.consolidadodesp = false;
                    this.totalMensual = true;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = false;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
                    this.column = [
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
                    ];
                } else if (this.seleccionReporte.id == 4) {
                    this.consolidado = false;
                    this.consolidadodesp = false;
                    this.totalMensual = false;
                    this.consultaServicio = true;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = true;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
                    this.column = [
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
                    ];
                    this.columnDetalle = [
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
                    ];
                } else if (this.seleccionReporte.id == 5) {
                    this.consolidado = false;
                    this.consolidadodesp = false;
                    this.totalMensual = false;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = true;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = true;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
                    this.column = [
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
                    ];
                    this.columnDetalle = [
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
                    ];
                } else if (this.seleccionReporte.id == 6) {
                    this.consolidado = false;
                    this.consolidadodesp = false;
                    this.totalMensual = false;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = true;
                    this.listapanual = false;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = true;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
                    this.column = [
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
                    ];
                    this.columnDetalle = [
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
                    ];
                } else if (this.seleccionReporte.id == 7) {
                    this.consolidado = false;
                    this.consolidadodesp = false;
                    this.totalMensual = false;
                    this.consultaServicio = false;
                    this.consultaServicioDesp = false;
                    this.consultaServicioDespFecha = false;
                    this.listapanual = true;
                    this.consultaporArticulo = false;
                    this.validadorLista = true;
                    this.validadorListaDetalle = false;
                    this.listadoGeneral = [];
                    this.listadoGeneralDetalle = [];
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
                    ];
                    this.CargaConsolidadoTotal();
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
        CargaConsolidadoByBodega() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteConsolidado",
                        data,
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
        CargaConsolidadoDespachadoByBodega() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteConsolidadoDespachado",
                        data,
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
        CargaTotalPorServicio() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteTotalServicio",
                        data,
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
        CargaConsolidadoPorServicio() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id,
                    idServicio: this.seleccionServicio.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteTotalByServicio",
                        data,
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
        CargaConsolidadoPorServicioDetalle() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id,
                    idServicio: this.seleccionServicio.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteConsolidadoPorServicio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneralDetalle = res.data;
                        if (this.listadoGeneralDetalle.length < 0) {
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
        CargaConsolidadoPorServicioDespachoDetalle() {
            try {
                let data = {
                    idBodega: this.seleccionBodega.id,
                    idServicio: this.seleccionServicio.id
                };
                axios
                    .post(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteConsolidadoPorServicioDespachado",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneralDetalle = res.data;
                        if (this.listadoGeneralDetalle.length < 0) {
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
        CargaConsolidadoPorServicioDespachoDetalleFecha() {
            try {
                if (this.fechaInicio == null || this.fechaInicio == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de inicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.fechaTermino == null ||
                    this.fechaTermino == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de termino",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        idBodega: this.seleccionBodega.id,
                        idServicio: this.seleccionServicio.id,
                        fechaInicio: moment(
                            this.fechaInicio,
                            "DD-MM-YYYY"
                        ).format("YYYY-MM-DD"),
                        fechaTermino: moment(
                            this.fechaTermino,
                            "DD-MM-YYYY"
                        ).format("YYYY-MM-DD")
                    };
                    axios
                        .post(
                            this.localVal +
                                "/api/RAbastecimiento/ReporteConsolidadoPorServicioDespachadoFecha",
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
                            this.listadoGeneralDetalle = res.data;
                            if (this.listadoGeneralDetalle.length < 0) {
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
                }
            } catch (error) {
                console.log(error);
            }
        },
        CargaConsolidadoTotal() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/RAbastecimiento/ReporteConsolidadoCompleto",
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
