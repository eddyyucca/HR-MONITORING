-- ============================================================
-- SCM HR Monitoring — SQL Schema
-- PT Sulawesi Cahaya Mineral | MPP-970 | Konawe
-- Jalankan di MySQL: mysql -u root scm_hr < schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS scm_hr
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE scm_hr;

-- ─── USERS ───────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(200) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','hr_manager','hr_staff','viewer') DEFAULT 'viewer',
  is_active TINYINT(1) DEFAULT 1,
  avatar VARCHAR(255) NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- ─── MASTER DIVISI ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS divisis (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(200) UNIQUE NOT NULL,
  kode VARCHAR(10) NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- ─── MASTER DEPARTEMEN ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS departemens (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  divisi_id BIGINT UNSIGNED NULL,
  nama VARCHAR(200) NOT NULL,
  kode VARCHAR(10) NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX(divisi_id),
  FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── MASTER JABATAN ──────────────────────────────────────────
CREATE TABLE IF NOT EXISTS jabatans (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  departemen_id BIGINT UNSIGNED NULL,
  nama VARCHAR(200) NOT NULL,
  level VARCHAR(100) DEFAULT 'Officer',
  grade INT NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── REKRUTMEN ───────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS rekrutmens (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_lengkap VARCHAR(200) NOT NULL,
  no_telp VARCHAR(30) NULL,
  email VARCHAR(200) NULL,
  gender ENUM('Male','Female') NULL,
  plan_job_title VARCHAR(200) NOT NULL,
  departemen_id BIGINT UNSIGNED NULL,
  divisi_id BIGINT UNSIGNED NULL,
  category_level VARCHAR(100) NULL,
  status ENUM('Open','In Progress','Closed') DEFAULT 'Open',
  progress VARCHAR(100) DEFAULT 'Compro',
  priority ENUM('P1','P2','P3','NP') NULL,
  status_ata ENUM('Full Approval','Not Yet','Pending') NULL,
  sourch ENUM('Referral','BSI','LinkedIn','PUS','JobStreet','Indeed','Internal','Lainnya') NULL,
  user_pic VARCHAR(100) NULL,
  site VARCHAR(100) DEFAULT 'Konawe',
  date_approved DATE NULL,
  date_progress DATE NULL,
  month_number TINYINT NULL,
  month_name VARCHAR(20) NULL,
  year YEAR NULL,
  sla DECIMAL(10,2) NULL,
  remarks TEXT NULL,
  evrp_bsi VARCHAR(255) NULL,
  evrp_wetar VARCHAR(255) NULL,
  ata_status VARCHAR(100) NULL,
  created_by BIGINT UNSIGNED NULL,
  updated_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX idx_progress_year (progress, year),
  INDEX idx_divisi_year (divisi_id, year),
  INDEX idx_priority (priority, status),
  FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE SET NULL,
  FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── KARYAWAN ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS karyawans (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  salutation VARCHAR(10) NULL,
  nama VARCHAR(200) NOT NULL,
  no_karyawan VARCHAR(50) UNIQUE NULL,
  alamat TEXT NULL,
  no_telp VARCHAR(30) NULL,
  email VARCHAR(200) NULL,
  company VARCHAR(200) DEFAULT 'PT Sulawesi Cahaya Mineral',
  position VARCHAR(200) NOT NULL,
  jabatan_id BIGINT UNSIGNED NULL,
  departemen_id BIGINT UNSIGNED NULL,
  divisi_id BIGINT UNSIGNED NULL,
  work_location VARCHAR(100) DEFAULT 'Konawe Site',
  tipe ENUM('Staff','Non-Staff') DEFAULT 'Staff',
  level VARCHAR(100) NULL,
  level_direct_report VARCHAR(100) NULL,
  grade INT NULL,
  terms ENUM('PKWT','PKWTT') DEFAULT 'PKWT',
  durasi VARCHAR(50) NULL,
  durasi_en VARCHAR(50) NULL,
  status ENUM('Kontrak','Percobaan','Tetap','Selesai') DEFAULT 'Kontrak',
  tgl_ol DATE NULL,
  tgl_berakhir DATE NULL,
  poh VARCHAR(100) NULL,
  basic_salary DECIMAL(15,2) NULL,
  nominal_terbilang VARCHAR(500) NULL,
  nominal_terbilang_id VARCHAR(500) NULL,
  weeks_on INT NULL,
  weeks_off INT NULL,
  inpatient_local DECIMAL(15,2) NULL,
  inpatient_interlokal DECIMAL(15,2) NULL,
  outpatient DECIMAL(15,2) NULL,
  frames DECIMAL(15,2) NULL,
  lens DECIMAL(15,2) NULL,
  signature_name VARCHAR(200) NULL,
  signature_title VARCHAR(200) NULL,
  rekrutmen_id BIGINT UNSIGNED NULL,
  created_by BIGINT UNSIGNED NULL,
  updated_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX idx_tipe_status (tipe, status),
  INDEX idx_divisi_tipe (divisi_id, tipe),
  FOREIGN KEY (jabatan_id) REFERENCES jabatans(id) ON DELETE SET NULL,
  FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE SET NULL,
  FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL,
  FOREIGN KEY (rekrutmen_id) REFERENCES rekrutmens(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── MPP POSITIONS ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS mpp_positions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tahun YEAR NOT NULL,
  job_title VARCHAR(200) NOT NULL,
  app_name VARCHAR(300) NULL,
  cost_centre VARCHAR(100) NULL,
  site VARCHAR(100) DEFAULT 'Konawe',
  departemen_id BIGINT UNSIGNED NULL,
  divisi_id BIGINT UNSIGNED NULL,
  category_grade VARCHAR(100) NULL,
  mpp_jan INT DEFAULT 0, mpp_feb INT DEFAULT 0, mpp_mar INT DEFAULT 0,
  mpp_apr INT DEFAULT 0, mpp_may INT DEFAULT 0, mpp_jun INT DEFAULT 0,
  mpp_jul INT DEFAULT 0, mpp_aug INT DEFAULT 0, mpp_sep INT DEFAULT 0,
  mpp_oct INT DEFAULT 0, mpp_nov INT DEFAULT 0, mpp_dec INT DEFAULT 0,
  existing_jan INT DEFAULT 0, existing_feb INT DEFAULT 0, existing_mar INT DEFAULT 0,
  existing_apr INT DEFAULT 0, existing_may INT DEFAULT 0, existing_jun INT DEFAULT 0,
  existing_jul INT DEFAULT 0, existing_aug INT DEFAULT 0, existing_sep INT DEFAULT 0,
  existing_oct INT DEFAULT 0, existing_nov INT DEFAULT 0, existing_dec INT DEFAULT 0,
  remarks TEXT NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_by BIGINT UNSIGNED NULL,
  updated_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  INDEX idx_tahun_divisi (tahun, divisi_id),
  INDEX idx_grade_tahun (category_grade(50), tahun),
  FOREIGN KEY (departemen_id) REFERENCES departemens(id) ON DELETE SET NULL,
  FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── ACTIVITY LOGS ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS activity_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  module VARCHAR(100) NOT NULL,
  action VARCHAR(100) NOT NULL,
  subject_type VARCHAR(200) NULL,
  subject_id BIGINT UNSIGNED NULL,
  old_values JSON NULL,
  new_values JSON NULL,
  ip_address VARCHAR(45) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_module_action (module, action),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ─── SESSION & CACHE ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS sessions (
  id VARCHAR(255) PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL INDEX,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload LONGTEXT NOT NULL,
  last_activity INT NOT NULL,
  INDEX(last_activity)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cache (
  `key` VARCHAR(255) PRIMARY KEY,
  value MEDIUMTEXT NOT NULL,
  expiration INT NOT NULL
) ENGINE=InnoDB;

-- ─── MIGRATIONS TABLE ────────────────────────────────────────
CREATE TABLE IF NOT EXISTS migrations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  migration VARCHAR(255) NOT NULL,
  batch INT NOT NULL
) ENGINE=InnoDB;
