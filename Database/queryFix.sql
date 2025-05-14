
-- Reset tabel pesanan untuk menggunakan auto-increment
ALTER TABLE pesanan_barang DROP CONSTRAINT IF EXISTS pesanan_barang_pesanan_id_fkey;

-- Buat sequence untuk pesanan jika belum ada
CREATE SEQUENCE IF NOT EXISTS pesanan_id_seq START 1;
ALTER SEQUENCE pesanan_id_seq RESTART WITH 1;

-- Ubah kolom ID di tabel pesanan (gunakan INTEGER, bukan SERIAL)
ALTER TABLE pesanan ALTER COLUMN id TYPE INTEGER;
ALTER TABLE pesanan ALTER COLUMN id SET DEFAULT nextval('pesanan_id_seq');
ALTER SEQUENCE pesanan_id_seq OWNED BY pesanan.id;


ALTER TABLE transaksi_barang DROP CONSTRAINT IF EXISTS transaksi_barang_transaksi_id_fkey;

-- Buat sequence untuk transaksi jika belum ada
CREATE SEQUENCE IF NOT EXISTS transaksi_id_seq START 1;
ALTER SEQUENCE transaksi_id_seq RESTART WITH 1;

-- Ubah kolom ID di tabel transaksi
ALTER TABLE transaksi ALTER COLUMN id TYPE INTEGER;
ALTER TABLE transaksi ALTER COLUMN id SET DEFAULT nextval('transaksi_id_seq');
ALTER SEQUENCE transaksi_id_seq OWNED BY transaksi.id;

-- Buat ulang constraint foreign key
ALTER TABLE pesanan_barang ADD CONSTRAINT pesanan_barang_pesanan_id_fkey
FOREIGN KEY (pesanan_id) REFERENCES pesanan(id);
ALTER TABLE transaksi_barang ADD CONSTRAINT transaksi_barang_transaksi_id_fkey
FOREIGN KEY (transaksi_id) REFERENCES transaksi(id);

-- Hapus semua data dan reset sequence (opsional, hanya jika ingin mulai dari awal)
DELETE FROM pesanan_barang;
DELETE FROM pesanan;
DELETE FROM transaksi_barang;
DELETE FROM transaksi;
ALTER SEQUENCE pesanan_id_seq RESTART WITH 1;
ALTER SEQUENCE transaksi_id_seq RESTART WITH 1;

-- Admin Fix for sequence
-- Buat sequence untuk tabel kasir jika belum ada
CREATE SEQUENCE IF NOT EXISTS kasir_id_seq START 1;
ALTER SEQUENCE kasir_id_seq RESTART WITH 1;

-- Pastikan ID kolom menggunakan sequence
ALTER TABLE kasir ALTER COLUMN id SET DEFAULT nextval('kasir_id_seq');
ALTER SEQUENCE kasir_id_seq OWNED BY kasir.id;