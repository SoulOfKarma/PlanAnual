<template>
    <div>
        <vx-card title="Plan de Compra Anual">
            <vx-card>
                <div class="vx-row">
                    <div class="vx-col w-1/3 mt-5">
                        <h6>Servicio</h6>
                        <v-select
                            taggable
                            v-model="seleccionServicio"
                            placeholder="Servicio"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>Seleccione Bodega</h6>
                        <v-select
                            taggable
                            v-model="seleccionBodega"
                            placeholder="Ej. Medicamentos"
                            class="w-full select-large"
                            label="descripcionBodega"
                            :options="listaBodega"
                            @input="CargarListaReprogramaciones"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>Seleccione Reprogramacion</h6>
                        <v-select
                            taggable
                            v-model="seleccionReprogramacion"
                            placeholder="Ej. Medicamentos"
                            class="w-full select-large"
                            label="descripcion"
                            :options="listaReprogramacion"
                            @input="CargarProgramacionEspecifica"
                        ></v-select>
                    </div>
                </div>
            </vx-card>
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
                        :rows="rowsTotalArticulos"
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
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rowsArticulos"
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
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
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
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
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
        Trash2Icon,
        UploadIcon,
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
            fechaAnio: null,
            obs: "",
            val_run: false,
            seleccionServicio: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: "Seleccione Bodega"
            },
            seleccionReprogramacion: {
                id: 0,
                descripcion: "Seleccione Reprogramacion"
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
                    label: "ENE",
                    field: "C_ENE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "FEB",
                    field: "C_FEB",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "MAR",
                    field: "C_MAR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "ABR",
                    field: "C_ABR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "MAY",
                    field: "C_MAY",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "JUN",
                    field: "C_JUN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "JUL",
                    field: "C_JUL",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "AGO",
                    field: "C_AGO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "SEP",
                    field: "C_SEP",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "OCT",
                    field: "C_OCT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "NOV",
                    field: "C_NOV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "DIC",
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
            columnsPresupuesto: [
                {
                    label: "P.Total",
                    field: "P_ANUAL"
                },
                {
                    label: "P.Utilizado",
                    field: "UTILIZADO"
                },
                {
                    label: "P.Restante",
                    field: "RESTANTE"
                }
            ],
            columnsPlanAnualConsumo: [
                {
                    label: "Enero",
                    field: "ENERO",
                    type: "number"
                },
                {
                    label: "Febrero",
                    field: "FEBRERO",
                    type: "number"
                },
                {
                    label: "Marzo",
                    field: "MARZO",
                    type: "number"
                },
                {
                    label: "Abril",
                    field: "ABRIL",
                    type: "number"
                },
                {
                    label: "Mayo",
                    field: "MAYO",
                    type: "number"
                },
                {
                    label: "Junio",
                    field: "JUNIO",
                    type: "number"
                },
                {
                    label: "Julio",
                    field: "JULIO",
                    type: "number"
                },
                {
                    label: "Agosto",
                    field: "AGOSTO",
                    type: "number"
                },
                {
                    label: "Septiembre",
                    field: "SEPTIEMBRE",
                    type: "number"
                },
                {
                    label: "Octubre",
                    field: "OCTUBRE",
                    type: "number"
                },
                {
                    label: "Noviembre",
                    field: "NOVIEMBRE",
                    type: "number"
                },
                {
                    label: "Diciembre",
                    field: "DICIEMBRE",
                    type: "number"
                },
                {
                    label: "Total",
                    field: "TOTAL",
                    type: "number"
                }
            ],
            //Datos Listado Proveedor
            rows: [],
            rowsArticulos: [],
            rowsTotalArticulos: [],
            listadoServicios: [],
            listadoArticulos: [],
            listadoTemporalArticulos: [],
            listaBodega: [],
            listaReprogramacion: [],
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
        limpiarCampos() {
            try {
                let data = 1;
            } catch (error) {
                console.log(error);
            }
        },
        cargarArticulosSegunBodega(idBodega) {
            try {
                let c = this.listadoTemporalArticulos;
                let d = [];
                c.forEach((value, ind) => {
                    if (value.idBodega == idBodega) {
                        d.push(value);
                    }
                });
                this.listadoArticulos = d;
            } catch (error) {
                console.log(error);
            }
        },
        CalculoCantPrecio() {
            try {
                this.precioTotal = 0;
                this.cantidadTotal = 0;
                let preEne = 0;
                let preFeb = 0;
                let preMar = 0;
                let preAbr = 0;
                let preMay = 0;
                let preJun = 0;
                let preJul = 0;
                let preAgo = 0;
                let preSep = 0;
                let preOct = 0;
                let preNov = 0;
                let preDic = 0;

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_ENE);
                preEne = parseInt(this.C_ENE) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_FEB);
                preFeb = parseInt(this.C_FEB) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_MAR);
                preMar = parseInt(this.C_MAR) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_ABR);
                preAbr = parseInt(this.C_ABR) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_MAY);
                preMay = parseInt(this.C_MAY) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_JUN);
                preJun = parseInt(this.C_JUN) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_JUL);
                preJul = parseInt(this.C_JUL) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_AGO);
                preAgo = parseInt(this.C_AGO) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_SEP);
                preSep = parseInt(this.C_SEP) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_OCT);
                preOct = parseInt(this.C_OCT) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_NOV);
                preNov = parseInt(this.C_NOV) * parseInt(this.precio);

                this.cantidadTotal =
                    parseInt(this.cantidadTotal) + parseInt(this.C_DIC);
                preDic = parseInt(this.C_DIC) * parseInt(this.precio);

                this.precioTotal =
                    parseInt(preEne) +
                    parseInt(preFeb) +
                    parseInt(preMar) +
                    parseInt(preAbr) +
                    parseInt(preMay) +
                    parseInt(preJun) +
                    parseInt(preJul) +
                    parseInt(preAgo) +
                    parseInt(preSep) +
                    parseInt(preOct) +
                    parseInt(preNov) +
                    parseInt(preDic);
            } catch (error) {
                console.log(error);
            }
        },
        //Carga de Datos
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
        TraerListadoPresupuestos(NOMSER, idBodega) {
            try {
                let data = {
                    NOMSER: NOMSER,
                    idBodega: idBodega,
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
                        let c = res.data;
                        let d = [];

                        c.forEach((value, ind) => {
                            if (value.PANUALVAL == 0) {
                                this.panualval = 0;
                            } else {
                                this.panualval = value.PANUALVAL;
                                this.topeMaximo = value.RESTANTEVAL;
                                this.valorUtilizado = value.UTILIZADOVAL;
                                if (this.topeMaximo == null) {
                                    this.topeMaximo = value.PANUALVAL;
                                    value.RESTANTE = value.P_ANUAL;
                                }

                                d.push(value);
                            }
                        });

                        this.rows = d;

                        if (this.rows.length < 0) {
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
        TraerArticulosPresupuesto(NOMSER, idBodega, idReprogramado) {
            try {
                let data = {
                    NOMSER: NOMSER,
                    idBodega: idBodega,
                    idReprogramado: idReprogramado,
                    anio: 2023
                };
                axios
                    .post(
                        this.localVal + "/api/PCompra/GetArticulosServReporte",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.rowsArticulos = res.data;
                        if (this.rowsArticulos.length < 0) {
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
        TraerTotalArticulosPresupuesto(NOMSER, idBodega) {
            try {
                let data = {
                    NOMSER: NOMSER,
                    idBodega: idBodega,
                    anio: 2023
                };
                axios
                    .post(
                        this.localVal + "/api/PCompra/GetTotalArticulosServ",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.rowsTotalArticulos = res.data;
                        if (this.rowsTotalArticulos.length < 0) {
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
        TraerUltimoNReprogramado(NOMSER, idBodega) {
            try {
                let data = {
                    NOMSER: NOMSER,
                    idBodega: idBodega,
                    anio: 2023
                };
                axios
                    .post(
                        this.localVal + "/api/PCompra/GetUltimoReprogramado",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        if (
                            res.data == [] ||
                            res.data == null ||
                            res.data.length == 0
                        ) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se cargo el ultimo numero reprogramado",
                                color: "danger",
                                position: "top-right"
                            });
                            this.reprogramacion = null;
                        } else {
                            this.reprogramacion =
                                res.data[0].ultimoReprogramado + 1;
                            console.log(this.reprogramacion);
                        }

                        if (this.reprogramacion < 1) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se cargo el ultimo numero reprogramado",
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
                    .get(
                        this.localVal + "/api/Mantenedor/GetArticulosActivos",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        //this.rows =;
                        let c = res.data;
                        //this.rows = res.data;
                        if (c.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
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
                            this.listadoTemporalArticulos = f;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Este Metodo Asignar la horas por default del formulario inicial.
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                let dat = moment()
                    .endOf("day")
                    .add(1, "y");
                this.fechaPAnual = date.format("DD/MM/YYYY").toString();
                this.fechaAnio = dat.format("YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        },
        CargarListaReprogramaciones() {
            try {
                let dat = {
                    BODEGA: this.seleccionBodega.id,
                    NOMSER: this.seleccionServicio.descripcionServicio
                };

                axios
                    .post(
                        this.localVal + "/api/PCompra/GetListaReprogramaciones",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaReprogramacion = res.data;
                        if (this.listaReprogramacion.length < 1) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text: "No hay lista Existente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        CargarProgramacionEspecifica() {
            try {
                if (this.seleccionServicio == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Seleccionar un Servicio para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionServicio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Seleccionar un Servicio para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionBodega == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Seleccionar una Bodega para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Seleccionar una Bodega para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    this.TraerListadoPresupuestos(
                        this.seleccionServicio.descripcionServicio,
                        this.seleccionBodega.id
                    );
                    this.TraerArticulosPresupuesto(
                        this.seleccionServicio.descripcionServicio,
                        this.seleccionBodega.id,
                        this.seleccionReprogramacion.id
                    );
                    this.TraerTotalArticulosPresupuesto(
                        this.seleccionServicio.descripcionServicio,
                        this.seleccionBodega.id
                    );
                    this.cargarArticulosSegunBodega(this.seleccionBodega.id);
                }
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerServicio();
        this.TraerArticulos();
        this.TraerBodega();
        this.cargarHoras();
        setTimeout(() => {
            //this.TraerUsuarios();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
