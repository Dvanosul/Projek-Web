BEGIN;


CREATE TABLE IF NOT EXISTS public.barang
(
    id bigint NOT NULL,
    nama_barang text COLLATE pg_catalog."default",
    harga numeric(10, 2),
    stok integer,
    deskripsi text COLLATE pg_catalog."default",
    gambar text COLLATE pg_catalog."default",
    grosir_id text COLLATE pg_catalog."default",
    CONSTRAINT barang_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.grosir
(
    id text COLLATE pg_catalog."default" NOT NULL,
    jumlah text COLLATE pg_catalog."default",
    CONSTRAINT grosir_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.jasa_kirim
(
    id text COLLATE pg_catalog."default" NOT NULL,
    jasa_kirim text COLLATE pg_catalog."default",
    ongkir numeric(10, 2),
    CONSTRAINT jasa_kirim_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.kasir
(
    id bigint NOT NULL,
    nama text COLLATE pg_catalog."default",
    username text COLLATE pg_catalog."default",
    password text COLLATE pg_catalog."default",
    telepon text COLLATE pg_catalog."default",
    alamat text COLLATE pg_catalog."default",
    CONSTRAINT kasir_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.pelanggan
(
    id bigint NOT NULL,
    nama text COLLATE pg_catalog."default",
    username text COLLATE pg_catalog."default",
    password text COLLATE pg_catalog."default",
    telepon text COLLATE pg_catalog."default",
    alamat text COLLATE pg_catalog."default",
    kode_pos text COLLATE pg_catalog."default",
    sudah_pernah_transaksi boolean,
    bio text COLLATE pg_catalog."default",
    tgl_lahir text COLLATE pg_catalog."default",
    agama text COLLATE pg_catalog."default",
    jenis_kelamin character(1) COLLATE pg_catalog."default",
    warga text COLLATE pg_catalog."default",
    profil text COLLATE pg_catalog."default",
    CONSTRAINT pelanggan_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.pesanan
(
    id integer NOT NULL,
    pelanggan_id integer,
    kirim_id text COLLATE pg_catalog."default",
    total numeric(10, 2),
    alamat_detail text COLLATE pg_catalog."default",
    bukti text COLLATE pg_catalog."default",
    waktu timestamp without time zone,
    status_id text COLLATE pg_catalog."default",
    nama_penerima text COLLATE pg_catalog."default",
    CONSTRAINT pesanan_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.pesanan_barang
(
    pesanan_id integer NOT NULL,
    barang_id integer NOT NULL,
    jumlah integer,
    sub_total numeric(10, 2),
    CONSTRAINT pesanan_barang_pkey PRIMARY KEY (pesanan_id, barang_id)
);

CREATE TABLE IF NOT EXISTS public.status
(
    id text COLLATE pg_catalog."default" NOT NULL,
    status text COLLATE pg_catalog."default",
    CONSTRAINT status_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.transaksi
(
    id bigint NOT NULL,
    pelanggan_id integer,
    kirim_id text COLLATE pg_catalog."default",
    total numeric(10, 2),
    alamat_detail text COLLATE pg_catalog."default",
    bukti text COLLATE pg_catalog."default",
    CONSTRAINT transaksi_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.transaksi_barang
(
    transaksi_id integer NOT NULL,
    barang_id integer NOT NULL,
    jumlah integer,
    sub_total numeric(10, 2),
    CONSTRAINT transaksi_barang_pkey PRIMARY KEY (transaksi_id, barang_id)
);

ALTER TABLE IF EXISTS public.barang
    ADD CONSTRAINT barang_grosir_id_fkey FOREIGN KEY (grosir_id)
    REFERENCES public.grosir (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.pesanan
    ADD CONSTRAINT pesanan_kirim_id_fkey FOREIGN KEY (kirim_id)
    REFERENCES public.jasa_kirim (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.pesanan
    ADD CONSTRAINT pesanan_pelanggan_id_fkey FOREIGN KEY (pelanggan_id)
    REFERENCES public.pelanggan (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.pesanan
    ADD CONSTRAINT pesanan_status_id_fkey FOREIGN KEY (status_id)
    REFERENCES public.status (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.pesanan_barang
    ADD CONSTRAINT pesanan_barang_barang_id_fkey FOREIGN KEY (barang_id)
    REFERENCES public.barang (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.pesanan_barang
    ADD CONSTRAINT pesanan_barang_pesanan_id_fkey FOREIGN KEY (pesanan_id)
    REFERENCES public.pesanan (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.transaksi
    ADD CONSTRAINT transaksi_kirim_id_fkey FOREIGN KEY (kirim_id)
    REFERENCES public.jasa_kirim (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.transaksi
    ADD CONSTRAINT transaksi_pelanggan_id_fkey FOREIGN KEY (pelanggan_id)
    REFERENCES public.pelanggan (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.transaksi_barang
    ADD CONSTRAINT transaksi_barang_barang_id_fkey FOREIGN KEY (barang_id)
    REFERENCES public.barang (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;


ALTER TABLE IF EXISTS public.transaksi_barang
    ADD CONSTRAINT transaksi_barang_transaksi_id_fkey FOREIGN KEY (transaksi_id)
    REFERENCES public.transaksi (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;

END;