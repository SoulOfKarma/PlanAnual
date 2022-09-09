<template>
    <div>
        <vx-card title="Articulos">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="popListaArticulos"
                    >Agregar Nuevo Articulo</vs-button
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
                                    content="Modificar Articulo"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarArticulo(
                                            props.row.id,
                                            props.row.CODART,
                                            props.row.NOMBRE,
                                            props.row.UNIMED,
                                            props.row.PRECIO,
                                            props.row.idEstado
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
                classContent="Articulos"
                title="Agregar Articulos"
                :active.sync="popUpListaArticulos"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo Articulos
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codart"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Descripcion Articulo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Unidad Medida
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unimed"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Precio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaEstado"
                                ></v-select>
                            </div>

                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpListaArticulos = false"
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
                                    >Agregar Articulo</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="ArticuloMod"
                title="Modificar Articulo"
                :active.sync="popUpListaArticulosMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo Articulos
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codart"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Descripcion Articulo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Unidad Medida
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unimed"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Precio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcion"
                                    :options="listaEstado"
                                ></v-select>
                            </div>

                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpListaArticulosMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarArticulo"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Articulo</vs-button
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
            popUpListaArticulos: false,
            popUpListaArticulosMod: false,
            codart: "",
            nombre: "",
            unimed: "",
            idMod: 0,
            precio: 0,
            seleccionEstado: {
                id: 1,
                descripcion: "Activo"
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
                    label: "Articulo",
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
            //Datos Listado Proveedor
            rows: [],
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
        //PopUp
        popListaArticulos() {
            try {
                this.popUpListaArticulos = true;
                this.idMod = 0;
                this.codart = "";
                this.nombre = "";
                this.seleccionEstado = {
                    id: 1,
                    descripcion: "Activo"
                };
                this.precio = 0;
                this.unimed = "";
            } catch (error) {
                console.log(error);
            }
        },
        popModificarArticulo(id, CODART, NOMBRE, UNIMED, PRECIO, idEstado) {
            try {
                this.popUpListaArticulosMod = true;
                this.idMod = id;
                this.codart = CODART;
                this.nombre = NOMBRE;
                this.unimed = UNIMED;
                this.precio = PRECIO;

                let c = this.listaEstado;
                c.forEach((value, ind) => {
                    if (value.id == idEstado) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcion = value.descripcion;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        //Carga de Datos
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

                            this.rows = f;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos para Agregar Datos
        AgregarListaPresupuesto() {
            try {
                if (this.codart == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar un Codigo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.precio == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un precio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.unimed == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Presupuesto debe ser mayor a 0",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        CODART: this.codart,
                        NOMBRE: this.nombre,
                        UNIMED: this.unimed,
                        PRECIO: this.precio,
                        idEstado: this.seleccionEstado.id
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostArticulos",
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
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Articulo Registrado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpListaArticulos = false;
                                this.TraerArticulos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el articulo,intentelo nuevamente",
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
        ModificarArticulo() {
            try {
                if (this.codart == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar un Codigo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.unimed == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una unidad de medida",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        CODART: this.codart,
                        NOMBRE: this.nombre,
                        UNIMED: this.unimed,
                        PRECIO: this.precio,
                        idEstado: this.seleccionEstado.id
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PutArticulos",
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
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Articulo Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpListaArticulosMod = false;
                                this.TraerArticulos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible Modificar el Articulo,intentelo nuevamente",
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
            this.disabledDates = {
                to: moment("2014-02-27").toDate(),
                from: moment()
                    .add(1, "years")
                    .toDate()
            };
        }
    },
    beforeMount() {
        this.cargarAnios();
        setTimeout(() => {
            //this.TraerUsuarios();
            this.TraerArticulos();
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
