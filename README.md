# AutoExpert

**AutoExpert** adalah sistem pendukung keputusan berbasis web yang dirancang untuk membantu pengemudi taksi online dalam mengalokasikan sebagian pendapatan harian sebagai dana servis kendaraan.

Sistem ini menerapkan metode **Forward Chaining** untuk menentukan persentase dana yang perlu dialokasikan berdasarkan jumlah pendapatan harian pengguna.

## 📌 Latar Belakang

Pendapatan pengemudi taksi online dapat berubah-ubah setiap hari. Kondisi tersebut dapat membuat pengelolaan dana untuk kebutuhan servis kendaraan menjadi kurang terencana.

AutoExpert dikembangkan untuk membantu pengguna mengelola dana servis kendaraan dengan cara mencatat pendapatan harian dan secara otomatis menentukan jumlah dana yang perlu disisihkan berdasarkan aturan yang telah ditentukan.

## 🎯 Tujuan

Sistem ini bertujuan untuk:

- Membantu pengguna mencatat pendapatan harian.
- Membantu mengelola dana yang dialokasikan untuk servis kendaraan.
- Menentukan persentase dana servis secara otomatis berdasarkan pendapatan harian.
- Menampilkan perkembangan dana servis melalui dashboard.
- Memberikan rekomendasi terkait kondisi kendaraan melalui fitur konsultasi.

## ⚙️ Cara Kerja Forward Chaining

AutoExpert menggunakan metode **Forward Chaining** untuk menentukan persentase dana servis berdasarkan fakta berupa pendapatan harian pengguna.

Aturan yang digunakan adalah:

| Rule | Kondisi Pendapatan | Dana yang Dialokasikan |
|------|--------------------|------------------------|
| R1 | Pendapatan < Rp150.000 | 15% |
| R2 | Rp150.000 ≤ Pendapatan ≤ Rp250.000 | 10% |
| R3 | Pendapatan > Rp250.000 | 5% |

Contoh:

Jika pengguna memperoleh pendapatan sebesar **Rp127.000**, maka sistem mencocokkan fakta tersebut dengan **Rule R1**.

Perhitungan:

**Rp127.000 × 15% = Rp19.050**

Maka sistem secara otomatis mengalokasikan **Rp19.050** sebagai dana servis kendaraan.

## 🚀 Fitur Utama

### 1. Dashboard

Menampilkan ringkasan kondisi keuangan pengguna, seperti:

- Total tabungan servis
- Jumlah hari menabung
- Total pendapatan
- Rekomendasi
- Grafik pendapatan dan tabungan

### 2. Input Pendapatan Harian

Pengguna dapat memasukkan pendapatan yang diperoleh setiap hari.

Data tersebut kemudian diproses oleh sistem menggunakan metode Forward Chaining untuk menentukan persentase dana servis.

### 3. Tabungan Servis

Menampilkan:

- Saldo dana servis
- Riwayat setoran
- Pendapatan harian
- Dana yang dialokasikan
- Status dana servis

### 4. Konsultasi Kendaraan

Fitur tambahan yang memungkinkan pengguna memasukkan informasi kendaraan dan memperoleh rekomendasi terkait kondisi kendaraan.

### 5. Riwayat Konsultasi

Pengguna dapat melihat kembali hasil konsultasi kendaraan yang pernah dilakukan.

## 🛠️ Teknologi yang Digunakan

- **Laravel** — Framework pengembangan aplikasi web
- **PHP** — Bahasa pemrograman
- **MySQL** — Database
- **Laragon** — Local development environment
- **Tailwind CSS** — Styling antarmuka
- **Vite** — Asset bundling dan development tool
- **Git & GitHub** — Version control dan repository

## 🗄️ Database

Sistem menggunakan database MySQL untuk menyimpan data pengguna, pendapatan, aturan, serta data konsultasi.

Beberapa tabel utama yang digunakan antara lain:

- `users`
- `pendapatan` / `incomes`
- `rules`
- `konsultasi` / `consultations`

Struktur database digunakan untuk mendukung proses pencatatan pendapatan, perhitungan dana servis, penerapan aturan Forward Chaining, dan penyimpanan hasil konsultasi.

## 🧪 Pengujian

Pengujian sistem dilakukan menggunakan **25 sampel data pendapatan harian** untuk menguji penerapan metode Forward Chaining dan perhitungan dana servis.

| Parameter | Hasil |
|-----------|-------|
| Jumlah Sampel | 25 |
| Eksekusi Rule | Berhasil |
| Perhitungan Dana | Akurat |
| Tingkat Akurasi | 100% |

Berdasarkan hasil pengujian, sistem berhasil mengidentifikasi rule yang sesuai dan menghitung alokasi dana servis berdasarkan aturan yang telah ditentukan.

## 📷 Tampilan Sistem

Screenshot aplikasi akan ditambahkan pada bagian ini, meliputi:

- Dashboard
- Input Pendapatan
- Tabungan Servis
- Konsultasi Kendaraan
- Hasil Konsultasi

## 📂 Struktur Project

Project ini dikembangkan menggunakan framework Laravel dengan struktur utama:

```text
AutoExpert/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
└── package.json
