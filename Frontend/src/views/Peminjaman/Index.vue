<template>
  <v-card>
    <v-card-title primary-title>
      Peminjaman Table
      <v-spacer></v-spacer>
      <v-btn color="primary" text @click="dialog = true" class="mr-2">
        <v-icon left>mdi-plus</v-icon>
        Tambah
      </v-btn>
    </v-card-title>
    <v-card-actions>
      <v-btn color="primary" text @click="showStatus('DIPINJAM')">
        <v-icon left>mdi-book-open-variant</v-icon>
        Dipinjam
      </v-btn>
      <v-btn color="primary" text @click="showStatus('DIKEMBALIKAN')">
        <v-icon left>mdi-book-check-outline</v-icon>
        Dikembalikan
      </v-btn>
    </v-card-actions>

    <!-- v-dialog for creating new peminjaman -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          Form Peminjaman
        </v-card-title>
        <v-form @submit.prevent="createPeminjaman">
          <v-container grid-list-xs>
            <v-select v-model="newPeminjaman.nomor_anggota" :items="dataAnggota.map(a => a.nomor + ' - ' + a.nama)"
              label="Anggota" required></v-select>
            <v-select v-model="newPeminjaman.kode_buku" :items="dataBuku.map(a => a.kode + ' - ' + a.judul)"
              label="Data Buku" required></v-select>
            <v-text-field v-model="newPeminjaman.tanggal_peminjaman" label="Tanggal Pinjam" type="date"
              required></v-text-field>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
            <v-btn color="blue darken-1" text @click="createPeminjaman">Save</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <!-- Edit Dialog -->
    <v-dialog v-model="editDialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          Form Pengembalian
        </v-card-title>
        <v-form @submit.prevent="editPeminjamanData">
          <v-container grid-list-xs>
            <v-text-field v-model="editPeminjaman.tanggal_pengembalian" label="Tanggal Pengembalian"
              type="date"></v-text-field>
            <v-text-field v-model="editPeminjaman.durasi_keterlambatan" label="Terlambat" type="number"></v-text-field>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="editDialog = false">Close</v-btn>
            <v-btn color="blue darken-1" text @click="editPeminjamanData">Save</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <!-- Your table as it was -->
    <v-container grid-list-xs>
      <v-table>
        <thead>
          <tr>
            <th class="text-left">
              Id
            </th>
            <th class="text-left">
              Tanggal Peminjaman
            </th>
            <th class="text-left">
              Status Peminjaman
            </th>
            <th class="text-left">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.tanggal_peminjaman }}</td>
            <td>{{ item.status_peminjaman }}</td>
            <td>
              <template v-if="item.status_peminjaman === 'DIPINJAM'">
                <v-btn size="x-small" prepend-icon="mdi-pencil" variant="outlined" color="warning" text
                  @click="openEditDialog(item)">Kembalikan</v-btn>
              </template>
              <v-btn size="x-small" @click="navigate('peminjaman-show', { 'id': item.id })" prepend-icon="mdi-trash-can"
                variant="outlined" color="info" text>Lihat</v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-container>
  </v-card>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const data = ref([])
const dialog = ref(false)
const editDialog = ref(false)

const newPeminjaman = ref({
  nomor_anggota: '',
  kode_buku: '',
  tanggal_peminjaman: ''
})

const editPeminjaman = ref({
  id: '',
  tanggal_pengembalian: '',
  durasi_keterlambatan: '',
  status_peminjaman: 'DIKEMBALIKAN'
})

const dataAnggota = ref([])
const dataBuku = ref([])

const API_URL = import.meta.env.VITE_API_URL

onMounted(async () => {
  try {
    await fetchData()
    await getDataAnggota()
    await getDataBuku()
  } catch (error) {
    console.error(error)
  }
})

const fetchData = async () => {
  try {
    const response = await axios.get(`${API_URL}/list_peminjaman`)
    data.value = response.data.data
  } catch (error) {
    console.error(error)
  }
}

const navigate = (value, params = {}) => {
  router.push({ name: value, params })
}

const showStatus = async (status = 'DIPINJAM') => {
  try {
    const response = await axios.get(`${API_URL}/list_peminjaman?status=${status}`)
    data.value = response.data.data
  } catch (error) {
    console.error(error)
  }
}

const createPeminjaman = async () => {
  try {
    if (newPeminjaman.value.nomor_anggota !== '' && newPeminjaman.value.kode_buku !== '' && newPeminjaman.value.tanggal_peminjaman !== '') {
      let formData = new FormData();
      formData.append('nomor_anggota', newPeminjaman.value.nomor_anggota);
      formData.append('kode_buku', newPeminjaman.value.kode_buku.split(' - ')[0]);
      formData.append('tanggal_peminjaman', newPeminjaman.value.tanggal_peminjaman);
      formData.append('status_peminjaman', 'DIPINJAM');

      const response = await fetch(`${API_URL}/peminjaman`, {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      if (data && data.status === "success") {
        newPeminjaman.value = {
          tanggal_peminjaman: '',
          nomor_anggota: '',
          kode_buku: '',
          status_peminjaman: 'DIPINJAM'
        };
        dialog.value = false;
        await fetchData();
      } else {
        console.error("Failed to save data: ", data);
      }
    }
  } catch (error) {
    console.error("Error when saving data: ", error);
  }
}

const getDataAnggota = async () => {
  try {
    const response = await fetch(`${API_URL}/anggota/select_anggota_all`)
    const data = await response.json();
    dataAnggota.value = data.data;
  } catch (error) {
    console.error(error)
  }
}

const getDataBuku = async () => {
  try {
    const response = await fetch(`${API_URL}/api/buku/select_buku_all`)
    const data = await response.json();
    dataBuku.value = data.data;
  } catch (error) {
    console.error(error)
  }
}

const openEditDialog = (item) => {
  editPeminjaman.value = { ...item }
  editDialog.value = true
}

const editPeminjamanData = async () => {
  try {
    if (editPeminjaman.value.nomor_anggota !== '' && editPeminjaman.value.kode_buku !== '' && editPeminjaman.value.tanggal_peminjaman !== '') {
      let formData = new FormData();
      formData.append('id', editPeminjaman.value.id);
      formData.append('tanggal_pengembalian', editPeminjaman.value.tanggal_pengembalian);
      formData.append('durasi_keterlambatan', editPeminjaman.value.durasi_keterlambatan);
      formData.append('status_peminjaman', 'DIKEMBALIKAN');

      const response = await fetch(`${API_URL}/pengembalian`, {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      if (data && data.status === "success") {
        editPeminjaman.value = {
          id: '',
          tanggal_pengembalian: '',
          durasi_keterlambatan: ''
        };
        editDialog.value = false;
        await fetchData();
      } else {
        console.error("Failed to update data: ", data);
      }
    }
  } catch (error) {
    console.error("Error when updating data: ", error);
  }
}
</script>
