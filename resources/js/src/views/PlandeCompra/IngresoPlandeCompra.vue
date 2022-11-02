<template>
    <div>
        <vx-card title="Plan de Compra Anual">
            <vx-card>
                <div>
                    <vs-button
                        class="w-full"
                        v-if="validarEstado"
                        color="primary"
                        type="filled"
                        @click="popArticulosPAnual"
                        >Agregar Articulos</vs-button
                    >
                </div>
            </vx-card>
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
            <br />
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
                            <span v-else-if="props.column.field === 'action'">
                                <upload-icon
                                    v-if="validarEstado"
                                    content="Modificar Articulo"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarArticulo(
                                            props.row.id,
                                            props.row.CODART,
                                            props.row.NOMART,
                                            props.row.UNIMED,
                                            props.row.PRECIO,
                                            props.row.PRECIO2
                                        )
                                    "
                                ></upload-icon>
                                <trash-2-icon
                                    v-if="validarEstado"
                                    content="Quitar Articulo"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="popDeleteArticulo(props.row.id)"
                                ></trash-2-icon>
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
                        <div class="vx-row w-full">
                            <vue-good-table
                                class="w-full"
                                :columns="columnsArt"
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
                </div>
            </vs-popup>
            <vs-popup
                classContent="EliminarArticulo"
                title="Eliminar Articulo"
                :active.sync="popUpEliminarArticulo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpEliminarArticulo = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="EliminarArticulo()"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Eliminar Articulo</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vs-popup>
            <vs-popup
                classContent="AgregarConsumoPAnual"
                title="Articulo Plan Anual"
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
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Primer Semestre
                                </h6>
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Enero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_ENE"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Febrero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_FEB"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Marzo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAR"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Abril
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_ABR"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Mayo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAY"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Junio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUN"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Segundo Semestre
                                </h6>
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Julio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUL"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Agosto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_AGO"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Septiembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_SEP"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Octubre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_OCT"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Noviembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_NOV"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Diciembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_DIC"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Cantidad
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadTotal"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Precio
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="precioTotal"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Utilizado
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="valorUtilizado"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Maximo Tope
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="topeMaximo"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Observaciones
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="obs"
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
                                    @click="AgregarArticuloPAnual"
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
                classContent="ModificarConsumoPAnual"
                title="Modificar Articulo Plan Anual"
                :active.sync="popUpModificarArticuloMod"
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
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Primer Semestre
                                </h6>
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Enero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_ENE"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Febrero
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_FEB"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Marzo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAR"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Abril
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_ABR"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Mayo
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_MAY"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Junio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUN"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Segundo Semestre
                                </h6>
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Julio
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_JUL"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Agosto
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_AGO"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Septiembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_SEP"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Octubre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_OCT"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Noviembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_NOV"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <h6>
                                    Diciembre
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="C_DIC"
                                    @keypress="isNumber($event)"
                                    @blur="CalculoCantPrecio()"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Cantidad
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadTotal"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Precio
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="precioTotal"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Utilizado
                                </h6>
                                <vs-input
                                    class="inputx w-full"
                                    v-model="valorUtilizado"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>
                                    Maximo Tope
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="topeMaximo"
                                    disabled
                                    @keypress="isNumber($event)"
                                />
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Observaciones
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="obs"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpModificarArticuloMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarArticuloPAnual()"
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
            popUpAgregarArticulo: false,
            popUpAgregarArticuloPAnual: false,
            popUpModificarArticuloMod: false,
            popUpEliminarArticulo: false,
            validarEstado: false,
            fechaPAnual: null,
            idArticulo: "",
            codart: "",
            nombre: "",
            unimed: "",
            precio: "",
            cantidadTotal: 0,
            precioTotal: 0,
            valorUtilizado: 0,
            topeMaximo: 0,
            panualval: 0,
            reprogramacion: 1,
            obs: "",
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
                    label: "TOTAL",
                    field: "T_PRECIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            columnsArt: [
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
                if (this.rows.length > 0 && this.panualval > 0) {
                    this.popUpAgregarArticulo = true;
                    this.popUpAgregarArticuloPAnual = false;
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No existe presupuesto para Agregar articulos",
                        color: "danger",
                        position: "top-right"
                    });
                }
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
        popDeleteArticulo(id) {
            try {
                this.idMod = id;
                this.popUpEliminarArticulo = true;
            } catch (error) {
                console.log(error);
            }
        },
        cargarArticulosSegunBodega() {
            try {
                let c = this.listadoTemporalArticulos;
                let d = [];
                c.forEach((value, ind) => {
                    if (value.idBodega == sessionStorage.getItem("idBodega")) {
                        d.push(value);
                    }
                });
                this.listadoArticulos = d;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarArticulo(id, codart, nombre, unimed, precio, precio2) {
            try {
                this.idMod = id;
                this.popUpModificarArticuloMod = true;
                let c = this.rowsArticulos;
                c.forEach((value, ind) => {
                    if (value.id == id) {
                        this.C_ENE = value.C_ENE;
                        this.C_FEB = value.C_FEB;
                        this.C_MAR = value.C_MAR;
                        this.C_ABR = value.C_ABR;
                        this.C_MAY = value.C_MAY;
                        this.C_JUN = value.C_JUN;
                        this.C_JUL = value.C_JUL;
                        this.C_AGO = value.C_AGO;
                        this.C_SEP = value.C_SEP;
                        this.C_OCT = value.C_OCT;
                        this.C_NOV = value.C_NOV;
                        this.C_DIC = value.C_DIC;
                        this.codart = codart;
                        this.nombre = nombre;
                        this.unimed = unimed;
                        this.precio = precio2;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarConsumoMensual(id, codart, nombre, unimed, precio) {
            try {
                let c = this.rowsArticulos;
                let result = false;
                c.forEach((value, ind) => {
                    if (value.CODART == codart) {
                        result = true;
                    }
                });

                if (result == true) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Articulo ya fue ingresado",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    this.idArticulo = id;
                    this.codart = codart;
                    this.nombre = nombre;
                    this.unimed = unimed;
                    this.precio = precio;
                    this.popUpAgregarArticulo = false;
                    this.popUpAgregarArticuloPAnual = true;
                    this.C_ENE = 0;
                    this.C_FEB = 0;
                    this.C_MAR = 0;
                    this.C_ABR = 0;
                    this.C_MAY = 0;
                    this.C_JUN = 0;
                    this.C_JUL = 0;
                    this.C_AGO = 0;
                    this.C_SEP = 0;
                    this.C_OCT = 0;
                    this.C_NOV = 0;
                    this.C_DIC = 0;
                    this.precioTotal = 0;
                    this.cantidadTotal = 0;
                }
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
        TraerListadoPresupuestos() {
            try {
                let data = {
                    NOMSER: sessionStorage.getItem("NOMSER"),
                    idBodega: sessionStorage.getItem("idBodega"),
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
        TraerArticulosPresupuesto() {
            try {
                let data = {
                    NOMSER: sessionStorage.getItem("NOMSER"),
                    idBodega: sessionStorage.getItem("idBodega"),
                    anio: 2023
                };
                axios
                    .post(
                        this.localVal + "/api/PCompra/GetArticulosServ",
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
        TraerTotalArticulosPresupuesto() {
            try {
                let data = {
                    NOMSER: sessionStorage.getItem("NOMSER"),
                    idBodega: sessionStorage.getItem("idBodega"),
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
        //Metodos para Agregar,Modificar o Eliminar Datos
        AgregarArticuloPAnual() {
            try {
                if (this.valorUtilizado == null) {
                    this.valorUtilizado = 0;
                }
                if (this.topeMaximo == null) {
                    this.topeMaximo = 0;
                }
                let valorTotal =
                    parseInt(this.precioTotal) + parseInt(this.valorUtilizado);
                this.C_ENE = parseInt(this.C_ENE) + parseInt(0);
                this.C_FEB = parseInt(this.C_FEB) + parseInt(0);
                this.C_MAR = parseInt(this.C_MAR) + parseInt(0);
                this.C_ABR = parseInt(this.C_ABR) + parseInt(0);
                this.C_MAY = parseInt(this.C_MAY) + parseInt(0);
                this.C_JUN = parseInt(this.C_JUN) + parseInt(0);
                this.C_JUL = parseInt(this.C_JUL) + parseInt(0);
                this.C_AGO = parseInt(this.C_AGO) + parseInt(0);
                this.C_SEP = parseInt(this.C_SEP) + parseInt(0);
                this.C_OCT = parseInt(this.C_OCT) + parseInt(0);
                this.C_NOV = parseInt(this.C_NOV) + parseInt(0);
                this.C_DIC = parseInt(this.C_DIC) + parseInt(0);
                if (
                    this.C_ENE < 1 &&
                    this.C_FEB < 1 &&
                    this.C_MAR < 1 &&
                    this.C_ABR < 1 &&
                    this.C_MAY < 1 &&
                    this.C_JUN < 1 &&
                    this.C_JUL < 1 &&
                    this.C_AGO < 1 &&
                    this.C_SEP < 1 &&
                    this.C_OCT < 1 &&
                    this.C_NOV < 1 &&
                    this.C_DIC < 1 &&
                    this.C_ENE == "" &&
                    this.C_FEB == "" &&
                    this.C_MAR == "" &&
                    this.C_ABR == "" &&
                    this.C_MAY == "" &&
                    this.C_JUN == "" &&
                    this.C_JUL == "" &&
                    this.C_AGO == "" &&
                    this.C_SEP == "" &&
                    this.C_OCT == "" &&
                    this.C_NOV == "" &&
                    this.C_DIC == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No puede dejar el campo vacio o todos los campos menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    valorTotal > this.panualval ||
                    valorTotal > this.topeMaximo
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "El valor total supera su presupuesto asignado, verifique los datos",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    isNaN(this.C_ENE) ||
                    isNaN(this.C_FEB) ||
                    isNaN(this.C_MAR) ||
                    isNaN(this.C_ABR) ||
                    isNaN(this.C_MAY) ||
                    isNaN(this.C_JUN) ||
                    isNaN(this.C_JUL) ||
                    isNaN(this.C_AGO) ||
                    isNaN(this.C_SEP) ||
                    isNaN(this.C_NOV) ||
                    isNaN(this.C_OCT) ||
                    isNaN(this.C_DIC)
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No puede dejar el campo vacio o todos los campos menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let date = moment().endOf("day");
                    let data = {
                        CODART: this.codart,
                        NOMART: this.nombre,
                        UNIMED: this.unimed,
                        PRECIO: this.precio,
                        C_ENE: this.C_ENE,
                        C_FEB: this.C_FEB,
                        C_MAR: this.C_MAR,
                        C_ABR: this.C_ABR,
                        C_MAY: this.C_MAY,
                        C_JUN: this.C_JUN,
                        C_JUL: this.C_JUL,
                        C_AGO: this.C_AGO,
                        C_SEP: this.C_SEP,
                        C_OCT: this.C_OCT,
                        C_NOV: this.C_NOV,
                        C_DIC: this.C_DIC,
                        C_TOTAL: this.cantidadTotal,
                        T_PRECIO: this.precioTotal,
                        idServicio: sessionStorage.getItem("idServicio"),
                        FECING: date.format("YYYY/MM/DD").toString(),
                        NOMSER: sessionStorage.getItem("NOMSER"),
                        BODEGA: sessionStorage.getItem("idBodega"),
                        OBS: this.obs,
                        ANIO: 2023,
                        idReprogramado: this.reprogramacion
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/PCompra/PostArticuloServ",
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
                                    text: "Articulo Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.TraerArticulosPresupuesto();
                                this.TraerTotalArticulosPresupuesto();
                                this.TraerListadoPresupuestos();
                                this.popUpAgregarArticulo = true;
                                this.popUpAgregarArticuloPAnual = false;
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible ingresar el articulo,intentelo nuevamente",
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
        ModificarArticuloPAnual() {
            try {
                let valorTotal =
                    parseInt(this.precioTotal) + parseInt(this.valorUtilizado);

                this.C_ENE = parseInt(this.C_ENE) + parseInt(0);
                this.C_FEB = parseInt(this.C_FEB) + parseInt(0);
                this.C_MAR = parseInt(this.C_MAR) + parseInt(0);
                this.C_ABR = parseInt(this.C_ABR) + parseInt(0);
                this.C_MAY = parseInt(this.C_MAY) + parseInt(0);
                this.C_JUN = parseInt(this.C_JUN) + parseInt(0);
                this.C_JUL = parseInt(this.C_JUL) + parseInt(0);
                this.C_AGO = parseInt(this.C_AGO) + parseInt(0);
                this.C_SEP = parseInt(this.C_SEP) + parseInt(0);
                this.C_OCT = parseInt(this.C_OCT) + parseInt(0);
                this.C_NOV = parseInt(this.C_NOV) + parseInt(0);
                this.C_DIC = parseInt(this.C_DIC) + parseInt(0);
                if (
                    this.C_ENE < 1 &&
                    this.C_FEB < 1 &&
                    this.C_MAR < 1 &&
                    this.C_ABR < 1 &&
                    this.C_MAY < 1 &&
                    this.C_JUN < 1 &&
                    this.C_JUL < 1 &&
                    this.C_AGO < 1 &&
                    this.C_SEP < 1 &&
                    this.C_OCT < 1 &&
                    this.C_NOV < 1 &&
                    this.C_DIC < 1 &&
                    this.C_ENE == "" &&
                    this.C_FEB == "" &&
                    this.C_MAR == "" &&
                    this.C_ABR == "" &&
                    this.C_MAY == "" &&
                    this.C_JUN == "" &&
                    this.C_JUL == "" &&
                    this.C_AGO == "" &&
                    this.C_SEP == "" &&
                    this.C_OCT == "" &&
                    this.C_NOV == "" &&
                    this.C_DIC == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No puede dejar el campo vacio o todos los campos menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    valorTotal > this.panualval ||
                    valorTotal > this.topeMaximo
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "El valor total supera su presupuesto asignado, verifique los datos",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    isNaN(this.C_ENE) ||
                    isNaN(this.C_FEB) ||
                    isNaN(this.C_MAR) ||
                    isNaN(this.C_ABR) ||
                    isNaN(this.C_MAY) ||
                    isNaN(this.C_JUN) ||
                    isNaN(this.C_JUL) ||
                    isNaN(this.C_AGO) ||
                    isNaN(this.C_SEP) ||
                    isNaN(this.C_NOV) ||
                    isNaN(this.C_OCT) ||
                    isNaN(this.C_DIC)
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "No puede dejar el campo vacio o todos los campos menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let date = moment().endOf("day");
                    let data = {
                        id: this.idMod,
                        CODART: this.codart,
                        NOMART: this.nombre,
                        UNIMED: this.unimed,
                        PRECIO: this.precio,
                        C_ENE: this.C_ENE,
                        C_FEB: this.C_FEB,
                        C_MAR: this.C_MAR,
                        C_ABR: this.C_ABR,
                        C_MAY: this.C_MAY,
                        C_JUN: this.C_JUN,
                        C_JUL: this.C_JUL,
                        C_AGO: this.C_AGO,
                        C_SEP: this.C_SEP,
                        C_OCT: this.C_OCT,
                        C_NOV: this.C_NOV,
                        C_DIC: this.C_DIC,
                        C_TOTAL: this.cantidadTotal,
                        T_PRECIO: this.precioTotal,
                        idServicio: sessionStorage.getItem("idServicio"),
                        FECING: date.format("YYYY/MM/DD").toString(),
                        NOMSER: sessionStorage.getItem("NOMSER"),
                        BODEGA: sessionStorage.getItem("idBodega"),
                        OBS: this.obs,
                        ANIO: 2023,
                        idReprogramado: this.reprogramacion
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/PCompra/UpdateArticuloServ",
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
                                    text: "Articulo Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.TraerArticulosPresupuesto();
                                this.TraerTotalArticulosPresupuesto();
                                this.TraerListadoPresupuestos();
                                this.popUpModificarArticuloMod = false;
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar el articulo,intentelo nuevamente",
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
        EliminarArticulo() {
            try {
                let data = {
                    id: this.idMod
                };

                const dat = data;
                axios
                    .post(
                        this.localVal + "/api/PCompra/DestroyArticuloServ",
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
                                text: "Articulo Eliminado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerArticulosPresupuesto();
                            this.TraerTotalArticulosPresupuesto();
                            this.TraerListadoPresupuestos();
                            this.popUpEliminarArticulo = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible eliminar el articulo,intentelo nuevamente",
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
        cargarValidacionEstado() {
            try {
                if (
                    sessionStorage.getItem("idEstado") == 1 ||
                    sessionStorage.getItem("idEstado") == 3
                ) {
                    this.validarEstado = true;
                } else {
                    this.validarEstado = false;
                }
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerServicio();
        this.TraerArticulos();
        setTimeout(() => {
            this.TraerListadoPresupuestos();
            this.TraerArticulosPresupuesto();
            this.TraerTotalArticulosPresupuesto();
            this.cargarArticulosSegunBodega();
            //this.TraerUsuarios();
            this.cargarValidacionEstado();
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
