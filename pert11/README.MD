# LAPORAN PRAKTIKUM PEMROGRAMAN BERBASIS OBJEK

| Informasi Praktikan | Keterangan |
| :--- | :--- |
| **Nama** | *Prevansyah Sjafar* |
| **NPM** | *4525210057* |
| **Kelas** | A |
| **Mata Kuliah** | Pemrograman Berbasis Objek (PBO) |
| **Pertemuan** | 11 — Generics, Collections, Functional Style, dan Unit Testing |
| **Tanggal** | *Kamis 12 November 2026* |
| **Dosen Pengampu** | *Adi Wahyu Pribadi, S.Si., M.Kom* |

---

## 1. Implementasi Java

Program Java menggunakan package `id.ac.univpancasila.perpustakaan` dan dibangun dengan Maven. Pada pertemuan ini dibuat kelas generik `Repository<T>` yang menyimpan data dalam `Map`, lalu diuji dengan JUnit 5. Bagian ini memuat berkas yang kodenya berubah dari kerangka awal (*sebelum*) menjadi hasil pengerjaan (*sesudah*).

### 1.1. `Repository.java`

**Penjelasan kode:**

Kelas generik `Repository<T>` dengan *type parameter* `T`, sehingga bisa dipakai untuk tipe apa pun, tetapi setelah dipakai sebagai `Repository<Buku>` kompilator memastikan hanya `Buku` yang masuk dan keluar. Data disimpan di `LinkedHashMap` agar urutan penyimpanan terjaga. Kunci tiap item diambil lewat `Function<T, String> pengambilKunci`, jadi `Repository` tidak perlu tahu isi `T`. Empat method yang dikerjakan:

- `simpan()` menyimpan item dengan kunci dari `pengambilKunci` (kunci sama menimpa item lama).
- `cariById()` mengembalikan `Optional`, bukan `null`.
- `cariSemua()` mengembalikan salinan tak-berubah lewat `List.copyOf()` agar koleksi internal tidak bocor.
- `hapus()` mengembalikan `true` bila ada item yang terhapus.

**Screenshot sebelum:**

Method `simpan()`, `cariById()`, `cariSemua()`, dan `hapus()` masih kosong (hanya berisi komentar TODO 1–4).

![Repository.java sebelum](../img/befor/pert11/Repository.java.png)

**Screenshot sesudah:**

Keempat method sudah terisi implementasinya.

![Repository.java sesudah](../img/after/pert11/Repository.java.png)

### 1.2. `RepositoryTest.java`

**Penjelasan kode:**

Unit test pertama untuk `Repository`, dengan total **11 uji**. `@BeforeEach` membuat `Repository` baru sebelum setiap uji sehingga antar-uji tidak saling memengaruhi. Lima uji utama (TODO 1–5):

- item yang disimpan dapat ditemukan kembali,
- id yang tidak ada mengembalikan `Optional` kosong,
- item yang dihapus tidak ditemukan lagi,
- repository baru berisi nol item,
- `cariSemua()` tidak bisa diubah dari luar (`UnsupportedOperationException`).

Enam uji tambahan:

- kunci sama menimpa item lama,
- menghapus id yang tidak ada mengembalikan `false`,
- peminjaman yang sah mengurangi stok satu eksemplar,
- `pinjam()` melempar `BukuTidakDitemukanException` untuk ISBN tak terdaftar,
- `pinjam()` melempar `BatasPinjamTerlampauiException` setelah tiga pinjaman,
- `pinjam()` melempar `BukuSedangDipinjamException` bila stok habis.

**Screenshot sebelum:**

Method uji `TODO 1–5` masih kosong, belum ada `assert`.

![RepositoryTest.java sebelum](../img/befor/pert11/RepositoryTest.java.png)

**Screenshot sesudah:**

Semua uji sudah berisi `assertTrue`, `assertEquals`, `assertFalse`, dan `assertThrows`, ditambah enam uji tambahan.

![RepositoryTest.java sesudah](../img/after/pert11/RepositoryTest.java.png)

### Output Java

Program dijalankan dengan `mvn exec:java`. Output memperlihatkan menu utama, lalu form tambah buku dengan ISBN `4525210057`, judul `Prevansyah sjafar`, dan 3 eksemplar. Program menampilkan pesan `BERHASIL`, kembali ke menu, lalu keluar (pilihan `0`) dan mengekspor daftar buku ke `laporan_buku.txt`.

