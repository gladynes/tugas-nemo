# README.md

## Deskripsi Proyek
web app ini  merupakan bentuk dari web app dengan kerentan sederhana untuk mencoba sqlinjesi dengan adanya halaman login dengan mengunakan  data user yang ada di database 

## Tampilan Web 
    halaman login 
  ![alt text](foto/halaman_login.png)
  ---
## Fitur Utama

1. **Login:**
   - Memastikan bahwa username dan password tidak kosong sebelum memproses login.
   
2. **Otentikasi Pengguna:**
   - Memeriksa kecocokan username dan password dengan data yang disimpan di database.

3. **Pengelolaan Sesi:**
   - Menyimpan informasi pengguna yang berhasil login ke dalam sesi, termasuk `username`, `role`, dan `user_id`.

4. **Pengalihan Berdasarkan Role:**
   - Admin diarahkan ke `admindas.php`.
   - User diarahkan ke `userdas.php`.

5. **Pesan Kesalahan:**
   - Memberikan feedback kepada pengguna jika terjadi kesalahan seperti input kosong, username/password salah, atau role yang tidak valid.
 ## Fitur Pada Dasbord Admin 

 
     
## Struktur Kode

### 1. **Bagian Backend**
- Memulai sesi menggunakan `session_start()`.
- Memproses data form menggunakan metode `POST`.
- Menjalankan query SQL untuk memeriksa kredensial pengguna.
- Menyimpan data sesi untuk pengguna yang berhasil login.

### 2. **Bagian Frontend**
- Formulir login dengan input untuk username dan password.
- Pesan kesalahan ditampilkan jika ada masalah dengan login.
- Link untuk mendaftar akun baru menuju `register.php`.

## Cara Menggunakan

1. **Prasyarat:**
   - Pastikan server web seperti Apache dengan modul PHP aktif.
   - Database yang berisi tabel `data_user` sudah dibuat dan terhubung dengan file `db.php`.

2. **Langkah-Langkah:**
   - Salin semua file ke direktori server web Anda.
   - Pastikan file `db.php` berisi konfigurasi koneksi database yang benar.
   - Akses halaman login melalui browser.
   - Masukkan username dan password yang valid untuk login.

```sql
CREATE TABLE data_user (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  alamat TEXT DEFAULT NULL,
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (id)
);
```
## dasbord admin 
pada dasbord admin memiliki 2 fitur yakni untuk chat dan merubah role dari user yang ada 
dasbord admin ini
![alt text](<foto/dasbord_admin .png>)
 1. **untuk membuat user jadi admin**
---
   pada bagina ini admin dapat merubah pengguna web dari memiliki role user ke admin 
2. **melakukan chat ke user**
pada dasbord ini admin dapat melakukan chat ke user lain dengan tinggal menekan tombol chat 
3. **ubah dasbord**
   admin dapat melakukan akses ke dasbord user melalui dasbord admin.
4. **melihat data user**
    pada dasbord ini admin juga bisa melihat data dari user mulai dari nama ,gmail,alamat user 
5. **logout**
    admin dapat logout lasung dari dasbord admin 
