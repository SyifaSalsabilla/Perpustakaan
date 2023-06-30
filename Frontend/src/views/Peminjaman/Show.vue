<template>
  <v-app>
    <v-main>
      <v-container class="px-4 py-6" id="print-container">
        <v-row>
          <v-col cols="12" md="6">
            <v-card>
              <v-toolbar color="primary" dark>
                <v-toolbar-title class="text-uppercase">Detail Peminjaman</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">ID Peminjaman:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.id }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Kode Buku:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.kode_buku }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Tanggal Peminjaman:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.tanggal_peminjaman }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Status Peminjaman:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.status_peminjaman }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item v-if="dataPeminjaman.status_peminjaman === 'DIKEMBALIKAN'">
                    <v-list-item-title class="font-weight-bold">Tanggal Pengembalian:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.tanggal_pengembalian }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item v-if="dataPeminjaman.status_peminjaman === 'DIKEMBALIKAN'">
                    <v-list-item-title class="font-weight-bold">Durasi Keterlambatan:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjaman.durasi_keterlambatan }} hari</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" md="6">
            <v-card>
              <v-toolbar color="primary" dark>
                <v-toolbar-title class="text-uppercase">Informasi Peminjam</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">ID Peminjam:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.id }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Nomor Anggota:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.nomor }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Nama:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.nama }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Jenis Kelamin:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.jenis_kelamin }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Alamat:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.alamat }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">No. HP:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.no_hp }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Tanggal Terdaftar:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataPeminjam.tanggal_terdaftar }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-card>
              <v-toolbar color="primary" dark>
                <v-toolbar-title class="text-uppercase">Informasi Buku</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Kode Buku:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataBuku.kode }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Judul:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataBuku.judul }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Pengarang:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataBuku.pengarang }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Penerbit:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataBuku.penerbit }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Tahun Terbit:</v-list-item-title>
                    <v-list-item-subtitle>{{ dataBuku.tahun }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Harga:</v-list-item-title>
                    <v-list-item-subtitle>{{ formatCurrency(dataBuku.harga) }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title class="font-weight-bold">Gambar:</v-list-item-title>
                    <v-list-item-subtitle>
                      <img :src="API_URL + '/' + dataBuku.file_cover" alt="Gambar Buku"
                        style="max-width: 200px; max-height: 200px">
                    </v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="printPage">Print</v-btn>
            </v-card-actions>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const dataPeminjaman = ref({})
const dataPeminjam = ref({})
const dataBuku = ref({})

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
    const idPeminjaman = router.currentRoute.value.params.id
    const response = await axios.get(`${API_URL}/list_peminjaman_detail?id=${idPeminjaman}`)
    const peminjamanData = response.data.data[0]
    dataPeminjaman.value = peminjamanData.data_peminjaman
    dataPeminjam.value = peminjamanData.data_peminjam
    await fetchBukuData(dataPeminjaman.value.kode_buku)
  } catch (error) {
    console.error(error)
  }
}

const fetchBukuData = async (kodeBuku) => {
  try {
    const response = await axios.get(`${API_URL}/api/buku/select_buku_by_kode?kode=${kodeBuku}`)
    const bukuData = response.data.data[0]
    dataBuku.value = bukuData
  } catch (error) {
    console.error(error)
  }
}

const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  })
  return formatter.format(value)
}

const printPage = () => {
  const printContainer = document.getElementById('print-container')
  const printContents = printContainer.innerHTML
  const originalContents = document.body.innerHTML
  document.body.innerHTML = printContents
  window.print()
  document.body.innerHTML = originalContents
}
</script>

<style>
@media print {
  v-app {
    max-width: 100%;
    margin: 0;
    box-shadow: none;
  }

  v-toolbar {
    display: none;
  }

  v-card {
    box-shadow: none;
    border: none;
  }

  v-card-title,
  v-card-text {
    color: #000;
  }

  v-card-text::after {
    display: none;
  }

  v-list-item-title,
  v-list-item-subtitle {
    color: #000;
  }

  v-btn {
    display: none;
  }
}

/* Styling tambahan untuk tampilan modern */
.v-toolbar {
  margin-bottom: 16px;
}

.v-card {
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.v-card-title {
  padding: 16px;
  font-size: 18px;
  font-weight: bold;
  background-color: #f5f5f5;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
}

.v-list {
  padding: 0;
}

.v-list-item {
  border-bottom: 1px solid #e0e0e0;
}

.v-list-item:last-child {
  border-bottom: none;
}

.font-weight-bold {
  font-weight: bold;
}
</style>
