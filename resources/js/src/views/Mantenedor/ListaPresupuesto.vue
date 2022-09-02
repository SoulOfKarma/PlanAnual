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
import vSelect from "vue-select";
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
        PlusCircleIcon
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
            popUpListaPresupuesto: false,
            popUpListaPresupuestoMod: false,
            idMod: 0,
            idServicio: 0,
            val_run: false,
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Rut",
                    field: "run",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre",
                    field: "nombre_usuario",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Apellido",
                    field: "apellido_usuario",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Anexo",
                    field: "anexo",
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
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado Proveedor
            rows: [],
            listadoServicios: []
        };
    },
    methods: {
        //Metodos Reusables
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
