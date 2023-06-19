<template>
  <v-container id="edit-buku" fluid tag="section">
    <v-row justify="center">
      <v-col cols="12" md="12">
        <v-card>
          <v-card-title primary-title>
            Edit Buku
          </v-card-title>
          <v-form @submit.prevent="submitBuku">
            <v-container class="py-0">
              <v-row>
                <!-- Kode Buku -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.kode" label="Kode Buku" class="purple-input" />
                </v-col>

                <!-- Kode Kategori -->
                <v-col cols="12" md="12">
                  <v-select v-model="buku.kode_kategori" label="Kode Kategori" class="purple-input" :items="kategoris"
                    item-text="kategori" item-value="kode"></v-select>
                </v-col>

                <!-- Judul -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.judul" label="Judul" class="purple-input" />
                </v-col>

                <!-- Pengarang -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.pengarang" label="Pengarang" class="purple-input" />
                </v-col>

                <!-- Penerbit -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.penerbit" label="Penerbit" class="purple-input" />
                </v-col>

                <!-- Tahun -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.tahun" label="Tahun" class="purple-input" type="number" />
                </v-col>

                <!-- Tanggal Input -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.tanggal_input" label="Tanggal Input" class="purple-input" type="date" />
                </v-col>

                <!-- Harga -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="buku.harga" label="Harga" class="purple-input" />
                </v-col>

                <!-- File Cover -->
                <v-col cols="12" md="12">
                  <v-file-input v-model="buku.file_cover" label="File Cover" class="purple-input" accept="image/*"
                    @change="onFileChange" />
                </v-col>

                <!-- Tombol Update Buku -->
                <v-col cols="12" class="text-right">
                  <v-btn color="primary" class="mr-0" type="submit">
                    Update Buku
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

<script>
export default {
  data() {
    return {
      buku: {
        kode: '',
        kode_kategori: '',
        judul: '',
        pengarang: '',
        penerbit: '',
        tahun: null,
        tanggal_input: '',
        harga: '',
        file_cover: [],
        file_cover_old: ''
      },
      kategoris: []
    };
  },
  created() {
    this.fetchKategori(); // Panggil metode fetchKategori saat komponen dibuat
  },

  mounted() {
    this.fetchBuku(); // Panggil metode fetchBuku saat komponen telah dimuat
  },

  methods: {
    fetchBuku() {
      const API_URL = import.meta.env.VITE_API_URL;
      const kode = this.$route.params.kode;

      fetch(`${API_URL}/api/buku/select_buku_by_kode?kode=${kode}`)
        .then(response => response.json())
        .then(res => {
          this.buku = {
            kode: res.data[0].kode,
            kode_kategori: res.data[0].kode_kategori,
            judul: res.data[0].judul,
            pengarang: res.data[0].pengarang,
            penerbit: res.data[0].penerbit,
            tahun: res.data[0].tahun,
            tanggal_input: res.data[0].tanggal_input,
            harga: res.data[0].harga,
            file_cover: null,
            file_cover_old: res.data[0].file_cover
          };
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan dalam mengambil data buku');
        });
    },
    fetchKategori() {
      const API_URL = import.meta.env.VITE_API_URL;

      fetch(`${API_URL}/api/select_kategori_all`)
        .then(response => response.json())
        .then(res => {
          this.kategoris = res.data.map(item => [item.kode, item.kategori].join(' - '));
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan dalam mengambil daftar kategori');
        });
    },
    submitBuku() {
      const formData = new FormData();
      formData.append('kode', this.buku.kode);
      formData.append('kode_kategori', this.buku.kode_kategori.split(' - ')[0]);
      formData.append('judul', this.buku.judul);
      formData.append('pengarang', this.buku.pengarang);
      formData.append('penerbit', this.buku.penerbit);
      formData.append('tahun', this.buku.tahun);
      formData.append('tanggal_input', this.buku.tanggal_input);
      formData.append('harga', this.buku.harga);
      formData.append('file_cover_old', this.buku.file_cover_old);
      if (this.buku.file_cover) {
        formData.append('file_cover', this.buku.file_cover[0]);
      }

      const API_URL = import.meta.env.VITE_API_URL;
      fetch(`${API_URL}/api/buku/update_buku`, {
        method: 'POST',
        body: formData,
      })
        .then(response => {
          if (response.ok) {
            this.$router.push({ name: 'Buku' });
          } else {
            alert('Data gagal diperbarui');
          }
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan');
        });
    },
    onFileChange(event) {
      this.buku.file_cover = [event.target.files[0]];
    }
  }
};
</script>
