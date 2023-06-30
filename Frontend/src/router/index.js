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
      {
        path: "/anggota",
        name: "Anggota",
        component: () =>
          import(
            /* webpackChunkName: "anggota-edit" */ "@/views/Anggota/Index"
          ),
      },
      {
        path: "/anggota/create",
        name: "anggota-create",
        component: () =>
          import(
            /* webpackChunkName: "anggota-create" */ "@/views/Anggota/Create"
          ),
      },
      {
        path: "/anggota/:nomor",
        name: "anggota-edit",
        component: () =>
          import(/* webpackChunkName: "edit" */ "@/views/Anggota/Edit"),
      },
      {
        path: "/peminjaman",
        name: "Peminjaman",
        component: () =>
          import(
            /* webpackChunkName: "peminjaman" */ "@/views/Peminjaman/Index"
          ),
      },
      {
        path: "/peminjaman/show/:id",
        name: "peminjaman-show",
        component: () =>
          import(
            /* webpackChunkName: "peminjaman-show" */ "@/views/Peminjaman/Show"
          ),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
