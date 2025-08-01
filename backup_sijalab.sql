--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4
-- Dumped by pg_dump version 16.4

-- Started on 2025-07-20 19:04:19

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 221 (class 1259 OID 117489)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 117496)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 117651)
-- Name: dosen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dosen (
    id_dosen bigint NOT NULL,
    nama_dosen character varying(255) NOT NULL,
    telepon character varying(255) NOT NULL,
    id_prodi bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    nip character varying(255) NOT NULL
);


ALTER TABLE public.dosen OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 117650)
-- Name: dosen_id_dosen_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dosen_id_dosen_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dosen_id_dosen_seq OWNER TO postgres;

--
-- TOC entry 5221 (class 0 OID 0)
-- Dependencies: 245
-- Name: dosen_id_dosen_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dosen_id_dosen_seq OWNED BY public.dosen.id_dosen;


--
-- TOC entry 227 (class 1259 OID 117521)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 117520)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5222 (class 0 OID 0)
-- Dependencies: 226
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 252 (class 1259 OID 117684)
-- Name: hari; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hari (
    id_hari bigint NOT NULL,
    nama_hari character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.hari OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 117683)
-- Name: hari_id_hari_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hari_id_hari_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hari_id_hari_seq OWNER TO postgres;

--
-- TOC entry 5223 (class 0 OID 0)
-- Dependencies: 251
-- Name: hari_id_hari_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hari_id_hari_seq OWNED BY public.hari.id_hari;


--
-- TOC entry 254 (class 1259 OID 117693)
-- Name: jadwal_lab; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jadwal_lab (
    "id_jadwalLab" bigint NOT NULL,
    id_hari bigint NOT NULL,
    id_lab bigint NOT NULL,
    id_mk bigint NOT NULL,
    id_dosen bigint NOT NULL,
    id_prodi bigint NOT NULL,
    id_kelas bigint NOT NULL,
    "id_tahunAjaran" bigint NOT NULL,
    "status_jadwalLab" character varying(255) DEFAULT 'aktif'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    waktu_mulai_nonaktif timestamp(0) without time zone,
    waktu_akhir_nonaktif timestamp(0) without time zone,
    CONSTRAINT "jadwal_lab_status_jadwalLab_check" CHECK ((("status_jadwalLab")::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying])::text[])))
);


ALTER TABLE public.jadwal_lab OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 117692)
-- Name: jadwal_lab_id_jadwalLab_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."jadwal_lab_id_jadwalLab_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."jadwal_lab_id_jadwalLab_seq" OWNER TO postgres;

--
-- TOC entry 5224 (class 0 OID 0)
-- Dependencies: 253
-- Name: jadwal_lab_id_jadwalLab_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."jadwal_lab_id_jadwalLab_seq" OWNED BY public.jadwal_lab."id_jadwalLab";


--
-- TOC entry 266 (class 1259 OID 117868)
-- Name: jadwal_lab_sesi_jam; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jadwal_lab_sesi_jam (
    "id_jadwalLab" bigint NOT NULL,
    id_sesi_jam bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.jadwal_lab_sesi_jam OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 117513)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 117504)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 117503)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5225 (class 0 OID 0)
-- Dependencies: 223
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 241 (class 1259 OID 117605)
-- Name: kelas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kelas (
    id_kelas bigint NOT NULL,
    id_prodi bigint NOT NULL,
    nama_kelas character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.kelas OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 117604)
-- Name: kelas_id_kelas_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kelas_id_kelas_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.kelas_id_kelas_seq OWNER TO postgres;

--
-- TOC entry 5226 (class 0 OID 0)
-- Dependencies: 240
-- Name: kelas_id_kelas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kelas_id_kelas_seq OWNED BY public.kelas.id_kelas;


--
-- TOC entry 248 (class 1259 OID 117667)
-- Name: lab; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lab (
    id_lab bigint NOT NULL,
    nama_lab character varying(255) NOT NULL,
    status_lab character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT lab_status_lab_check CHECK (((status_lab)::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying])::text[])))
);


ALTER TABLE public.lab OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 117666)
-- Name: lab_id_lab_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lab_id_lab_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lab_id_lab_seq OWNER TO postgres;

--
-- TOC entry 5227 (class 0 OID 0)
-- Dependencies: 247
-- Name: lab_id_lab_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lab_id_lab_seq OWNED BY public.lab.id_lab;


--
-- TOC entry 242 (class 1259 OID 117616)
-- Name: mahasiswa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mahasiswa (
    id bigint NOT NULL,
    id_prodi bigint NOT NULL,
    id_kelas bigint NOT NULL,
    nim character varying(255) NOT NULL,
    telepon character varying(255) NOT NULL,
    foto_ktm character varying(10240),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.mahasiswa OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 117639)
-- Name: matakuliah; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.matakuliah (
    id_mk bigint NOT NULL,
    nama_mk character varying(255) NOT NULL,
    id_prodi bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    kode_mk character varying(255) NOT NULL
);


ALTER TABLE public.matakuliah OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 117638)
-- Name: matakuliah_id_mk_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.matakuliah_id_mk_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.matakuliah_id_mk_seq OWNER TO postgres;

--
-- TOC entry 5228 (class 0 OID 0)
-- Dependencies: 243
-- Name: matakuliah_id_mk_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.matakuliah_id_mk_seq OWNED BY public.matakuliah.id_mk;


--
-- TOC entry 216 (class 1259 OID 99388)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 99387)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5229 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 219 (class 1259 OID 117473)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 117737)
-- Name: peminjaman; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman (
    id_peminjaman bigint NOT NULL,
    tgl_peminjaman date NOT NULL,
    id bigint NOT NULL,
    status_peminjaman character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT peminjaman_status_peminjaman_check CHECK (((status_peminjaman)::text = ANY ((ARRAY['pengajuan'::character varying, 'dipinjam'::character varying, 'ditolak'::character varying, 'selesai'::character varying, 'bermasalah'::character varying])::text[])))
);


ALTER TABLE public.peminjaman OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 117816)
-- Name: peminjaman_bermasalah; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_bermasalah (
    id_peminjaman bigint NOT NULL,
    jam_dikembalikan time(0) without time zone NOT NULL,
    tgl_pengembalian date NOT NULL,
    alasan_bermasalah text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_bermasalah OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 117793)
-- Name: peminjaman_ditolak; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_ditolak (
    id_peminjaman bigint NOT NULL,
    alasan_ditolak text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_ditolak OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 117736)
-- Name: peminjaman_id_peminjaman_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.peminjaman_id_peminjaman_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.peminjaman_id_peminjaman_seq OWNER TO postgres;

--
-- TOC entry 5230 (class 0 OID 0)
-- Dependencies: 255
-- Name: peminjaman_id_peminjaman_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.peminjaman_id_peminjaman_seq OWNED BY public.peminjaman.id_peminjaman;


--
-- TOC entry 258 (class 1259 OID 117757)
-- Name: peminjaman_jadwal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_jadwal (
    id_peminjaman bigint NOT NULL,
    "id_jadwalLab" bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_jadwal OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 117770)
-- Name: peminjaman_manual; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_manual (
    id_peminjaman bigint NOT NULL,
    id_sesi_mulai bigint NOT NULL,
    id_sesi_selesai bigint NOT NULL,
    id_lab bigint NOT NULL,
    kegiatan character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_manual OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 117803)
-- Name: peminjaman_peralatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_peralatan (
    id_peminjaman bigint NOT NULL,
    id_peralatan bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_peralatan OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 117749)
-- Name: peminjaman_selesai; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_selesai (
    id_peminjaman bigint NOT NULL,
    tgl_pengembalian date NOT NULL,
    jam_dikembalikan time(0) without time zone NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_selesai OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 117844)
-- Name: peminjaman_unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peminjaman_unit (
    id_peminjaman bigint NOT NULL,
    id_unit bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peminjaman_unit OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 117589)
-- Name: peralatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.peralatan (
    id_peralatan bigint NOT NULL,
    nama_peralatan character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.peralatan OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 117588)
-- Name: peralatan_id_peralatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.peralatan_id_peralatan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.peralatan_id_peralatan_seq OWNER TO postgres;

--
-- TOC entry 5231 (class 0 OID 0)
-- Dependencies: 236
-- Name: peralatan_id_peralatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.peralatan_id_peralatan_seq OWNED BY public.peralatan.id_peralatan;


--
-- TOC entry 229 (class 1259 OID 117533)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 117532)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 5232 (class 0 OID 0)
-- Dependencies: 228
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 239 (class 1259 OID 117596)
-- Name: prodi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.prodi (
    id_prodi bigint NOT NULL,
    nama_prodi character varying(255) NOT NULL,
    singkatan_prodi character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    kode_prodi character varying(255) NOT NULL
);


ALTER TABLE public.prodi OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 117595)
-- Name: prodi_id_prodi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.prodi_id_prodi_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.prodi_id_prodi_seq OWNER TO postgres;

--
-- TOC entry 5233 (class 0 OID 0)
-- Dependencies: 238
-- Name: prodi_id_prodi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.prodi_id_prodi_seq OWNED BY public.prodi.id_prodi;


--
-- TOC entry 250 (class 1259 OID 117677)
-- Name: sesi_jam; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sesi_jam (
    id_sesi_jam bigint NOT NULL,
    nama_sesi character varying(20) NOT NULL,
    jam_mulai time(0) without time zone NOT NULL,
    jam_selesai time(0) without time zone NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.sesi_jam OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 117676)
-- Name: sesi_jam_id_sesi_jam_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sesi_jam_id_sesi_jam_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sesi_jam_id_sesi_jam_seq OWNER TO postgres;

--
-- TOC entry 5234 (class 0 OID 0)
-- Dependencies: 249
-- Name: sesi_jam_id_sesi_jam_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sesi_jam_id_sesi_jam_seq OWNED BY public.sesi_jam.id_sesi_jam;


--
-- TOC entry 220 (class 1259 OID 117480)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 117577)
-- Name: tahun_ajaran; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tahun_ajaran (
    "id_tahunAjaran" bigint NOT NULL,
    tahun_ajaran character varying(255) NOT NULL,
    semester character varying(255) NOT NULL,
    "status_tahunAjaran" character varying(255) DEFAULT 'aktif'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tahun_ajaran_semester_check CHECK (((semester)::text = ANY ((ARRAY['ganjil'::character varying, 'genap'::character varying])::text[]))),
    CONSTRAINT "tahun_ajaran_status_tahunAjaran_check" CHECK ((("status_tahunAjaran")::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying])::text[])))
);


ALTER TABLE public.tahun_ajaran OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 117576)
-- Name: tahun_ajaran_id_tahunAjaran_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."tahun_ajaran_id_tahunAjaran_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."tahun_ajaran_id_tahunAjaran_seq" OWNER TO postgres;

--
-- TOC entry 5235 (class 0 OID 0)
-- Dependencies: 234
-- Name: tahun_ajaran_id_tahunAjaran_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."tahun_ajaran_id_tahunAjaran_seq" OWNED BY public.tahun_ajaran."id_tahunAjaran";


--
-- TOC entry 272 (class 1259 OID 117899)
-- Name: team_invitations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.team_invitations (
    id bigint NOT NULL,
    team_id bigint NOT NULL,
    email character varying(255) NOT NULL,
    role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.team_invitations OWNER TO postgres;

--
-- TOC entry 271 (class 1259 OID 117898)
-- Name: team_invitations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.team_invitations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.team_invitations_id_seq OWNER TO postgres;

--
-- TOC entry 5236 (class 0 OID 0)
-- Dependencies: 271
-- Name: team_invitations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.team_invitations_id_seq OWNED BY public.team_invitations.id;


--
-- TOC entry 270 (class 1259 OID 117890)
-- Name: team_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.team_user (
    id bigint NOT NULL,
    team_id bigint NOT NULL,
    user_id bigint NOT NULL,
    role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.team_user OWNER TO postgres;

--
-- TOC entry 269 (class 1259 OID 117889)
-- Name: team_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.team_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.team_user_id_seq OWNER TO postgres;

--
-- TOC entry 5237 (class 0 OID 0)
-- Dependencies: 269
-- Name: team_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.team_user_id_seq OWNED BY public.team_user.id;


--
-- TOC entry 268 (class 1259 OID 117882)
-- Name: teams; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.teams (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    personal_team boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.teams OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 117881)
-- Name: teams_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.teams_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.teams_id_seq OWNER TO postgres;

--
-- TOC entry 5238 (class 0 OID 0)
-- Dependencies: 267
-- Name: teams_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.teams_id_seq OWNED BY public.teams.id;


--
-- TOC entry 231 (class 1259 OID 117545)
-- Name: telescope_entries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telescope_entries (
    sequence bigint NOT NULL,
    uuid uuid NOT NULL,
    batch_id uuid NOT NULL,
    family_hash character varying(255),
    should_display_on_index boolean DEFAULT true NOT NULL,
    type character varying(20) NOT NULL,
    content text NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.telescope_entries OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 117544)
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.telescope_entries_sequence_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.telescope_entries_sequence_seq OWNER TO postgres;

--
-- TOC entry 5239 (class 0 OID 0)
-- Dependencies: 230
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.telescope_entries_sequence_seq OWNED BY public.telescope_entries.sequence;


--
-- TOC entry 232 (class 1259 OID 117560)
-- Name: telescope_entries_tags; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telescope_entries_tags (
    entry_uuid uuid NOT NULL,
    tag character varying(255) NOT NULL
);


ALTER TABLE public.telescope_entries_tags OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 117571)
-- Name: telescope_monitoring; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telescope_monitoring (
    tag character varying(255) NOT NULL
);


ALTER TABLE public.telescope_monitoring OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 117827)
-- Name: unit_peralatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.unit_peralatan (
    id_unit bigint NOT NULL,
    id_peralatan bigint NOT NULL,
    kode_unit character varying(255) NOT NULL,
    status_unit character varying(255) DEFAULT 'tersedia'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT unit_peralatan_status_unit_check CHECK (((status_unit)::text = ANY ((ARRAY['tersedia'::character varying, 'dipinjam'::character varying, 'rusak'::character varying])::text[])))
);


ALTER TABLE public.unit_peralatan OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 117826)
-- Name: unit_peralatan_id_unit_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unit_peralatan_id_unit_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.unit_peralatan_id_unit_seq OWNER TO postgres;

--
-- TOC entry 5240 (class 0 OID 0)
-- Dependencies: 263
-- Name: unit_peralatan_id_unit_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.unit_peralatan_id_unit_seq OWNED BY public.unit_peralatan.id_unit;


