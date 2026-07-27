# 💰 Budget Tracker System

<p align="center">

<img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel">
<img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php">
<img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql">
<img src="https://img.shields.io/badge/Project-Financial%20Management-success?style=for-the-badge">

</p>


<h2 align="center">
Sistem Informasi Manajemen Anggaran dan Pengajuan Dana Perusahaan
</h2>


<p align="center">
Aplikasi berbasis web untuk mengelola anggaran perusahaan, pengajuan dana, approval keuangan, transaksi, monitoring saldo, serta pencatatan aktivitas pengguna secara terintegrasi.
</p>


---

# 📌 Overview Sistem

**Budget Tracker System** merupakan aplikasi berbasis web yang digunakan untuk membantu perusahaan dalam melakukan pengelolaan keuangan secara lebih efektif, transparan, dan terstruktur.


Sistem ini mencakup proses:

```
Perencanaan Anggaran
        ↓
Manajemen Proyek
        ↓
Pengajuan Dana
        ↓
Verifikasi Keuangan
        ↓
Approval / Reject
        ↓
Transaksi Dana
        ↓
Update Saldo
        ↓
Audit Trail
```


---

# 🎯 Tujuan Sistem

Sistem ini dikembangkan untuk:

- Mempermudah proses pengajuan dana
- Mengurangi proses administrasi manual
- Meningkatkan transparansi penggunaan anggaran
- Mempermudah monitoring keuangan perusahaan
- Menyediakan histori aktivitas pengguna


---

# 🚀 Modul Sistem


## 📁 1. Project Management

Modul ini digunakan untuk mengelola data proyek dan anggaran.


Fitur:

- Membuat proyek
- Mengelola divisi proyek
- Mengatur alokasi dana proyek
- Monitoring penggunaan anggaran


---

## 💸 2. Expense Request Management

Modul pengajuan dana digunakan oleh karyawan untuk mengajukan kebutuhan biaya.


Informasi pengajuan:

- Judul pengajuan
- Proyek
- Divisi
- Jumlah dana
- Keterangan
- Bukti transaksi


Alur proses:

```
Karyawan

    ↓

Membuat Pengajuan Dana

    ↓

Status Pending

    ↓

Finance Melakukan Verifikasi

    ↓

Approved / Rejected
```


---

## ✅ 3. Financial Approval

Modul approval digunakan oleh bagian keuangan.


Fitur:

- Melihat pengajuan pending
- Mengecek saldo rekening
- Mengecek saldo divisi
- Approve pengajuan
- Reject pengajuan dengan catatan


Ketika pengajuan disetujui:


```
Pengajuan Approved

        ↓

Transaksi Dana Dibuat

        ↓

Saldo Bank Berkurang

        ↓

Saldo Divisi Berkurang

        ↓

Audit Log Tersimpan
```


---

## 💰 4. Financial Monitoring


Sistem menyediakan monitoring:


- Saldo rekening bank
- Saldo divisi proyek
- Riwayat transaksi
- Penggunaan anggaran


---

## 👥 5. Employee Activity Tracker


Modul aktivitas karyawan digunakan untuk monitoring pekerjaan.


Fitur:

- Membuat aktivitas harian
- Menghubungkan aktivitas dengan tugas
- Menyimpan histori pekerjaan


---

## 🔎 6. Audit Trail System


Audit trail digunakan untuk mencatat aktivitas penting pengguna.


Aktivitas yang dicatat:


- Login
- Logout
- Membuat pengajuan dana
- Approval dana
- Reject dana
- Aktivitas sistem


Informasi audit:


| Data | Keterangan |
|-|-|
| User | Pengguna yang melakukan aktivitas |
| Action | Jenis aktivitas |
| Module | Modul yang digunakan |
| Description | Detail aktivitas |
| IP Address | Alamat perangkat |
| Timestamp | Waktu aktivitas |


Contoh:


```
CREATE

Membuat pengajuan dana: Laptop

User:
Shahreva

Tanggal:
27 Juli 2026
```


---

# 👤 Role dan Hak Akses


