<template>
  <v-app>
    <v-app-bar app flat dense color="primary">
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click="drawerOpen = !drawerOpen"></v-app-bar-nav-icon>
      </template>

      <v-icon>mdi-circle-slice-6</v-icon>

      <v-app-bar-title>Perpustakaan</v-app-bar-title>

      <v-spacer></v-spacer>

    </v-app-bar>

    <v-main>
      <v-container>
        <v-row>
          <v-col cols="12" sm="8" offset-sm="2">
            <v-navigation-drawer v-model="drawerOpen" color="#111340" theme="dark">
              <v-list nav>
                <v-list-item prepend-icon="mdi-shape" @click="navigate('Kategori')" title="Kategori"
                  value="Kategori"></v-list-item>
                <v-list-item prepend-icon="mdi-book" @click="navigate('Buku')" title="List Buku"
                  value="book"></v-list-item>
                <v-list-item prepend-icon="mdi-account" @click="navigate('Anggota')" title="List Anggota"
                  value="anggota"></v-list-item>
              </v-list>
            </v-navigation-drawer>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="12">
            <router-view></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'App',
  setup() {
    const drawerOpen = ref(true);
    const router = useRouter();

    const navigate = (value) => {
      router.push({ name: value });
    };

    return {
      drawerOpen,
      navigate,
    };
  },
};
</script>
