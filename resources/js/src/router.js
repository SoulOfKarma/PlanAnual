/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

const router = new Router({
    mode: "history",
    base: "/",
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        {
            path: "",
            redirect: "/pages/login"
        },
        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("./layouts/main/Main.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/home",
                    name: "home",
                    component: () => import("./views/Home.vue")
                },
                {
                    path: "/Mantenedor/ListaPresupuesto",
                    name: "ListaPresupuesto",
                    component: () =>
                        import("./views/Mantenedor/ListaPresupuesto.vue")
                },
                {
                    path: "/Mantenedor/ModificacionArticulos",
                    name: "ModificacionArticulos",
                    component: () =>
                        import("./views/Mantenedor/ModificacionArticulos.vue")
                },
                {
                    path: "/PlandeCompra/IngresoPlandeCompra",
                    name: "IngresoPlandeCompra",
                    component: () =>
                        import("./views/PlandeCompra/IngresoPlandeCompra.vue")
                },
                {
                    path: "/PlandeCompra/ReprogramacionPC",
                    name: "ReprogramacionPC",
                    component: () =>
                        import("./views/PlandeCompra/ReprogramacionPC.vue")
                },
                {
                    path: "/PlandeCompra/ReporteReprogramacion",
                    name: "ReporteReprogramacion",
                    component: () =>
                        import("./views/PlandeCompra/ReporteReprogramacion.vue")
                },
                {
                    path: "/Reportes/ReportesGenerales",
                    name: "ReportesGenerales",
                    component: () =>
                        import("./views/Reportes/ReportesGenerales.vue")
                },
                {
                    path: "/Reportes/ReporteUsuarios",
                    name: "ReporteUsuarios",
                    component: () =>
                        import("./views/Reportes/ReporteUsuarios.vue")
                },
                {
                    path: "/ReportesAbastecimiento/ReportesAbastecimiento",
                    name: "ReportesAbastecimiento",
                    component: () =>
                        import(
                            "./views/ReportesAbastecimiento/ReportesAbastecimiento.vue"
                        )
                },
                {
                    path: "/ReportesContables/ResumenReporteGeneral",
                    name: "ResumenReporteGeneral",
                    component: () =>
                        import(
                            "./views/ReportesContables/ResumenReporteGeneral.vue"
                        )
                },
                {
                    path: "/Usuarios/Usuarios",
                    name: "Usuarios",
                    component: () => import("./views/Usuarios/Usuarios.vue")
                }
            ]
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: "",
            component: () => import("@/layouts/full-page/FullPage.vue"),
            children: [
                // =============================================================================
                // PAGES
                // =============================================================================
                {
                    path: "/pages/login",
                    name: "page-login",
                    component: () => import("@/views/pages/Login.vue")
                },
                {
                    path: "/pages/error-404",
                    name: "page-error-404",
                    component: () => import("@/views/pages/Error404.vue")
                }
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: "*",
            redirect: "/pages/error-404"
        }
    ]
});

router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById("loading-bg");
    if (appLoading) {
        appLoading.style.display = "none";
    }
});

export default router;
