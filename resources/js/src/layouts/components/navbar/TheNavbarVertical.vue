<!-- =========================================================================================
  File Name: TheNavbar.vue
  Description: Navbar component
  Component Name: TheNavbar
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div class="relative">
        <div class="vx-navbar-wrapper" :class="classObj">
            <vs-navbar
                class="vx-navbar navbar-custom navbar-skelton"
                :color="navbarColorLocal"
                :class="textColor"
            >
                <!-- SM - OPEN SIDEBAR BUTTON -->
                <feather-icon
                    class="sm:inline-flex xl:hidden cursor-pointer p-2"
                    icon="MenuIcon"
                    @click.stop="showSidebar"
                />

                <div class="vx-col w-1/3">
                    <h6 class="text-right">{{ texto }}</h6>
                </div>
                <div class="vx-col w-1/3 p-2">
                    <v-select
                        taggable
                        v-model="seleccionBodega"
                        placeholder="Medicamentos"
                        class="w-full select-large"
                        label="descripcionBodega"
                        :options="listaBodega"
                    ></v-select>
                </div>
                <div class="vx-col w-1/3 ">
                    <vs-button
                        class="text-right"
                        color="primary"
                        type="filled"
                        @click="CargarDatos()"
                        >Cargar Bodega</vs-button
                    >
                </div>

                <!-- <bookmarks :navbarColor="navbarColor" v-if="windowWidth >= 992" /> -->

                <vs-spacer />

                <search-bar />

                <!-- <notification-drop-down /> -->

                <profile-drop-down />
            </vs-navbar>
        </div>
    </div>
</template>

<script>
import Bookmarks from "./components/Bookmarks.vue";
import SearchBar from "./components/SearchBar.vue";
import NotificationDropDown from "./components/NotificationDropDown.vue";
import ProfileDropDown from "./components/ProfileDropDown.vue";
import vSelect from "vue-select";
import axios from "axios";
import router from "@/router";

export default {
    name: "the-navbar-vertical",
    data() {
        return {
            localVal: process.env.MIX_APP_URL,
            siabVal: process.env.MIX_APP_URL_API_SIAB,
            texto: "Seleccione Bodega: ",
            seleccionBodega: {
                id: 1,
                descripcionBodega: "Medicamentos"
            },
            listaBodega: []
        };
    },
    props: {
        navbarColor: {
            type: String,
            default: "#fff"
        }
    },
    components: {
        Bookmarks,
        SearchBar,
        NotificationDropDown,
        ProfileDropDown,
        "v-select": vSelect
    },
    computed: {
        navbarColorLocal() {
            return this.$store.state.theme === "dark" &&
                this.navbarColor === "#fff"
                ? "#10163a"
                : this.navbarColor;
        },
        verticalNavMenuWidth() {
            return this.$store.state.verticalNavMenuWidth;
        },
        textColor() {
            return {
                "text-white":
                    (this.navbarColor !== "#10163a" &&
                        this.$store.state.theme === "dark") ||
                    (this.navbarColor !== "#fff" &&
                        this.$store.state.theme !== "dark")
            };
        },
        windowWidth() {
            return this.$store.state.windowWidth;
        },

        // NAVBAR STYLE
        classObj() {
            if (this.verticalNavMenuWidth === "default")
                return "navbar-default";
            else if (this.verticalNavMenuWidth === "reduced")
                return "navbar-reduced";
            else if (this.verticalNavMenuWidth) return "navbar-full";
        }
    },
    methods: {
        showSidebar() {
            this.$store.commit("TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE", true);
        },
        CargarDatos() {
            try {
                sessionStorage.setItem("idBodega", this.seleccionBodega.id);
                sessionStorage.setItem(
                    "descripcionBodega",
                    this.seleccionBodega.descripcionBodega
                );
                window.location.reload();
            } catch (error) {
                console.log(error);
            }
        },
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
        cargaBodegaSeleccionada() {
            try {
                this.seleccionBodega.id = sessionStorage.getItem("idBodega");
                this.seleccionBodega.descripcionBodega = sessionStorage.getItem(
                    "descripcionBodega"
                );
            } catch (error) {
                console.log(error);
            }
        }
    },
    created() {
        setTimeout(() => {
            this.TraerBodega();
        }, 2000);
        setTimeout(() => {
            this.cargaBodegaSeleccionada();
        }, 3000);
    }
};
</script>
