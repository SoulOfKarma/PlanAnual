<template>
    <div
        class="the-navbar__user-meta flex items-center"
        v-if="activeUserInfo.displayName"
    >
        <div class="text-right leading-tight hidden sm:block">
            <p class="font-semibold">{{ nombre }}</p>
            <small></small><br />
            <small></small>
        </div>

        <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
            <div class="con-img ml-3"></div>

            <vs-dropdown-menu class="vx-navbar-dropdown">
                <ul style="min-width: 9rem"></ul>
            </vs-dropdown-menu>
        </vs-dropdown>
    </div>
</template>

<script>
import axios from "axios";
import router from "@/router";
export default {
    data() {
        return {
            localVal: process.env.MIX_APP_URL,
            nombre: sessionStorage.getItem("nombre")
        };
    },
    computed: {
        activeUserInfo() {
            return this.$store.state.AppActiveUser;
        }
    },
    methods: {
        async salir() {
            await axios.post(this.localVal + "/api/Login/Salir", {
                rut: ""
            });
            window.sessionStorage.clear();
            router.push("/pages/login");
        }
    }
};
</script>
