/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

export default [
    {
        url: "/home",
        name: "Inicio",
        slug: "Inicio",
        icon: "HomeIcon"
    },
    {
        url: null,
        name: "Mantenedor",
        slug: "Mantenedor",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Mantenedor/ListaPresupuesto",
                name: "Lista Presupuesto",
                slug: "/Mantenedor/ListaPresupuesto",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/ModificacionArticulos",
                name: "Modificacion Articulos",
                slug: "/Mantenedor/ModificacionArticulos",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Plan de Compra",
        slug: "PlandeCompra",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/PlandeCompra/IngresoPlandeCompra",
                name: "Ingreso Plan de Compra",
                slug: "/PlandeCompra/IngresoPlandeCompra",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Reportes",
        slug: "Reportes",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Reportes/ReportesGenerales",
                name: "Reportes Generales",
                slug: "/Reportes/ReportesGenerales",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Reportes Abastecimiento",
        slug: "ReportesAbastecimiento",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/ReportesAbastecimiento/ReportesAbastecimiento",
                name: "Reportes Aba.",
                slug: "/ReportesAbastecimiento/ReportesAbastecimiento",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Reportes Contables",
        slug: "ReportesContables",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/ReportesContables/ResumenReporteGeneral",
                name: "Reportes Generales",
                slug: "/ReportesContables/ResumenReporteGeneral",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: "/Usuarios/Usuarios",
        name: "Usuarios",
        slug: "Usuarios",
        icon: "HomeIcon"
    }
];
