<template>
    <div>
        <vx-card title="Plan de Compra Anual">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="popArticulosPAnual"
                    >Agregar Articulos</vs-button
                >
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columnsPresupuesto"
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
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columnsPlanAnualConsumo"
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
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
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
                                    @click="popModificarPlanAnual(props.row.id)"
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
                classContent="AgregarArticulo"
                title="Agregar Articulo"
                :active.sync="popUpAgregarArticulo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                :columns="columns"
                                :rows="listadoArticulos"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Vista"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popAgregarConsumoMensual(
                                                    props.row.id,
                                                    props.row.CODART,
                                                    props.row.NOMBRE,
                                                    props.row.UNIMED,
                                                    props.row.PRECIO
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="AgregarConsumoPAnual"
                title="Plan Anual Articulo"
                :active.sync="popUpAgregarArticuloPAnual"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Total Anual: {{ precio }} Articulo:
                                    {{ codart }} Descripcion:
                                    {{ nombre }} Unidad Medida
                                    {{ unimed }} Precio {{ precio }}
                                </h6>
                                <br />
                            </div>
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
                                <h6>Fecha Inicio</h6>
                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaPAnual"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
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
                                    v-model="C_ENE"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Febrero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_FEB"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Marzo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Abril
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_ABR"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Mayo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAY"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Junio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUN"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Julio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUL"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Agosto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_AGO"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Septiembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_SEP"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Octubre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_OCT"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Noviembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_NOV"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Diciembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_DIC"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="VolverListaArticulos()"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarPlanAnual"
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
            //Datos Campos
            popUpAgregarArticulo: false,
            popUpAgregarArticuloPAnual: false,
            popUpAgregarArticuloMod: false,
            fechaPAnual: null,
            idArticulo: "",
            codart: "",
            nombre: "",
            unimed: "",
            precio: "",
            C_ENE: 0,
            C_FEB: 0,
            C_MAR: 0,
            C_ABR: 0,
            C_MAY: 0,
            C_JUN: 0,
            C_JUL: 0,
            C_AGO: 0,
            C_SEP: 0,
            C_OCT: 0,
            C_NOV: 0,
            C_DIC: 0,
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
                    label: "Codigo Articulo",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion",
                    field: "NOMBRE",
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
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            columnsPresupuesto: [
                {
                    label: "P.Enero",
                    field: "P_ENE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Febrero",
                    field: "P_FEB",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Marzo",
                    field: "P_MAR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Abril",
                    field: "P_ABR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Mayo",
                    field: "P_MAY",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Junio",
                    field: "P_JUN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Julio",
                    field: "P_JUL",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Agosto",
                    field: "P_AGO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Septiembre",
                    field: "P_SEP",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Octubre",
                    field: "P_OCT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Noviembre",
                    field: "P_NOV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Diciembre",
                    field: "P_DIC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "P.Total",
                    field: "P_ANUAL",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            columnsPlanAnualConsumo: [
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
                    field: "C_TOTAL",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            //Datos Listado Proveedor
            rows: [],
            listadoServicios: [],
            listadoArticulos: [],
            listaBodega: [
                {
                    id: 1,
                    descripcion: "Farmacia"
                },
                {
                    id: 2,
                    descripcion: "Economato"
                }
            ],
            listaEstado: [
                {
                    id: 1,
                    descripcion: "Activo"
                },
                {
                    id: 2,
                    descripcion: "Pasivo"
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
        limpiarCampos() {
            try {
                let data = 1;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popArticulosPAnual() {
            try {
                this.popUpAgregarArticulo = true;
                this.popUpAgregarArticuloPAnual = false;
            } catch (error) {
                console.log(error);
            }
        },
        VolverListaArticulos() {
            try {
                this.popUpAgregarArticulo = true;
                this.popUpAgregarArticuloPAnual = false;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarPlanAnual(id) {
            try {
                let dato = 0;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarConsumoMensual(id, codart, nombre, unimed, precio) {
            try {
                this.idArticulo = id;
                this.codart = codart;
                this.nombre = nombre;
                this.unimed = unimed;
                this.precio = precio;
                this.popUpAgregarArticulo = false;
                this.popUpAgregarArticuloPAnual = true;
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
                let data = {
                    idServicio: 1,
                    idBodega: 3,
                    anio: 2023
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetPresupuestoByServBodega",
                        data,
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
        TraerArticulos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetArticulos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        //this.rows =;
                        let c = res.data;
                        //this.rows = res.data;
                        if (c.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let d = this.listaEstado;
                            let f = [];
                            c.forEach((value, ind) => {
                                d.forEach((val, index) => {
                                    if (value.idEstado == val.id) {
                                        value.descripcionEstado =
                                            val.descripcion;
                                        f.push(value);
                                    }
                                });
                            });

                            this.listadoArticulos = f;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos para Agregar Datos
        AgregarListaPresupuesto() {
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
                        dato: 1
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
                                this.popUpAgregarArticulo = false;
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
        ModificarPlanAnual() {
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
                                this.popUpAgregarArticuloMod = false;
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
        }
    },
    beforeMount() {
        this.TraerServicio();
        setTimeout(() => {
            this.TraerListadoPresupuestos();
            this.TraerArticulos();
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