| Role | Deskripsi | Hak Akses |
|-|-|-|
| 👷 Karyawan | Pengguna operasional | Membuat pengajuan dana, upload bukti, melihat status pengajuan |
| 💼 Keuangan | Pengelola keuangan | Verifikasi, approve/reject pengajuan, transaksi dana |
| 🛠️ Admin | Pengelola sistem | Mengelola user, proyek, divisi, rekening |
| 👑 Owner | Monitoring perusahaan | Melihat laporan, monitoring keuangan, melihat aktivitas sistem |


---

# 🔐 Role Permission Matrix


| Fitur | Karyawan | Keuangan | Admin | Owner |
|-|-|-|-|-|
| Login Sistem | ✅ | ✅ | ✅ | ✅ |
| Membuat Pengajuan Dana | ✅ | ❌ | ❌ | ❌ |
| Approval Dana | ❌ | ✅ | ❌ | ❌ |
| Kelola User | ❌ | ❌ | ✅ | ❌ |
| Kelola Project | ❌ | ❌ | ✅ | ❌ |
| Monitoring Keuangan | ❌ | ✅ | ✅ | ✅ |
| Audit Trail | ❌ | ✅ | ✅ | ✅ |


---

# 🏗️ System Architecture


```
              User

                |

                ↓

        Laravel Application

                |

        ----------------

        Controller

                |

        ----------------

              Model

                |

                ↓

             MySQL

             Database

```


---

# 🗄️ Database Structure


| Table | Fungsi |
|-|-|
| users | Data pengguna |
| proyek | Data proyek |
| divisi | Data divisi |
| pengajuan_dana | Data pengajuan dana |
| transaksi_dana | Riwayat transaksi dana |
| rekening_bank | Data rekening |
| saldo_divisi | Saldo divisi |
| log_audit | Riwayat aktivitas pengguna |
| tasks | Data pekerjaan |
| task_activities | Aktivitas pekerjaan |


---

# 🖥️ Application Preview


## Dashboard

Tambahkan screenshot:

```
screenshots/dashboard.png
```


## Pengajuan Dana

```
screenshots/pengajuan.png
```


## Approval Finance

```
screenshots/approval.png
```


## Audit Trail

```
screenshots/audit.png
```


---

# 🛠️ Technology Stack


| Teknologi | Fungsi |
|-|-|
| Laravel | Backend Framework |
| PHP | Programming Language |
| MySQL | Database |
| Blade Template | User Interface |
| CSS | Styling |
| JavaScript | Interactive Feature |


---

# ⚙️ Installation


## 1. Clone Repository

```bash
git clone https://github.com/username/budget-tracker.git
```


Masuk folder:

```bash
cd budget-tracker
```


---

## 2. Install Dependency

```bash
composer install
```


---

## 3. Environment Setup


Copy file:


```bash
cp .env.example .env
```


Generate key:


```bash
php artisan key:generate
```


---

## 4. Database Configuration


Edit file:


```
.env
```


Contoh:


```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=budget_tracker
DB_USERNAME=root
DB_PASSWORD=
```


---

## 5. Migration Database


Jalankan:


```bash
php artisan migrate
```


---

## 6. Storage Setup


```bash
php artisan storage:link
```


---

## 7. Run Application


```bash
php artisan serve
```


Akses:


```
http://127.0.0.1:8000
```


---

# 🛡️ Security Implementation


Sistem menerapkan:


- Laravel Authentication
- Role Based Access Control
- Middleware Authorization
- Request Validation
- Database Transaction
- Audit Logging
- Notification System


---

# 📈 Future Development


Pengembangan selanjutnya:


- Dashboard grafik keuangan
- Export laporan PDF
- Approval bertingkat
- Email notification
- Mobile application
- Real-time monitoring


---

# 👨‍💻 Developer


## Budget Tracker System


Built With:


```
Laravel Framework

MySQL Database

Web Technology
```


---

<p align="center">

⭐ Budget Tracker System  
Financial Management & Expense Monitoring Platform

</p>
