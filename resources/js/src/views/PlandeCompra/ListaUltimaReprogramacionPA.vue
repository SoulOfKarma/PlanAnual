<template>
    <div>
        <vx-card title="Listado Recepciones Abiertas">
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        styleClass="vgt-table condensed bordered"
                        :sort-options="{
                            enabled: true,
                            initialSortBy: {
                                field: 'NOMSER',
                                type: 'ASC'
                            }
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
                                <edit-icon
                                    content="Ir a la Reprogramacion"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        redireccionarReprogramacion(
                                            props.row.NOMSER,
                                            props.row.descripcionBodega,
                                            props.row.ULTIMAREPROG
                                        )
                                    "
                                ></edit-icon>
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
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import { EditIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        PlusCircleIcon,
        EditIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            //Datos Campos
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Servicio",
                    field: "NOMSER",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Reprogramacion Interna",
                    field: "ULTIMAREPROG",
                    type: "number",
                    width: "150px",
                    sortable: true,
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado
            rows: []
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
        //Metodos CRUD
        TraerUltimasReprogramaciones() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Reprogramacion/GetUltimaReprogramacion",
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
        redireccionarReprogramacion(nomser, desbodega, nreprog) {
            try {
                this.$router.push({
                    name: "ModificarReprogramacion",
                    params: {
                        NOMSER: `${nomser}`,
                        BODEGA: `${desbodega}`,
                        NUMREPROG: `${nreprog}`
                    }
                });
                console.log(nreprog);
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        setTimeout(() => {
            this.TraerUltimasReprogramaciones();
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
