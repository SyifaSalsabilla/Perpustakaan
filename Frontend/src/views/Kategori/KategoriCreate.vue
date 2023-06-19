<template>
  <v-container id="create-kategori" fluid tag="section">
    <v-row justify="center">
      <v-col cols="12" md="12">
        <v-card>
          <v-card-title primary-title>
            Tambah Kategori
          </v-card-title>
          <v-form @submit.prevent="submitKategori">
            <v-container class="py-0">
              <v-row>
                <v-col cols="12" md="12">
                  <v-text-field label="Kode Kategori" class="purple-input" v-model="kategori.kode" />
                </v-col>
                <v-col cols="12" md="12">
                  <v-text-field label="Kategori" class="purple-input" v-model="kategori.kategori" />
                </v-col>
                <v-col cols="12" class="text-right">
                  <v-btn color="primary" class="mr-0" type="submit">
                    Update Kategori
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const kategori = ref({
  kode: '',
  kategori: ''
});

const API_URL = import.meta.env.VITE_API_URL;
const router = useRouter();


const submitKategori = () => {
  // Mengirim permintaan PUT ke API untuk mengupdate kategori
  axios.post(`${API_URL}/kategori/insert_kategori`, kategori.value)
    .then(() => {
      // Mengarahkan kembali ke halaman Kategori setelah berhasil mengupdate
      router.push({ name: 'Kategori' });
    })
    .catch(err => {
      console.log(err);
    });
};
</script>