![Output Java](../img/after/pert11/outputjava.png)

**Hasil pengujian (`mvn test`):**

Laporan Surefire (`target/surefire-reports`) mencatat semua uji `RepositoryTest` lulus:

```text
Tests run: 11, Failures: 0, Errors: 0, Skipped: 0
```

---

## 2. Implementasi PHP

Program PHP memakai namespace `Perpustakaan\Model` (kelas) dan `Perpustakaan\Tests` (pengujian). PHP tidak punya generics, jadi padanannya dibuat dengan *typed collection class* `KoleksiBuku`. Pengujian memakai PHPUnit. Bagian ini memuat berkas yang kodenya berubah dari kerangka awal (*sebelum*) menjadi hasil pengerjaan (*sesudah*).

### 2.1. `KoleksiBuku.php`

**Penjelasan kode:**

Typed collection class sebagai padanan generics. Kelas ini `implements IteratorAggregate` (bisa dipakai di `foreach`) dan `Countable` (bisa dipakai di `count()`). Item disimpan di array dengan kunci ISBN. Method yang dikerjakan:

- `simpan()` menyimpan buku dengan kunci ISBN.
- `cariByIsbn()` mengembalikan `?Buku` (buku atau `null`).
- `filter()` memakai `array_filter` lalu `array_values` agar indeks tidak berlubang.
- `map()` memakai `array_map`. Urutan argumennya berbeda dari `array_filter` (callable dulu).
- `jumlahkan()` memakai `array_reduce`.
- `kelompokkan()` mengelompokkan item berdasarkan kunci hasil fungsi.

**Screenshot sebelum:**

Method `simpan()`, `cariByIsbn()`, `filter()`, `map()`, `jumlahkan()`, dan `kelompokkan()` masih kosong (TODO 1–6).

![KoleksiBuku.php sebelum](../img/befor/pert11/KoleksiBuku.php.png)

**Screenshot sesudah:**

Semua method sudah terisi implementasinya.

![KoleksiBuku.php sesudah](../img/after/pert11/KoleksiBuku.php.png)

### 2.2. `KoleksiBukuTest.php`

**Penjelasan kode:**

Unit test PHPUnit untuk `KoleksiBuku`, dengan total **12 uji**. `setUp()` membuat koleksi baru sebelum setiap uji, dan `isiTigaBuku()` mengisi tiga buku (stok 2, 0, dan 1) sebagai data uji bersama. Lima uji utama (TODO 1–5):

- item yang disimpan dapat ditemukan kembali,
- ISBN tak ada mengembalikan `null`,
- koleksi baru berisi nol item (`count()` bekerja karena `Countable`),
- `filter` hanya mengembalikan buku yang lolos predikat,
- `jumlahkan` menghitung total dengan benar.

Tujuh uji tambahan:

- ISBN sama menimpa buku lama,
- `filter` mengembalikan indeks berurutan (tidak berlubang),
- `map` mengembalikan daftar judul,
- `kelompokkan` berdasarkan penulis,
- `pinjam()` melempar `BukuTidakDitemukanException` untuk ISBN tak terdaftar,
- `pinjam()` melempar `BatasPinjamTerlampauiException` setelah tiga pinjaman,
- `pinjam()` melempar `BukuSedangDipinjamException` bila stok habis.

Pengujian dijalankan dengan `./vendor/bin/phpunit tests`.

**Screenshot sebelum:**

Method uji `TODO 1–5` masih kosong, belum ada `assert`.

![KoleksiBukuTest.php sebelum](../img/befor/pert11/KoleksiBukuTest.php.png)

**Screenshot sesudah:**

Semua uji sudah berisi `assertSame`, `assertNull`, `assertCount`, dan `expectException`, ditambah tujuh uji tambahan.

![KoleksiBukuTest.php sesudah](../img/after/pert11/KoleksiBukuTest.php.png)

---

### Output PHP

Program dijalankan dengan `php main.php`. Output terdiri dari tiga bagian: daftar koleksi buku (kode, judul, penulis, stok, jumlah bab), daftar transaksi peminjaman (`PJ-001` sudah kembali, `PJ-002` masih dipinjam), dan simulasi denda keterlambatan `PJ-001` sebesar Rp5.000,00 untuk keterlambatan 5 hari.

![Output PHP](../img/after/pert11/outputphp.png)

---