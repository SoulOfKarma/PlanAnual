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
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Modificar Presupuesto"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popModificarPlanAnual(
                                                    props.row.id
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
                classContent="PresupuestoMod"
                title="Modificar Listado Presupuesto"
                :active.sync="popUpAgregarArticuloMod"
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
                                    @click="popUpAgregarArticuloMod = false"
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
            popUpAgregarArticuloMod: false,
            fechaPAnual: null,
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
        popArticulosPAnual() {
            try {
                this.popUpAgregarArticulo = true;
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
