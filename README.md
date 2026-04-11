# SCM HR Monitoring
**PT Sulawesi Cahaya Mineral — SCM Division Konawe**
**MPP-970 | Laravel 11 + MySQL + AdminLTE 3**

---

## 📁 Struktur Modul

| Modul | Deskripsi |
|---|---|
| Dashboard | Overview KPI, chart rekrutmen, karyawan, MPP |
| Rekrutmen | CRUD kandidat + Pipeline Kanban + filter lengkap |
| Karyawan | CRUD Staff & Non-Staff OL + filter |
| MPP Planning | CRUD posisi MPP + monitoring per bulan |
| Gap Analysis | Perbandingan MPP vs karyawan aktif per divisi |
| Master Data | Divisi, Departemen, Jabatan |
| User Management | CRUD user + role-based access |

---

## ⚙️ Setup & Instalasi

### 1. Clone / Extract project
```bash
cd /your/project/folder
```

### 2. Install dependencies
```bash
composer install
```

### 3. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Edit `.env` — sesuaikan database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scm_hr
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Buat database MySQL
```sql
CREATE DATABASE scm_hr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan migrasi dan seeder
```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan aplikasi
```bash
php artisan serve
```
Akses: **http://localhost:8000**

---

## 🔑 Default Login

| Username | Password | Role |
|---|---|---|
| `admin` | `password123` | Administrator |
| `hrmanager` | `password123` | HR Manager |
| `hrstaff` | `password123` | HR Staff |
| `viewer` | `password123` | Viewer |

---

## 📊 Data yang Di-seed dari Excel

- **76 kandidat** rekrutmen (data asli dari sheet `Recruitment`)
- **Master data**: 23 divisi, 30+ departemen
- **Sample karyawan** Staff & Non-Staff
- **MPP positions** untuk tahun 2024, 2025, 2026

---

## 🗄️ Struktur Database

```
users               — Auth + role management
divisis             — Master divisi
departemens         — Master departemen (FK → divisis)
jabatans            — Master jabatan/posisi (FK → departemens)
rekrutmens          — Data kandidat rekrutmen
karyawans           — Data karyawan aktif OL
mpp_positions       — Man Power Planning per tahun + per bulan
activity_logs       — Audit trail semua perubahan
```

---

## 🎨 Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Database**: MySQL 8
- **Frontend**: AdminLTE 3, Bootstrap 4
- **Tables**: Yajra DataTables (server-side)
- **Charts**: Chart.js 3
- **Select**: Select2
- **Import**: Maatwebsite Excel (placeholder)

---

## 📦 Package yang Diperlukan

```json
"require": {
    "laravel/framework": "^11.0",
    "maatwebsite/excel": "^3.1",
    "yajra/laravel-datatables-oracle": "^11.0"
}
```

---

## 🔒 Role & Access

| Role | Dashboard | Rekrutmen | Karyawan | MPP | Master | Users |
|---|---|---|---|---|---|---|
| admin | ✅ | ✅ CRUD | ✅ CRUD | ✅ CRUD | ✅ CRUD | ✅ CRUD |
| hr_manager | ✅ | ✅ CRUD | ✅ CRUD | ✅ CRUD | ✅ CRUD | ❌ |
| hr_staff | ✅ | ✅ CRUD | ✅ CRUD | ✅ CRUD | ✅ CRUD | ❌ |
| viewer | ✅ | 👁️ View | 👁️ View | 👁️ View | ❌ | ❌ |

---

## 🚀 Fitur Utama

1. **Dashboard** — KPI cards, chart donut status, bar chart per bulan, progress per divisi
2. **Filter Rekrutmen** — Tahun, Bulan, Progress, Level, Divisi, Priority, Sumber, Gender, Search
3. **Pipeline View** — Kanban board 3 kolom (Compro / On Board / Failed)
4. **DataTables Server-side** — Semua tabel dengan sorting, paging, search
5. **Gap Analysis** — Visualisasi MPP vs karyawan aktif per divisi + chart
6. **Audit Log** — Semua aksi CRUD tercatat di `activity_logs`
7. **Master Data** — CRUD Divisi / Departemen / Jabatan via AJAX modal

---

## 📋 TODO / Next Development

- [ ] Import Excel (Maatwebsite implementation)
- [ ] Export Excel per modul
- [ ] Print/PDF Offering Letter
- [ ] Notifikasi email SLA expired
- [ ] History log per kandidat rekrutmen
- [ ] Mobile responsive improvement
