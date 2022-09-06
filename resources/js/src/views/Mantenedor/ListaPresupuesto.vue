<template>
    <div>
        <vx-card title="Lista Presupuesto">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="popListaPresupuesto"
                    >Agregar Nuevo Presupuesto</vs-button
                >
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
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
                                <plus-circle-icon
                                    content="Modificar Presupuesto"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarPresupuestoAnual(
                                            props.row.id
                                        )
                                    "
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
            <vs-popup
                classContent="Presupuesto"
                title="Agregar Presupuesto"
                :active.sync="popUpListaPresupuesto"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Servicio</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionServicio"
                                    placeholder="Servicio"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionBodega"
                                    placeholder="descripcion"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaBodega"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Año
                                </h6>
                                <datepicker
                                    v-model="anio"
                                    placeholder="Seleccione Año"
                                    :format="DatePickerFormat"
                                    :language="language"
                                    minimum-view="year"
                                    :disabled-dates="disabledDates"
                                ></datepicker>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Monto Presupuesto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="MontoPresupuesto"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Enero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_ENE"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Febrero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_FEB"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Marzo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_MAR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Abril
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_ABR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Mayo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_MAY"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Junio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_JUN"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Julio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_JUL"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Agosto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_AGO"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Septiembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_SEP"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Octubre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_OCT"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Noviembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_NOV"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Diciembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_DIC"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpListaPresupuesto = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarListaPresupuesto"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Presupuesto</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="PresupuestoMod"
                title="Modificar Listado Presupuesto"
                :active.sync="popUpListaPresupuestoMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Servicio</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionServicio"
                                    placeholder="Servicio"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionBodega"
                                    placeholder="descripcion"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaBodega"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Año
                                </h6>
                                <datepicker
                                    v-model="anio"
                                    placeholder="Seleccione Año"
                                    :format="DatePickerFormat"
                                    :language="language"
                                    minimum-view="year"
                                    :disabled-dates="disabledDates"
                                ></datepicker>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Monto Presupuesto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="MontoPresupuesto"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Enero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_ENE"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Febrero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_FEB"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Marzo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_MAR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Abril
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_ABR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Mayo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_MAY"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Junio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_JUN"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Julio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_JUL"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Agosto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_AGO"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Septiembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_SEP"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Octubre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_OCT"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Noviembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_NOV"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Diciembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="P_DIC"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpListaPresupuestoMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarPresupuestoAnual"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Presupuesto</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import moment from "moment";
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import { validate, clean, format } from "rut.js";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import Datepicker from "vuejs-datepicker";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        flatPickr,
        Datepicker
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
            //Configuracion Datepicker Anio
            DatePickerFormat: "yyyy",
            language: {
                language: "Spanish",
                months: [
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
                    "Diciembre"
                ],
                monthsAbbr: [
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
                    "Diciembre"
                ],
                days: [
                    "Lunes",
                    "Martes",
                    "Miercoles",
                    "Jueves",
                    "Viernes",
                    "Sabado",
                    "Domingo"
                ],
                rtl: false,
                ymd: false,
                yearSuffix: ""
            },
            //Fechas Anios Habilitadas
            disabledDates: {},
            //Datos Campos
            popUpListaPresupuesto: false,
            popUpListaPresupuestoMod: false,
            fechaPAnual: null,
            anio: "",
            P_ENE: 0,
            P_FEB: 0,
            P_MAR: 0,
            P_ABR: 0,
            P_MAY: 0,
            P_JUN: 0,
            P_JUL: 0,
            P_AGO: 0,
            P_SEP: 0,
            P_OCT: 0,
            P_NOV: 0,
            P_DIC: 0,
            idMod: 0,
            idServicio: 0,
            MontoPresupuesto: 0,
            val_run: false,
            seleccionServicio: {
                id: 1,
                descripcionServicio: "MEDICINA-CIRUGIA"
            },
            seleccionBodega: {
                id: 1,
                descripcion: "Farmacia"
            },
            //Configuracion Horas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: null,
                allowInput: true,
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
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Año",
                    field: "anio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Bodega",
                    field: "bodega",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Presupuesto Anual",
                    field: "panual",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Enero",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Febrero",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Marzo",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Abril",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Mayo",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Junio",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Julio",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Agosto",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Septiembre",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Octubre",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Noviembre",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Diciembre",
                    field: "descripcionServicio",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado Proveedor
            rows: [],
            listadoServicios: [],
            listaBodega: [
                {
                    id: 1,
                    descripcion: "Farmacia"
                },
                {
                    id: 2,
                    descripcion: "Economato"
                },
                {
                    id: 3,
                    descripcion: "Ortesis"
                },
                {
                    id: 4,
                    descripcion: "Combustible"
                },
                {
                    id: 5,
                    descripcion: "Textiles"
                },
                {
                    id: 6,
                    descripcion: "Material de Construccion"
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
            this.fechaPAnual = dateStr;
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
        /* formatear_run() {
            if (this.run_usuario == "" || this.run_usuario == null) {
                this.val_run = false;
            } else {
                this.run_usuario = format(this.run_usuario);
                this.val_run = !validate(this.run_usuario);
            }
        }, */
        limpiarCampos() {
            try {
                let data = 1;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popListaPresupuesto() {
            try {
                this.popUpListaPresupuesto = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarPresupuestoAnual(id) {
            try {
                let dato = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //Carga de Datos
        TraerServicio() {
            try {
                axios
                    .get(this.siabVal + "/api/Mantenedor/GetServicios", {
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
        TraerListadoPresupuestos() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Mantenedor/GetListadoPresupuestos",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
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
        //Metodos para Agregar Datos
        AgregarListaPresupuesto() {
            try {
                if (anio == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un Año",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionServicio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un Servicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una Bodega",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.MontoPresupuesto < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_ENE < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de enero debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_FEB < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Febrero debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_MAR < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Marzo debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_ABR < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Abril debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_MAY < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Mayo debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_JUN < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Junio debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_JUL < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Julio debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_AGO < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Agosto debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_SEP < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Septiembre debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_OCT < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Octubre debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_NOV < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Noviembre debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.P_DIC < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto de Diciembre debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        anio: this.anio,
                        NOMSER: this.seleccionServicio.descripcionServicio,
                        BODEGA: this.seleccionBodega.id,
                        P_ANUAL: this.MontoPresupuesto
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostPresupuesto",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Presupuesto Registrado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpListaPresupuesto = false;
                                this.TraerListadoPresupuestos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el presupuesto,intentelo nuevamente",
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
        ModificarPresupuestoAnual() {
            try {
                let d = true;
                if (d == false) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Error",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PutListaPresupuesto",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Presupuesto Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpListaPresupuestoMod = false;
                                this.TraerPresupuesto();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar el Presupuesto,intentelo nuevamente",
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
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaPAnual = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        },
        cargarAnios() {
            let ini = moment("2014-02-27T10:00:00").endOf("day");
            let end = moment("2014-02-27").endOf("day");
            this.disabledDates = {
                to: moment("2014-02-27").toDate(),
                from: moment()
                    .add(1, "years")
                    .toDate()
            };
            /*this.disabledDates = {
                from: end.format("DD/MM/YYYY").toString(),
                to: ini.format("DD/MM/YYYY").toString()
                 ranges: [
                    {
                        // Disable dates in given ranges (exclusive).
                        from: end.format("DD/MM/YYYY").toString(),
                        to: ini.format("DD/MM/YYYY").toString()
                    }
                ] 
            };*/
        }
    },
    beforeMount() {
        this.TraerServicio();
        this.cargarAnios();
        setTimeout(() => {
            //this.TraerUsuarios();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="scss"></style>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
