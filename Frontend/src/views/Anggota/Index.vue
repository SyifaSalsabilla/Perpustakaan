<template>
  <v-card>
    <v-card-title primary-title>
      Anggota Table
      <v-spacer></v-spacer>
      <v-text-field v-model="searchQuery" label="Cari Anggota By Nomor Anggota" solo-inverted hide-details></v-text-field>
    </v-card-title>
    <v-card-actions>
      <v-btn color="primary" text @click="navigate('anggota-create')">Tambah</v-btn>
    </v-card-actions>

    <v-container class="py-0">
      <v-table>
        <thead>
          <tr>
            <th class="text-left">
              Id
            </th>
            <th class="text-left">
              Nomor
            </th>
            <th class="text-left">
              Nama
            </th>
            <th class="text-left">
              Jenis Kelamin
            </th>
            <th class="text-left">
              Alamat
            </th>
            <th class="text-left">
              No Hp
            </th>
            <th class="text-left">
              Tanggal Terdaftar
            </th>
            <th class="text-left">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in filteredData" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.nomor }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.jenis_kelamin }}</td>
            <td>{{ item.alamat }}</td>
            <td>{{ item.no_hp }}</td>
            <td>{{ item.tanggal_terdaftar }}</td>
            <td>
              <v-btn size="x-small" prepend-icon="mdi-pencil" variant="outlined" color="warning" text
                @click="navigate('anggota-edit', { nomor: item.nomor })">Edit</v-btn>
              <v-btn size="x-small" prepend-icon="mdi-trash-can" variant="outlined" color="red" text
                @click="confirmDelete(item.nomor)">Hapus</v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-container>
  </v-card>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const data = ref([])
const searchQuery = ref('')
const API_URL = import.meta.env.VITE_API_URL;

onMounted(async () => {
  try {
    await fetchData()
  } catch (error) {
    console.error(error)
  }
})

const fetchData = async () => {
  try {
    const response = await axios.get(`${API_URL}/anggota/select_anggota_all`)
    data.value = response.data.data
  } catch (error) {
    console.error(error)
  }
}

const navigate = (value, params = {}) => {
  router.push({ name: value, params })
}

const confirmDelete = async (nomor) => {
  const confirmed = confirm("Anda yakin ingin menghapus anggota ini?")
  if (confirmed) {
    try {
      await axios.delete(`${API_URL}/anggota/delete_anggota`, { data: { nomor: nomor } })
      await fetchData() // Memuat ulang data setelah penghapusan berhasil
    } catch (error) {
      console.error(error)
    }
  }
};

const filteredData = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return data.value.filter(item => item.nomor.toLowerCase().includes(query))
})
</script>
