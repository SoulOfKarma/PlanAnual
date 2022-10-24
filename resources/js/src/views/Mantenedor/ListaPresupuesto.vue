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
                                            props.row.id,
                                            props.row.NOMSER,
                                            props.row.ANIO,
                                            props.row.P_ANUAL2
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Eliminar Presupuesto"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popEliminarPresupuestoAnual(
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
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Monto Presupuesto
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="MontoPresupuesto"
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
                            <div class="vx-col w-full mt-5">
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
            <vs-popup
                classContent="Presupuesto"
                title="Eliminar Presupuesto"
                :active.sync="popUpListaPresupuestoDel"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpListaPresupuestoDel = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="EliminarPresupuestoAnual"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Eliminar Presupuesto</vs-button
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
            popUpListaPresupuestoDel: false,
            fechaPAnual: null,
            anio: null,
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
                    field: "aniofiltrado",
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
                    label: "Presupuesto Anual",
                    field: "P_ANUAL",
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
                this.idMod = 0;
                this.anio = null;
                this.seleccionServicio = {
                    id: 1,
                    descripcionServicio: "MEDICINA-CIRUGIA"
                };
                this.seleccionBodega = {
                    id: 1,
                    descripcion: "Farmacia"
                };
                this.MontoPresupuesto = 0;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarPresupuestoAnual(id, NOMSER, ANIO, P_ANUAL) {
            try {
                this.popUpListaPresupuestoMod = true;
                this.idMod = id;
                this.anio = ANIO;
                let idServicio = NOMSER;
                this.MontoPresupuesto = P_ANUAL;

                let c = this.listadoServicios;
                c.forEach((value, ind) => {
                    if (value.id == idServicio) {
                        this.seleccionServicio.id = value.id;
                        this.seleccionServicio.descripcionServicio =
                            value.descripcionServicio;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        popEliminarPresupuestoAnual(id) {
            try {
                this.popUpListaPresupuestoDel = true;
                this.idMod = id;
            } catch (error) {
                console.log(error);
            }
        },
        //Carga de Datos
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
        TraerListadoPresupuestos() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Mantenedor/GetPresupuestosFormato",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        //this.rows =;
                        let listado = res.data;
                        if (listado.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = listado;
                            let d = this.listadoServicios;
                            let g = [];

                            c.forEach((value, ind) => {
                                d.forEach((vals, ind) => {
                                    if (vals.id == value.NOMSER) {
                                        value.descripcionServicio =
                                            vals.descripcionServicio;
                                        value.aniofiltrado = moment(value.ANIO)
                                            .format("YYYY")
                                            .toString();
                                        g.push(value);
                                    }
                                });
                            });

                            this.rows = g;

                            //c.forEach((value, ind) => {});
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos para Agregar Datos
        AgregarListaPresupuesto() {
            try {
                let c = this.rows;
                let validador = false;

                c.forEach((value, ind) => {
                    if (value.NOMSER == this.seleccionServicio.id) {
                        validador = true;
                    }
                });

                if (this.anio == null) {
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
                } else if (this.MontoPresupuesto < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (validador) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto ya ingreso a este servicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        ANIO: this.anio,
                        NOMSER: this.seleccionServicio.id,
                        P_ANUAL: this.MontoPresupuesto
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PostPresupuestoAnual",
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
                if (this.anio == null) {
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
                } else if (this.MontoPresupuesto < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        ANIO: this.anio,
                        NOMSER: this.seleccionServicio.id,
                        P_ANUAL: this.MontoPresupuesto
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PutPresupuestoAnual",
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
                                this.TraerListadoPresupuestos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible Modificar el presupuesto,intentelo nuevamente",
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
        EliminarPresupuestoAnual() {
            try {
                let data = {
                    id: this.idMod
                };

                const dat = data;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/DeletePresupuestoAnual",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                                text: "Presupuesto Eliminado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpListaPresupuestoDel = false;
                            this.TraerListadoPresupuestos();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible Eliminar el presupuesto,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
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
            this.disabledDates = {
                to: moment("2014-02-27").toDate(),
                from: moment()
                    .add(1, "years")
                    .toDate()
            };
        }
    },
    beforeMount() {
        this.TraerServicio();
        this.cargarAnios();
        setTimeout(() => {
            //this.TraerUsuarios();
            this.TraerListadoPresupuestos();
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
