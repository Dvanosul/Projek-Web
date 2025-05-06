-- Hapus data lama jika ada untuk menghindari duplikasi
DELETE FROM public.barang;
DELETE FROM public.grosir;

-- Tambahkan data ke tabel grosir jika belum ada
INSERT INTO public.grosir (id, jumlah) VALUES
('GR001', '10-49'),
('GR002', '50-99'),
('GR003', '100-499'),
('GR004', '500+')

-- Insert data dummy barang ATK
INSERT INTO public.barang (id, nama_barang, harga, stok, deskripsi, gambar, grosir_id) VALUES
(1, 'Pensil 2B Faber Castell', 3500.00, 100, 'Pensil 2B Faber Castell dengan kualitas terbaik untuk menulis dan menggambar.', 'pensil-2b.jpg', 'GR001'),
(2, 'Pulpen Joyko Gel 0.5mm', 5000.00, 150, 'Pulpen gel dengan ujung 0.5mm untuk tulisan halus dan rapi.', 'pulpen-gel.jpg', 'GR001'),
(3, 'Buku Tulis A5 58 Lembar', 6500.00, 200, 'Buku tulis ukuran A5 dengan 58 lembar, cocok untuk catatan sehari-hari.', 'buku-tulis.jpg', 'GR002'),
(4, 'Penggaris Plastik 30cm', 4000.00, 80, 'Penggaris plastik transparan 30 cm dengan ukuran yang presisi.', 'penggaris.jpg', 'GR003'),
(5, 'Gunting Kenko Sedang', 12500.00, 50, 'Gunting stainless steel dengan pegangan nyaman untuk kebutuhan kantor.', 'gunting.jpg', 'GR003'),
(6, 'Kertas HVS A4 80gsm', 45000.00, 75, 'Satu rim kertas HVS ukuran A4 dengan ketebalan 80gsm, cocok untuk printer dan fotokopi.', 'kertas-hvs.jpg', 'GR002'),
(7, 'Sticky Notes 3M', 15000.00, 120, 'Sticky notes berwarna-warni untuk menulis pengingat dan catatan kecil.', 'sticky-notes.jpg', 'GR004'),
(8, 'Correction Tape Joyko', 8000.00, 90, 'Correction tape berkualitas tinggi, praktis untuk mengoreksi tulisan yang salah.', 'correction-tape.jpg', 'GR001'),
(9, 'Map Plastik Folio', 5500.00, 200, 'Map plastik transparan ukuran folio untuk menyimpan dokumen.', 'map-plastik.jpg', 'GR002'),
(10, 'Stapler Kenko HD-10', 18500.00, 60, 'Stapler kecil dengan kapasitas 20 lembar, tahan lama dan mudah digunakan.', 'stapler.jpg', 'GR003'),
(11, 'Isi Staples No.10', 3500.00, 150, 'Isi staples nomor 10 isi 1000 pcs, cocok untuk stapler kecil.', 'isi-staples.jpg', 'GR001'),
(12, 'Klip Kertas Warna 50mm', 7500.00, 100, 'Klip kertas berwarna-warni ukuran 50mm, isi 12 pcs.', 'klip-kertas.jpg', 'GR004'),
(13, 'Spidol Hitam Permanen', 9500.00, 80, 'Spidol permanen hitam dengan ujung tebal, tidak mudah luntur.', 'spidol.jpg', 'GR001'),
(14, 'Tinta Stempel Warna Biru', 12000.00, 40, 'Tinta stempel warna biru 30ml, tidak mudah kering.', 'tinta-stempel.jpg', 'GR004'),
(15, 'Binder Clip 155', 12500.00, 70, 'Binder clip ukuran 155, isi 12 pcs per box, kuat menjepit dokumen tebal.', 'binder-clip.jpg', 'GR004'),
(16, 'Kalkulator Casio MJ-12D', 85000.00, 30, 'Kalkulator meja 12 digit dengan fungsi perhitungan pajak.', 'kalkulator.jpg', 'GR003'),
(17, 'Ordner Folio Bantex', 38500.00, 45, 'Ordner folio dengan kualitas premium untuk menyimpan dan mengarsipkan dokumen.', 'ordner.jpg', 'GR002'),
(18, 'Lem Stik UHU 21g', 14500.00, 100, 'Lem stik praktis untuk kertas, tidak berantakan dan cepat kering.', 'lem-stik.jpg', 'GR001'),
(19, 'Double Tape 1 Inch', 6500.00, 85, 'Double tape 1 inch dengan panjang 10 meter, daya rekat kuat.', 'double-tape.jpg', 'GR004'),
(20, 'Pembolong Kertas Kenko', 32000.00, 50, 'Pembolong kertas dengan kapasitas 30 lembar, cocok untuk arsip dokumen.', 'pembolong-kertas.jpg', 'GR003'),
(21, 'Buku Kwitansi NCR', 14500.00, 100, 'Buku kwitansi dengan kertas NCR rangkap 2, memiliki nomor seri.', 'kwitansi.jpg', 'GR002'),
(22, 'Box File Plastik', 28500.00, 60, 'Box file plastik untuk menyimpan dokumen dengan rapi dan terhindar dari debu.', 'box-file.jpg', 'GR002'),
(23, 'Highlighter Faber Castell', 8500.00, 120, 'Highlighter warna-warni untuk menandai teks penting pada dokumen.', 'highlighter.jpg', 'GR001'),
(24, 'Cutter Kenko A-300', 15000.00, 70, 'Cutter dengan mata pisau yang tajam dan pegangan anti slip.', 'cutter.jpg', 'GR003'),
(25, 'Paper Clips', 4500.00, 150, 'Paper clips warna silver, isi 100 pcs per box.', 'paper-clips.jpg', 'GR004'),
(26, 'Push Pin Warna-warni', 7500.00, 90, 'Push pin warna-warni untuk menempel pesan pada papan bulletin, isi 50pcs.', 'push-pin.jpg', 'GR004'),
(27, 'Drawing Book A3', 35000.00, 40, 'Buku gambar ukuran A3 dengan kertas berkualitas, cocok untuk sketsa dan gambar.', 'drawing-book.jpg', 'GR002'),
(28, 'Tinta Printer Epson 664 Hitam', 75000.00, 35, 'Tinta original Epson 664 warna hitam, hasil cetak tajam dan tahan lama.', 'tinta-printer.jpg', 'GR003'),
(29, 'Pensil Warna Faber Castell 24', 48500.00, 25, 'Set pensil warna Faber Castell isi 24 warna, kualitas terbaik untuk mewarnai.', 'pensil-warna.jpg', 'GR001'),
(30, 'Desk Organizer', 65000.00, 20, 'Tempat penyimpanan alat tulis di meja, memiliki beberapa kompartemen.', 'desk-organizer.jpg', 'GR003');

INSERT INTO jasa_kirim (id, jasa_kirim, ongkir) VALUES
('11', 'POS Indonesia', 15000.00),
('22', 'JNE Express', 18000.00),
('33', 'J&T Express', 17000.00),
('44', 'Anter Aja', 16000.00),
('55', 'SiCepat', 15500.00),
('66', 'Ninja Express', 19000.00);





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