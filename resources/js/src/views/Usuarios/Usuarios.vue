<template>
    <div>
        <vx-card title="Usuarios">
            <div class="vx-row">
                <div class="vx-col w-1/2 mt-5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popUsuarios"
                        >Agregar Nuevo Usuario</vs-button
                    >
                </div>
                <div class="vx-col w-1/2 mt-5">
                    <vs-button
                        class="w-full"
                        color="warning"
                        type="filled"
                        @click="popAPUsuarios"
                        >Dejar Activo o Pasivo a todos los Usuarios</vs-button
                    >
                </div>
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
                                <upload-icon
                                    content="Modificar Usuario"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarUsuario(
                                            props.row.id,
                                            props.row.run,
                                            props.row.nombre_usuario,
                                            props.row.apellido_usuario,
                                            props.row.anexo,
                                            props.row.correo_usuario,
                                            props.row.idServicio,
                                            props.row.permiso_usuario,
                                            props.row.idEstado
                                        )
                                    "
                                ></upload-icon>
                                <plus-circle-icon
                                    content="Asociar Bodegas a Usuario"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="TraerBodegaAsociada(props.row.run)"
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
                classContent="Usuarios"
                title="Agregar Usuario"
                :active.sync="popUpUsuario"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. 18499714-2"
                                    v-model="run_usuario"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. Ricardo"
                                    v-model="nombre_usuario"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. Soto"
                                    v-model="apellido_usuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Anexo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. 222222"
                                    v-model="anexo"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Correo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. ricardoarturo.soto@redsalud.gob.cl"
                                    v-model="correo_usuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Contraseña</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder=""
                                    v-model="password"
                                    type="password"
                                />
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
                                <h6>Perfil</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionListaPerfil"
                                    placeholder="descripcionPerfil"
                                    class="w-full select-large"
                                    label="descripcionPerfil"
                                    :options="listaPerfilUsuario"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="descripcion"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listaEstado"
                                ></v-select>
                            </div>
                        </div>

                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpUsuario = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarUsuario"
                                    color="success"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Usuarios"
                title="Modificar Usuario"
                :active.sync="popUpUsuarioMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. 18499714-2"
                                    v-model="run_usuario"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. Ricardo"
                                    v-model="nombre_usuario"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. Soto"
                                    v-model="apellido_usuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Anexo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. 222222"
                                    v-model="anexo"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Correo</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Ej. ricardoarturo.soto@redsalud.gob.cl"
                                    v-model="correo_usuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Contraseña</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder=""
                                    v-model="password"
                                    type="password"
                                />
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
                                <h6>Perfil</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionListaPerfil"
                                    placeholder="descripcionPerfil"
                                    class="w-full select-large"
                                    label="descripcionPerfil"
                                    :options="listaPerfilUsuario"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="descripcion"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listaEstado"
                                ></v-select>
                            </div>
                        </div>

                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpUsuarioMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarUsuario"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="APUsuario"
                title="Activar o Desactivar Todas las Cuentas de Usuario"
                :active.sync="popUpAPUsuario"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstadoAP"
                                    placeholder="descripcion"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listaEstadoAP"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpAPUsuario = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="APUsuarios"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Activar o Desactivar Todas las Cuentas de
                                    Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="ABUsuarios"
                title="Asociar Bodegas a Usuario"
                :active.sync="popUpAsociarBodega"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
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
                                <h6>.</h6>
                                <vs-button
                                    @click="AgregarBodegaAsociada"
                                    color="success"
                                    type="filled"
                                    class="w-full m-1"
                                    >Asociar Bodega</vs-button
                                >
                            </div>
                        </div>
                        <br />
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <vx-card title="">
                                    <vue-good-table
                                        :columns="columnsBodega"
                                        :rows="rowsBodega"
                                        :pagination-options="{
                                            enabled: true,
                                            perPage: 10
                                        }"
                                    >
                                        <template
                                            slot="table-row"
                                            slot-scope="props"
                                        >
                                            <!-- Column: Name -->
                                            <span
                                                v-if="
                                                    props.column.field ===
                                                        'fullName'
                                                "
                                                class="text-nowrap"
                                            >
                                            </span>
                                            <span
                                                v-else-if="
                                                    props.column.field ===
                                                        'action'
                                                "
                                            >
                                                <trash-2-icon
                                                    content="Quitar Bodega"
                                                    v-tippy
                                                    size="1.5x"
                                                    class="custom-class"
                                                    @click="
                                                        EliminarBodegaAsociada(
                                                            props.row.idBodega,
                                                            props.row
                                                                .run_usuario
                                                        )
                                                    "
                                                ></trash-2-icon>
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
                                </vx-card>
                            </div>
                        </div>
                        <br />
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <vs-button
                                    @click="popUpAsociarBodega = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
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
import { UploadIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
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
        UploadIcon,
        Trash2Icon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
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
            popUpUsuario: false,
            popUpUsuarioMod: false,
            popUpAPUsuario: false,
            popUpAsociarBodega: false,
            run_usuario: "",
            nombre_usuario: "",
            apellido_usuario: "",
            anexo: "",
            correo_usuario: "",
            password: "",
            idMod: 0,
            idServicio: 0,
            val_run: false,
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            seleccionListaPerfil: {
                id: 4,
                descripcionPerfil: "USU"
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: "Seleccione Bodega"
            },
            seleccionEstado: {
                id: 1,
                descripcionEstado: "Activo"
            },
            seleccionEstadoAP: {
                id: 1,
                descripcionEstado: "Activo"
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
            columnsBodega: [
                {
                    label: "Descripcion Bodega",
                    field: "descripcionBodega",
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
            rowsBodega: [],
            listadoServicios: [],
            listaPerfilUsuario: [
                {
                    id: 1,
                    descripcionPerfil: "ADM"
                },
                {
                    id: 2,
                    descripcionPerfil: "ADU"
                },
                {
                    id: 3,
                    descripcionPerfil: "BOD"
                },
                {
                    id: 4,
                    descripcionPerfil: "USU"
                }
            ],
            listaEstado: [
                {
                    id: 1,
                    descripcionEstado: "Activo"
                },
                {
                    id: 2,
                    descripcionEstado: "Pasivo"
                },
                {
                    id: 3,
                    descripcionEstado: "Administrador"
                }
            ],
            listaEstadoAP: [
                {
                    id: 1,
                    descripcionEstado: "Activo"
                },
                {
                    id: 2,
                    descripcionEstado: "Pasivo"
                }
            ],
            listaBodega: []
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
        formatear_run() {
            if (this.run_usuario == "" || this.run_usuario == null) {
                //console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.run_usuario = format(this.run_usuario);
                this.val_run = !validate(this.run_usuario);
            }
        },
        limpiarCampos() {
            try {
                this.run_usuario = "";
                this.nombre_usuario = "";
                this.apellido_usuario = "";
                this.anexo = "";
                this.correo_usuario = "";
                this.password = "";
                this.seleccionListaPerfil = {
                    id: 4,
                    descripcionPerfil: "USU"
                };
                this.seleccionEstado = {
                    id: 1,
                    descripcionEstado: "Activo"
                };
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popUsuarios() {
            try {
                this.popUpUsuario = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popAPUsuarios() {
            try {
                this.popUpAPUsuario = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarUsuario(
            id,
            rut,
            nombre,
            apellido,
            anexo,
            correo,
            idServicio,
            PerfilUsuario,
            idEstado
        ) {
            try {
                this.run_usuario = rut;
                this.nombre_usuario = nombre;
                this.apellido_usuario = apellido;
                this.anexo = anexo;
                this.correo_usuario = correo;
                this.idMod = id;
                this.popUpUsuarioMod = true;

                let c = this.listadoServicios;
                c.forEach((value, ind) => {
                    if (idServicio == value.id) {
                        this.seleccionServicio.id = idServicio;
                        this.seleccionServicio.descripcionServicio =
                            value.descripcionServicio;
                    }
                });

                c = [];
                c = this.listaPerfilUsuario;
                c.forEach((value, ind) => {
                    if (PerfilUsuario == value.id) {
                        this.seleccionListaPerfil.id = value.id;
                        this.seleccionListaPerfil.descripcionPerfil =
                            value.descripcionPerfil;
                    }
                });

                c = [];
                c = this.listaEstado;
                c.forEach((value, ind) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });
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
        TraerUsuarios() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetUsers", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        //this.rows = res.data;
                        let c = [];
                        c = res.data;
                        let f = this.listadoServicios;
                        let d = [];
                        c.forEach((value, index) => {
                            f.forEach((val, index) => {
                                if (value.NOMSER == val.descripcionServicio) {
                                    value.descripcionServicio =
                                        val.descripcionServicio;
                                    d.push(value);
                                }
                            });
                        });

                        this.rows = d;
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
        AgregarUsuario() {
            try {
                if (this.run_usuario == "" || this.run_usuario == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un rut de usuario",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.correo_usuario == "" ||
                    this.correo_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un correo del usuario",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.nombre_usuario == "" ||
                    this.nombre_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.apellido_usuario == "" ||
                    this.apellido_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un apellido",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.anexo == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un anexo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.password == "" || this.password == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una contraseña",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionServicio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un servicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionEstado == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un estado",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        run_usuario: this.run_usuario,
                        correo_usuario: this.correo_usuario.toUpperCase(),
                        nombre_usuario: this.nombre_usuario.toUpperCase(),
                        apellido_usuario: this.apellido_usuario.toUpperCase(),
                        anexo: this.anexo,
                        password: this.password,
                        idServicio: this.seleccionServicio.id,
                        NOMSER: this.seleccionServicio.descripcionServicio,
                        bodega: this.seleccionBodega.id,
                        permiso_usuario: this.seleccionListaPerfil.id,
                        idEstado: this.seleccionEstado.id,
                        estado_login: 1
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/RegistrarUsuario",
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
                                    text: "Usuario Registrado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpUsuario = false;
                                this.TraerUsuarios();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar al usuario,intentelo nuevamente",
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
        ModificarUsuario() {
            try {
                if (this.run_usuario == "" || this.run_usuario == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un rut de usuario",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.correo_usuario == "" ||
                    this.correo_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un correo del usuario",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.nombre_usuario == "" ||
                    this.nombre_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.apellido_usuario == "" ||
                    this.apellido_usuario == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un apellido",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.anexo == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un anexo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.password == "" || this.password == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una contraseña",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionServicio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un servicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionEstado == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un estado",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.idMod,
                        run_usuario: this.run_usuario,
                        correo_usuario: this.correo_usuario.toUpperCase(),
                        nombre_usuario: this.nombre_usuario.toUpperCase(),
                        apellido_usuario: this.apellido_usuario.toUpperCase(),
                        idServicio: this.seleccionServicio.id,
                        NOMSER: this.seleccionServicio.descripcionServicio,
                        anexo: this.anexo,
                        password: this.password,
                        bodega: this.seleccionBodega.id,
                        permiso_usuario: this.seleccionListaPerfil.id,
                        idEstado: this.seleccionEstado.id,
                        estado_login: 1
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Usuario/PutUsuario", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Usuario Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpUsuarioMod = false;
                                this.TraerUsuarios();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar al usuario,intentelo nuevamente",
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
        APUsuarios() {
            try {
                if (
                    this.seleccionEstadoAP == null ||
                    this.seleccionEstadoAP.id == 0
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No fue posible activar o desactivar las cuentas, intentelo nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let dat = {
                        idEstado: this.seleccionEstadoAP.id,
                        idPerfil: 4
                    };
                    axios
                        .post(
                            this.localVal + "/api/Usuario/PutAPUsuario",
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
                                    text: "Usuarios Modificados Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpAPUsuario = false;
                                this.TraerUsuarios();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar a los usuarios,intentelo nuevamente",
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
        TraerBodegaAsociada(run) {
            try {
                this.limpiarCampos();
                this.popUpAsociarBodega = true;
                this.run_usuario = run;
                let dat = {
                    run_usuario: run
                };
                axios
                    .post(
                        this.localVal + "/api/Usuario/GetUsuarioBodegas",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.rowsBodega = res.data;
                        if (this.rowsBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text: "No hay datos o no se cargaron los datos",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarBodegaAsociada() {
            try {
                if (
                    this.seleccionBodega == null ||
                    this.seleccionBodega.id == 0
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let dat = {
                        run_usuario: this.run_usuario,
                        idBodega: this.seleccionBodega.id,
                        descripcionBodega: this.seleccionBodega
                            .descripcionBodega
                    };
                    axios
                        .post(
                            this.localVal + "/api/Usuario/PostUsuarioBodegas",
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
                            let dato = res.data;
                            if (dato) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Bodega Asociada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.TraerBodegaAsociada(this.run_usuario);
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        EliminarBodegaAsociada(id, run) {
            try {
                let dat = {
                    run_usuario: run,
                    idBodega: id
                };
                axios
                    .post(
                        this.localVal + "/api/Usuario/DeleteUsuarioBodegas",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let dato = res.data;
                        if (dato) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Asociada Eliminada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerBodegaAsociada(this.run_usuario);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerServicio();
        setTimeout(() => {
            this.TraerUsuarios();
            this.TraerBodega();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
