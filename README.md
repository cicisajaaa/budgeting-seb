# 💰 Budget Tracker

<p align="center">

<img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel">
<img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php">
<img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql">
<img src="https://img.shields.io/badge/Status-Development-success?style=for-the-badge">

</p>


<h3 align="center">
Sistem Manajemen Keuangan dan Monitoring Anggaran Perusahaan
</h3>


<p align="center">
Budget Tracker merupakan aplikasi berbasis web yang membantu perusahaan dalam mengelola anggaran, pengajuan dana, transaksi keuangan, monitoring proyek, serta pencatatan aktivitas pengguna secara terintegrasi.
</p>


---

# 📌 Tentang Sistem

Budget Tracker dikembangkan untuk membantu proses administrasi keuangan perusahaan agar lebih:

✅ Terstruktur  
✅ Transparan  
✅ Mudah dipantau  
✅ Memiliki histori aktivitas yang jelas  


Sistem menyediakan mekanisme approval keuangan, pengelolaan saldo, monitoring proyek, serta audit trail untuk mencatat setiap aktivitas penting pengguna.


---

# 🚀 Fitur Utama


<table>

<tr>

<td width="50%">

## 📁 Manajemen Proyek

Fitur:

- Pengelolaan data proyek
- Pengaturan divisi proyek
- Alokasi anggaran
- Monitoring penggunaan dana


</td>

<td width="50%">

## 💸 Pengajuan Dana

Fitur:

- Membuat pengajuan dana
- Upload bukti transaksi
- Tracking status pengajuan
- Riwayat pengajuan


</td>

</tr>


<tr>

<td>

## ✅ Approval Finance

Fitur:

- Verifikasi pengajuan
- Approve dana
- Reject dengan catatan
- Update saldo otomatis


</td>


<td>

## 📊 Monitoring Keuangan

Fitur:

- Saldo rekening bank
- Saldo divisi
- Transaksi dana
- Riwayat penggunaan


</td>

</tr>


<tr>

<td>

## 👥 Employee Tracker

Fitur:

- Pengelolaan tugas
- Aktivitas harian
- Monitoring pekerjaan


</td>


<td>

## 🔎 Audit Trail

Fitur:

- Login
- Logout
- Create data
- Approval
- Reject


</td>

</tr>

</table>


---

# 👤 Hak Akses Pengguna


| Role | Akses |
|---|---|
| 👨‍💼 Administrator | Mengelola data utama sistem |
| 👷 Karyawan | Membuat pengajuan dana dan aktivitas pekerjaan |
| 💼 Finance | Melakukan approval dan monitoring transaksi |


---

# 🔄 Alur Sistem


```
                PROJECT MANAGEMENT

                       |
                       ↓

              Alokasi Anggaran

                       |
                       ↓

              Karyawan Mengajukan Dana

                       |
                       ↓

              Status Pending

                       |
                       ↓

              Finance Melakukan Review

              /                    \

             ↓                      ↓

        Approved              Rejected

             |

             ↓

      Transaksi Dana Dibuat

             |

             ↓

       Saldo Diperbarui

             |

             ↓

        Audit Trail Tersimpan

```


---

# 🖥️ Tampilan Sistem


## Dashboard

```
Tambahkan screenshot dashboard disini
```


## Pengajuan Dana

```
Tambahkan screenshot pengajuan dana disini
```


## Approval Finance

```
Tambahkan screenshot approval disini
```


## Audit Trail

```
Tambahkan screenshot audit trail disini
```


---

# 🛠️ Teknologi


| Teknologi | Penggunaan |
|-|-|
| Laravel | Backend Framework |
| PHP | Programming Language |
| MySQL | Database |
| Blade Template | Frontend View |
| CSS | Styling Interface |
| JavaScript | Interactive Component |


---

# 📂 Struktur Project


```
budget-tracker

├── app

│   ├── Models

│   ├── Controllers

│   ├── Notifications

│   └── Helpers


├── database

│   └── migrations


├── resources

│   └── views


├── routes

│   └── web.php


└── public

```


---

# 🗄️ Database Utama


| Table | Deskripsi |
|-|-|
| users | Data pengguna |
| proyek | Data proyek |
| divisi | Data divisi |
| pengajuan_dana | Data permintaan dana |
| transaksi_dana | Riwayat transaksi |
| rekening_bank | Data rekening |
| saldo_divisi | Saldo divisi |
| log_audit | Histori aktivitas |
| tasks | Data pekerjaan |
| task_activities | Aktivitas tugas |


---

# ⚙️ Instalasi


## 1. Clone Repository

```bash
git clone https://github.com/username/budget-tracker.git
```


## 2. Masuk Folder Project

```bash
cd budget-tracker
```


## 3. Install Dependency

```bash
composer install
```


## 4. Konfigurasi Environment

```bash
cp .env.example .env
```


Generate key:

```bash
php artisan key:generate
```


---

## 5. Konfigurasi Database


Edit file:

```
.env
```


Contoh:


```env
DB_DATABASE=budget_tracker
DB_USERNAME=root
DB_PASSWORD=
```


---

## 6. Jalankan Migration


```bash
php artisan migrate
```


---

## 7. Jalankan Storage


```bash
php artisan storage:link
```


---

## 8. Jalankan Server


```bash
php artisan serve
```


Akses:


```
http://127.0.0.1:8000
```


---

# 🔐 Keamanan Sistem


Implementasi keamanan:

- Laravel Authentication
- Role Middleware
- Request Validation
- Database Transaction
- Audit Logging
- Permission Control


---

# 📈 Pengembangan Selanjutnya


Rencana pengembangan:

- Dashboard grafik keuangan
- Export laporan PDF
- Approval bertingkat
- Email notification
- Real-time monitoring


---

# 👨‍💻 Developer


**Budget Tracker System**

Developed using:

- Laravel Framework
- MySQL Database
- Web Technology


---

<p align="center">

⭐ Jika project ini membantu, berikan star pada repository ini.

</p>