--
-- TOC entry 218 (class 1259 OID 117459)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'mahasiswa'::character varying NOT NULL,
    status_user character varying(255) DEFAULT 'aktif'::character varying NOT NULL,
    remember_token character varying(100),
    current_team_id bigint,
    profile_photo_path character varying(6048),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    two_factor_confirmed_at timestamp(0) without time zone,
    akses_ubah_kelas boolean DEFAULT false NOT NULL,
    username character varying(255) NOT NULL,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['teknisi'::character varying, 'mahasiswa'::character varying])::text[]))),
    CONSTRAINT users_status_user_check CHECK (((status_user)::text = ANY ((ARRAY['aktif'::character varying, 'nonaktif'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 117458)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5241 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4869 (class 2604 OID 117654)
-- Name: dosen id_dosen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen ALTER COLUMN id_dosen SET DEFAULT nextval('public.dosen_id_dosen_seq'::regclass);


--
-- TOC entry 4858 (class 2604 OID 117524)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4872 (class 2604 OID 117687)
-- Name: hari id_hari; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hari ALTER COLUMN id_hari SET DEFAULT nextval('public.hari_id_hari_seq'::regclass);


--
-- TOC entry 4873 (class 2604 OID 117696)
-- Name: jadwal_lab id_jadwalLab; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab ALTER COLUMN "id_jadwalLab" SET DEFAULT nextval('public."jadwal_lab_id_jadwalLab_seq"'::regclass);


--
-- TOC entry 4857 (class 2604 OID 117507)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4867 (class 2604 OID 117608)
-- Name: kelas id_kelas; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kelas ALTER COLUMN id_kelas SET DEFAULT nextval('public.kelas_id_kelas_seq'::regclass);


--
-- TOC entry 4870 (class 2604 OID 117670)
-- Name: lab id_lab; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lab ALTER COLUMN id_lab SET DEFAULT nextval('public.lab_id_lab_seq'::regclass);


--
-- TOC entry 4868 (class 2604 OID 117642)
-- Name: matakuliah id_mk; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matakuliah ALTER COLUMN id_mk SET DEFAULT nextval('public.matakuliah_id_mk_seq'::regclass);


--
-- TOC entry 4852 (class 2604 OID 99391)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4875 (class 2604 OID 117740)
-- Name: peminjaman id_peminjaman; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman ALTER COLUMN id_peminjaman SET DEFAULT nextval('public.peminjaman_id_peminjaman_seq'::regclass);


--
-- TOC entry 4865 (class 2604 OID 117592)
-- Name: peralatan id_peralatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peralatan ALTER COLUMN id_peralatan SET DEFAULT nextval('public.peralatan_id_peralatan_seq'::regclass);


--
-- TOC entry 4860 (class 2604 OID 117536)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 4866 (class 2604 OID 117599)
-- Name: prodi id_prodi; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prodi ALTER COLUMN id_prodi SET DEFAULT nextval('public.prodi_id_prodi_seq'::regclass);


--
-- TOC entry 4871 (class 2604 OID 117680)
-- Name: sesi_jam id_sesi_jam; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sesi_jam ALTER COLUMN id_sesi_jam SET DEFAULT nextval('public.sesi_jam_id_sesi_jam_seq'::regclass);


--
-- TOC entry 4863 (class 2604 OID 117580)
-- Name: tahun_ajaran id_tahunAjaran; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tahun_ajaran ALTER COLUMN "id_tahunAjaran" SET DEFAULT nextval('public."tahun_ajaran_id_tahunAjaran_seq"'::regclass);


--
-- TOC entry 4880 (class 2604 OID 117902)
-- Name: team_invitations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_invitations ALTER COLUMN id SET DEFAULT nextval('public.team_invitations_id_seq'::regclass);


--
-- TOC entry 4879 (class 2604 OID 117893)
-- Name: team_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_user ALTER COLUMN id SET DEFAULT nextval('public.team_user_id_seq'::regclass);


--
-- TOC entry 4878 (class 2604 OID 117885)
-- Name: teams id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teams ALTER COLUMN id SET DEFAULT nextval('public.teams_id_seq'::regclass);


--
-- TOC entry 4861 (class 2604 OID 117548)
-- Name: telescope_entries sequence; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_entries ALTER COLUMN sequence SET DEFAULT nextval('public.telescope_entries_sequence_seq'::regclass);


--
-- TOC entry 4876 (class 2604 OID 117830)
-- Name: unit_peralatan id_unit; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unit_peralatan ALTER COLUMN id_unit SET DEFAULT nextval('public.unit_peralatan_id_unit_seq'::regclass);


--
-- TOC entry 4853 (class 2604 OID 117462)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5164 (class 0 OID 117489)
-- Dependencies: 221
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 5165 (class 0 OID 117496)
-- Dependencies: 222
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 5189 (class 0 OID 117651)
-- Dependencies: 246
-- Data for Name: dosen; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dosen (id_dosen, nama_dosen, telepon, id_prodi, created_at, updated_at, nip) FROM stdin;
1	Mohamad Dimyati Ayatullah, S.T., M.Kom.	08123399184	1	2025-07-20 19:03:39	2025-07-20 19:03:39	197601222021211001
2	Dianni Yusuf, S.Kom., M.Kom.	082328333399	1	2025-07-20 19:03:39	2025-07-20 19:03:39	198403052021212004
3	Eka Mistiko Rini, S.Kom, M.Kom.	081913922224	1	2025-07-20 19:03:39	2025-07-20 19:03:39	198310202014042001
4	Farizqi Panduardi, S.ST., M.T.	082244680800	1	2025-07-20 19:03:39	2025-07-20 19:03:39	198603052024211014
5	Devit Suwardiyanto,S.Si., M.T.	08113570683	1	2025-07-20 19:03:39	2025-07-20 19:03:39	198311052015041001
6	Lutfi Hakim, S.Pd., M.T.	085330161514	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199203302019031012
7	Sepyan Purnama Kristanto, S.Kom., M.Kom.	+6285237516017	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199009052019031024
8	Ruth Ema Febrita, S.Pd., M.Kom.	085259082627	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199202272020122019
9	Lukman Hakim S.Kom., M.T	081232947805	1	2025-07-20 19:03:39	2025-07-20 19:03:39	198903232022031007
10	Khoirul Umam, S.Pd, M.Kom	087755580796	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199103112022031006
11	Arif Fahmi, S.T., M.T.	081217945658	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199503032024061001
12	Eka Novita Sari, S. Kom., M.Kom.	+6285736907069	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199312032024062002
13	Furiansyah Dipraja, S.T., M.Kom.	+6282129916997	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199408122024061002
14	Indra Kurniawan, S.T., M.Eng.	+6285293810942	1	2025-07-20 19:03:39	2025-07-20 19:03:39	199607142024061001
15	Herman Yuliandoko, S.T., M.T.	081334436478	2	2025-07-20 19:03:39	2025-07-20 19:03:39	197509272021211002
16	Vivien Arief Wardhany, S.T., M.T.	081331068658	2	2025-07-20 19:03:39	2025-07-20 19:03:39	198404032019032012
17	Endi Sailul Haq, S.T., M.Kom.	081336851513	2	2025-07-20 19:03:39	2025-07-20 19:03:39	198403112019031005
18	Subono, S.T., M.T.	087859576210	2	2025-07-20 19:03:39	2025-07-20 19:03:39	197506252021211003
19	Alfin Hidayat, S.T., M.T.	085731147608	2	2025-07-20 19:03:39	2025-07-20 19:03:39	199010052014041002
20	Junaedi Adi Prasetyo, S.ST., M.Sc.	082333312244	2	2025-07-20 19:03:39	2025-07-20 19:03:39	199004192018031001
21	Galih Hendra Wibowo, S.Tr.Kom., M.T.	083831120642	2	2025-07-20 19:03:39	2025-07-20 19:03:39	199209052022031004
22	Agus Priyo Utomo, S.ST., M.Tr.Kom.	085 731 311 399	2	2025-07-20 19:03:39	2025-07-20 19:03:39	198708272024211012
23	I Wayan Suardinata, S.Kom., M.T.	085736577864	3	2025-07-20 19:03:39	2025-07-20 19:03:39	198010222015041001
24	Moh. Nur Shodiq, S.T., M.T.	085236675444	3	2025-07-20 19:03:39	2025-07-20 19:03:39	198301192021211006
25	Dedy Hidayat Kusuma, S.T., M.Cs.	087755527517	3	2025-07-20 19:03:39	2025-07-20 19:03:39	197704042021211004
26	Muh. Fuad Al Haris, S.T., M.T.	081234619898	3	2025-07-20 19:03:39	2025-07-20 19:03:39	197806132014041001
27	Arum Andary Ratri, S.Si., M.Si.	083117703473	3	2025-07-20 19:03:39	2025-07-20 19:03:39	199209212020122021
28	Indira Nuansa Ratri, S.M., M.SM.	083831244299	3	2025-07-20 19:03:39	2025-07-20 19:03:39	199607032024062001
29	Mega Devita Sari, M. A	082397148738	3	2025-07-20 19:03:39	2025-07-20 19:03:39	199708052025062007
30	Septa Lukman Andes, S.AB., M.AB.	087789027297	3	2025-07-20 19:03:39	2025-07-20 19:03:39	199409212025061002
\.


--
-- TOC entry 5170 (class 0 OID 117521)
-- Dependencies: 227
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 5195 (class 0 OID 117684)
-- Dependencies: 252
-- Data for Name: hari; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hari (id_hari, nama_hari, created_at, updated_at) FROM stdin;
1	Senin	\N	\N
2	Selasa	\N	\N
3	Rabu	\N	\N
4	Kamis	\N	\N
5	Jumat	\N	\N
6	Sabtu	\N	\N
7	Minggu	\N	\N
\.


--
-- TOC entry 5197 (class 0 OID 117693)
-- Dependencies: 254
-- Data for Name: jadwal_lab; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jadwal_lab ("id_jadwalLab", id_hari, id_lab, id_mk, id_dosen, id_prodi, id_kelas, "id_tahunAjaran", "status_jadwalLab", created_at, updated_at, waktu_mulai_nonaktif, waktu_akhir_nonaktif) FROM stdin;
\.


--
-- TOC entry 5209 (class 0 OID 117868)
-- Dependencies: 266
-- Data for Name: jadwal_lab_sesi_jam; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jadwal_lab_sesi_jam ("id_jadwalLab", id_sesi_jam, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5168 (class 0 OID 117513)
-- Dependencies: 225
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 5167 (class 0 OID 117504)
-- Dependencies: 224
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 5184 (class 0 OID 117605)
-- Dependencies: 241
-- Data for Name: kelas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kelas (id_kelas, id_prodi, nama_kelas, created_at, updated_at) FROM stdin;
1	1	1A	2025-07-20 19:03:39	2025-07-20 19:03:39
2	1	1B	2025-07-20 19:03:39	2025-07-20 19:03:39
3	1	1C	2025-07-20 19:03:39	2025-07-20 19:03:39
4	1	1D	2025-07-20 19:03:39	2025-07-20 19:03:39
5	1	1E	2025-07-20 19:03:39	2025-07-20 19:03:39
6	1	2A	2025-07-20 19:03:39	2025-07-20 19:03:39
7	1	2B	2025-07-20 19:03:39	2025-07-20 19:03:39
8	1	2C	2025-07-20 19:03:39	2025-07-20 19:03:39
9	1	2D	2025-07-20 19:03:39	2025-07-20 19:03:39
10	1	2E	2025-07-20 19:03:39	2025-07-20 19:03:39
11	1	3A	2025-07-20 19:03:39	2025-07-20 19:03:39
12	1	3B	2025-07-20 19:03:39	2025-07-20 19:03:39
13	1	3C	2025-07-20 19:03:39	2025-07-20 19:03:39
14	1	3D	2025-07-20 19:03:39	2025-07-20 19:03:39
15	1	3E	2025-07-20 19:03:39	2025-07-20 19:03:39
16	1	4A	2025-07-20 19:03:39	2025-07-20 19:03:39
17	1	4B	2025-07-20 19:03:39	2025-07-20 19:03:39
18	1	4C	2025-07-20 19:03:39	2025-07-20 19:03:39
19	1	4D	2025-07-20 19:03:39	2025-07-20 19:03:39
20	1	4E	2025-07-20 19:03:39	2025-07-20 19:03:39
21	2	1A	2025-07-20 19:03:39	2025-07-20 19:03:39
22	2	1B	2025-07-20 19:03:39	2025-07-20 19:03:39
23	2	1C	2025-07-20 19:03:39	2025-07-20 19:03:39
24	2	1D	2025-07-20 19:03:39	2025-07-20 19:03:39
25	2	1E	2025-07-20 19:03:39	2025-07-20 19:03:39
26	2	2A	2025-07-20 19:03:39	2025-07-20 19:03:39
27	2	2B	2025-07-20 19:03:39	2025-07-20 19:03:39
28	2	2C	2025-07-20 19:03:39	2025-07-20 19:03:39
29	2	2D	2025-07-20 19:03:39	2025-07-20 19:03:39
30	2	2E	2025-07-20 19:03:39	2025-07-20 19:03:39
31	2	3A	2025-07-20 19:03:39	2025-07-20 19:03:39
32	2	3B	2025-07-20 19:03:39	2025-07-20 19:03:39
33	2	3C	2025-07-20 19:03:39	2025-07-20 19:03:39
34	2	3D	2025-07-20 19:03:39	2025-07-20 19:03:39
35	2	3E	2025-07-20 19:03:39	2025-07-20 19:03:39
36	2	4A	2025-07-20 19:03:39	2025-07-20 19:03:39
37	2	4B	2025-07-20 19:03:39	2025-07-20 19:03:39
38	2	4C	2025-07-20 19:03:39	2025-07-20 19:03:39
39	2	4D	2025-07-20 19:03:39	2025-07-20 19:03:39
40	2	4E	2025-07-20 19:03:39	2025-07-20 19:03:39
41	3	1A	2025-07-20 19:03:39	2025-07-20 19:03:39
42	3	1B	2025-07-20 19:03:39	2025-07-20 19:03:39
43	3	1C	2025-07-20 19:03:39	2025-07-20 19:03:39
44	3	1D	2025-07-20 19:03:39	2025-07-20 19:03:39
45	3	1E	2025-07-20 19:03:39	2025-07-20 19:03:39
46	3	2A	2025-07-20 19:03:39	2025-07-20 19:03:39
47	3	2B	2025-07-20 19:03:39	2025-07-20 19:03:39
48	3	2C	2025-07-20 19:03:39	2025-07-20 19:03:39
49	3	2D	2025-07-20 19:03:39	2025-07-20 19:03:39
50	3	2E	2025-07-20 19:03:39	2025-07-20 19:03:39
51	3	3A	2025-07-20 19:03:39	2025-07-20 19:03:39
52	3	3B	2025-07-20 19:03:39	2025-07-20 19:03:39
53	3	3C	2025-07-20 19:03:39	2025-07-20 19:03:39
54	3	3D	2025-07-20 19:03:39	2025-07-20 19:03:39
55	3	3E	2025-07-20 19:03:39	2025-07-20 19:03:39
56	3	4A	2025-07-20 19:03:39	2025-07-20 19:03:39
57	3	4B	2025-07-20 19:03:39	2025-07-20 19:03:39
58	3	4C	2025-07-20 19:03:39	2025-07-20 19:03:39
59	3	4D	2025-07-20 19:03:39	2025-07-20 19:03:39
60	3	4E	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5191 (class 0 OID 117667)
-- Dependencies: 248
-- Data for Name: lab; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lab (id_lab, nama_lab, status_lab, created_at, updated_at) FROM stdin;
1	Pemrograman 1	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
2	Pemrograman 2	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
3	Basis Data	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
4	Hardware	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
5	Multimedia	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
6	Coworking	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
7	Design	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
8	TUK	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5185 (class 0 OID 117616)
-- Dependencies: 242
-- Data for Name: mahasiswa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mahasiswa (id, id_prodi, id_kelas, nim, telepon, foto_ktm, created_at, updated_at) FROM stdin;
4	1	1	369731321654	081267658982	\N	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5187 (class 0 OID 117639)
-- Dependencies: 244
-- Data for Name: matakuliah; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.matakuliah (id_mk, nama_mk, id_prodi, created_at, updated_at, kode_mk) FROM stdin;
1	Praktikum Pemrograman Web Dasar	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL101
2	Praktikum Desain Pengalaman Pengguna	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL102
3	Praktikum Basis Data	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL103
4	Praktikum Algoritma & Struktur Data	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL104
5	Proyek Aplikasi Dasar	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL105
6	Praktikum Sistem Terdistribusi	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL106
7	Praktikum Machine Learning	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL107
8	Praktikum Struktur Data	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL108
9	Aljabar Vektor dan Matrik	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL109
10	Manajemen Proyek	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL110
11	Praktikum Pemrograman Berorientasi Objek	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL111
12	Analisis & desain Perangkat Lunak	1	2025-07-20 19:03:39	2025-07-20 19:03:39	TRPL112
13	Praktikum Mikro Komputer	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK201
14	Praktikum Jaringan Komputer Dasar	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK202
15	Praktikum Pengelolahan Sinyal & Citra Digital	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK203
16	Teknologi Nirkabel	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK204
17	Praktikum Rangkaian Elektronikal Digital	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK205
18	Praktikum Pemrograman Perangkat Bergerak	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK206
19	Praktikum Basis Data	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK207
20	Keamanan, Kesehatan, dan Keselamatan Kerja	2	2025-07-20 19:03:39	2025-07-20 19:03:39	TRK208
21	Praktikum Basis Data	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD301
22	Studi Kelayakan	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD302
23	Praktikum Desain & Analisis Sistem Informasi	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD303
24	Praktikum Pemrograman Web Dasar	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD304
25	Analisis Data Bisnis	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD305
26	Praktikum Pemrograman Web Dasar	3	2025-07-20 19:03:39	2025-07-20 19:03:39	BD306
\.


--
-- TOC entry 5159 (class 0 OID 99388)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
695	0001_01_01_000000_create_users_table	1
696	0001_01_01_000001_create_cache_table	1
697	0001_01_01_000002_create_jobs_table	1
698	2025_02_26_025052_add_two_factor_columns_to_users_table	1
699	2025_02_26_025145_create_personal_access_tokens_table	1
700	2025_02_26_025747_create_telescope_entries_table	1
701	2025_02_28_000902_create_tahun_ajarans_table	1
702	2025_03_01_015428_create_peralatans_table	1
703	2025_03_05_023632_create_prodis_table	1
704	2025_03_06_014955_create_kelas_table	1
705	2025_04_10_043315_create_mahasiswas_table	1
706	2025_04_18_035139_create_matakuliahs_table	1
707	2025_04_19_033040_create_dosens_table	1
708	2025_04_23_040914_create_labs_table	1
709	2025_04_23_092413_create_sesi_jams_table	1
710	2025_04_24_224902_create_haris_table	1
711	2025_04_24_232722_create_jadwal_labs_table	1
712	2025_04_30_222412_create_peminjamen_table	1
713	2025_04_30_222419_create_peminjaman_selesais_table	1
714	2025_04_30_222433_create_peminjaman_jadwals_table	1
715	2025_04_30_222441_create_peminjaman_manuals_table	1
716	2025_04_30_222503_create_peminjaman_ditolaks_table	1
717	2025_04_30_222529_create_peminjaman_peralatan_table	1
718	2025_05_12_064029_create_peminjaman_bermasalahs_table	1
719	2025_05_19_064558_create_unit_peralatans_table	1
720	2025_05_19_075027_create_peminjaman_unit_table	1
721	2025_06_11_172055_add_akses_ubah_kelas_to_users_table	1
722	2025_06_13_100307_add_username_to_users_table	1
723	2025_06_23_074449_add_kode_prodi_to_prodi_table	1
724	2025_06_23_082532_add_kode_mk_to_matakuliah_table	1
725	2025_06_24_075122_add_nip_to_dosen_table	1
726	2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table	1
727	2025_06_26_093501_create_jadwal_lab_sesi_jam_table	1
728	2025_07_19_183931_create_teams_table	1
729	2025_07_19_183932_create_team_user_table	1
730	2025_07_19_183933_create_team_invitations_table	1
\.


--
-- TOC entry 5162 (class 0 OID 117473)
-- Dependencies: 219
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 5199 (class 0 OID 117737)
-- Dependencies: 256
-- Data for Name: peminjaman; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman (id_peminjaman, tgl_peminjaman, id, status_peminjaman, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5205 (class 0 OID 117816)
-- Dependencies: 262
-- Data for Name: peminjaman_bermasalah; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_bermasalah (id_peminjaman, jam_dikembalikan, tgl_pengembalian, alasan_bermasalah, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5203 (class 0 OID 117793)
-- Dependencies: 260
-- Data for Name: peminjaman_ditolak; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_ditolak (id_peminjaman, alasan_ditolak, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5201 (class 0 OID 117757)
-- Dependencies: 258
-- Data for Name: peminjaman_jadwal; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_jadwal (id_peminjaman, "id_jadwalLab", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5202 (class 0 OID 117770)
-- Dependencies: 259
-- Data for Name: peminjaman_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_manual (id_peminjaman, id_sesi_mulai, id_sesi_selesai, id_lab, kegiatan, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5204 (class 0 OID 117803)
-- Dependencies: 261
-- Data for Name: peminjaman_peralatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_peralatan (id_peminjaman, id_peralatan, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5200 (class 0 OID 117749)
-- Dependencies: 257
-- Data for Name: peminjaman_selesai; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_selesai (id_peminjaman, tgl_pengembalian, jam_dikembalikan, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5208 (class 0 OID 117844)
-- Dependencies: 265
-- Data for Name: peminjaman_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peminjaman_unit (id_peminjaman, id_unit, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5180 (class 0 OID 117589)
-- Dependencies: 237
-- Data for Name: peralatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.peralatan (id_peralatan, nama_peralatan, created_at, updated_at) FROM stdin;
1	Proyektor	2025-07-20 19:03:39	2025-07-20 19:03:39
2	Remot AC	2025-07-20 19:03:39	2025-07-20 19:03:39
3	Kunci Lab	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5172 (class 0 OID 117533)
-- Dependencies: 229
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5182 (class 0 OID 117596)
-- Dependencies: 239
-- Data for Name: prodi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.prodi (id_prodi, nama_prodi, singkatan_prodi, created_at, updated_at, kode_prodi) FROM stdin;
1	Teknologi Rekayasa Perangkat Lunak	TRPL	2025-07-20 19:03:39	2025-07-20 19:03:39	58302
2	Teknologi Rekayasa Komputer dan jaringan	TRK	2025-07-20 19:03:39	2025-07-20 19:03:39	56301
3	Bisnis Digital	BSD	2025-07-20 19:03:39	2025-07-20 19:03:39	61316
\.


--
-- TOC entry 5193 (class 0 OID 117677)
-- Dependencies: 250
-- Data for Name: sesi_jam; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sesi_jam (id_sesi_jam, nama_sesi, jam_mulai, jam_selesai, created_at, updated_at) FROM stdin;
1	Jam Ke 1	07:30:00	08:20:00	2025-07-20 19:03:39	2025-07-20 19:03:39
2	Jam Ke 2	08:20:00	09:10:00	2025-07-20 19:03:39	2025-07-20 19:03:39
3	Jam Ke 3	09:10:00	10:00:00	2025-07-20 19:03:39	2025-07-20 19:03:39
4	Jam Ke 4	10:00:00	10:50:00	2025-07-20 19:03:39	2025-07-20 19:03:39
5	Jam Ke 5	10:50:00	11:40:00	2025-07-20 19:03:39	2025-07-20 19:03:39
6	Jam Ke 6	12:30:00	13:20:00	2025-07-20 19:03:39	2025-07-20 19:03:39
7	Jam Ke 7	13:20:00	14:10:00	2025-07-20 19:03:39	2025-07-20 19:03:39
8	Jam Ke 8	14:10:00	15:00:00	2025-07-20 19:03:39	2025-07-20 19:03:39
9	Jam Ke 9	15:00:00	15:50:00	2025-07-20 19:03:39	2025-07-20 19:03:39
10	Jam Ke 10	15:50:00	16:20:00	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5163 (class 0 OID 117480)
-- Dependencies: 220
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- TOC entry 5178 (class 0 OID 117577)
-- Dependencies: 235
-- Data for Name: tahun_ajaran; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tahun_ajaran ("id_tahunAjaran", tahun_ajaran, semester, "status_tahunAjaran", created_at, updated_at) FROM stdin;
1	2023/2024	ganjil	nonaktif	2025-07-20 19:03:39	2025-07-20 19:03:39
2	2023/2024	genap	nonaktif	2025-07-20 19:03:39	2025-07-20 19:03:39
3	2024/2025	ganjil	aktif	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5215 (class 0 OID 117899)
-- Dependencies: 272
-- Data for Name: team_invitations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.team_invitations (id, team_id, email, role, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5213 (class 0 OID 117890)
-- Dependencies: 270
-- Data for Name: team_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.team_user (id, team_id, user_id, role, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5211 (class 0 OID 117882)
-- Dependencies: 268
-- Data for Name: teams; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.teams (id, user_id, name, personal_team, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5174 (class 0 OID 117545)
-- Dependencies: 231
-- Data for Name: telescope_entries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.telescope_entries (sequence, uuid, batch_id, family_hash, should_display_on_index, type, content, created_at) FROM stdin;
1	9f6f83d1-5267-4f5e-b886-4f8a3632b8a9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select exists (select 1 from pg_class c, pg_namespace n where n.nspname = 'public' and c.relname = 'migrations' and c.relkind in ('r', 'p') and n.oid = c.relnamespace)","time":"5.18","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"7988c9c8692d965656b065ee2b0fdbca","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
2	9f6f83d1-5713-4091-b04f-86c3447071a9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select \\"migration\\" from \\"migrations\\" order by \\"batch\\" asc, \\"migration\\" asc","time":"2.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"84af29f5c40ba2eeda76663cdfcee4df","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
3	9f6f83d1-adb2-481f-8905-53b660e62eec	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"team_invitations\\"","time":"12.74","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183933_create_team_invitations_table.php","line":30,"hash":"ff20a9faa26229fc795f51e72fa1d1cd","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
4	9f6f83d1-bb0b-4fe7-9fd0-70910cbcd91b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_07_19_183933_create_team_invitations_table'","time":"1.16","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
5	9f6f83d1-bbd6-452c-b9ac-2252b048c0c9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"team_user\\"","time":"0.88","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183932_create_team_user_table.php","line":30,"hash":"f7e579b19784b559836ab59ac08081bd","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
6	9f6f83d1-be51-4351-8ff7-f90a98da127e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_07_19_183932_create_team_user_table'","time":"0.76","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
7	9f6f83d1-c01f-44a2-9ffa-5f19448ab708	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"teams\\"","time":"3.15","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183931_create_teams_table.php","line":28,"hash":"4f06d4cb81acef62af2318287cbf44b6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
8	9f6f83d1-c25c-45b1-bc96-ba751005c1f3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_07_19_183931_create_teams_table'","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
9	9f6f83d1-c37c-410c-b573-0f7e3ca214d9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"jadwal_lab_sesi_jam\\"","time":"1.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_26_093501_create_jadwal_lab_sesi_jam_table.php","line":19,"hash":"f66e4bb88b0923d89df0dd99617f5c51","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
10	9f6f83d1-c553-4f17-b606-fbb0019ce638	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_26_093501_create_jadwal_lab_sesi_jam_table'","time":"0.85","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
11	9f6f83d1-c779-4660-86f9-80fdd332b2ec	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" drop column \\"waktu_mulai_nonaktif\\"","time":"2.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table.php","line":19,"hash":"c7e31f5044022c13b043e13353292619","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
12	9f6f83d1-c8cf-41b2-b305-42f393cfd932	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" drop column \\"waktu_akhir_nonaktif\\"","time":"3.02","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table.php","line":19,"hash":"86027cf2840b11f62eccc86a194e1cc5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
13	9f6f83d1-ca0c-4c46-8653-55a4a9e93400	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table'","time":"0.93","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
14	9f6f83d1-caf3-4ba4-a68e-c6b7748c1985	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"dosen\\" drop column \\"nip\\"","time":"0.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_075122_add_nip_to_dosen_table.php","line":17,"hash":"8094f6b620629851794e9b9fd1d95b88","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
15	9f6f83d1-cd5f-4b9c-88e3-5f53838033f0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_24_075122_add_nip_to_dosen_table'","time":"0.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
16	9f6f83d1-ce22-4bb4-a600-55f4b47a4587	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"matakuliah\\" drop column \\"kode_mk\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_082532_add_kode_mk_to_matakuliah_table.php","line":17,"hash":"3ea4993f3fa485d139d8d8284f00bcab","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
17	9f6f83d1-cffe-4a60-a4ca-9923c346c298	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_23_082532_add_kode_mk_to_matakuliah_table'","time":"0.98","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
18	9f6f83d1-d107-4e0f-9e8c-93e7de54f677	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"prodi\\" drop column \\"kode_prodi\\"","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_074449_add_kode_prodi_to_prodi_table.php","line":18,"hash":"2e1d662130dda1fb965e9c9d30192a4b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
19	9f6f83d1-d40a-4c56-b762-1aee5b06f86f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_23_074449_add_kode_prodi_to_prodi_table'","time":"1.59","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
20	9f6f83d1-d54d-4cbc-8d36-ad79ad9b1a4b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_13_100307_add_username_to_users_table'","time":"0.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
21	9f6f83d1-d611-4019-9101-1164e6578b2f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" drop column \\"akses_ubah_kelas\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_11_172055_add_akses_ubah_kelas_to_users_table.php","line":17,"hash":"a66e291faed57d0c3cbc6256714e9554","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
22	9f6f83d1-d78a-4470-99b9-7e9408b91846	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_06_11_172055_add_akses_ubah_kelas_to_users_table'","time":"1.24","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
23	9f6f83d1-d855-4639-a1f1-5053941cf9b2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_unit\\"","time":"0.89","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_075027_create_peminjaman_unit_table.php","line":26,"hash":"51038b18a816aa5629482183349cd8cf","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
24	9f6f83d1-da70-4410-b5aa-80bee8359c14	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_05_19_075027_create_peminjaman_unit_table'","time":"0.93","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
25	9f6f83d1-db6c-4511-bb6a-ade7386de6ed	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"unit_peralatan\\"","time":"1.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_064558_create_unit_peralatans_table.php","line":28,"hash":"b9dfbb6fa60974b9e3456f260a9fd652","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
26	9f6f83d1-de9b-4e18-a884-7760837be7db	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_05_19_064558_create_unit_peralatans_table'","time":"0.84","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
27	9f6f83d1-e091-46d8-9226-47e3ce4497de	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_bermasalah\\"","time":"2.09","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_12_064029_create_peminjaman_bermasalahs_table.php","line":28,"hash":"39ceffd1fdf73d1e8c0a116259596c12","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
28	9f6f83d1-e2dd-4f0c-9d16-984e53d95971	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_05_12_064029_create_peminjaman_bermasalahs_table'","time":"0.89","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
29	9f6f83d1-e45d-4073-856d-30a5bf438584	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_peralatan\\"","time":"1.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222529_create_peminjaman_peralatan_table.php","line":26,"hash":"ca0fe8c9bb7cce74ee3ce881be53c71e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
30	9f6f83d1-e64f-49da-8381-a8ba689dcbca	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222529_create_peminjaman_peralatan_table'","time":"0.87","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
31	9f6f83d1-e77f-44b4-9f4e-6cb97c2f795b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_ditolak\\"","time":"0.92","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222503_create_peminjaman_ditolaks_table.php","line":27,"hash":"6cf0eb5a9f4d485667bd7fbcb59dd85c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
32	9f6f83d1-e97e-4e78-8210-da98702817cf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222503_create_peminjaman_ditolaks_table'","time":"0.76","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
33	9f6f83d1-eab1-49f0-a47d-aad3692427ab	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_manual\\"","time":"1.37","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":31,"hash":"752ddc6c0fb66c4424a5c09e26abef26","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
34	9f6f83d1-ec6c-4a6d-a9fe-e02a62a896c1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222441_create_peminjaman_manuals_table'","time":"1.18","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
35	9f6f83d1-ed68-45d1-a23c-1086cecf0b4f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_jadwal\\"","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222433_create_peminjaman_jadwals_table.php","line":27,"hash":"3e2c70dc016ab41bb6a7ee3f51d71579","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
36	9f6f83d1-ee97-4549-a582-e9ebc25166fb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222433_create_peminjaman_jadwals_table'","time":"0.58","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
37	9f6f83d1-ef6e-4663-9ad4-f1d129111924	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman_selesai\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222419_create_peminjaman_selesais_table.php","line":27,"hash":"f4911cfff7dc25e082a413fc7fedb934","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
38	9f6f83d1-f0d3-4d0c-b726-f745d253eb78	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222419_create_peminjaman_selesais_table'","time":"0.84","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
39	9f6f83d1-f216-4758-80d9-8fb0ca82ef07	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peminjaman\\"","time":"1.12","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222412_create_peminjamen_table.php","line":28,"hash":"7385bacf693f407ae5229e558b5840fa","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
40	9f6f83d1-f3d6-40f6-ad26-65697750c885	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_30_222412_create_peminjamen_table'","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
41	9f6f83d1-f553-4f71-b8d2-8cd85fa9eb1f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"jadwal_lab\\"","time":"2.50","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":35,"hash":"629b17b2ccc6f63238835ebde34d6d2c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
42	9f6f83d1-f772-4021-bef7-7449a32a8fdf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_24_232722_create_jadwal_labs_table'","time":"0.99","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
43	9f6f83d1-f87b-4c3a-9fe6-31f1078f5b32	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"hari\\"","time":"1.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_224902_create_haris_table.php","line":26,"hash":"cc9d9d36fa659876e59c78350ef88195","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
44	9f6f83d1-fb87-41b3-9606-9d0518aa8779	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_24_224902_create_haris_table'","time":"0.87","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
45	9f6f83d1-fc62-43f1-b0c4-4db6c1c268a1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"sesi_jam\\"","time":"0.74","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_23_092413_create_sesi_jams_table.php","line":23,"hash":"89ae9e9655a1821aad526de588cb8a7b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
46	9f6f83d1-ff5a-4a58-a511-c373f907cde0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_23_092413_create_sesi_jams_table'","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
47	9f6f83d1-ffff-41d6-a2b0-bd66557e3a3f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"lab\\"","time":"0.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_23_040914_create_labs_table.php","line":31,"hash":"456660cc0dcaacee2b7e0f36b2f3679a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
48	9f6f83d2-0263-4be0-96cb-75c0532303f4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_23_040914_create_labs_table'","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
49	9f6f83d2-0349-40b4-b159-5640108b4b92	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"dosen\\"","time":"1.07","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_19_033040_create_dosens_table.php","line":21,"hash":"1afc1b41d6deb4f86c1c97597b5307f5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
50	9f6f83d2-06c0-4d58-94e6-8c877ccb6821	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_19_033040_create_dosens_table'","time":"1.60","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
51	9f6f83d2-0793-45b2-919a-7db487f593b2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"matakuliah\\"","time":"0.95","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_18_035139_create_matakuliahs_table.php","line":21,"hash":"43015f1af35f3347a34102f66b27ce1e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
52	9f6f83d2-09d3-472a-a387-ef20753dc096	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_18_035139_create_matakuliahs_table'","time":"0.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
53	9f6f83d2-0b3d-4299-ad73-7255c5fe66a7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"mahasiswa\\"","time":"1.95","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":26,"hash":"d4731d5a624d247dba1d4e3cbe7cfa64","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
54	9f6f83d2-0d76-453a-b54c-47398931c429	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_04_10_043315_create_mahasiswas_table'","time":"0.68","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
55	9f6f83d2-0e2c-40ff-9120-20665d1b4b7f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"kelas\\"","time":"0.77","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_06_014955_create_kelas_table.php","line":22,"hash":"a7e45e42d13e8ba6d8d94474d29c891e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
56	9f6f83d2-1015-47c9-9145-7dde3a0a429b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_03_06_014955_create_kelas_table'","time":"0.60","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
57	9f6f83d2-10fc-4eb9-b270-12f1aca2b733	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"prodi\\"","time":"1.24","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_05_023632_create_prodis_table.php","line":27,"hash":"1474ff4b5589f6debd9b34ab8cc7c8f5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
58	9f6f83d2-143f-4d16-8a7c-f233425b82f3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_03_05_023632_create_prodis_table'","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
59	9f6f83d2-14e8-49c7-9577-2fb64b9bec81	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"peralatan\\"","time":"0.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_01_015428_create_peralatans_table.php","line":26,"hash":"488e99c99c57f7f0b45c9d2fcee65381","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
60	9f6f83d2-16ae-46d7-ac39-331c5791cd73	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_03_01_015428_create_peralatans_table'","time":"0.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
61	9f6f83d2-17b6-4bc4-a18f-e43d87f6090d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"tahun_ajaran\\"","time":"1.44","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_28_000902_create_tahun_ajarans_table.php","line":28,"hash":"f905548dbaf4564898323ae21834b5fe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
62	9f6f83d2-1aa1-4239-a209-15ce9609365c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_02_28_000902_create_tahun_ajarans_table'","time":"0.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
63	9f6f83d2-1b58-44f6-b794-57c72adf6196	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"telescope_entries_tags\\"","time":"0.75","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":66,"hash":"3343ab7521447d3450a05bb40556baf0","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
64	9f6f83d2-1bdc-4b26-a7d3-0cd46de86cb8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"telescope_entries\\"","time":"1.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":67,"hash":"878f3881758e611c9c4b0e6982b2120a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
65	9f6f83d2-1c16-496f-8713-fd7095848156	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"telescope_monitoring\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":68,"hash":"9111a4d2c15ce2786962ce6100b457ce","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
66	9f6f83d2-2157-4dea-987f-49ad00b04b20	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_02_26_025747_create_telescope_entries_table'","time":"0.75","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
67	9f6f83d2-221b-47e5-92ec-49adc7d0e21e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"personal_access_tokens\\"","time":"0.83","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025145_create_personal_access_tokens_table.php","line":31,"hash":"bb727ec5a667b28b20fb0e8dcade427c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
68	9f6f83d2-2431-4310-9966-9300b34f2a12	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_02_26_025145_create_personal_access_tokens_table'","time":"0.60","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
69	9f6f83d2-2530-4b86-a470-fce6c9fea8f4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" drop column \\"two_factor_secret\\", drop column \\"two_factor_recovery_codes\\", drop column \\"two_factor_confirmed_at\\"","time":"0.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025052_add_two_factor_columns_to_users_table.php","line":34,"hash":"8f0b8befe96955bd97782d7cc9c0d8df","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
70	9f6f83d2-2660-4db1-b29f-66179c60d317	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '2025_02_26_025052_add_two_factor_columns_to_users_table'","time":"0.69","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
71	9f6f83d2-279d-4144-a4e5-da5a926bf909	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"jobs\\"","time":"1.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":53,"hash":"35102f192cd7d073950cae202bc12602","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
72	9f6f83d2-27fa-4518-a643-736ba3934230	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"job_batches\\"","time":"0.54","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":54,"hash":"081de242f47097b74d4f600196da62bf","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
73	9f6f83d2-2854-432e-9cd9-68e67875939f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"failed_jobs\\"","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":55,"hash":"63e960268bb2d38eb6b0f3680f454e7d","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
74	9f6f83d2-2c85-44b7-9354-3bbb2bc8580a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '0001_01_01_000002_create_jobs_table'","time":"1.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
75	9f6f83d2-2d2f-4795-97f9-2e63947305ed	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"cache\\"","time":"0.62","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":32,"hash":"99b3a558a3a4c312bbf87f73e1fca9eb","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
76	9f6f83d2-2d7d-46af-9272-8110645e1cb5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"cache_locks\\"","time":"0.47","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":33,"hash":"aa429031740fdab400d12ecab47b4ee9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
77	9f6f83d2-2f9b-4a0b-8d80-7db612c3897d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '0001_01_01_000001_create_cache_table'","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
78	9f6f83d2-306d-4682-9fdc-92636786ef9a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"users\\"","time":"1.04","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":50,"hash":"c3b7c0bec69d3a6c32bcfc5ca2a89624","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
79	9f6f83d2-30be-45d7-bef3-064d0406dffb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"password_reset_tokens\\"","time":"0.48","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":51,"hash":"ce6e5413534beb01682b1de884e9c37b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
80	9f6f83d2-310c-4cac-b6c9-b00721daa6b1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"drop table if exists \\"sessions\\"","time":"0.52","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":52,"hash":"9b36e288dc44b4d0983be51c0a08239b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
81	9f6f83d2-3694-4cba-bd9b-a202e7cd2d2e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"delete from \\"migrations\\" where \\"migration\\" = '0001_01_01_000000_create_users_table'","time":"0.92","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"8960385cf7ddcd29cd513bf889d53827","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
82	9f6f83d2-37fc-4e30-881d-70340757621c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select exists (select 1 from pg_class c, pg_namespace n where n.nspname = 'public' and c.relname = 'migrations' and c.relkind in ('r', 'p') and n.oid = c.relnamespace)","time":"1.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"7988c9c8692d965656b065ee2b0fdbca","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
83	9f6f83d2-388b-43e9-8008-35e50e2868f1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select exists (select 1 from pg_class c, pg_namespace n where n.nspname = 'public' and c.relname = 'migrations' and c.relkind in ('r', 'p') and n.oid = c.relnamespace)","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"7988c9c8692d965656b065ee2b0fdbca","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
84	9f6f83d2-393f-458d-ae29-bdbe91787f62	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select \\"migration\\" from \\"migrations\\" order by \\"batch\\" asc, \\"migration\\" asc","time":"1.04","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"84af29f5c40ba2eeda76663cdfcee4df","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
85	9f6f83d2-3aa4-4a79-aafa-a0b48daf5072	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select \\"migration\\" from \\"migrations\\" order by \\"batch\\" asc, \\"migration\\" asc","time":"0.44","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"84af29f5c40ba2eeda76663cdfcee4df","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
86	9f6f83d2-3be8-4369-a0cc-9317f8cd89df	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select max(\\"batch\\") as aggregate from \\"migrations\\"","time":"0.97","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"891c93593b7807a7dfc0848070936947","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
87	9f6f83d2-4f22-4750-b824-055f96c5d284	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"users\\" (\\"id\\" bigserial not null primary key, \\"name\\" varchar(255) not null, \\"email\\" varchar(255) not null, \\"email_verified_at\\" timestamp(0) without time zone null, \\"password\\" varchar(255) not null, \\"role\\" varchar(255) check (\\"role\\" in ('teknisi', 'mahasiswa')) not null default 'mahasiswa', \\"status_user\\" varchar(255) check (\\"status_user\\" in ('aktif', 'nonaktif')) not null default 'aktif', \\"remember_token\\" varchar(100) null, \\"current_team_id\\" bigint null, \\"profile_photo_path\\" varchar(6048) null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"21.20","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":14,"hash":"d02a1367e63fbd604e6f0d29dc5b8ea2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
88	9f6f83d2-52a7-43c1-b8bd-6aced01e8bb9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add constraint \\"users_email_unique\\" unique (\\"email\\")","time":"8.27","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":14,"hash":"a7941bc5211747d9f6bba27e7cd40aa3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
89	9f6f83d2-5443-4f88-9b5b-db5acb43e21e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"password_reset_tokens\\" (\\"email\\" varchar(255) not null, \\"token\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null)","time":"3.30","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":29,"hash":"e8e5c5ce0dbec55ccd257c47e89ecaec","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
90	9f6f83d2-551b-4e4f-a462-5998d119deb9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"password_reset_tokens\\" add primary key (\\"email\\")","time":"1.72","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":29,"hash":"5b90b60c4becc7731fc855c5fa63972a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
91	9f6f83d2-5666-4836-9b7b-ee86afbf229c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"sessions\\" (\\"id\\" varchar(255) not null, \\"user_id\\" bigint null, \\"ip_address\\" varchar(45) null, \\"user_agent\\" text null, \\"payload\\" text not null, \\"last_activity\\" integer not null)","time":"2.68","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":35,"hash":"8308816771d6a380fb3a4b72e22f4dac","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
92	9f6f83d2-573d-45ed-86eb-51dc3bf352c2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"sessions\\" add primary key (\\"id\\")","time":"1.75","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":35,"hash":"632707dbc81193dc6466cf3ab7a3062b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
93	9f6f83d2-5831-400b-8e12-863d5f8e682d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"sessions_user_id_index\\" on \\"sessions\\" (\\"user_id\\")","time":"2.01","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":35,"hash":"2542eec4d80cc182d87c3cf7cab44922","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
94	9f6f83d2-5970-4f6f-a796-93a9d71886c7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"sessions_last_activity_index\\" on \\"sessions\\" (\\"last_activity\\")","time":"2.62","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000000_create_users_table.php","line":35,"hash":"d92496b4297ffd699cf298b9aeae6950","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
95	9f6f83d2-5b60-4661-92b8-9b59098bdb04	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('0001_01_01_000000_create_users_table', 1)","time":"1.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
96	9f6f83d2-5cd5-4631-9d83-297881cc13a4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"cache\\" (\\"key\\" varchar(255) not null, \\"value\\" text not null, \\"expiration\\" integer not null)","time":"2.94","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":14,"hash":"7f67485c05da39282f5a9cfc42f22833","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
97	9f6f83d2-5dcc-434b-90f3-d1abc0dda4ef	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"cache\\" add primary key (\\"key\\")","time":"2.04","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":14,"hash":"787fdee5d41b50e0ddaee677c8df71ca","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
98	9f6f83d2-5f7c-4ca7-8230-c5476555894d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"cache_locks\\" (\\"key\\" varchar(255) not null, \\"owner\\" varchar(255) not null, \\"expiration\\" integer not null)","time":"3.54","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":20,"hash":"63ace63c4220a580aa733330af30f704","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
99	9f6f83d2-60d1-4108-8940-71b6963b7ef7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"cache_locks\\" add primary key (\\"key\\")","time":"2.73","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000001_create_cache_table.php","line":20,"hash":"e725542fe13520a67e943bdf87887548","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
100	9f6f83d2-62c2-40df-8b14-af4fcbfc26af	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('0001_01_01_000001_create_cache_table', 1)","time":"0.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
101	9f6f83d2-654d-403a-9a0c-8fd98601cf73	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"jobs\\" (\\"id\\" bigserial not null primary key, \\"queue\\" varchar(255) not null, \\"payload\\" text not null, \\"attempts\\" smallint not null, \\"reserved_at\\" integer null, \\"available_at\\" integer not null, \\"created_at\\" integer not null)","time":"5.38","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":14,"hash":"b7729da8aa116863fe7f3af77c646f6b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
102	9f6f83d2-6709-43b0-88a2-e7a9fe6272e7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"jobs_queue_index\\" on \\"jobs\\" (\\"queue\\")","time":"3.73","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":14,"hash":"7b59ef50d4ab2d8cfe94adaf49d887a6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
103	9f6f83d2-6893-4e7a-87cf-4c5a5b128e63	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"job_batches\\" (\\"id\\" varchar(255) not null, \\"name\\" varchar(255) not null, \\"total_jobs\\" integer not null, \\"pending_jobs\\" integer not null, \\"failed_jobs\\" integer not null, \\"failed_job_ids\\" text not null, \\"options\\" text null, \\"cancelled_at\\" integer null, \\"created_at\\" integer not null, \\"finished_at\\" integer null)","time":"3.15","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":24,"hash":"66e646f400ac2669f2ff0b0d511530a3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
104	9f6f83d2-6982-44b6-b3da-025bd527afa3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"job_batches\\" add primary key (\\"id\\")","time":"1.97","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":24,"hash":"ac41bc33ab9059ed28a4db56836e8c2a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
105	9f6f83d2-7bb6-402d-9cd1-d8f21f834588	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"failed_jobs\\" (\\"id\\" bigserial not null primary key, \\"uuid\\" varchar(255) not null, \\"connection\\" text not null, \\"queue\\" text not null, \\"payload\\" text not null, \\"exception\\" text not null, \\"failed_at\\" timestamp(0) without time zone not null default CURRENT_TIMESTAMP)","time":"8.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":37,"hash":"8f6b859463c56bf902459b69488562c2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
106	9f6f83d2-7d03-4435-ad2a-bd85e36995ad	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"failed_jobs\\" add constraint \\"failed_jobs_uuid_unique\\" unique (\\"uuid\\")","time":"2.89","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\0001_01_01_000002_create_jobs_table.php","line":37,"hash":"55995ef416af2079ea79dbfbd676c79f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
107	9f6f83d2-7e79-4bee-9806-c0be76882997	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('0001_01_01_000002_create_jobs_table', 1)","time":"0.94","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
108	9f6f83d2-7f27-4046-b115-eb1fbb15e77f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add column \\"two_factor_secret\\" text null","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025052_add_two_factor_columns_to_users_table.php","line":14,"hash":"d0cc975edea5631d7f904aa43c7d608a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
109	9f6f83d2-7f93-4cda-9851-1ffb06e3441d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add column \\"two_factor_recovery_codes\\" text null","time":"0.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025052_add_two_factor_columns_to_users_table.php","line":14,"hash":"1b98fac27d8b060ac76b68bc0c8aa17c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
110	9f6f83d2-7ff1-42d4-b43e-081bdc60f141	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add column \\"two_factor_confirmed_at\\" timestamp(0) without time zone null","time":"0.48","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025052_add_two_factor_columns_to_users_table.php","line":14,"hash":"f0d3f5b36a2ce3959d50bafeaf5a3cc8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
111	9f6f83d2-8141-4527-b87a-3dabc82188bb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_02_26_025052_add_two_factor_columns_to_users_table', 1)","time":"0.72","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
112	9f6f83d2-83cf-40df-a2a4-6992698ebc27	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"personal_access_tokens\\" (\\"id\\" bigserial not null primary key, \\"tokenable_type\\" varchar(255) not null, \\"tokenable_id\\" bigint not null, \\"name\\" varchar(255) not null, \\"token\\" varchar(64) not null, \\"abilities\\" text null, \\"last_used_at\\" timestamp(0) without time zone null, \\"expires_at\\" timestamp(0) without time zone null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"5.35","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025145_create_personal_access_tokens_table.php","line":14,"hash":"8ae7b6991b0359992c2ba438e62bcddb","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
113	9f6f83d2-84d3-4c88-b984-b73fb6c09cc5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"personal_access_tokens_tokenable_type_tokenable_id_index\\" on \\"personal_access_tokens\\" (\\"tokenable_type\\", \\"tokenable_id\\")","time":"2.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025145_create_personal_access_tokens_table.php","line":14,"hash":"f58d8e450b917eab13e6bec95345ae07","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
114	9f6f83d2-85be-4cfe-a8cb-19a46e103e3e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"personal_access_tokens\\" add constraint \\"personal_access_tokens_token_unique\\" unique (\\"token\\")","time":"1.74","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025145_create_personal_access_tokens_table.php","line":14,"hash":"099e0991d0cc0d053795f9387a3a0a9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
115	9f6f83d2-87de-4d0c-95ac-f90abc6ffe4f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_02_26_025145_create_personal_access_tokens_table', 1)","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
116	9f6f83d2-8b58-407a-9c82-add2bc8a7506	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"telescope_entries\\" (\\"sequence\\" bigserial not null primary key, \\"uuid\\" uuid not null, \\"batch_id\\" uuid not null, \\"family_hash\\" varchar(255) null, \\"should_display_on_index\\" boolean not null default '1', \\"type\\" varchar(20) not null, \\"content\\" text not null, \\"created_at\\" timestamp(0) without time zone null)","time":"6.43","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"b406db2c2f873cdd4e80585f223cfdf9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:37
117	9f6f83d2-8c78-4ba5-b4f4-c84a77db0b52	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"telescope_entries\\" add constraint \\"telescope_entries_uuid_unique\\" unique (\\"uuid\\")","time":"2.26","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"65516b962cdccf5d313657a083ce8e23","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
118	9f6f83d2-8e0d-4d7a-8a23-32c1824bf13c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"telescope_entries_batch_id_index\\" on \\"telescope_entries\\" (\\"batch_id\\")","time":"2.87","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"e10b43e84e03625fedc71f28fb117fcd","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
119	9f6f83d2-8f16-4517-a480-54c64dfe4b2c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"telescope_entries_family_hash_index\\" on \\"telescope_entries\\" (\\"family_hash\\")","time":"1.97","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"83054e6de7da4fc398165e89e56e6579","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
120	9f6f83d2-902e-4f53-a58c-37179a5809d7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"telescope_entries_created_at_index\\" on \\"telescope_entries\\" (\\"created_at\\")","time":"2.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"480c085033a759f5759c64439988b7ad","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
121	9f6f83d2-91d2-4acc-87c9-43d31871fc11	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"telescope_entries_type_should_display_on_index_index\\" on \\"telescope_entries\\" (\\"type\\", \\"should_display_on_index\\")","time":"3.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":24,"hash":"2dde9b32f7ec3cbde8e7233229f9e72a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
122	9f6f83d2-9d2c-47fa-804a-dc80c4086533	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"telescope_entries_tags\\" (\\"entry_uuid\\" uuid not null, \\"tag\\" varchar(255) not null)","time":"3.14","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":41,"hash":"84423770c386428de619551ca156a52b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
123	9f6f83d2-9e36-4d0c-a486-d77c965e16fe	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"telescope_entries_tags\\" add primary key (\\"entry_uuid\\", \\"tag\\")","time":"2.25","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":41,"hash":"d121bf7f5eac3400def591e1ebce7439","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
124	9f6f83d2-9f54-45e9-b3e9-964aa733c087	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"telescope_entries_tags_tag_index\\" on \\"telescope_entries_tags\\" (\\"tag\\")","time":"2.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":41,"hash":"fb3cf587edc205c8c419d474ea351a78","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
125	9f6f83d2-a29c-464d-b184-b569a2948fe9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"telescope_entries_tags\\" add constraint \\"telescope_entries_tags_entry_uuid_foreign\\" foreign key (\\"entry_uuid\\") references \\"telescope_entries\\" (\\"uuid\\") on delete cascade","time":"7.96","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":41,"hash":"84715bebe24deb92d4af7a4800fc4a2b","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
126	9f6f83d2-a332-4881-923d-db908284c0c1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"telescope_monitoring\\" (\\"tag\\" varchar(255) not null)","time":"1.02","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":54,"hash":"ae42f8fdcbfbd265b65572f79934d1ae","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
127	9f6f83d2-a43c-4cab-acf0-07e81a043aab	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"telescope_monitoring\\" add primary key (\\"tag\\")","time":"2.29","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_26_025747_create_telescope_entries_table.php","line":54,"hash":"27b4fa17d400b8ca9300968e559f8b58","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
128	9f6f83d2-a56a-4f10-bf1a-c98224da5e1c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_02_26_025747_create_telescope_entries_table', 1)","time":"0.84","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
189	9f6f83d2-f832-4521-8927-95b9b1013d9b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222529_create_peminjaman_peralatan_table', 1)","time":"0.77","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
129	9f6f83d2-a7bf-489d-86a2-85966e543634	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"tahun_ajaran\\" (\\"id_tahunAjaran\\" bigserial not null primary key, \\"tahun_ajaran\\" varchar(255) not null, \\"semester\\" varchar(255) check (\\"semester\\" in ('ganjil', 'genap')) not null, \\"status_tahunAjaran\\" varchar(255) check (\\"status_tahunAjaran\\" in ('aktif', 'nonaktif')) not null default 'aktif', \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"5.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_02_28_000902_create_tahun_ajarans_table.php","line":14,"hash":"16388cd5107670f45a6df01d9e409410","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
130	9f6f83d2-a8df-4348-bdbe-b09b763b9dc2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_02_28_000902_create_tahun_ajarans_table', 1)","time":"0.86","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
131	9f6f83d2-ab19-40c8-bafa-c49f39818901	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peralatan\\" (\\"id_peralatan\\" bigserial not null primary key, \\"nama_peralatan\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"4.26","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_01_015428_create_peralatans_table.php","line":14,"hash":"3dbfd99f2b11bea6308ec454d15e1ccd","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
132	9f6f83d2-acf8-4ec1-adc8-122c35cef292	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_03_01_015428_create_peralatans_table', 1)","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
133	9f6f83d2-afcb-4379-97b7-f814708f66d1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"prodi\\" (\\"id_prodi\\" bigserial not null primary key, \\"nama_prodi\\" varchar(255) not null, \\"singkatan_prodi\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"5.88","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_05_023632_create_prodis_table.php","line":14,"hash":"ab66d866077ea32c33554b75becb7f64","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
134	9f6f83d2-b115-4038-a12d-34bd484d3d1f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_03_05_023632_create_prodis_table', 1)","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
135	9f6f83d2-b2e0-440b-a6ea-2cfeb8cbf5f2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"kelas\\" (\\"id_kelas\\" bigserial not null primary key, \\"id_prodi\\" bigint not null, \\"nama_kelas\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.51","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_06_014955_create_kelas_table.php","line":12,"hash":"9c09295b9029b50730c79372fc83594d","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
136	9f6f83d2-b435-4c96-aafe-5754f199a7db	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"kelas\\" add constraint \\"kelas_id_prodi_foreign\\" foreign key (\\"id_prodi\\") references \\"prodi\\" (\\"id_prodi\\") on delete cascade","time":"2.85","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_03_06_014955_create_kelas_table.php","line":12,"hash":"d67afdc76a901d765cd27f78462a63bd","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
137	9f6f83d2-b5d3-44f3-97c5-05e626148576	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_03_06_014955_create_kelas_table', 1)","time":"1.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
138	9f6f83d2-b7ad-4642-bf0a-c134b257e2ba	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"mahasiswa\\" (\\"id\\" bigint not null, \\"id_prodi\\" bigint not null, \\"id_kelas\\" bigint not null, \\"nim\\" varchar(255) not null, \\"telepon\\" varchar(255) not null, \\"foto_ktm\\" varchar(10240) null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.53","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":10,"hash":"89b4137949c8106b885f6e9699c279a2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
139	9f6f83d2-b8c0-48c5-8fe3-8138001fb049	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"mahasiswa\\" add constraint \\"mahasiswa_id_foreign\\" foreign key (\\"id\\") references \\"users\\" (\\"id\\") on delete cascade","time":"2.30","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":10,"hash":"33a1ca4e38919eec68e25df79418e07c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
140	9f6f83d2-b956-46f1-983d-3a61d1096bf6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"mahasiswa\\" add constraint \\"mahasiswa_id_prodi_foreign\\" foreign key (\\"id_prodi\\") references \\"prodi\\" (\\"id_prodi\\") on delete cascade","time":"1.16","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":10,"hash":"df4b4bf5757009d74f583e7c98dd41ad","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
141	9f6f83d2-ba22-4437-9d01-4ef635878144	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"mahasiswa\\" add constraint \\"mahasiswa_id_kelas_foreign\\" foreign key (\\"id_kelas\\") references \\"kelas\\" (\\"id_kelas\\") on delete cascade","time":"1.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":10,"hash":"9f7d1e4801620748ef617eae64db3098","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
142	9f6f83d2-bb89-4826-a355-41ec9e414072	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"mahasiswa\\" add constraint \\"mahasiswa_nim_unique\\" unique (\\"nim\\")","time":"3.08","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_10_043315_create_mahasiswas_table.php","line":10,"hash":"e98ebdf3db744978012b180ab63310a1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
143	9f6f83d2-bca9-474a-9efe-87c14dd05b38	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_10_043315_create_mahasiswas_table', 1)","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
263	9f6f83d4-492b-4b95-b7a8-600cb55e09e5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\UnitPeralatan:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
144	9f6f83d2-be7b-465e-b153-434d3b8a330d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"matakuliah\\" (\\"id_mk\\" bigserial not null primary key, \\"nama_mk\\" varchar(255) not null, \\"id_prodi\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_18_035139_create_matakuliahs_table.php","line":10,"hash":"51517a76bf0a10d490158d303821fe3f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
145	9f6f83d2-bf59-44b7-b2de-d61ab491af84	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"matakuliah\\" add constraint \\"matakuliah_id_prodi_foreign\\" foreign key (\\"id_prodi\\") references \\"prodi\\" (\\"id_prodi\\") on delete cascade","time":"1.77","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_18_035139_create_matakuliahs_table.php","line":10,"hash":"c46879b8cfbf45bd711c253dfd2d9b1f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
146	9f6f83d2-c0d2-4f2a-a68a-78ae5b7d592e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_18_035139_create_matakuliahs_table', 1)","time":"1.29","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
147	9f6f83d2-c40b-4524-adfd-062a15800720	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"dosen\\" (\\"id_dosen\\" bigserial not null primary key, \\"nama_dosen\\" varchar(255) not null, \\"telepon\\" varchar(255) not null, \\"id_prodi\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"6.58","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_19_033040_create_dosens_table.php","line":10,"hash":"67420b2970c9c0a9e8f5c46e891d6a75","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
148	9f6f83d2-c4ec-4925-b482-d25c25c63c38	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"dosen\\" add constraint \\"dosen_id_prodi_foreign\\" foreign key (\\"id_prodi\\") references \\"prodi\\" (\\"id_prodi\\") on delete cascade","time":"1.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_19_033040_create_dosens_table.php","line":10,"hash":"e9ca6175342aeaf71a1b767489c34f8f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
149	9f6f83d2-c5e3-4fa2-b2b5-fe96e290bd37	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"dosen\\" add constraint \\"dosen_nama_dosen_unique\\" unique (\\"nama_dosen\\")","time":"2.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_19_033040_create_dosens_table.php","line":10,"hash":"acee980ded523cb1dbdd50465cb41695","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
150	9f6f83d2-c75c-463f-ad0d-e2c277636708	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_19_033040_create_dosens_table', 1)","time":"1.17","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
151	9f6f83d2-caed-4b81-8739-f72dc127ec3e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"lab\\" (\\"id_lab\\" bigserial not null primary key, \\"nama_lab\\" varchar(255) not null, \\"status_lab\\" varchar(255) check (\\"status_lab\\" in ('aktif', 'nonaktif')) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"6.49","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_23_040914_create_labs_table.php","line":16,"hash":"c19f5f38ce82247ccc022f7c1bdab1e3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
152	9f6f83d2-cc3c-41df-8c1e-0e41b06b85d9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_23_040914_create_labs_table', 1)","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
153	9f6f83d2-ce44-4123-b8e3-d54c9a9a6d7a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"sesi_jam\\" (\\"id_sesi_jam\\" bigserial not null primary key, \\"nama_sesi\\" varchar(20) not null, \\"jam_mulai\\" time(0) without time zone not null, \\"jam_selesai\\" time(0) without time zone not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.96","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_23_092413_create_sesi_jams_table.php","line":12,"hash":"a4b51bee2cac6d454b7f45d2b7695204","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
154	9f6f83d2-cffc-437a-9524-f6e71bab7eec	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_23_092413_create_sesi_jams_table', 1)","time":"1.02","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
155	9f6f83d2-d1bf-4b41-ad64-0ccba026980e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"hari\\" (\\"id_hari\\" bigserial not null primary key, \\"nama_hari\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.43","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_224902_create_haris_table.php","line":14,"hash":"5b057798944e1edd51eeb97c312c32e0","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
156	9f6f83d2-d2c8-4900-9ed9-e13e9db138f1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"hari\\" add constraint \\"hari_nama_hari_unique\\" unique (\\"nama_hari\\")","time":"2.18","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_224902_create_haris_table.php","line":14,"hash":"30ad6f2d834108eecc5860fa3f8d60a2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
157	9f6f83d2-d444-4efa-a886-a30681f39a5d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_24_224902_create_haris_table', 1)","time":"1.22","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
158	9f6f83d2-d717-4b2a-8c6e-f2d3631069b5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"jadwal_lab\\" (\\"id_jadwalLab\\" bigserial not null primary key, \\"id_hari\\" bigint not null, \\"id_lab\\" bigint not null, \\"id_mk\\" bigint not null, \\"id_dosen\\" bigint not null, \\"id_prodi\\" bigint not null, \\"id_kelas\\" bigint not null, \\"id_tahunAjaran\\" bigint not null, \\"status_jadwalLab\\" varchar(255) check (\\"status_jadwalLab\\" in ('aktif', 'nonaktif')) not null default 'aktif', \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"4.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"ba102d2a88b0c34b3cec3de56ad74884","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
287	9f6f83d4-55a8-4b36-8c65-73a9d275aea7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
159	9f6f83d2-d877-4114-9af4-16335013551f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_hari_foreign\\" foreign key (\\"id_hari\\") references \\"hari\\" (\\"id_hari\\") on delete cascade","time":"3.06","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"07f4aa4199e38f948b6f6e880f137c65","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
160	9f6f83d2-d949-48f1-9478-df649c100881	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_lab_foreign\\" foreign key (\\"id_lab\\") references \\"lab\\" (\\"id_lab\\") on delete cascade","time":"1.73","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"38023b84f14a7ffb39ba382c773bb07c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
161	9f6f83d2-da18-434d-820c-a05fcfdffee3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_mk_foreign\\" foreign key (\\"id_mk\\") references \\"matakuliah\\" (\\"id_mk\\") on delete cascade","time":"1.72","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"4c05a05620edd8c1852778d7419199d5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
162	9f6f83d2-db39-49f5-bc1a-8f245025383f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_dosen_foreign\\" foreign key (\\"id_dosen\\") references \\"dosen\\" (\\"id_dosen\\") on delete cascade","time":"2.44","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"e1117e367b9a1eab49900ad76f8347ec","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
163	9f6f83d2-dc36-4c65-b684-9fdda9bf8882	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_prodi_foreign\\" foreign key (\\"id_prodi\\") references \\"prodi\\" (\\"id_prodi\\") on delete cascade","time":"1.86","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"f883d3b17956e5c1a5923c8233d18aa8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
164	9f6f83d2-dcd5-4750-8805-ccf8e297b88b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_kelas_foreign\\" foreign key (\\"id_kelas\\") references \\"kelas\\" (\\"id_kelas\\") on delete cascade","time":"1.23","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"1618d29dd835dc68c730959bf5126b78","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
165	9f6f83d2-dda6-4e67-99d2-e94607c205df	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add constraint \\"jadwal_lab_id_tahunajaran_foreign\\" foreign key (\\"id_tahunAjaran\\") references \\"tahun_ajaran\\" (\\"id_tahunAjaran\\") on delete cascade","time":"1.77","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_24_232722_create_jadwal_labs_table.php","line":14,"hash":"cc95b68c11d98cce2fd70f96b64170e8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
166	9f6f83d2-df03-476a-9c58-f7863d1e3c7f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_24_232722_create_jadwal_labs_table', 1)","time":"1.03","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
167	9f6f83d2-e12b-4ddd-807c-938af068ecf4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman\\" (\\"id_peminjaman\\" bigserial not null primary key, \\"tgl_peminjaman\\" date not null, \\"id\\" bigint not null, \\"status_peminjaman\\" varchar(255) check (\\"status_peminjaman\\" in ('pengajuan', 'dipinjam', 'ditolak', 'selesai', 'bermasalah')) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.96","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222412_create_peminjamen_table.php","line":14,"hash":"b8755778f75c112ba3466efc2df52613","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
168	9f6f83d2-e279-45e4-b022-2d4d461262c5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman\\" add constraint \\"peminjaman_id_foreign\\" foreign key (\\"id\\") references \\"users\\" (\\"id\\") on delete cascade","time":"2.70","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222412_create_peminjamen_table.php","line":14,"hash":"0040aa535bd32dbc48518ee767cbbbe6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
169	9f6f83d2-e405-4ae0-8fc4-3e071971286c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222412_create_peminjamen_table', 1)","time":"1.04","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
170	9f6f83d2-e4e0-420d-8e5e-91240776190c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_selesai\\" (\\"id_peminjaman\\" bigint not null, \\"tgl_pengembalian\\" date not null, \\"jam_dikembalikan\\" time(0) without time zone not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.09","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222419_create_peminjaman_selesais_table.php","line":14,"hash":"9a7bd13a3796936799b63d11c767192e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
171	9f6f83d2-e5b7-4af3-a4a1-5cccb5a6a12f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_selesai\\" add constraint \\"peminjaman_selesai_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.81","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222419_create_peminjaman_selesais_table.php","line":14,"hash":"ef59935bf3391ba5e82c5819f1860174","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
172	9f6f83d2-e6d9-433b-9fb7-aa1fe74bddcf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222419_create_peminjaman_selesais_table', 1)","time":"0.75","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
173	9f6f83d2-e7ee-4d6e-8d09-8031947decf8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_jadwal\\" (\\"id_peminjaman\\" bigint not null, \\"id_jadwalLab\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.66","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222433_create_peminjaman_jadwals_table.php","line":14,"hash":"0b9518f94067ba95ebc726430b99d0fe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
557	9f6f83d4-fa8d-4022-baf2-1d5e338d6ce9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\User:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
174	9f6f83d2-e8d2-4827-9fdf-e762d0a046af	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_jadwal\\" add constraint \\"peminjaman_jadwal_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.70","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222433_create_peminjaman_jadwals_table.php","line":14,"hash":"d0d02e6033566b04bcb0f9c4b0b3cb0e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
175	9f6f83d2-ea0a-40c5-9e84-731f9201cdbf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_jadwal\\" add constraint \\"peminjaman_jadwal_id_jadwallab_foreign\\" foreign key (\\"id_jadwalLab\\") references \\"jadwal_lab\\" (\\"id_jadwalLab\\") on delete cascade","time":"2.53","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222433_create_peminjaman_jadwals_table.php","line":14,"hash":"2ec53c8024c7735e4f46595c809f225d","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
176	9f6f83d2-eb34-4b53-8ec0-a3adb45aba27	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222433_create_peminjaman_jadwals_table', 1)","time":"0.68","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
177	9f6f83d2-ec3e-4ef6-913a-712e5ca77251	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_manual\\" (\\"id_peminjaman\\" bigint not null, \\"id_sesi_mulai\\" bigint not null, \\"id_sesi_selesai\\" bigint not null, \\"id_lab\\" bigint not null, \\"kegiatan\\" varchar(255) not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.44","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":14,"hash":"46150a7f4f16c81176b7b742352d4866","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
178	9f6f83d2-ecd7-44a8-976c-3570f85d3338	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_manual\\" add constraint \\"peminjaman_manual_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.20","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":14,"hash":"48c6d0eecf807e7a6ea782aa3067b9d1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
179	9f6f83d2-ed9d-4187-a4d1-6416d193bc56	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_manual\\" add constraint \\"peminjaman_manual_id_sesi_mulai_foreign\\" foreign key (\\"id_sesi_mulai\\") references \\"sesi_jam\\" (\\"id_sesi_jam\\") on delete cascade","time":"1.65","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":14,"hash":"a8372fdd33d8f99120daef6117ade0bf","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
180	9f6f83d2-ee3d-41a8-b6d9-06d42a62de0e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_manual\\" add constraint \\"peminjaman_manual_id_sesi_selesai_foreign\\" foreign key (\\"id_sesi_selesai\\") references \\"sesi_jam\\" (\\"id_sesi_jam\\") on delete cascade","time":"1.16","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":14,"hash":"df845f9a8eb8e10e25f1d4b0c8af4dd1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
181	9f6f83d2-eefe-4343-8f1f-4532291a4c09	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_manual\\" add constraint \\"peminjaman_manual_id_lab_foreign\\" foreign key (\\"id_lab\\") references \\"lab\\" (\\"id_lab\\") on delete cascade","time":"1.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222441_create_peminjaman_manuals_table.php","line":14,"hash":"2bf6bf40cb58936c4416ba7441b752bc","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
182	9f6f83d2-f086-4610-a122-4a15a6df6753	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222441_create_peminjaman_manuals_table', 1)","time":"0.89","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
183	9f6f83d2-f215-4539-ab4f-394cfe1bc798	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_ditolak\\" (\\"id_peminjaman\\" bigint not null, \\"alasan_ditolak\\" text not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"2.95","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222503_create_peminjaman_ditolaks_table.php","line":14,"hash":"72e1a27ffd2f86e486c4936473e76f79","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
184	9f6f83d2-f2b6-4258-9b9e-e2550c1482c7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_ditolak\\" add constraint \\"peminjaman_ditolak_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.16","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222503_create_peminjaman_ditolaks_table.php","line":14,"hash":"4c8f55adb8e252b8fbdb6b037a932863","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
185	9f6f83d2-f3d2-4f5f-8b7f-3e610a96261c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_04_30_222503_create_peminjaman_ditolaks_table', 1)","time":"0.56","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
186	9f6f83d2-f4da-48cb-9a12-b0798bce8aba	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_peralatan\\" (\\"id_peminjaman\\" bigint not null, \\"id_peralatan\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222529_create_peminjaman_peralatan_table.php","line":14,"hash":"43ddf79de02df514d0db939ebb0eed26","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
187	9f6f83d2-f5dc-4798-901a-7a5d17da6cc6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_peralatan\\" add constraint \\"peminjaman_peralatan_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.93","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222529_create_peminjaman_peralatan_table.php","line":14,"hash":"c3ffe83f44055d6beaa6ae8d540c4e92","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
188	9f6f83d2-f6f9-4d15-ba6d-65c48b5b5c7d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_peralatan\\" add constraint \\"peminjaman_peralatan_id_peralatan_foreign\\" foreign key (\\"id_peralatan\\") references \\"peralatan\\" (\\"id_peralatan\\") on delete cascade","time":"2.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_04_30_222529_create_peminjaman_peralatan_table.php","line":14,"hash":"06050560ea6c37e66cbac0b7382a5ecb","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
190	9f6f83d2-f9e6-461e-85c1-9a6d31548f00	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_bermasalah\\" (\\"id_peminjaman\\" bigint not null, \\"jam_dikembalikan\\" time(0) without time zone not null, \\"tgl_pengembalian\\" date not null, \\"alasan_bermasalah\\" text null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.23","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_12_064029_create_peminjaman_bermasalahs_table.php","line":14,"hash":"0cc1e7feb70b2d27d112e4d0ad4578b3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
191	9f6f83d2-fa8c-4cb5-a3cc-39de86b49de6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_bermasalah\\" add constraint \\"peminjaman_bermasalah_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.20","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_12_064029_create_peminjaman_bermasalahs_table.php","line":14,"hash":"372cb9cbc6bb9dc8922541720454648a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
192	9f6f83d2-fc19-4b99-878c-3140633704f4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_05_12_064029_create_peminjaman_bermasalahs_table', 1)","time":"0.92","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
193	9f6f83d3-0001-4163-bc0a-90369424d248	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"unit_peralatan\\" (\\"id_unit\\" bigserial not null primary key, \\"id_peralatan\\" bigint not null, \\"kode_unit\\" varchar(255) not null, \\"status_unit\\" varchar(255) check (\\"status_unit\\" in ('tersedia', 'dipinjam', 'rusak')) not null default 'tersedia', \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"8.29","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_064558_create_unit_peralatans_table.php","line":14,"hash":"fc3e5438e0b807bde4bd260eb489e1ef","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
194	9f6f83d3-00cc-40db-a540-b6968fe01241	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"unit_peralatan\\" add constraint \\"unit_peralatan_id_peralatan_foreign\\" foreign key (\\"id_peralatan\\") references \\"peralatan\\" (\\"id_peralatan\\") on delete cascade","time":"1.62","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_064558_create_unit_peralatans_table.php","line":14,"hash":"a510bef31a75f64b960294acfc4f0232","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
195	9f6f83d3-01c4-4b0b-bdaa-c2a6d8573303	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"unit_peralatan\\" add constraint \\"unit_peralatan_kode_unit_unique\\" unique (\\"kode_unit\\")","time":"2.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_064558_create_unit_peralatans_table.php","line":14,"hash":"30271e7cc177345801246e64b33dad45","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
196	9f6f83d3-039c-448b-8381-52d4f29e49f7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_05_19_064558_create_unit_peralatans_table', 1)","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
197	9f6f83d3-0498-4b02-b246-96b8baeef735	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"peminjaman_unit\\" (\\"id_peminjaman\\" bigint not null, \\"id_unit\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.47","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_075027_create_peminjaman_unit_table.php","line":14,"hash":"fc5a184287cedc758f3f695b24038bf0","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
198	9f6f83d3-0535-4554-9edb-61fd1e2ec9ee	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_unit\\" add constraint \\"peminjaman_unit_id_peminjaman_foreign\\" foreign key (\\"id_peminjaman\\") references \\"peminjaman\\" (\\"id_peminjaman\\") on delete cascade","time":"1.22","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_075027_create_peminjaman_unit_table.php","line":14,"hash":"4f855d6e34b96e624559b1e24b21c87a","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
199	9f6f83d3-0632-424f-99b0-6c3e3712031e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"peminjaman_unit\\" add constraint \\"peminjaman_unit_id_unit_foreign\\" foreign key (\\"id_unit\\") references \\"unit_peralatan\\" (\\"id_unit\\") on delete cascade","time":"2.21","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_05_19_075027_create_peminjaman_unit_table.php","line":14,"hash":"1bf11415d04a135e61e82b090ee2203e","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
200	9f6f83d3-0751-410d-a608-b2fff684c768	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_05_19_075027_create_peminjaman_unit_table', 1)","time":"0.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
201	9f6f83d3-07f4-4706-b22a-578d3748b7fb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add column \\"akses_ubah_kelas\\" boolean not null default '0'","time":"0.67","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_11_172055_add_akses_ubah_kelas_to_users_table.php","line":10,"hash":"24d425267e44f893c1c02c02b8d60334","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
202	9f6f83d3-0965-42b1-bb79-a82c2789dfb9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_11_172055_add_akses_ubah_kelas_to_users_table', 1)","time":"1.09","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
203	9f6f83d3-0a5c-4270-9e45-0d67711a4087	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add column \\"username\\" varchar(255) not null","time":"0.86","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_13_100307_add_username_to_users_table.php","line":11,"hash":"3401f80715f490f0318cd1f3daeee1c7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
204	9f6f83d3-0b70-426c-ae43-ea697fdde28c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"users\\" add constraint \\"users_username_unique\\" unique (\\"username\\")","time":"2.35","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_13_100307_add_username_to_users_table.php","line":11,"hash":"8e0f86c5a37ef7e9c968b5e88569e929","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
205	9f6f83d3-0ca5-44e2-b0f5-43d854499aff	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_13_100307_add_username_to_users_table', 1)","time":"0.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
206	9f6f83d3-0d66-4799-a384-00fb9efc5cda	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"prodi\\" add column \\"kode_prodi\\" varchar(255) not null","time":"0.84","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_074449_add_kode_prodi_to_prodi_table.php","line":11,"hash":"14b2981d2b6fd84b9df2399732fb880c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
207	9f6f83d3-0e5c-4ac2-9a13-972c5570af7c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"prodi\\" add constraint \\"prodi_kode_prodi_unique\\" unique (\\"kode_prodi\\")","time":"2.09","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_074449_add_kode_prodi_to_prodi_table.php","line":11,"hash":"cb76dacef9aaef60fab7281b4bfd6aa4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
208	9f6f83d3-1062-4e6c-aba1-4476e5bf08bf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_23_074449_add_kode_prodi_to_prodi_table', 1)","time":"1.59","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
209	9f6f83d3-1206-4d56-87d0-4d3f3d72b3be	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"matakuliah\\" add column \\"kode_mk\\" varchar(255) not null","time":"3.15","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_082532_add_kode_mk_to_matakuliah_table.php","line":10,"hash":"6207d5d4487d840acac8cb1228c2a9e6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
210	9f6f83d3-1349-47b5-a3ef-db1fa2855112	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"matakuliah\\" add constraint \\"matakuliah_kode_mk_unique\\" unique (\\"kode_mk\\")","time":"2.67","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_23_082532_add_kode_mk_to_matakuliah_table.php","line":10,"hash":"4a8c882f77bc7e5a208a00cdea5508e5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
211	9f6f83d3-147b-473a-a9b8-b8ad562763e5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_23_082532_add_kode_mk_to_matakuliah_table', 1)","time":"0.56","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
212	9f6f83d3-153a-4157-b082-546ac21c2d5c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"dosen\\" add column \\"nip\\" varchar(255) not null","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_075122_add_nip_to_dosen_table.php","line":10,"hash":"ceaf8045b5835b8f2fee152eff16c7be","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
213	9f6f83d3-16f7-4f00-9125-344d5bf94c64	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"dosen\\" add constraint \\"dosen_nip_unique\\" unique (\\"nip\\")","time":"3.90","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_075122_add_nip_to_dosen_table.php","line":10,"hash":"a4b86a04dd3203c332b620b026445e79","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
214	9f6f83d3-1824-4835-883d-21652f456f88	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_24_075122_add_nip_to_dosen_table', 1)","time":"0.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
215	9f6f83d3-18ba-480c-8ffc-c1ba1f297cfb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add column \\"waktu_mulai_nonaktif\\" timestamp(0) without time zone null","time":"0.60","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table.php","line":11,"hash":"b01fa12910941b021f0d04be7c809882","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
216	9f6f83d3-190d-46ae-907b-5ef0a246db81	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab\\" add column \\"waktu_akhir_nonaktif\\" timestamp(0) without time zone null","time":"0.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table.php","line":11,"hash":"493f39bbf55440b18a0c0d005f682b55","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
217	9f6f83d3-1a16-4e9f-a40c-90850fdba30a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_24_083853_add_waktu_nonaktif_to_jadwal_lab_table', 1)","time":"0.67","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
218	9f6f83d3-1af4-4db5-a2f1-3fe1d67707c9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"jadwal_lab_sesi_jam\\" (\\"id_jadwalLab\\" bigint not null, \\"id_sesi_jam\\" bigint not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"1.22","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_26_093501_create_jadwal_lab_sesi_jam_table.php","line":10,"hash":"fbe5ad9a769914252a82ebbab13fb397","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
219	9f6f83d3-1b92-4fbf-8875-017a82395b85	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab_sesi_jam\\" add constraint \\"jadwal_lab_sesi_jam_id_jadwallab_foreign\\" foreign key (\\"id_jadwalLab\\") references \\"jadwal_lab\\" (\\"id_jadwalLab\\") on delete cascade","time":"1.24","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_26_093501_create_jadwal_lab_sesi_jam_table.php","line":10,"hash":"739d1ee09fb928e0541dc81097d1f092","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
220	9f6f83d3-1c86-410f-a26a-42fa68089088	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"jadwal_lab_sesi_jam\\" add constraint \\"jadwal_lab_sesi_jam_id_sesi_jam_foreign\\" foreign key (\\"id_sesi_jam\\") references \\"sesi_jam\\" (\\"id_sesi_jam\\") on delete cascade","time":"1.73","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_06_26_093501_create_jadwal_lab_sesi_jam_table.php","line":10,"hash":"72a58da80f274fd3243c99c1c56923b5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
221	9f6f83d3-1e0c-41a5-9e1f-a90f48abe8ce	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_06_26_093501_create_jadwal_lab_sesi_jam_table', 1)","time":"0.97","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
222	9f6f83d3-1ff0-44f0-bc24-536233cde568	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"teams\\" (\\"id\\" bigserial not null primary key, \\"user_id\\" bigint not null, \\"name\\" varchar(255) not null, \\"personal_team\\" boolean not null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"3.74","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183931_create_teams_table.php","line":14,"hash":"366fe46d50d164bf8f02a12b09e37e72","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
223	9f6f83d3-2110-4a15-9285-2a88f25bcfc3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create index \\"teams_user_id_index\\" on \\"teams\\" (\\"user_id\\")","time":"2.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183931_create_teams_table.php","line":14,"hash":"c951590c13c6390a552b7d5d27e9f1b6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
224	9f6f83d3-2280-4815-8e1e-a6669d683e17	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_07_19_183931_create_teams_table', 1)","time":"1.14","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
225	9f6f83d3-24ef-4ed7-8895-34f3781c0db7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"team_user\\" (\\"id\\" bigserial not null primary key, \\"team_id\\" bigint not null, \\"user_id\\" bigint not null, \\"role\\" varchar(255) null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"4.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183932_create_team_user_table.php","line":14,"hash":"36e97596655cce04d748372875b76cf2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
226	9f6f83d3-2600-427a-8ea5-9fe716af930a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"team_user\\" add constraint \\"team_user_team_id_user_id_unique\\" unique (\\"team_id\\", \\"user_id\\")","time":"2.28","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183932_create_team_user_table.php","line":14,"hash":"d1d6b89e3842408c12a666be3b297db7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
227	9f6f83d3-274e-4555-b1ba-4d9dd09ed6fa	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_07_19_183932_create_team_user_table', 1)","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
228	9f6f83d3-2d05-49c2-9fe8-68f41598117e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"create table \\"team_invitations\\" (\\"id\\" bigserial not null primary key, \\"team_id\\" bigint not null, \\"email\\" varchar(255) not null, \\"role\\" varchar(255) null, \\"created_at\\" timestamp(0) without time zone null, \\"updated_at\\" timestamp(0) without time zone null)","time":"5.66","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183933_create_team_invitations_table.php","line":14,"hash":"2f0c418e0f311f55950dcb11717585c3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
229	9f6f83d3-2e30-4d2d-9d2d-9fccee5b1af1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"team_invitations\\" add constraint \\"team_invitations_team_id_foreign\\" foreign key (\\"team_id\\") references \\"teams\\" (\\"id\\") on delete cascade","time":"2.54","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183933_create_team_invitations_table.php","line":14,"hash":"0b1c8f7baca7ae3d748be0d0fd703ad6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
230	9f6f83d3-2f50-4953-8546-40157c8219fe	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"alter table \\"team_invitations\\" add constraint \\"team_invitations_team_id_email_unique\\" unique (\\"team_id\\", \\"email\\")","time":"2.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\migrations\\\\2025_07_19_183933_create_team_invitations_table.php","line":14,"hash":"6233072676845e74cbfd34979a93c104","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
231	9f6f83d3-310f-4c8b-8be8-ae6efcc3fc64	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"migrations\\" (\\"migration\\", \\"batch\\") values ('2025_07_19_183933_create_team_invitations_table', 1)","time":"0.89","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\artisan","line":13,"hash":"09c22f830d52d80cc99fe8c1b1acc44c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:38
232	9f6f83d4-3792-4704-b16e-a28acc74bd7d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"users\\" where (\\"email\\" = 'teknisi1@gmail.com') limit 1","time":"3.71","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"e5c82da95d9139d08a555c87495f99b7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
233	9f6f83d4-38fe-4639-a4c9-b6b4ef56ab33	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"users\\" (\\"email\\", \\"name\\", \\"username\\", \\"password\\", \\"role\\", \\"updated_at\\", \\"created_at\\") values ('teknisi1@gmail.com', 'Hida Jaya Habibi, A.Md', 'teknisi001', 'yNtX4NGjGG4F9NfX63FnBOcqdpOK2euwCquihPaLi0GubAU0C05nO', 'teknisi', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id\\"","time":"1.58","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"d948b009bdd177ca7f15ee9beab913fa","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
234	9f6f83d4-3942-4255-9f95-3193b7db094c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\User:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
235	9f6f83d4-3a4f-4c17-ab65-3195d25d2889	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"users\\" where (\\"email\\" = 'teknisi2@gmail.com') limit 1","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"e5c82da95d9139d08a555c87495f99b7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
236	9f6f83d4-3af4-42ca-b3f2-74216de6b66e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"users\\" (\\"email\\", \\"name\\", \\"username\\", \\"password\\", \\"role\\", \\"updated_at\\", \\"created_at\\") values ('teknisi2@gmail.com', 'Fendi Hermawanto, A.Md', 'teknisi002', 'y$IJqHdvHdEe5nuI4O81htGOTi6.GKCrnLskFtd8447MMtqHhbL0xY2', 'teknisi', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id\\"","time":"0.93","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"d948b009bdd177ca7f15ee9beab913fa","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
237	9f6f83d4-3b0d-45db-9656-3d16f34dbb71	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\User:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
238	9f6f83d4-3b6e-4748-9baf-4f4dd3b3b430	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"users\\" where (\\"email\\" = 'teknisi3@gmail.com') limit 1","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"e5c82da95d9139d08a555c87495f99b7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
239	9f6f83d4-3bf0-4dd4-8315-27be42da6057	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"users\\" (\\"email\\", \\"name\\", \\"username\\", \\"password\\", \\"role\\", \\"updated_at\\", \\"created_at\\") values ('teknisi3@gmail.com', 'Teknisi 3', 'teknisi003', 'y$c.O9wtyUYjB6cAPauyE3j.PubkpcUk7HqNrd8PPHSV5WLBZ2aekiO', 'teknisi', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id\\"","time":"0.84","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TeknisiSeeder.php","line":41,"hash":"d948b009bdd177ca7f15ee9beab913fa","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
240	9f6f83d4-3c07-4121-8828-f590743b7204	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\User:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
241	9f6f83d4-3dc6-4683-a5ca-f241d49dbc3f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"tahun_ajaran\\" (\\"tahun_ajaran\\", \\"semester\\", \\"status_tahunAjaran\\", \\"updated_at\\", \\"created_at\\") values ('2023\\/2024', 'ganjil', 'nonaktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_tahunAjaran\\"","time":"1.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TahunAjaranSeeder.php","line":19,"hash":"420ac3063636077fa2522638bff0f1b9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
242	9f6f83d4-3de8-43bb-98fd-59ce85524df8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\TahunAjaran:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
243	9f6f83d4-3e69-4ec1-9579-076756a0c917	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"tahun_ajaran\\" (\\"tahun_ajaran\\", \\"semester\\", \\"status_tahunAjaran\\", \\"updated_at\\", \\"created_at\\") values ('2023\\/2024', 'genap', 'nonaktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_tahunAjaran\\"","time":"0.85","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TahunAjaranSeeder.php","line":19,"hash":"420ac3063636077fa2522638bff0f1b9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
244	9f6f83d4-3e81-4048-8e9b-6a8e3661fa2b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\TahunAjaran:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
245	9f6f83d4-3efa-415a-9992-dee83592ffbb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"tahun_ajaran\\" (\\"tahun_ajaran\\", \\"semester\\", \\"status_tahunAjaran\\", \\"updated_at\\", \\"created_at\\") values ('2024\\/2025', 'ganjil', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_tahunAjaran\\"","time":"0.81","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\TahunAjaranSeeder.php","line":19,"hash":"420ac3063636077fa2522638bff0f1b9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
246	9f6f83d4-3f12-46d1-95be-fc1bff8f2858	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\TahunAjaran:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
247	9f6f83d4-4151-407c-8d7c-655b97f85239	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"peralatan\\" (\\"nama_peralatan\\", \\"updated_at\\", \\"created_at\\") values ('Proyektor', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_peralatan\\"","time":"2.23","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\PeralatanSeeder.php","line":22,"hash":"780161d97b88a03e41668ad300a1b016","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
248	9f6f83d4-41e4-4400-b036-39f85c64d24f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Peralatan:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
249	9f6f83d4-4289-40ef-af09-ba66f14e9575	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"peralatan\\" (\\"nama_peralatan\\", \\"updated_at\\", \\"created_at\\") values ('Remot AC', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_peralatan\\"","time":"0.88","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\PeralatanSeeder.php","line":22,"hash":"780161d97b88a03e41668ad300a1b016","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
250	9f6f83d4-42a7-4698-97e2-8adb87aa9714	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Peralatan:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
251	9f6f83d4-4324-4a9e-a176-2a82307e76b9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"peralatan\\" (\\"nama_peralatan\\", \\"updated_at\\", \\"created_at\\") values ('Kunci Lab', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_peralatan\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\PeralatanSeeder.php","line":22,"hash":"780161d97b88a03e41668ad300a1b016","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
252	9f6f83d4-433c-4827-9779-0a2aa719d3be	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Peralatan:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
253	9f6f83d4-4475-4ded-be52-e88601edd2db	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"peralatan\\" where (\\"nama_peralatan\\" = 'Proyektor') limit 1","time":"0.68","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":28,"hash":"b83b7a0ebf38a97f194371af18772e82","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
254	9f6f83d4-4496-4bfd-9d9b-77a58dbc8b36	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"retrieved","model":"App\\\\Models\\\\Peralatan","count":1,"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
255	9f6f83d4-455d-4791-8883-65852f626485	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"unit_peralatan\\" where (\\"kode_unit\\" = 'PJ201') limit 1","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"a0977947502e43fb83b2fed6a1deb5af","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
256	9f6f83d4-4628-412b-9552-e9285c74e0bb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"unit_peralatan\\" (\\"kode_unit\\", \\"id_peralatan\\", \\"status_unit\\", \\"updated_at\\", \\"created_at\\") values ('PJ201', 1, 'tersedia', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_unit\\"","time":"1.45","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"c95cc7da11ee89bbe12f66ad41120089","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
257	9f6f83d4-4647-474a-86bc-d2fb3f23c050	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\UnitPeralatan:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
258	9f6f83d4-46ad-4db6-b699-bb3217db75e0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"unit_peralatan\\" where (\\"kode_unit\\" = 'PJ202') limit 1","time":"0.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"a0977947502e43fb83b2fed6a1deb5af","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
259	9f6f83d4-474d-4b91-9a61-d14f18b8632b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"unit_peralatan\\" (\\"kode_unit\\", \\"id_peralatan\\", \\"status_unit\\", \\"updated_at\\", \\"created_at\\") values ('PJ202', 1, 'tersedia', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_unit\\"","time":"1.01","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"c95cc7da11ee89bbe12f66ad41120089","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
260	9f6f83d4-477f-43fd-8570-c646633575ce	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\UnitPeralatan:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
261	9f6f83d4-482c-4b54-aaa8-98b0c17702e3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"unit_peralatan\\" where (\\"kode_unit\\" = 'PJ203') limit 1","time":"0.76","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"a0977947502e43fb83b2fed6a1deb5af","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
262	9f6f83d4-490a-4eb8-8706-7dc1fc5fbba7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"unit_peralatan\\" (\\"kode_unit\\", \\"id_peralatan\\", \\"status_unit\\", \\"updated_at\\", \\"created_at\\") values ('PJ203', 1, 'tersedia', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_unit\\"","time":"1.09","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"c95cc7da11ee89bbe12f66ad41120089","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
264	9f6f83d4-4990-42e9-8668-b00394bd62aa	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"unit_peralatan\\" where (\\"kode_unit\\" = 'PJ204') limit 1","time":"0.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"a0977947502e43fb83b2fed6a1deb5af","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
265	9f6f83d4-4a18-46aa-8f4b-32cbfe8d6b3e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"unit_peralatan\\" (\\"kode_unit\\", \\"id_peralatan\\", \\"status_unit\\", \\"updated_at\\", \\"created_at\\") values ('PJ204', 1, 'tersedia', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_unit\\"","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"c95cc7da11ee89bbe12f66ad41120089","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
266	9f6f83d4-4a31-46e0-896e-7f65eb2fad54	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\UnitPeralatan:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
267	9f6f83d4-4a92-4533-96ee-fa626ae36bb4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"unit_peralatan\\" where (\\"kode_unit\\" = 'PJ205') limit 1","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"a0977947502e43fb83b2fed6a1deb5af","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
268	9f6f83d4-4b12-466d-843c-8f9ee126342c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"unit_peralatan\\" (\\"kode_unit\\", \\"id_peralatan\\", \\"status_unit\\", \\"updated_at\\", \\"created_at\\") values ('PJ205', 1, 'tersedia', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_unit\\"","time":"0.85","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\UnitPeralatanSeeder.php","line":34,"hash":"c95cc7da11ee89bbe12f66ad41120089","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
269	9f6f83d4-4b2a-4021-90a7-116530066c89	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\UnitPeralatan:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
270	9f6f83d4-4d55-4851-9b52-da8ff32d3b2e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"prodi\\" (\\"nama_prodi\\", \\"kode_prodi\\", \\"singkatan_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Teknologi Rekayasa Perangkat Lunak', '58302', 'TRPL', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_prodi\\"","time":"2.22","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\ProdiSeeder.php","line":34,"hash":"fea9c14855dd5f59f57f9fe94538787c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
271	9f6f83d4-4d78-4883-a5b6-1bfe0479acd2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Prodi:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
272	9f6f83d4-4eab-4d71-8891-329c4d72e7e9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"prodi\\" (\\"nama_prodi\\", \\"kode_prodi\\", \\"singkatan_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Teknologi Rekayasa Komputer dan jaringan', '56301', 'TRK', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_prodi\\"","time":"2.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\ProdiSeeder.php","line":34,"hash":"fea9c14855dd5f59f57f9fe94538787c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
273	9f6f83d4-4ef4-4e12-9e7e-139ca2ef1597	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Prodi:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
274	9f6f83d4-4fa6-4372-ac0f-782a1d6ce1e2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"prodi\\" (\\"nama_prodi\\", \\"kode_prodi\\", \\"singkatan_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Bisnis Digital', '61316', 'BSD', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_prodi\\"","time":"0.95","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\ProdiSeeder.php","line":34,"hash":"fea9c14855dd5f59f57f9fe94538787c","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
275	9f6f83d4-4fc3-49fb-9d16-8bf047e25f41	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Prodi:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
276	9f6f83d4-50f4-44e2-b920-80a1643834f8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\"","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":18,"hash":"cb976240e1b115aedcb34554e1159e86","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
277	9f6f83d4-5116-41d0-bb16-5959f269857c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"retrieved","model":"App\\\\Models\\\\Prodi","count":10,"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
278	9f6f83d4-5211-4136-89b2-945e0aab64b1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '1A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.50","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
279	9f6f83d4-5230-46af-803c-cda9791879a7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
280	9f6f83d4-52b6-48ae-a4f9-50e081aaf712	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '1B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
281	9f6f83d4-52cf-436d-adf6-bfeb802c884b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
282	9f6f83d4-534d-439a-abb6-aabdea50c261	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '1C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.86","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
283	9f6f83d4-5366-4e16-a0d7-8d5bc1cf13fb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
284	9f6f83d4-53e2-4402-bbad-ad754f5d3454	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '1D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.83","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
285	9f6f83d4-53fa-4e9a-90cf-da145d468942	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
286	9f6f83d4-5549-4f0b-80ab-fd8c7932a830	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '1E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"2.67","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
288	9f6f83d4-5652-4795-a02c-0852cd7cf3f7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '2A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.07","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
289	9f6f83d4-566e-450d-bfed-79a1d0344bf5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
290	9f6f83d4-56e9-4d6f-be5e-7c951bbb5317	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '2B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
291	9f6f83d4-5701-42dc-a974-5570f16e1346	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
292	9f6f83d4-5779-47ab-8f4d-298901fc6c98	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '2C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
293	9f6f83d4-5790-4396-a846-ed1db9fb98ee	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
294	9f6f83d4-5808-4f00-a25e-ea286faff5b8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '2D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
295	9f6f83d4-581f-4351-8a8d-ad7bda36f1e1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
296	9f6f83d4-5895-4479-a53a-1cc88ddb19d4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '2E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
297	9f6f83d4-58ac-4e8d-832c-da2fbe2ad64b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:10","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
298	9f6f83d4-5924-492e-9c27-465c9eb1f7eb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '3A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
299	9f6f83d4-593a-4397-99e0-cc6210165231	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:11","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
300	9f6f83d4-59b3-4b63-a1f3-a4e1ee9981f6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '3B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
301	9f6f83d4-59c9-4fc0-b934-d81192d52dee	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:12","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
302	9f6f83d4-5a3e-4c8a-88b5-0e64469f78f6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '3C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
303	9f6f83d4-5a58-4de0-a7b2-4a977a7ce0a7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:13","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
304	9f6f83d4-5ae0-4199-9370-91872bf4d101	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '3D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.85","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
305	9f6f83d4-5b75-4284-aa40-080f64db321a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:14","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
306	9f6f83d4-5c4d-40f1-9e02-82e823e63bfc	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '3E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.23","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
307	9f6f83d4-5c6e-4c72-b7de-72b28ba816d4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:15","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
308	9f6f83d4-5cf8-44d8-a6a9-dee22069cdf0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '4A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.91","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
309	9f6f83d4-5d11-48bc-abd5-ab0d7a78d0b6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:16","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
310	9f6f83d4-5d8c-4d7f-a193-ef783fb0cbef	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '4B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.81","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
311	9f6f83d4-5da3-4cf7-86fd-994e385a9e38	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:17","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
312	9f6f83d4-5e1e-4cd0-8acb-39c90f0944e3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '4C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.83","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
313	9f6f83d4-5e34-4063-9863-47144824a088	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:18","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
314	9f6f83d4-5eab-4551-85e1-734e46906afb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '4D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
315	9f6f83d4-5ec2-4363-afc2-a67f790b24fb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:19","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
316	9f6f83d4-5f39-4218-a7a4-401bdd7b62d0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (1, '4E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
317	9f6f83d4-5f4f-4b7c-8770-fecaf7d9690a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:20","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
318	9f6f83d4-5fc5-4233-9b5b-c44471391d29	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '1A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
319	9f6f83d4-5fdb-4b7c-81d0-7e081c6ab5be	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:21","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
320	9f6f83d4-6053-488e-acb4-2498599225c1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '1B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
321	9f6f83d4-6069-4d76-a3b0-534f5282e523	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:22","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
322	9f6f83d4-60df-4737-9115-098e83b06cda	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '1C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.78","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
323	9f6f83d4-60f5-401d-9734-200a9e9807eb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:23","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
324	9f6f83d4-61b6-41be-8ab6-c6d1eee97fb1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '1D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.01","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
325	9f6f83d4-6225-46c4-b2de-3bde5a753a83	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:24","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
326	9f6f83d4-62db-40e6-965d-7f06b1b2f386	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '1E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.02","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
327	9f6f83d4-62fb-42a6-8e60-2e13f8c7e0b1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:25","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
328	9f6f83d4-6378-4195-9416-96254d07f115	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '2A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
329	9f6f83d4-6390-4abe-b6a5-b5d32322913a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:26","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
330	9f6f83d4-6407-40f1-af5d-2226408f64b6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '2B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
331	9f6f83d4-641f-4ef6-adf4-942c10490907	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:27","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
332	9f6f83d4-649b-4ee5-9983-23d5e01692f5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '2C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.81","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
333	9f6f83d4-64b2-49f0-a90a-1aab7ae43541	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:28","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
334	9f6f83d4-652a-48d9-990c-629e6ebc45d0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '2D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
335	9f6f83d4-6541-4189-ae17-db5771596a03	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:29","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
336	9f6f83d4-65bc-4ab9-a25b-f94334c74247	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '2E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
337	9f6f83d4-65d3-4734-87db-a749ea9510aa	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:30","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
338	9f6f83d4-664c-4c46-8498-51e76add7e20	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '3A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
339	9f6f83d4-6663-44b4-aa4c-257b619cc666	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:31","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
340	9f6f83d4-66de-4630-8455-e5860324ccf6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '3B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.80","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
341	9f6f83d4-66f6-4daf-af47-c9bede76f826	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:32","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
342	9f6f83d4-6770-447e-b280-b4b65968d7dd	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '3C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.81","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
343	9f6f83d4-6787-43c5-b85f-5526e13e2f81	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:33","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
344	9f6f83d4-6894-48a8-beb8-7d7b9d8e6673	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '3D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.87","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
345	9f6f83d4-68ca-443e-a6e2-bfa3d4e8985b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:34","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
346	9f6f83d4-6954-499f-ba24-413f1e47602c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '3E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
347	9f6f83d4-696d-4cee-96bd-e2105349a438	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:35","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
348	9f6f83d4-69ce-45d3-a56e-9791a476a67a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '4A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
349	9f6f83d4-69e2-493d-96ec-0d7a8d2d0d4c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:36","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
350	9f6f83d4-6a3d-48b9-8761-fc4be17c13e5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '4B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.56","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
351	9f6f83d4-6a52-4919-991b-594a3f397af0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:37","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
352	9f6f83d4-6ab7-485f-bbba-aa44a7560c4d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '4C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.65","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
353	9f6f83d4-6acb-47ab-9e56-e2f53c49e343	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:38","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
354	9f6f83d4-6b22-49f8-91dd-e6f22bf0c207	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '4D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.52","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
355	9f6f83d4-6b34-4068-885c-2d3b286d5e28	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:39","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
356	9f6f83d4-6b8b-4a2a-9f3b-3aee7a67f783	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (2, '4E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.52","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
357	9f6f83d4-6b9c-41f0-b81e-0c714def9891	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:40","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
358	9f6f83d4-6bdf-46cc-a58d-a621b451bace	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '1A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.35","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
359	9f6f83d4-6bef-4965-a77e-1436118c485b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:41","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
360	9f6f83d4-6c31-410f-8de9-aceb13540c3e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '1B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
361	9f6f83d4-6c42-40a1-bb97-c3392d1298b6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:42","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
362	9f6f83d4-6c83-4c0b-a9cc-8d553b68bb07	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '1C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
363	9f6f83d4-6c94-4f17-8dc4-3a11c0472771	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:43","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
364	9f6f83d4-6cd2-4213-a1fe-feb1a0cc29a0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '1D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
365	9f6f83d4-6ce2-4c3f-94a7-272b81d2cf6b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:44","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
366	9f6f83d4-6d20-4ab6-b104-ef87bfee5938	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '1E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
367	9f6f83d4-6d31-43a3-b3bd-7b66ae683192	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:45","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
368	9f6f83d4-6d6f-45bd-89e7-8daee9c8a51e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '2A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
369	9f6f83d4-6d7f-4aef-a760-ef0d9ccf3572	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:46","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
370	9f6f83d4-6dbf-4a39-bf40-eab12bb30d12	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '2B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
371	9f6f83d4-6dd0-4096-a658-53ada19bcc5c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:47","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
372	9f6f83d4-6e0e-4694-b724-4c1e5a79b30a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '2C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.30","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
373	9f6f83d4-6e1d-476a-9630-7f8ced45cefb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:48","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
374	9f6f83d4-6ee8-4f94-96f6-26158fd3878b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '2D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"1.26","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
375	9f6f83d4-6f09-4ea0-adb4-2131f07ac3d7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:49","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
376	9f6f83d4-6f6b-43d1-8e1e-2ef85750e48d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '2E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.52","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
377	9f6f83d4-6f85-4fec-9991-72871169c9d4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:50","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
378	9f6f83d4-6fd8-47dc-ae8d-c5e492cd2a09	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '3A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.43","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
379	9f6f83d4-6fee-439d-a662-d0b08467c877	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:51","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
380	9f6f83d4-703c-4175-b03b-138930810e84	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '3B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
381	9f6f83d4-704e-4034-af81-5a0f72129753	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:52","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
382	9f6f83d4-70af-40ac-a2c1-479aca9b6364	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '3C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.54","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
383	9f6f83d4-70c4-40bb-a46a-e014f283e0b9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:53","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
384	9f6f83d4-7113-4a9f-a73e-9817387f63cf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '3D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.41","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
385	9f6f83d4-7125-4f6f-a4d9-4cbea71b2ef0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:54","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
386	9f6f83d4-7169-450a-aba7-fe67e02db1b1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '3E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
387	9f6f83d4-717b-4164-8630-96328cc544a3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:55","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
388	9f6f83d4-71bc-4cb8-bac4-c0e6831ec51c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '4A', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
389	9f6f83d4-71ce-4cdc-a9ab-ba7ae8b25b76	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:56","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
390	9f6f83d4-720f-49fc-845f-d7b40ae050de	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '4B', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
391	9f6f83d4-7221-4f04-8e6e-4071f8bccdd8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:57","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
392	9f6f83d4-7261-41eb-a3f3-2d4466e0e9bb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '4C', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
393	9f6f83d4-7273-4b6c-a222-dc6f4b55747c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:58","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
394	9f6f83d4-72b2-4335-98a8-20cee6e3a38e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '4D', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
395	9f6f83d4-72c4-4e9f-bcbe-da744212764d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:59","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
396	9f6f83d4-7305-49df-89f8-0257b3d266d7	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"kelas\\" (\\"id_prodi\\", \\"nama_kelas\\", \\"updated_at\\", \\"created_at\\") values (3, '4E', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_kelas\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\KelasSeeder.php","line":24,"hash":"1e86c2c942f864b98e40c3fda57d1f80","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
397	9f6f83d4-7315-4dd1-b2b3-908e97784705	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Kelas:60","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
398	9f6f83d4-743c-4c96-904d-d4830e2ab99e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Teknologi Rekayasa Perangkat Lunak' limit 1","time":"0.51","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":49,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
399	9f6f83d4-75f4-4aea-b825-ae2689395018	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pemrograman Web Dasar', 'TRPL101', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"2.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
400	9f6f83d4-7621-4771-a9af-38428fcbaf6d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
401	9f6f83d4-7699-4203-b499-13640832ca37	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Desain Pengalaman Pengguna', 'TRPL102', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.56","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
402	9f6f83d4-76b4-42e0-8b9b-8a7ea42425c6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
403	9f6f83d4-772f-4d50-94d9-4fe2d13c8c3a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Basis Data', 'TRPL103', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.62","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
404	9f6f83d4-775b-48c7-8cf4-699cd3cb98bb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
405	9f6f83d4-77e0-4abd-8351-805e29f0a142	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Algoritma & Struktur Data', 'TRPL104', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.82","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
406	9f6f83d4-77fb-4048-baed-a0c3a5591990	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
407	9f6f83d4-7864-4fa5-a331-fe0a4f83345c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Proyek Aplikasi Dasar', 'TRPL105', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.62","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
408	9f6f83d4-787b-47a1-99f1-0365c7db6689	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
409	9f6f83d4-78df-45ee-a406-ea9d805c2231	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Sistem Terdistribusi', 'TRPL106', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.61","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
410	9f6f83d4-78f5-4601-816f-e524c5b12e53	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
411	9f6f83d4-7944-4560-961d-c3cba8e0cfa9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Machine Learning', 'TRPL107', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.42","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
412	9f6f83d4-7956-4c68-8303-04b827ec9c72	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
413	9f6f83d4-799e-4c2d-b68d-e04a9bfdc963	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Struktur Data', 'TRPL108', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
414	9f6f83d4-79b1-4c0b-82f4-59dc36c42bce	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
415	9f6f83d4-79f6-44a1-a712-4487028ea2da	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Aljabar Vektor dan Matrik', 'TRPL109', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
416	9f6f83d4-7a08-4297-af49-07ea583a9f10	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
417	9f6f83d4-7a49-4f0b-8aca-439eb95eb8d5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Manajemen Proyek', 'TRPL110', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
418	9f6f83d4-7a5a-41ed-a6cc-558b36239409	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:10","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
419	9f6f83d4-7a9c-4b71-b1af-aa61594f7532	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pemrograman Berorientasi Objek', 'TRPL111', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
420	9f6f83d4-7aaf-4cda-93ef-19b5bc8a5239	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:11","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
421	9f6f83d4-7af6-4f5a-b3ef-cf2bb3a70493	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Analisis & desain Perangkat Lunak', 'TRPL112', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
422	9f6f83d4-7b06-45d1-81fe-ed48a424782d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:12","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
423	9f6f83d4-7b58-468e-a4ef-e1edf480a172	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Teknologi Rekayasa Komputer dan jaringan' limit 1","time":"0.48","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":49,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
424	9f6f83d4-7c17-477c-bcdb-1fa2f1bb67f1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Mikro Komputer', 'TRK201', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.94","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
425	9f6f83d4-7c52-4261-bcc8-c7eb53430e13	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:13","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
426	9f6f83d4-7cfc-4ea5-89d5-0ef73a5fc366	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Jaringan Komputer Dasar', 'TRK202', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.97","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
427	9f6f83d4-7d4b-458e-a207-3f1ed5d97651	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:14","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
428	9f6f83d4-7dc5-40b1-a893-200c0612ac66	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pengelolahan Sinyal & Citra Digital', 'TRK203', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.63","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
429	9f6f83d4-7ddb-4f62-84d3-2d10474d0451	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:15","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
430	9f6f83d4-7e2b-4366-bc3b-306b71009167	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Teknologi Nirkabel', 'TRK204', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.41","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
431	9f6f83d4-7e41-453d-bbf8-3758789f33de	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:16","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
432	9f6f83d4-7e8b-44d9-8464-c879b94cf6ac	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Rangkaian Elektronikal Digital', 'TRK205', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.38","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
433	9f6f83d4-7e9d-4a76-97f8-e4b8fa9bfb18	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:17","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
434	9f6f83d4-7ee3-457e-a254-b93e46db927d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pemrograman Perangkat Bergerak', 'TRK206', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
435	9f6f83d4-7ef4-46b0-8f73-112ec79b6624	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:18","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
436	9f6f83d4-7f39-4007-9179-dbdbafbfa1bd	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Basis Data', 'TRK207', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
437	9f6f83d4-7f4a-480c-9624-2c0ecd3cee81	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:19","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
438	9f6f83d4-7f8d-48da-9f4a-da827ce0bcf6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Keamanan, Kesehatan, dan Keselamatan Kerja', 'TRK208', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
439	9f6f83d4-7f9c-4fd7-bd03-7f1a198e78eb	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:20","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
440	9f6f83d4-7fd2-441a-ba52-fc54260f19f0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Bisnis Digital' limit 1","time":"0.27","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":49,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
441	9f6f83d4-801d-45f0-8343-a9684757ce64	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Basis Data', 'BD301', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
442	9f6f83d4-8031-4ff6-84aa-0f829d4c1a8b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:21","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
443	9f6f83d4-8074-4a64-a2e9-79b9df44656b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Studi Kelayakan', 'BD302', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
444	9f6f83d4-8084-490c-970a-95e5e7276ea9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:22","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
445	9f6f83d4-80c4-4976-b56e-a32f21787e7a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Desain & Analisis Sistem Informasi', 'BD303', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
446	9f6f83d4-80d5-43f0-9f40-2cc883eeddc2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:23","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
447	9f6f83d4-8115-424b-82c9-61a3266e3f92	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pemrograman Web Dasar', 'BD304', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
448	9f6f83d4-8126-4a94-b0dc-326bdc932052	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:24","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
449	9f6f83d4-8168-4059-9ee0-b96c6d74c272	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Analisis Data Bisnis', 'BD305', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
450	9f6f83d4-8178-4df3-8e43-013ec8fdc6ae	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:25","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
451	9f6f83d4-81d1-4313-b55d-1a044252e479	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"matakuliah\\" (\\"nama_mk\\", \\"kode_mk\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Praktikum Pemrograman Web Dasar', 'BD306', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_mk\\"","time":"0.46","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MatakuliahSeeder.php","line":53,"hash":"3472e65609853203bce3820d63d0e6f6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
452	9f6f83d4-81f4-414e-9585-6340312cd7f9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Matakuliah:26","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
453	9f6f83d4-83de-4187-bf97-3b7f4b651b3d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Teknologi Rekayasa Perangkat Lunak' limit 1","time":"0.50","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":53,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
454	9f6f83d4-8509-4b68-aac3-f328971c20c8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Mohamad Dimyati Ayatullah, S.T., M.Kom.', '197601222021211001', '08123399184', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"1.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
455	9f6f83d4-852a-4167-b3cb-f026af410589	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
456	9f6f83d4-8590-415f-905b-f3480db72fa3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Dianni Yusuf, S.Kom., M.Kom.', '198403052021212004', '082328333399', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.58","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
457	9f6f83d4-85a6-4cf8-a79a-0289c96fc400	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
458	9f6f83d4-85fb-4f8d-97ac-4f630f9f0a47	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Eka Mistiko Rini, S.Kom, M.Kom.', '198310202014042001', '081913922224', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.44","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
459	9f6f83d4-8610-403d-94ce-46de768f8ea3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
460	9f6f83d4-8660-4a8b-a5ba-2873e857a424	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Farizqi Panduardi, S.ST., M.T.', '198603052024211014', '082244680800', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.41","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
461	9f6f83d4-8674-43e0-aac2-bcaa89b0cad8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
462	9f6f83d4-86c0-442b-8fa5-8dfcc0d735d4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Devit Suwardiyanto,S.Si., M.T.', '198311052015041001', '08113570683', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
463	9f6f83d4-86d1-4959-9671-25e4b98e5d60	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
464	9f6f83d4-871a-4dce-9d15-269c650f8d88	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Lutfi Hakim, S.Pd., M.T.', '199203302019031012', '085330161514', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.38","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
465	9f6f83d4-872c-4773-af44-704917056207	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
466	9f6f83d4-8770-42db-9217-5b3f0d5b3aab	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Sepyan Purnama Kristanto, S.Kom., M.Kom.', '199009052019031024', '+6285237516017', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
467	9f6f83d4-8781-40a8-ba8d-13f065be1755	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
468	9f6f83d4-87c4-4fb8-9369-d8511fec4ff5	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Ruth Ema Febrita, S.Pd., M.Kom.', '199202272020122019', '085259082627', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
469	9f6f83d4-87d4-4a87-94c4-25aabaac1cae	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
470	9f6f83d4-8817-4b86-94f0-351947225b60	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Lukman Hakim S.Kom., M.T', '198903232022031007', '081232947805', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
471	9f6f83d4-8828-47e8-b9a8-3f4c21056d42	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
472	9f6f83d4-88f9-48af-968f-4ecc176f31ea	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Khoirul Umam, S.Pd, M.Kom', '199103112022031006', '087755580796', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"1.10","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
473	9f6f83d4-8930-42a6-8639-70d1a74558de	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:10","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
474	9f6f83d4-89c7-4727-bd83-2f63f49e0722	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Arif Fahmi, S.T., M.T.', '199503032024061001', '081217945658', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.68","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
475	9f6f83d4-89e1-4e24-b619-5de134e33705	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:11","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
476	9f6f83d4-8a39-4353-abbc-1e3a45d0495f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Eka Novita Sari, S. Kom., M.Kom.', '199312032024062002', '+6285736907069', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.46","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
477	9f6f83d4-8a4d-4096-a614-dd90e80488c1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:12","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
478	9f6f83d4-8a99-487c-a0fd-be286875da68	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Furiansyah Dipraja, S.T., M.Kom.', '199408122024061002', '+6282129916997', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.40","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
479	9f6f83d4-8aaa-4d31-9ac0-6677e1c33b63	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:13","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
480	9f6f83d4-8af7-46ab-a1c9-45ffecb3db0b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Indra Kurniawan, S.T., M.Eng.', '199607142024061001', '+6285293810942', 1, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
481	9f6f83d4-8b09-42c1-b7b3-d7eabb962927	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:14","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
482	9f6f83d4-8b40-4b99-ae68-1d100242f380	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Teknologi Rekayasa Komputer dan jaringan' limit 1","time":"0.27","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":53,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
483	9f6f83d4-8b8d-480d-b2f3-39962c977811	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Herman Yuliandoko, S.T., M.T.', '197509272021211002', '081334436478', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.37","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
484	9f6f83d4-8b9f-4883-83a8-eb1edde5b57d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:15","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
485	9f6f83d4-8be3-49f2-944b-4889aaa6a941	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Vivien Arief Wardhany, S.T., M.T.', '198404032019032012', '081331068658', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
486	9f6f83d4-8bf6-450e-a5fe-61ad43491d79	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:16","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
487	9f6f83d4-8c3a-4c3f-a997-60afd3444f1b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Endi Sailul Haq, S.T., M.Kom.', '198403112019031005', '081336851513', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
488	9f6f83d4-8c4c-4b72-be98-8e02b2c79113	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:17","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
489	9f6f83d4-8c96-4c4e-a33a-21a7d4503e40	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Subono, S.T., M.T.', '197506252021211003', '087859576210', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
490	9f6f83d4-8ca7-4b3d-8209-4762dec4a52f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:18","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
491	9f6f83d4-8cea-4ad5-b1d5-4ac0f238aaf6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Alfin Hidayat, S.T., M.T.', '199010052014041002', '085731147608', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
492	9f6f83d4-8cfb-4456-878c-071a9f88e67d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:19","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
493	9f6f83d4-8d3f-4c00-9efc-6a2b8b98426c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Junaedi Adi Prasetyo, S.ST., M.Sc.', '199004192018031001', '082333312244', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.33","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
494	9f6f83d4-8d4e-4c23-a71e-0d152b4f9001	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:20","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
495	9f6f83d4-8d8e-4f54-81cd-db645521774e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Galih Hendra Wibowo, S.Tr.Kom., M.T.', '199209052022031004', '083831120642', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
496	9f6f83d4-8d9e-46c4-acd6-940713631e38	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:21","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
497	9f6f83d4-8ddd-4bc6-900d-fca479f4c9ba	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Agus Priyo Utomo, S.ST., M.Tr.Kom.', '198708272024211012', '085 731 311 399', 2, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
498	9f6f83d4-8dee-4fcb-ba1c-c2fd4e435b78	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:22","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
499	9f6f83d4-8e22-4c10-b7a5-fea8726182fc	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" where \\"nama_prodi\\" = 'Bisnis Digital' limit 1","time":"0.25","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":53,"hash":"0faace6f2c8d789315f326b6f44d2148","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
500	9f6f83d4-8e71-4d24-9c08-f01043e55274	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('I Wayan Suardinata, S.Kom., M.T.', '198010222015041001', '085736577864', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.37","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
501	9f6f83d4-8e82-42c1-85be-16e93449a3d1	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:23","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
502	9f6f83d4-8eed-49fb-9e0c-b681f77e931e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Moh. Nur Shodiq, S.T., M.T.', '198301192021211006', '085236675444', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.59","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
503	9f6f83d4-8f16-473d-896a-d813db1347cd	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:24","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
504	9f6f83d4-8fc1-4064-ae01-58b895e7541d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Dedy Hidayat Kusuma, S.T., M.Cs.', '197704042021211004', '087755527517', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.87","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
505	9f6f83d4-8ff8-4dfe-9890-d7354eaf4b30	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:25","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
506	9f6f83d4-90a0-491f-ab34-7af686d38408	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Muh. Fuad Al Haris, S.T., M.T.', '197806132014041001', '081234619898', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.79","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
507	9f6f83d4-90bb-4169-9567-5adc78711d51	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:26","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
508	9f6f83d4-9113-4507-bde9-5b54f4da55a9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Arum Andary Ratri, S.Si., M.Si.', '199209212020122021', '083117703473', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.46","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
509	9f6f83d4-9127-4366-8eda-3c62153e8f4b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:27","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
510	9f6f83d4-9173-4528-8c8b-df83421ff2cf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Indira Nuansa Ratri, S.M., M.SM.', '199607032024062001', '083831244299', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.39","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
511	9f6f83d4-9188-4384-8ce5-fe125364755a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:28","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
512	9f6f83d4-91d0-40d5-936f-012d5f062c66	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Mega Devita Sari, M. A', '199708052025062007', '082397148738', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.35","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
513	9f6f83d4-91e1-4f18-912f-4249cc41c039	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:29","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
514	9f6f83d4-9227-44d7-b9f8-c21ce728e765	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"dosen\\" (\\"nama_dosen\\", \\"nip\\", \\"telepon\\", \\"id_prodi\\", \\"updated_at\\", \\"created_at\\") values ('Septa Lukman Andes, S.AB., M.AB.', '199409212025061002', '087789027297', 3, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_dosen\\"","time":"0.34","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\DosenSeeder.php","line":57,"hash":"f6655ae39db3c10db4fa766c62120c9f","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
515	9f6f83d4-9238-4262-aedd-eb3a5fe26838	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Dosen:30","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
516	9f6f83d4-93be-4aac-8b10-d00d92919b4a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Pemrograman 1', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"1.13","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
517	9f6f83d4-93df-45ff-b90c-aac4a28ffc78	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
518	9f6f83d4-9436-4c6f-99db-aaa822ea85e3	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Pemrograman 2', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.45","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
519	9f6f83d4-9449-418e-8a52-32326398df5e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
520	9f6f83d4-9491-41a1-bc68-10b927372cc0	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Basis Data', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.36","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
521	9f6f83d4-94a2-410e-a60f-d59fe1be1694	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
522	9f6f83d4-94e3-4b77-9dfc-cd546e2eb185	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Hardware', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
523	9f6f83d4-94f7-4fa8-b58d-119c7821b902	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
524	9f6f83d4-9553-46b8-a8f8-6c3bfef9c00e	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Multimedia', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.32","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
525	9f6f83d4-9579-4ddb-a0de-6505d58aa584	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
526	9f6f83d4-962b-4ae6-80f8-09ebfa71521b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Coworking', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"1.00","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
527	9f6f83d4-965e-4532-b2c9-ea75d86b8ea8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
528	9f6f83d4-96ec-4ec1-a2e0-c8c3a533a5ab	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('Design', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.64","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
529	9f6f83d4-9708-4137-a9ef-224ab4023f81	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
530	9f6f83d4-9768-4a55-af5d-cd7e1b501552	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"lab\\" (\\"nama_lab\\", \\"status_lab\\", \\"updated_at\\", \\"created_at\\") values ('TUK', 'aktif', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_lab\\"","time":"0.53","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\LabSeeder.php","line":48,"hash":"7ef2aa71270ad64d18b67ee9de3fd751","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
531	9f6f83d4-9782-4ad9-b6de-3808b2eea9a2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Lab:8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
532	9f6f83d4-98fe-49dd-9d51-e45e35c92003	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"hari\\" (\\"nama_hari\\") values ('Senin'), ('Selasa'), ('Rabu'), ('Kamis'), ('Jumat'), ('Sabtu'), ('Minggu')","time":"1.27","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\HariSeeder.php","line":14,"hash":"8245a15816650d435c2c5aec5be017e1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
533	9f6f83d4-9a93-40e4-9d07-e4c2172a64cf	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 1', '07:30', '08:20', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"1.12","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
534	9f6f83d4-9ab4-4587-9414-d915e5c76e5f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:1","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
535	9f6f83d4-9b0c-4eb2-ae28-79dd48f2ba86	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 2', '08:20', '09:10', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.45","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
536	9f6f83d4-9b1f-4630-a25a-de04913f773b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:2","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
537	9f6f83d4-9b68-4989-a96c-006dd3bbf8ac	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 3', '09:10', '10:00', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.37","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
538	9f6f83d4-9b7a-4408-8ef2-976393a5f441	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:3","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
539	9f6f83d4-9bc0-4ef7-bcc2-b2cccc1bb10d	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 4', '10:00', '10:50', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.31","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
540	9f6f83d4-9bee-49cd-a707-ba16279d60f9	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
541	9f6f83d4-9c8d-46a2-8c24-f7133d42faec	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 5', '10:50', '11:40', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.92","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
542	9f6f83d4-9cc5-4c3c-a8c2-9582367d07cc	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
543	9f6f83d4-9db3-4d3a-b10a-a3c88714b2b4	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 6', '12:30', '13:20', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"1.55","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
544	9f6f83d4-9dd4-472a-9e2e-1b0e56a6edc8	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:6","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
545	9f6f83d4-9e40-44ea-a2a8-576e5f2bba6c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 7', '13:20', '14:10', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.67","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
546	9f6f83d4-9e56-43b9-8f62-acff6e04ad85	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:7","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
547	9f6f83d4-9eb3-43de-b109-f4efd3834e5f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 8', '14:10', '15:00', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.54","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
548	9f6f83d4-9ec8-487e-a2ae-4bcaec4cbab2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:8","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
549	9f6f83d4-9f23-4a3d-a724-f317ee0f6f96	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 9', '15:00', '15:50', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.52","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
550	9f6f83d4-9f35-4ac5-b527-22467f4ffa5b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:9","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
551	9f6f83d4-9f8c-4b5f-8972-ef0795ded59b	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"sesi_jam\\" (\\"nama_sesi\\", \\"jam_mulai\\", \\"jam_selesai\\", \\"updated_at\\", \\"created_at\\") values ('Jam Ke 10', '15:50', '16:20', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id_sesi_jam\\"","time":"0.51","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\SesiJamSeeder.php","line":26,"hash":"f8559d4d1f005f276f0ac4b3656adabe","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
552	9f6f83d4-9f9f-4c8d-ad42-69ad0d27a35c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\SesiJam:10","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
553	9f6f83d4-a0e2-412c-99bc-7be78ecf7f7c	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"prodi\\" limit 1","time":"0.57","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MahasiswaSeeder.php","line":17,"hash":"56d84eb907d853b9e383d7443b129a57","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
554	9f6f83d4-a138-422d-88e8-6e150eaac14f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"select * from \\"kelas\\" where \\"id_prodi\\" = 1 limit 1","time":"0.38","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MahasiswaSeeder.php","line":18,"hash":"6f4b7be6ed3bebcf81b8d74adb32b1de","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
555	9f6f83d4-a150-4328-a8f3-1b2fad468016	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"retrieved","model":"App\\\\Models\\\\Kelas","count":1,"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
556	9f6f83d4-fa6a-470e-a6cf-c3e031f27cf6	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"users\\" (\\"name\\", \\"username\\", \\"email\\", \\"password\\", \\"role\\", \\"updated_at\\", \\"created_at\\") values ('MahasiswaTesting Teknologi Rekayasa Perangkat Lunak 1A', '369731321654', 'mhs_trpl-1a_znnWm@example.com', 'y$vTNNJnQ4GGZp3jxwMGiJjOi4zHKkzrafmEfjMVcT8HCv4AsRNkiHq', 'mahasiswa', '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id\\"","time":"2.66","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MahasiswaSeeder.php","line":30,"hash":"8d1d1c343291bf12c16408dbc9467019","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
558	9f6f83d4-fbea-4a10-91f1-69d123589de2	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	query	{"connection":"pgsql","bindings":[],"sql":"insert into \\"mahasiswa\\" (\\"id\\", \\"id_prodi\\", \\"id_kelas\\", \\"nim\\", \\"telepon\\", \\"foto_ktm\\", \\"updated_at\\", \\"created_at\\") values (4, 1, 1, '369731321654', '081267658982', null, '2025-07-20 19:03:39', '2025-07-20 19:03:39') returning \\"id\\"","time":"2.42","slow":false,"file":"D:\\\\Tugas Akhir\\\\Projek SIJALAB\\\\sijalab\\\\database\\\\seeders\\\\MahasiswaSeeder.php","line":39,"hash":"16a193b89b0100e41697e466551ea5c5","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
559	9f6f83d4-fc0d-4399-92de-91a2ac95122f	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	model	{"action":"created","model":"App\\\\Models\\\\Mahasiswa:4","hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
560	9f6f83d4-fcf5-42fc-b10a-cb82068fef6a	9f6f83d4-fdd6-46d8-98e9-ff3f3dd13173	\N	t	command	{"command":"migrate:refresh","exit_code":0,"arguments":{"command":"migrate:refresh"},"options":{"database":null,"force":false,"path":[],"realpath":false,"seed":true,"seeder":null,"step":null,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:03:39
561	9f6f8410-b52a-483b-bbdb-4d8d7f01ef16	9f6f8410-bb0e-4020-ab4b-972a06d4fb98	\N	t	command	{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:04:18
562	9f6f8410-b52a-4d0f-8712-5ed2aa9fb6e9	9f6f8410-c03d-43a1-a18e-5737456267ee	\N	t	command	{"command":"list","exit_code":0,"arguments":{"command":"list","namespace":null},"options":{"raw":false,"format":"txt","short":false,"help":false,"silent":false,"quiet":false,"verbose":false,"version":false,"ansi":null,"no-interaction":false,"env":null},"hostname":"LAPTOP-M6SAUDTU"}	2025-07-20 19:04:18
\.


--
-- TOC entry 5175 (class 0 OID 117560)
-- Dependencies: 232
-- Data for Name: telescope_entries_tags; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.telescope_entries_tags (entry_uuid, tag) FROM stdin;
9f6f83d4-3942-4255-9f95-3193b7db094c	App\\Models\\User:1
9f6f83d4-3b0d-45db-9656-3d16f34dbb71	App\\Models\\User:2
9f6f83d4-3c07-4121-8828-f590743b7204	App\\Models\\User:3
9f6f83d4-3de8-43bb-98fd-59ce85524df8	App\\Models\\TahunAjaran:1
9f6f83d4-3e81-4048-8e9b-6a8e3661fa2b	App\\Models\\TahunAjaran:2
9f6f83d4-3f12-46d1-95be-fc1bff8f2858	App\\Models\\TahunAjaran:3
9f6f83d4-41e4-4400-b036-39f85c64d24f	App\\Models\\Peralatan:1
9f6f83d4-42a7-4698-97e2-8adb87aa9714	App\\Models\\Peralatan:2
9f6f83d4-433c-4827-9779-0a2aa719d3be	App\\Models\\Peralatan:3
9f6f83d4-4496-4bfd-9d9b-77a58dbc8b36	App\\Models\\Peralatan
9f6f83d4-4647-474a-86bc-d2fb3f23c050	App\\Models\\UnitPeralatan:1
9f6f83d4-477f-43fd-8570-c646633575ce	App\\Models\\UnitPeralatan:2
9f6f83d4-492b-4b95-b7a8-600cb55e09e5	App\\Models\\UnitPeralatan:3
9f6f83d4-4a31-46e0-896e-7f65eb2fad54	App\\Models\\UnitPeralatan:4
9f6f83d4-4b2a-4021-90a7-116530066c89	App\\Models\\UnitPeralatan:5
9f6f83d4-4d78-4883-a5b6-1bfe0479acd2	App\\Models\\Prodi:1
9f6f83d4-4ef4-4e12-9e7e-139ca2ef1597	App\\Models\\Prodi:2
9f6f83d4-4fc3-49fb-9d16-8bf047e25f41	App\\Models\\Prodi:3
9f6f83d4-5116-41d0-bb16-5959f269857c	App\\Models\\Prodi
9f6f83d4-5230-46af-803c-cda9791879a7	App\\Models\\Kelas:1
9f6f83d4-52cf-436d-adf6-bfeb802c884b	App\\Models\\Kelas:2
9f6f83d4-5366-4e16-a0d7-8d5bc1cf13fb	App\\Models\\Kelas:3
9f6f83d4-53fa-4e9a-90cf-da145d468942	App\\Models\\Kelas:4
9f6f83d4-55a8-4b36-8c65-73a9d275aea7	App\\Models\\Kelas:5
9f6f83d4-566e-450d-bfed-79a1d0344bf5	App\\Models\\Kelas:6
9f6f83d4-5701-42dc-a974-5570f16e1346	App\\Models\\Kelas:7
9f6f83d4-5790-4396-a846-ed1db9fb98ee	App\\Models\\Kelas:8
9f6f83d4-581f-4351-8a8d-ad7bda36f1e1	App\\Models\\Kelas:9
9f6f83d4-58ac-4e8d-832c-da2fbe2ad64b	App\\Models\\Kelas:10
9f6f83d4-593a-4397-99e0-cc6210165231	App\\Models\\Kelas:11
9f6f83d4-59c9-4fc0-b934-d81192d52dee	App\\Models\\Kelas:12
9f6f83d4-5a58-4de0-a7b2-4a977a7ce0a7	App\\Models\\Kelas:13
9f6f83d4-5b75-4284-aa40-080f64db321a	App\\Models\\Kelas:14
9f6f83d4-5c6e-4c72-b7de-72b28ba816d4	App\\Models\\Kelas:15
9f6f83d4-5d11-48bc-abd5-ab0d7a78d0b6	App\\Models\\Kelas:16
9f6f83d4-5da3-4cf7-86fd-994e385a9e38	App\\Models\\Kelas:17
9f6f83d4-5e34-4063-9863-47144824a088	App\\Models\\Kelas:18
9f6f83d4-5ec2-4363-afc2-a67f790b24fb	App\\Models\\Kelas:19
9f6f83d4-5f4f-4b7c-8770-fecaf7d9690a	App\\Models\\Kelas:20
9f6f83d4-5fdb-4b7c-81d0-7e081c6ab5be	App\\Models\\Kelas:21
9f6f83d4-6069-4d76-a3b0-534f5282e523	App\\Models\\Kelas:22
9f6f83d4-60f5-401d-9734-200a9e9807eb	App\\Models\\Kelas:23
9f6f83d4-6225-46c4-b2de-3bde5a753a83	App\\Models\\Kelas:24
9f6f83d4-62fb-42a6-8e60-2e13f8c7e0b1	App\\Models\\Kelas:25
9f6f83d4-6390-4abe-b6a5-b5d32322913a	App\\Models\\Kelas:26
9f6f83d4-641f-4ef6-adf4-942c10490907	App\\Models\\Kelas:27
9f6f83d4-64b2-49f0-a90a-1aab7ae43541	App\\Models\\Kelas:28
9f6f83d4-6541-4189-ae17-db5771596a03	App\\Models\\Kelas:29
9f6f83d4-65d3-4734-87db-a749ea9510aa	App\\Models\\Kelas:30
9f6f83d4-6663-44b4-aa4c-257b619cc666	App\\Models\\Kelas:31
9f6f83d4-66f6-4daf-af47-c9bede76f826	App\\Models\\Kelas:32
9f6f83d4-6787-43c5-b85f-5526e13e2f81	App\\Models\\Kelas:33
9f6f83d4-68ca-443e-a6e2-bfa3d4e8985b	App\\Models\\Kelas:34
9f6f83d4-696d-4cee-96bd-e2105349a438	App\\Models\\Kelas:35
9f6f83d4-69e2-493d-96ec-0d7a8d2d0d4c	App\\Models\\Kelas:36
9f6f83d4-6a52-4919-991b-594a3f397af0	App\\Models\\Kelas:37
9f6f83d4-6acb-47ab-9e56-e2f53c49e343	App\\Models\\Kelas:38
9f6f83d4-6b34-4068-885c-2d3b286d5e28	App\\Models\\Kelas:39
9f6f83d4-6b9c-41f0-b81e-0c714def9891	App\\Models\\Kelas:40
9f6f83d4-6bef-4965-a77e-1436118c485b	App\\Models\\Kelas:41
9f6f83d4-6c42-40a1-bb97-c3392d1298b6	App\\Models\\Kelas:42
9f6f83d4-6c94-4f17-8dc4-3a11c0472771	App\\Models\\Kelas:43
9f6f83d4-6ce2-4c3f-94a7-272b81d2cf6b	App\\Models\\Kelas:44
9f6f83d4-6d31-43a3-b3bd-7b66ae683192	App\\Models\\Kelas:45
9f6f83d4-6d7f-4aef-a760-ef0d9ccf3572	App\\Models\\Kelas:46
9f6f83d4-6dd0-4096-a658-53ada19bcc5c	App\\Models\\Kelas:47
9f6f83d4-6e1d-476a-9630-7f8ced45cefb	App\\Models\\Kelas:48
9f6f83d4-6f09-4ea0-adb4-2131f07ac3d7	App\\Models\\Kelas:49
9f6f83d4-6f85-4fec-9991-72871169c9d4	App\\Models\\Kelas:50
9f6f83d4-6fee-439d-a662-d0b08467c877	App\\Models\\Kelas:51
9f6f83d4-704e-4034-af81-5a0f72129753	App\\Models\\Kelas:52
9f6f83d4-70c4-40bb-a46a-e014f283e0b9	App\\Models\\Kelas:53
9f6f83d4-7125-4f6f-a4d9-4cbea71b2ef0	App\\Models\\Kelas:54
9f6f83d4-717b-4164-8630-96328cc544a3	App\\Models\\Kelas:55
9f6f83d4-71ce-4cdc-a9ab-ba7ae8b25b76	App\\Models\\Kelas:56
9f6f83d4-7221-4f04-8e6e-4071f8bccdd8	App\\Models\\Kelas:57
9f6f83d4-7273-4b6c-a222-dc6f4b55747c	App\\Models\\Kelas:58
9f6f83d4-72c4-4e9f-bcbe-da744212764d	App\\Models\\Kelas:59
9f6f83d4-7315-4dd1-b2b3-908e97784705	App\\Models\\Kelas:60
9f6f83d4-7621-4771-a9af-38428fcbaf6d	App\\Models\\Matakuliah:1
9f6f83d4-76b4-42e0-8b9b-8a7ea42425c6	App\\Models\\Matakuliah:2
9f6f83d4-775b-48c7-8cf4-699cd3cb98bb	App\\Models\\Matakuliah:3
9f6f83d4-77fb-4048-baed-a0c3a5591990	App\\Models\\Matakuliah:4
9f6f83d4-787b-47a1-99f1-0365c7db6689	App\\Models\\Matakuliah:5
9f6f83d4-78f5-4601-816f-e524c5b12e53	App\\Models\\Matakuliah:6
9f6f83d4-7956-4c68-8303-04b827ec9c72	App\\Models\\Matakuliah:7
9f6f83d4-79b1-4c0b-82f4-59dc36c42bce	App\\Models\\Matakuliah:8
9f6f83d4-7a08-4297-af49-07ea583a9f10	App\\Models\\Matakuliah:9
9f6f83d4-7a5a-41ed-a6cc-558b36239409	App\\Models\\Matakuliah:10
9f6f83d4-7aaf-4cda-93ef-19b5bc8a5239	App\\Models\\Matakuliah:11
9f6f83d4-7b06-45d1-81fe-ed48a424782d	App\\Models\\Matakuliah:12
9f6f83d4-7c52-4261-bcc8-c7eb53430e13	App\\Models\\Matakuliah:13
9f6f83d4-7d4b-458e-a207-3f1ed5d97651	App\\Models\\Matakuliah:14
9f6f83d4-7ddb-4f62-84d3-2d10474d0451	App\\Models\\Matakuliah:15
9f6f83d4-7e41-453d-bbf8-3758789f33de	App\\Models\\Matakuliah:16
9f6f83d4-7e9d-4a76-97f8-e4b8fa9bfb18	App\\Models\\Matakuliah:17
9f6f83d4-7ef4-46b0-8f73-112ec79b6624	App\\Models\\Matakuliah:18
9f6f83d4-7f4a-480c-9624-2c0ecd3cee81	App\\Models\\Matakuliah:19
9f6f83d4-7f9c-4fd7-bd03-7f1a198e78eb	App\\Models\\Matakuliah:20
9f6f83d4-8031-4ff6-84aa-0f829d4c1a8b	App\\Models\\Matakuliah:21
9f6f83d4-8084-490c-970a-95e5e7276ea9	App\\Models\\Matakuliah:22
9f6f83d4-80d5-43f0-9f40-2cc883eeddc2	App\\Models\\Matakuliah:23
9f6f83d4-8126-4a94-b0dc-326bdc932052	App\\Models\\Matakuliah:24
9f6f83d4-8178-4df3-8e43-013ec8fdc6ae	App\\Models\\Matakuliah:25
9f6f83d4-81f4-414e-9585-6340312cd7f9	App\\Models\\Matakuliah:26
9f6f83d4-852a-4167-b3cb-f026af410589	App\\Models\\Dosen:1
9f6f83d4-85a6-4cf8-a79a-0289c96fc400	App\\Models\\Dosen:2
9f6f83d4-8610-403d-94ce-46de768f8ea3	App\\Models\\Dosen:3
9f6f83d4-8674-43e0-aac2-bcaa89b0cad8	App\\Models\\Dosen:4
9f6f83d4-86d1-4959-9671-25e4b98e5d60	App\\Models\\Dosen:5
9f6f83d4-872c-4773-af44-704917056207	App\\Models\\Dosen:6
9f6f83d4-8781-40a8-ba8d-13f065be1755	App\\Models\\Dosen:7
9f6f83d4-87d4-4a87-94c4-25aabaac1cae	App\\Models\\Dosen:8
9f6f83d4-8828-47e8-b9a8-3f4c21056d42	App\\Models\\Dosen:9
9f6f83d4-8930-42a6-8639-70d1a74558de	App\\Models\\Dosen:10
9f6f83d4-89e1-4e24-b619-5de134e33705	App\\Models\\Dosen:11
9f6f83d4-8a4d-4096-a614-dd90e80488c1	App\\Models\\Dosen:12
9f6f83d4-8aaa-4d31-9ac0-6677e1c33b63	App\\Models\\Dosen:13
9f6f83d4-8b09-42c1-b7b3-d7eabb962927	App\\Models\\Dosen:14
9f6f83d4-8b9f-4883-83a8-eb1edde5b57d	App\\Models\\Dosen:15
9f6f83d4-8bf6-450e-a5fe-61ad43491d79	App\\Models\\Dosen:16
9f6f83d4-8c4c-4b72-be98-8e02b2c79113	App\\Models\\Dosen:17
9f6f83d4-8ca7-4b3d-8209-4762dec4a52f	App\\Models\\Dosen:18
9f6f83d4-8cfb-4456-878c-071a9f88e67d	App\\Models\\Dosen:19
9f6f83d4-8d4e-4c23-a71e-0d152b4f9001	App\\Models\\Dosen:20
9f6f83d4-8d9e-46c4-acd6-940713631e38	App\\Models\\Dosen:21
9f6f83d4-8dee-4fcb-ba1c-c2fd4e435b78	App\\Models\\Dosen:22
9f6f83d4-8e82-42c1-85be-16e93449a3d1	App\\Models\\Dosen:23
9f6f83d4-8f16-473d-896a-d813db1347cd	App\\Models\\Dosen:24
9f6f83d4-8ff8-4dfe-9890-d7354eaf4b30	App\\Models\\Dosen:25
9f6f83d4-90bb-4169-9567-5adc78711d51	App\\Models\\Dosen:26
9f6f83d4-9127-4366-8eda-3c62153e8f4b	App\\Models\\Dosen:27
9f6f83d4-9188-4384-8ce5-fe125364755a	App\\Models\\Dosen:28
9f6f83d4-91e1-4f18-912f-4249cc41c039	App\\Models\\Dosen:29
9f6f83d4-9238-4262-aedd-eb3a5fe26838	App\\Models\\Dosen:30
9f6f83d4-93df-45ff-b90c-aac4a28ffc78	App\\Models\\Lab:1
9f6f83d4-9449-418e-8a52-32326398df5e	App\\Models\\Lab:2
9f6f83d4-94a2-410e-a60f-d59fe1be1694	App\\Models\\Lab:3
9f6f83d4-94f7-4fa8-b58d-119c7821b902	App\\Models\\Lab:4
9f6f83d4-9579-4ddb-a0de-6505d58aa584	App\\Models\\Lab:5
9f6f83d4-965e-4532-b2c9-ea75d86b8ea8	App\\Models\\Lab:6
9f6f83d4-9708-4137-a9ef-224ab4023f81	App\\Models\\Lab:7
9f6f83d4-9782-4ad9-b6de-3808b2eea9a2	App\\Models\\Lab:8
9f6f83d4-9ab4-4587-9414-d915e5c76e5f	App\\Models\\SesiJam:1
9f6f83d4-9b1f-4630-a25a-de04913f773b	App\\Models\\SesiJam:2
9f6f83d4-9b7a-4408-8ef2-976393a5f441	App\\Models\\SesiJam:3
9f6f83d4-9bee-49cd-a707-ba16279d60f9	App\\Models\\SesiJam:4
9f6f83d4-9cc5-4c3c-a8c2-9582367d07cc	App\\Models\\SesiJam:5
9f6f83d4-9dd4-472a-9e2e-1b0e56a6edc8	App\\Models\\SesiJam:6
9f6f83d4-9e56-43b9-8f62-acff6e04ad85	App\\Models\\SesiJam:7
9f6f83d4-9ec8-487e-a2ae-4bcaec4cbab2	App\\Models\\SesiJam:8
9f6f83d4-9f35-4ac5-b527-22467f4ffa5b	App\\Models\\SesiJam:9
9f6f83d4-9f9f-4c8d-ad42-69ad0d27a35c	App\\Models\\SesiJam:10
9f6f83d4-a150-4328-a8f3-1b2fad468016	App\\Models\\Kelas
9f6f83d4-fa8d-4022-baf2-1d5e338d6ce9	App\\Models\\User:4
9f6f83d4-fc0d-4399-92de-91a2ac95122f	App\\Models\\Mahasiswa:4
\.


--
-- TOC entry 5176 (class 0 OID 117571)
-- Dependencies: 233
-- Data for Name: telescope_monitoring; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.telescope_monitoring (tag) FROM stdin;
\.


--
-- TOC entry 5207 (class 0 OID 117827)
-- Dependencies: 264
-- Data for Name: unit_peralatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.unit_peralatan (id_unit, id_peralatan, kode_unit, status_unit, created_at, updated_at) FROM stdin;
1	1	PJ201	tersedia	2025-07-20 19:03:39	2025-07-20 19:03:39
2	1	PJ202	tersedia	2025-07-20 19:03:39	2025-07-20 19:03:39
3	1	PJ203	tersedia	2025-07-20 19:03:39	2025-07-20 19:03:39
4	1	PJ204	tersedia	2025-07-20 19:03:39	2025-07-20 19:03:39
5	1	PJ205	tersedia	2025-07-20 19:03:39	2025-07-20 19:03:39
\.


--
-- TOC entry 5161 (class 0 OID 117459)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, role, status_user, remember_token, current_team_id, profile_photo_path, created_at, updated_at, two_factor_secret, two_factor_recovery_codes, two_factor_confirmed_at, akses_ubah_kelas, username) FROM stdin;
1	Hida Jaya Habibi, A.Md	teknisi1@gmail.com	\N	$2y$12$8NtX4NGjGG4F9NfX63FnBOcqdpOK2euwCquihPaLi0GubAU0C05nO	teknisi	aktif	\N	\N	\N	2025-07-20 19:03:39	2025-07-20 19:03:39	\N	\N	\N	f	teknisi001
2	Fendi Hermawanto, A.Md	teknisi2@gmail.com	\N	$2y$12$IJqHdvHdEe5nuI4O81htGOTi6.GKCrnLskFtd8447MMtqHhbL0xY2	teknisi	aktif	\N	\N	\N	2025-07-20 19:03:39	2025-07-20 19:03:39	\N	\N	\N	f	teknisi002
3	Teknisi 3	teknisi3@gmail.com	\N	$2y$12$c.O9wtyUYjB6cAPauyE3j.PubkpcUk7HqNrd8PPHSV5WLBZ2aekiO	teknisi	aktif	\N	\N	\N	2025-07-20 19:03:39	2025-07-20 19:03:39	\N	\N	\N	f	teknisi003
4	MahasiswaTesting Teknologi Rekayasa Perangkat Lunak 1A	mhs_trpl-1a_znnWm@example.com	\N	$2y$12$vTNNJnQ4GGZp3jxwMGiJjOi4zHKkzrafmEfjMVcT8HCv4AsRNkiHq	mahasiswa	aktif	\N	\N	\N	2025-07-20 19:03:39	2025-07-20 19:03:39	\N	\N	\N	f	369731321654
\.


--
-- TOC entry 5242 (class 0 OID 0)
-- Dependencies: 245
-- Name: dosen_id_dosen_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dosen_id_dosen_seq', 30, true);


--
-- TOC entry 5243 (class 0 OID 0)
-- Dependencies: 226
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 5244 (class 0 OID 0)
-- Dependencies: 251
-- Name: hari_id_hari_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hari_id_hari_seq', 7, true);


--
-- TOC entry 5245 (class 0 OID 0)
-- Dependencies: 253
-- Name: jadwal_lab_id_jadwalLab_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."jadwal_lab_id_jadwalLab_seq"', 1, false);


--
-- TOC entry 5246 (class 0 OID 0)
-- Dependencies: 223
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 5247 (class 0 OID 0)
-- Dependencies: 240
-- Name: kelas_id_kelas_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kelas_id_kelas_seq', 60, true);


--
-- TOC entry 5248 (class 0 OID 0)
-- Dependencies: 247
-- Name: lab_id_lab_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lab_id_lab_seq', 8, true);


--
-- TOC entry 5249 (class 0 OID 0)
-- Dependencies: 243
-- Name: matakuliah_id_mk_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.matakuliah_id_mk_seq', 26, true);


--
-- TOC entry 5250 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 730, true);


--
-- TOC entry 5251 (class 0 OID 0)
-- Dependencies: 255
-- Name: peminjaman_id_peminjaman_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.peminjaman_id_peminjaman_seq', 1, false);


--
-- TOC entry 5252 (class 0 OID 0)
-- Dependencies: 236
-- Name: peralatan_id_peralatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.peralatan_id_peralatan_seq', 3, true);


--
-- TOC entry 5253 (class 0 OID 0)
-- Dependencies: 228
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- TOC entry 5254 (class 0 OID 0)
-- Dependencies: 238
-- Name: prodi_id_prodi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.prodi_id_prodi_seq', 3, true);


--
-- TOC entry 5255 (class 0 OID 0)
-- Dependencies: 249
-- Name: sesi_jam_id_sesi_jam_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sesi_jam_id_sesi_jam_seq', 10, true);


--
-- TOC entry 5256 (class 0 OID 0)
-- Dependencies: 234
-- Name: tahun_ajaran_id_tahunAjaran_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."tahun_ajaran_id_tahunAjaran_seq"', 3, true);


--
-- TOC entry 5257 (class 0 OID 0)
-- Dependencies: 271
-- Name: team_invitations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.team_invitations_id_seq', 1, false);


--
-- TOC entry 5258 (class 0 OID 0)
-- Dependencies: 269
-- Name: team_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.team_user_id_seq', 1, false);


--
-- TOC entry 5259 (class 0 OID 0)
-- Dependencies: 267
-- Name: teams_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.teams_id_seq', 1, false);


--
-- TOC entry 5260 (class 0 OID 0)
-- Dependencies: 230
-- Name: telescope_entries_sequence_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.telescope_entries_sequence_seq', 562, true);


--
-- TOC entry 5261 (class 0 OID 0)
-- Dependencies: 263
-- Name: unit_peralatan_id_unit_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.unit_peralatan_id_unit_seq', 5, true);


--
-- TOC entry 5262 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 4, true);


--
-- TOC entry 4906 (class 2606 OID 117502)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 4904 (class 2606 OID 117495)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4951 (class 2606 OID 117665)
-- Name: dosen dosen_nama_dosen_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_nama_dosen_unique UNIQUE (nama_dosen);


--
-- TOC entry 4953 (class 2606 OID 117867)
-- Name: dosen dosen_nip_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_nip_unique UNIQUE (nip);


--
-- TOC entry 4955 (class 2606 OID 117658)
-- Name: dosen dosen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_pkey PRIMARY KEY (id_dosen);


--
-- TOC entry 4913 (class 2606 OID 117529)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4915 (class 2606 OID 117531)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4961 (class 2606 OID 117691)
-- Name: hari hari_nama_hari_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hari
    ADD CONSTRAINT hari_nama_hari_unique UNIQUE (nama_hari);


--
-- TOC entry 4963 (class 2606 OID 117689)
-- Name: hari hari_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hari
    ADD CONSTRAINT hari_pkey PRIMARY KEY (id_hari);


--
-- TOC entry 4965 (class 2606 OID 117700)
-- Name: jadwal_lab jadwal_lab_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_pkey PRIMARY KEY ("id_jadwalLab");


--
-- TOC entry 4911 (class 2606 OID 117519)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 4908 (class 2606 OID 117511)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4943 (class 2606 OID 117610)
-- Name: kelas kelas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_pkey PRIMARY KEY (id_kelas);


--
-- TOC entry 4957 (class 2606 OID 117675)
-- Name: lab lab_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lab
    ADD CONSTRAINT lab_pkey PRIMARY KEY (id_lab);


--
-- TOC entry 4945 (class 2606 OID 117637)
-- Name: mahasiswa mahasiswa_nim_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_nim_unique UNIQUE (nim);


--
-- TOC entry 4947 (class 2606 OID 117865)
-- Name: matakuliah matakuliah_kode_mk_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matakuliah
    ADD CONSTRAINT matakuliah_kode_mk_unique UNIQUE (kode_mk);


--
-- TOC entry 4949 (class 2606 OID 117644)
-- Name: matakuliah matakuliah_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matakuliah
    ADD CONSTRAINT matakuliah_pkey PRIMARY KEY (id_mk);


--
-- TOC entry 4890 (class 2606 OID 99393)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4898 (class 2606 OID 117479)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 4967 (class 2606 OID 117743)
-- Name: peminjaman peminjaman_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman
    ADD CONSTRAINT peminjaman_pkey PRIMARY KEY (id_peminjaman);


--
-- TOC entry 4937 (class 2606 OID 117594)
-- Name: peralatan peralatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peralatan
    ADD CONSTRAINT peralatan_pkey PRIMARY KEY (id_peralatan);


--
-- TOC entry 4917 (class 2606 OID 117540)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 4919 (class 2606 OID 117543)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 4939 (class 2606 OID 117861)
-- Name: prodi prodi_kode_prodi_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prodi
    ADD CONSTRAINT prodi_kode_prodi_unique UNIQUE (kode_prodi);


--
-- TOC entry 4941 (class 2606 OID 117603)
-- Name: prodi prodi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prodi
    ADD CONSTRAINT prodi_pkey PRIMARY KEY (id_prodi);


--
-- TOC entry 4959 (class 2606 OID 117682)
-- Name: sesi_jam sesi_jam_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sesi_jam
    ADD CONSTRAINT sesi_jam_pkey PRIMARY KEY (id_sesi_jam);


--
-- TOC entry 4901 (class 2606 OID 117486)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 4935 (class 2606 OID 117587)
-- Name: tahun_ajaran tahun_ajaran_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tahun_ajaran
    ADD CONSTRAINT tahun_ajaran_pkey PRIMARY KEY ("id_tahunAjaran");


--
-- TOC entry 4980 (class 2606 OID 117906)
-- Name: team_invitations team_invitations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_pkey PRIMARY KEY (id);


--
-- TOC entry 4982 (class 2606 OID 117913)
-- Name: team_invitations team_invitations_team_id_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_team_id_email_unique UNIQUE (team_id, email);


--
-- TOC entry 4976 (class 2606 OID 117895)
-- Name: team_user team_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_user
    ADD CONSTRAINT team_user_pkey PRIMARY KEY (id);


--
-- TOC entry 4978 (class 2606 OID 117897)
-- Name: team_user team_user_team_id_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_user
    ADD CONSTRAINT team_user_team_id_user_id_unique UNIQUE (team_id, user_id);


--
-- TOC entry 4973 (class 2606 OID 117887)
-- Name: teams teams_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.teams
    ADD CONSTRAINT teams_pkey PRIMARY KEY (id);


--
-- TOC entry 4925 (class 2606 OID 117553)
-- Name: telescope_entries telescope_entries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_entries
    ADD CONSTRAINT telescope_entries_pkey PRIMARY KEY (sequence);


--
-- TOC entry 4930 (class 2606 OID 117564)
-- Name: telescope_entries_tags telescope_entries_tags_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_entries_tags
    ADD CONSTRAINT telescope_entries_tags_pkey PRIMARY KEY (entry_uuid, tag);


--
-- TOC entry 4928 (class 2606 OID 117555)
-- Name: telescope_entries telescope_entries_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_entries
    ADD CONSTRAINT telescope_entries_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4933 (class 2606 OID 117575)
-- Name: telescope_monitoring telescope_monitoring_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_monitoring
    ADD CONSTRAINT telescope_monitoring_pkey PRIMARY KEY (tag);


--
-- TOC entry 4969 (class 2606 OID 117843)
-- Name: unit_peralatan unit_peralatan_kode_unit_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unit_peralatan
    ADD CONSTRAINT unit_peralatan_kode_unit_unique UNIQUE (kode_unit);


--
-- TOC entry 4971 (class 2606 OID 117836)
-- Name: unit_peralatan unit_peralatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unit_peralatan
    ADD CONSTRAINT unit_peralatan_pkey PRIMARY KEY (id_unit);


--
-- TOC entry 4892 (class 2606 OID 117472)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4894 (class 2606 OID 117470)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4896 (class 2606 OID 117859)
-- Name: users users_username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);


--
-- TOC entry 4909 (class 1259 OID 117512)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 4920 (class 1259 OID 117541)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 4899 (class 1259 OID 117488)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 4902 (class 1259 OID 117487)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 4974 (class 1259 OID 117888)
-- Name: teams_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX teams_user_id_index ON public.teams USING btree (user_id);


--
-- TOC entry 4921 (class 1259 OID 117556)
-- Name: telescope_entries_batch_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX telescope_entries_batch_id_index ON public.telescope_entries USING btree (batch_id);


--
-- TOC entry 4922 (class 1259 OID 117558)
-- Name: telescope_entries_created_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX telescope_entries_created_at_index ON public.telescope_entries USING btree (created_at);


--
-- TOC entry 4923 (class 1259 OID 117557)
-- Name: telescope_entries_family_hash_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX telescope_entries_family_hash_index ON public.telescope_entries USING btree (family_hash);


--
-- TOC entry 4931 (class 1259 OID 117565)
-- Name: telescope_entries_tags_tag_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX telescope_entries_tags_tag_index ON public.telescope_entries_tags USING btree (tag);


--
-- TOC entry 4926 (class 1259 OID 117559)
-- Name: telescope_entries_type_should_display_on_index_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX telescope_entries_type_should_display_on_index_index ON public.telescope_entries USING btree (type, should_display_on_index);


--
-- TOC entry 4989 (class 2606 OID 117659)
-- Name: dosen dosen_id_prodi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dosen
    ADD CONSTRAINT dosen_id_prodi_foreign FOREIGN KEY (id_prodi) REFERENCES public.prodi(id_prodi) ON DELETE CASCADE;


--
-- TOC entry 4990 (class 2606 OID 117716)
-- Name: jadwal_lab jadwal_lab_id_dosen_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_dosen_foreign FOREIGN KEY (id_dosen) REFERENCES public.dosen(id_dosen) ON DELETE CASCADE;


--
-- TOC entry 4991 (class 2606 OID 117701)
-- Name: jadwal_lab jadwal_lab_id_hari_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_hari_foreign FOREIGN KEY (id_hari) REFERENCES public.hari(id_hari) ON DELETE CASCADE;


--
-- TOC entry 4992 (class 2606 OID 117726)
-- Name: jadwal_lab jadwal_lab_id_kelas_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_kelas_foreign FOREIGN KEY (id_kelas) REFERENCES public.kelas(id_kelas) ON DELETE CASCADE;


--
-- TOC entry 4993 (class 2606 OID 117706)
-- Name: jadwal_lab jadwal_lab_id_lab_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_lab_foreign FOREIGN KEY (id_lab) REFERENCES public.lab(id_lab) ON DELETE CASCADE;


--
-- TOC entry 4994 (class 2606 OID 117711)
-- Name: jadwal_lab jadwal_lab_id_mk_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_mk_foreign FOREIGN KEY (id_mk) REFERENCES public.matakuliah(id_mk) ON DELETE CASCADE;


--
-- TOC entry 4995 (class 2606 OID 117721)
-- Name: jadwal_lab jadwal_lab_id_prodi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_prodi_foreign FOREIGN KEY (id_prodi) REFERENCES public.prodi(id_prodi) ON DELETE CASCADE;


--
-- TOC entry 4996 (class 2606 OID 117731)
-- Name: jadwal_lab jadwal_lab_id_tahunajaran_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab
    ADD CONSTRAINT jadwal_lab_id_tahunajaran_foreign FOREIGN KEY ("id_tahunAjaran") REFERENCES public.tahun_ajaran("id_tahunAjaran") ON DELETE CASCADE;


--
-- TOC entry 5012 (class 2606 OID 117871)
-- Name: jadwal_lab_sesi_jam jadwal_lab_sesi_jam_id_jadwallab_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab_sesi_jam
    ADD CONSTRAINT jadwal_lab_sesi_jam_id_jadwallab_foreign FOREIGN KEY ("id_jadwalLab") REFERENCES public.jadwal_lab("id_jadwalLab") ON DELETE CASCADE;


--
-- TOC entry 5013 (class 2606 OID 117876)
-- Name: jadwal_lab_sesi_jam jadwal_lab_sesi_jam_id_sesi_jam_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jadwal_lab_sesi_jam
    ADD CONSTRAINT jadwal_lab_sesi_jam_id_sesi_jam_foreign FOREIGN KEY (id_sesi_jam) REFERENCES public.sesi_jam(id_sesi_jam) ON DELETE CASCADE;


--
-- TOC entry 4984 (class 2606 OID 117611)
-- Name: kelas kelas_id_prodi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kelas
    ADD CONSTRAINT kelas_id_prodi_foreign FOREIGN KEY (id_prodi) REFERENCES public.prodi(id_prodi) ON DELETE CASCADE;


--
-- TOC entry 4985 (class 2606 OID 117621)
-- Name: mahasiswa mahasiswa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_id_foreign FOREIGN KEY (id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4986 (class 2606 OID 117631)
-- Name: mahasiswa mahasiswa_id_kelas_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_id_kelas_foreign FOREIGN KEY (id_kelas) REFERENCES public.kelas(id_kelas) ON DELETE CASCADE;


--
-- TOC entry 4987 (class 2606 OID 117626)
-- Name: mahasiswa mahasiswa_id_prodi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mahasiswa
    ADD CONSTRAINT mahasiswa_id_prodi_foreign FOREIGN KEY (id_prodi) REFERENCES public.prodi(id_prodi) ON DELETE CASCADE;


--
-- TOC entry 4988 (class 2606 OID 117645)
-- Name: matakuliah matakuliah_id_prodi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.matakuliah
    ADD CONSTRAINT matakuliah_id_prodi_foreign FOREIGN KEY (id_prodi) REFERENCES public.prodi(id_prodi) ON DELETE CASCADE;


--
-- TOC entry 5008 (class 2606 OID 117821)
-- Name: peminjaman_bermasalah peminjaman_bermasalah_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_bermasalah
    ADD CONSTRAINT peminjaman_bermasalah_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5005 (class 2606 OID 117798)
-- Name: peminjaman_ditolak peminjaman_ditolak_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_ditolak
    ADD CONSTRAINT peminjaman_ditolak_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 4997 (class 2606 OID 117744)
-- Name: peminjaman peminjaman_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman
    ADD CONSTRAINT peminjaman_id_foreign FOREIGN KEY (id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4999 (class 2606 OID 117765)
-- Name: peminjaman_jadwal peminjaman_jadwal_id_jadwallab_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_jadwal
    ADD CONSTRAINT peminjaman_jadwal_id_jadwallab_foreign FOREIGN KEY ("id_jadwalLab") REFERENCES public.jadwal_lab("id_jadwalLab") ON DELETE CASCADE;


--
-- TOC entry 5000 (class 2606 OID 117760)
-- Name: peminjaman_jadwal peminjaman_jadwal_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_jadwal
    ADD CONSTRAINT peminjaman_jadwal_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5001 (class 2606 OID 117788)
-- Name: peminjaman_manual peminjaman_manual_id_lab_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_manual
    ADD CONSTRAINT peminjaman_manual_id_lab_foreign FOREIGN KEY (id_lab) REFERENCES public.lab(id_lab) ON DELETE CASCADE;


--
-- TOC entry 5002 (class 2606 OID 117773)
-- Name: peminjaman_manual peminjaman_manual_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_manual
    ADD CONSTRAINT peminjaman_manual_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5003 (class 2606 OID 117778)
-- Name: peminjaman_manual peminjaman_manual_id_sesi_mulai_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_manual
    ADD CONSTRAINT peminjaman_manual_id_sesi_mulai_foreign FOREIGN KEY (id_sesi_mulai) REFERENCES public.sesi_jam(id_sesi_jam) ON DELETE CASCADE;


--
-- TOC entry 5004 (class 2606 OID 117783)
-- Name: peminjaman_manual peminjaman_manual_id_sesi_selesai_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_manual
    ADD CONSTRAINT peminjaman_manual_id_sesi_selesai_foreign FOREIGN KEY (id_sesi_selesai) REFERENCES public.sesi_jam(id_sesi_jam) ON DELETE CASCADE;


--
-- TOC entry 5006 (class 2606 OID 117806)
-- Name: peminjaman_peralatan peminjaman_peralatan_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_peralatan
    ADD CONSTRAINT peminjaman_peralatan_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5007 (class 2606 OID 117811)
-- Name: peminjaman_peralatan peminjaman_peralatan_id_peralatan_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_peralatan
    ADD CONSTRAINT peminjaman_peralatan_id_peralatan_foreign FOREIGN KEY (id_peralatan) REFERENCES public.peralatan(id_peralatan) ON DELETE CASCADE;


--
-- TOC entry 4998 (class 2606 OID 117752)
-- Name: peminjaman_selesai peminjaman_selesai_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_selesai
    ADD CONSTRAINT peminjaman_selesai_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5010 (class 2606 OID 117847)
-- Name: peminjaman_unit peminjaman_unit_id_peminjaman_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_unit
    ADD CONSTRAINT peminjaman_unit_id_peminjaman_foreign FOREIGN KEY (id_peminjaman) REFERENCES public.peminjaman(id_peminjaman) ON DELETE CASCADE;


--
-- TOC entry 5011 (class 2606 OID 117852)
-- Name: peminjaman_unit peminjaman_unit_id_unit_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.peminjaman_unit
    ADD CONSTRAINT peminjaman_unit_id_unit_foreign FOREIGN KEY (id_unit) REFERENCES public.unit_peralatan(id_unit) ON DELETE CASCADE;


--
-- TOC entry 5014 (class 2606 OID 117907)
-- Name: team_invitations team_invitations_team_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.team_invitations
    ADD CONSTRAINT team_invitations_team_id_foreign FOREIGN KEY (team_id) REFERENCES public.teams(id) ON DELETE CASCADE;


--
-- TOC entry 4983 (class 2606 OID 117566)
-- Name: telescope_entries_tags telescope_entries_tags_entry_uuid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telescope_entries_tags
    ADD CONSTRAINT telescope_entries_tags_entry_uuid_foreign FOREIGN KEY (entry_uuid) REFERENCES public.telescope_entries(uuid) ON DELETE CASCADE;


--
-- TOC entry 5009 (class 2606 OID 117837)
-- Name: unit_peralatan unit_peralatan_id_peralatan_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unit_peralatan
    ADD CONSTRAINT unit_peralatan_id_peralatan_foreign FOREIGN KEY (id_peralatan) REFERENCES public.peralatan(id_peralatan) ON DELETE CASCADE;


-- Completed on 2025-07-20 19:04:19

--
-- PostgreSQL database dump complete
--

