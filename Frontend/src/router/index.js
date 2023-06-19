import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    component: () => import("@/layouts/default/Default.vue"),
    children: [
      {
        path: "",
        name: "Kategori",
        component: () =>
          import(/* webpackChunkName: "kategori" */ "@/views/Kategori/Index"),
      },
      {
        path: "/kategori/create",
        name: "kategori-create",
        component: () =>
          import(
            /* webpackChunkName: "kategori-create" */ "@/views/Kategori/KategoriCreate"
          ),
      },
      {
        path: "/kategori/:kode",
        name: "kategori-edit",
        component: () =>
          import(
            /* webpackChunkName: "kategori-edit" */ "@/views/Kategori/KategoriEdit"
          ),
      },
      {
        path: "/buku",
        name: "Buku",
        component: () =>
          import(/* webpackChunkName: "kategori-edit" */ "@/views/Buku/Index"),
      },
      {
        path: "/buku/create",
        name: "buku-create",
        component: () =>
          import(
            /* webpackChunkName: "kategori-create" */ "@/views/Buku/BukuCreate"
          ),
      },
      {
        path: "/buku/:kode",
        name: "buku-edit",
        component: () =>
          import(/* webpackChunkName: "buku-edit" */ "@/views/Buku/BukuEdit"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
