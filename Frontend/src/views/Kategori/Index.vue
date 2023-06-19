<template>
  <v-card>
    <v-card-title primary-title>
      Kategori Table
      <v-spacer></v-spacer>
      <v-text-field v-model="searchQuery" label="Cari Kategori By Kode Kategori" solo-inverted
        hide-details></v-text-field>
    </v-card-title>
    <v-card-actions>
      <v-btn color="primary" text @click="navigate('kategori-create')">Tambah</v-btn>
    </v-card-actions>

    <v-container grid-list-xs>
      <v-table>
        <thead>
          <tr>
            <th class="text-left">
              Id
            </th>
            <th class="text-left">
              Kode
            </th>
            <th class="text-left">
              Kategori
            </th>
            <th class="text-left">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in filteredData" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.kode }}</td>
            <td>{{ item.kategori }}</td>
            <td>
              <v-btn size="x-small" prepend-icon="mdi-pencil" variant="outlined" color="warning" text
                @click="navigate('kategori-edit', { kode: item.kode })">Edit</v-btn>
              <v-btn size="x-small" prepend-icon="mdi-trash-can" variant="outlined" color="red" text
                @click="confirmDeleteKategori(item.kode)">Hapus</v-btn>
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
const API_URL = import.meta.env.VITE_API_URL

onMounted(async () => {
  try {
    await fetchData()
  } catch (error) {
    console.error(error)
  }
})

const fetchData = async () => {
  try {
    const response = await axios.get(`${API_URL}/kategori/select_kategori_all`)
    data.value = response.data.data
  } catch (error) {
    console.error(error)
  }
}

const navigate = (value, params = {}) => {
  router.push({ name: value, params })
}

const confirmDeleteKategori = async (kode) => {
  const confirmed = confirm("Anda yakin ingin menghapus kategori ini?")
  if (confirmed) {
    try {
      await axios.delete(`${API_URL}/kategori/delete_kategori`, { data: { kode: kode } })
      await fetchData() // Memuat ulang data setelah penghapusan berhasil
    } catch (error) {
      console.error(error)
    }
  }
};

const filteredData = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return data.value.filter(item => item.kode.toLowerCase().includes(query))
})
</script>
