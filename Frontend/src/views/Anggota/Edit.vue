<template>
  <v-container id="edit-anggota" fluid tag="section">
    <v-row justify="center">
      <v-col cols="12" md="12">
        <v-card>
          <v-card-title primary-title>
            Edit Anggota
          </v-card-title>
          <v-form @submit.prevent="submit">
            <v-container class="py-0">
              <v-row>
                <!-- Nomor -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="anggota.nomor" label="Nomor Anggota" class="purple-input" type="number" />
                </v-col>

                <!-- Nama -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="anggota.nama" label="Nama" class="purple-input" />
                </v-col>

                <!-- Jenis Kelamin -->
                <v-col cols="12" md="12">
                  <v-select v-model="anggota.jenis_kelamin" label="Jenis Kelamin" class="purple-input" :items="jk">
                  </v-select>
                </v-col>

                <!-- No Hp -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="anggota.no_hp" label="Nomor Hp" class="purple-input" type="number" />
                </v-col>

                <!-- Tanggal Terdaftar -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="anggota.tanggal_terdaftar" label="Tanggal Daftar" class="purple-input"
                    type="date" />
                </v-col>

                <!-- Alamat -->
                <v-col cols="12" md="12">
                  <v-text-field v-model="anggota.alamat" label="Alamat" class="purple-input" textarea />
                </v-col>
                <!-- Tombol Update Data -->
                <v-col cols="12" class="text-right">
                  <v-btn color="primary" class="mr-0" type="submit">
                    Update Data
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
      anggota: {
        nomor: '',
        nama: '',
        jenis_kelamin: '',
        alamat: '',
        tanggal_terdaftar: '',
        no_hp: '',
      },
      jk: [
        'Laki-laki', 'Perempuan'
      ]
    };
  },

  created() {
    // Panggil method untuk mendapatkan data anggota berdasarkan nomor anggota yang dikirim sebagai parameter
    const nomorAnggota = this.$route.params.nomor;
    this.fetchAnggotaByNomor(nomorAnggota);
  },

  methods: {
    fetchAnggotaByNomor(nomor) {
      const API_URL = import.meta.env.VITE_API_URL;
      fetch(`${API_URL}/anggota/select_anggota_by_nomor?nomor=${nomor}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            this.anggota = data.data[0];
          } else {
            alert('Gagal mendapatkan data anggota');
          }
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan');
        });
    },

    submit() {
      const formData = new FormData();
      formData.append('nomor', this.anggota.nomor);
      formData.append('nama', this.anggota.nama);
      formData.append('jenis_kelamin', this.anggota.jenis_kelamin);
      formData.append('alamat', this.anggota.alamat);
      formData.append('no_hp', this.anggota.no_hp);
      formData.append('tanggal_terdaftar', this.anggota.tanggal_terdaftar);

      const API_URL = import.meta.env.VITE_API_URL;
      fetch(`${API_URL}/anggota/update_anggota`, {
        method: 'POST',
        body: formData,
      })
        .then(response => {
          if (response.ok) {
            this.$router.push({ name: 'Anggota' });
          } else {
            alert('Data gagal disimpan');
          }
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan');
        });
    },
  }
};
</script>
