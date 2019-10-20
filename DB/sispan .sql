-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2019 at 08:42 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sispan`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id_agenda` int(11) NOT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `nama_agenda` varchar(200) DEFAULT NULL,
  `keterangan` text,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id_agenda`, `tanggal_awal`, `tanggal_akhir`, `nama_agenda`, `keterangan`, `foto`) VALUES
(2, '2019-10-11', '2019-10-12', 'Agenda 2', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'uji.jpg'),
(3, '2019-09-12', '2019-09-12', 'Agenda 3', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'lantik.jpg'),
(4, '2019-09-10', '2019-09-10', 'Agenda 4', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'default.jpg'),
(5, '2019-10-17', '2019-10-17', 'Agenda 5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'uji.jpg'),
(6, '2019-10-19', '2019-10-19', 'Agenda 6', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'lantik.jpg'),
(7, '2019-10-29', '2019-10-30', 'Agenda 7', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, obcaecati reprehenderit dicta praesentium perspiciatis minus similique ipsa molestias! Veritatis dolor porro eum minus, doloribus iusto commodi doloremque voluptatum aliquid laudantium.', 'default.jpg'),
(8, '1970-01-31', '1970-01-31', 'Agenda 88', 'Agenda 88', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `akses_cepat`
--

CREATE TABLE `akses_cepat` (
  `id_akses` int(11) NOT NULL,
  `nama_link` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akses_cepat`
--

INSERT INTO `akses_cepat` (`id_akses`, `nama_link`, `url`) VALUES
(1, 'TENTANG KAMI', 'http://google.com'),
(2, 'SEJARAH SINGKAT', '#'),
(3, 'INFORMASI LAYANAN', '#'),
(4, 'DAFTAR SL', '#'),
(5, 'HUBUNGI KAMIS', '#');

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id_album` int(5) NOT NULL,
  `judul_album` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `album_seo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `keterangan` text COLLATE latin1_general_ci NOT NULL,
  `gambar` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `hits_album` int(5) NOT NULL DEFAULT '1',
  `tgl_posting` date NOT NULL,
  `jam` time NOT NULL,
  `hari` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `judul_album`, `album_seo`, `keterangan`, `gambar`, `aktif`, `hits_album`, `tgl_posting`, `jam`, `hari`, `username`) VALUES
(76, '', '', 'Gambar 6', 'img2.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(75, '', '', 'Gambar 5', 'img1.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(73, '', '', 'Gambar 4', 'img3.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(91, '', '', 'Gambar 7', 'img4.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(90, '', '', 'Gambar 72', 'img2.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(89, '', '', 'Gambar 74', 'default.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(81, '', '', 'Gambar 76', 'img4.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(88, '', '', 'Gambar 78', 'img3.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(87, '', '', 'Gambar 71', 'img4.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(86, '', '', 'Gambar 4', 'img4.jpg', 'Y', 1, '0000-00-00', '00:00:00', '', ''),
(92, '', '', 'Gambar Roket', 'rok300.jpg', 'Y', 1, '2019-10-14', '00:00:00', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(5) NOT NULL,
  `id_posisi` int(5) NOT NULL,
  `id_bidang` int(5) NOT NULL,
  `username` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `judul` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `sub_judul` text COLLATE latin1_general_ci NOT NULL,
  `youtube` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `judul_seo` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `headline` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `utama` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `isi_berita` text COLLATE latin1_general_ci NOT NULL,
  `keterangan_gambar` text COLLATE latin1_general_ci NOT NULL,
  `hari` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `gambar` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `dibaca` int(5) NOT NULL DEFAULT '1',
  `tag` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `id_posisi`, `id_bidang`, `username`, `judul`, `sub_judul`, `youtube`, `judul_seo`, `headline`, `aktif`, `utama`, `isi_berita`, `keterangan_gambar`, `hari`, `tanggal`, `jam`, `gambar`, `dibaca`, `tag`) VALUES
(698, 1, 0, 'admin', 'Pertemuan Ahli Stasiun Bumi ASEAN ke 7, LAPAN Mendukung Pencapaian SDGs', 'Pertemuan Ahli Stasiun Bumi ASEAN ke 7', '', 'perteman_ahli_stasiun_bumi', 'Y', 'N', 'Y', '<p>LAPAN menjadi host dalam acara \"The 7th ASEAN Remote Sensing Ground Station Experts Exhange Workshop\" dari tanggal 13-15 Agustus. Acara yang diselenggarakan oleh Pusat Teknologi dan Data Penginderaan Jauh (Pustekdata) ini bertempat di Hotel Swiss Bel Makassar, Sulawesi Selatan. Dalam acara ini berlangsung pula penandatanganan Nota Kesepahaman (MoU) dan Perjanjian Kerja sama antara LAPAN dengan Universitas Hasanudin (Unhas) Makassar.</p><p><span xss=removed>Acara yang kembali diselenggarakan di Indonesia, setelah sebelumnya diselenggarakan tahun 2012, ini adalah wujud nyata LAPAN dalam mendukung Sustainable Development Goals (SDGs) di Indonesia.</span><br></p><p><span xss=removed>Deputi Bidang Penginderaan Jauh LAPAN, Dr. Orbita Roswintiarti menyatakan bahwa pertemuan para ahli di bidang stasiun bumi/ ground station ketujuh ini adalah ajang pertukaran pengalaman dan informasi untuk saling mendukung kegiatan pengamatan bumi di masing-masing negara. \"UU nomor 21 tahun 2013 tentang Keantariksaan jelas menyatakan bahwa LAPAN adalah penyedia data penginderaan jauh nasional. Sejak itu sudah ada roadmap untuk meningkatkan infrastruktur penunjang kegiatan penginderaan jauh. Pertemuan ini diharapkan dapat mendukung peningkatan tersebut,\" ujarnya.</span><br></p><p><span xss=removed>Kegiatan ini juga mengundang para praktisi stasiun bumi di negara ASEAN untuk saling mengintegrasi data seluruh ASEAN. Hal ini akan sangat memungkinkan karena hampir rata-rata setiap negara ASEAN memiliki ground station. Jika digabungkan, data dan informasi tersebut dapat mencakup seluruh wilayah ASEAN.</span><br></p><p><br></p><p>Terkait kerja sama antara LAPAN dengan Unhas, kedua pihak sepakat untuk memperpanjang MoU mengenai penelitian, pengembangan, dan perekayasaan, serta pengabdian masyarakat di bidang sains dan teknologi penerbangan dan antariksa. MoU tersebut sebelumnya telah disepakati pada 2014, dan pada tahun ini kembali diperpanjang.</p><p><br></p><p>Wakil Rektor Bidang Akademik Unhas, Prof. Dr. Muh. Restu, menyatakan bahwa kerja sama LAPAN dengan Unhas akan mendukung riset berbasis data spasial. Tidak hanya itu, pemerintah daerah juga membutuhkan data penginderaan jauh sebagai dasar untuk mengambil kebijakan yang terkain dengan data spasial. Ia juga mengharapkan MoU ini dapat memperluas jejaring mulai dari Indonesia, baik LAPAN maupun Unhas, dengan negara-negara anggota ASEAN lainnya.</p><p><span xss=removed>Peserta lokakarya ini berasal dari Thailand, Singapura, Malaysia, Safran, Maxar, Soletop, Pasco, Universitas Hasanuddin, dan Diskominfo Sulawesi Selatan. Para peserta akan melakukan kunjungan ke stasiun bumi penginderaan jauh Parepare. Kunjungan tersebut untuk melihat langsung infrastruktur yang dibangun serta melihat mekanisme operasional stasiun bumi LAPAN.</span><br></p>', 'pertemuan_ahli_stasiun_bumi', '', '2019-08-26', '00:00:00', 'Lok_ASEAN_2019.jpg', 1, ''),
(697, 1, 0, 'admin', 'Regulasi dan Kebijakan Penerbangan dan Antariksa Dorong Percepatan Pembangunan Nasional', 'Regulasi dan Kebijakan Penerbangan dan Antariksa Dorong Percepatan Pembangunan', '', 'regulasi_dan_kebijakan_penerbangan', 'Y', 'N', 'Y', '<p>Teknologi penerbangan dan antariksa merupakan salah satu teknologi yang mampu mendukung pembangunan negara. Indonesia memiliki potensi yang besar untuk menguasai teknologi tersebut. Teknologi yang canggih, berbiaya mahal, beresiko besar dan memiliki manfaat yang luas ini hanya mampu dikuasai oleh beberapa negara. Usai kemerdekaan, Indonesia bertekad kuat untuk menjadi pelopor dalam pengembangan teknologi tersebut.</p><p><br></p><p>LAPAN sebagai lembaga pembina kegiatan keantariksaan di Indonesia melalui kompetensi utamanya yakni penginderaan jauh, teknologi penerbangan dan antariksa, sains antariksa dan atmosfer,dan kebijakan penerbangan dan antariksa terus mendorong tercapainya kemandirian di bidang teknologi tersebut. Kegiatan keantariksaan tidak bisa dilakukan oleh LAPAN saja, tapi perlu melibatkan banyak stakeholder sehingga nantinya menjadi sinergi nasional antara lembaga litbang, perguruan tinggi dan dunia industri sehingga manfaat dari teknologi keantariksaan bisa langsung dirasakan oleh masyarakat.</p><p><br></p><p>Undang-Undang No. 21 Tahun 2013 tentang keantariksaan dan Perpres No.45 Tahun 2017 tentang rencana induk keantariksaan tahun 2016-2040 merupakan payung hukum dan landasan yang kuat dalam penyelenggaraan kegiatan keantariksaan di Indonesia. Saat ini di Asia Tenggara , hanya Indonesia yang memiliki landasan yang kuat dalam menyusun program-program keantariksaannya dan ini menjadi kebanggaan sekaligus membuka peluang dan tantangan dalam pengembangan kegiatan keantariksaan.</p><p><br></p><p>Dalam Seminar Nasional Kebijakan Penerbangan dan Antariksa ke IV yang digelar di Universitas Padjadjaran, Bandung, Jawa Barat dari tanggal 13 – 14 Agustus 2019, Kepala LAPAN Prof Thomas Djamaluddin mengatakan, undang-undang keantariksaan dan rencana induk keantariksaan 2016-2040 adalah sebagai dasar utama dalam melakukan perumusan kebijakan di bidang penerbangan dan antariksa di Indonesia. “Rencana induk keantariksaan ini harus mampu diimplementasikan guna mempercepat penguasaan dan pemanfaatan teknologi antariksa untuk pembangunan di Indonesia,” ujarnya. </p><p><br></p><p>Ia juga mengingatkan kembali mengenai apa yang disampaikan oleh Bung Karno pada tahun 1960 an apabila Indonesia ingin menjadi negara maju harus mampu menguasai 2 hal yakni teknologi nuklir dan antariksa. Prof Thomas berharap dengan adanya Seminar Nasional Kebijakan Penerbangan dan Antariksa ke IV dengan tema “Kebijakan dan Regulasi dalam Pengembangan IPTEK Berbasis Penerbangan dan Antariksa sebagai Penggerak Sektor Pembangunan” ini, LAPAN mampu menggali dan merumuskan regulasi/ kebijakan yang mampu menjawab tantangan pengembangan Iptek penerbangan dan antariksa serta aspek dalam penyelenggaran kegiatannya.</p><p><br></p><p>Seminar yang terselenggara atas kerja sama Pusat Kajian Kebijakan Penerbangan dan Antariksa LAPAN dan Fakultas Hukum, Universitas Padjajaran ini turut mengundang para pakar dan ahli sebagai pembicara utama antara lain mewakili perguruan tinggi Plt. Rektor Universitas Padjajaran, Prof. Dr. Rina Indiastuti, Guru Besar Ilmu Hukum Internasional FH UNPAD dan Dekan FH UNPAD, Prof Dr An An Chandrawulan, Guru Besar Hukum Udara dan Ruang Angkasa FH UNIKA Atmajaya, Prof Dr I.B.R. Pembicara utama lainya yang hadir adalah Ketua ICASL, Prof Atip Latipulhayat, Direktur Utama PT. Pasifik Satelit Nusantara, Ir. Adi Rahman Adiwoso dan PT Dirgantara Indonesia, Palmana Banandhi.</p><p><br></p><p>Beberapa topik yang akan dibahas dalam seminar ini berkaitan dengan teknologi penerbangan dan antariksa mulai dari aspek-aspek ekonomi, politik, hukum udara dan antariksa baik dari strategi pertahanan dan kerja sama (nasional dan internasional), manajemen litbang, aset, SDM dan isu-isu strategis lainnya.</p><p><br></p><p>Sinas KPA ke IV ini bertujuan untuk memasyarakatkan hasil penelitian kajian kebijakan penerbangan dan antariksa yang dilakukan oleh berbagai pihak khususnya LAPAN. Sinas KPA ini menjadi forum untuk berbagi pandangan dan memperoleh masukan dari pakar dan stakeholders terkait kebijakan dan regulasi di bidang penerbangan dan antariksa.</p><p><br></p><p>Selain para pembicara utama diatas seminar ini juga diisi oleh peserta yang memaparkan makalah terkait dengan tema dan topik yang berkaitan dengan kegiatan ini. Hasil dari Seminar ini akan diterbitakan ke dalam jurnal dan prosiding. Acara ini dihadiri sekitar 200 orang, yang terdiri dari peneliti Pusat KKPA, perwakilan unit kerja LAPAN lainnya, Kementerian/Lembaga terkait, organisasi internasional, perguruan tinggi, industri, lembaga swadaya masyarakat, dan perorangan.</p>', 'regulasi', '', '2019-08-26', '00:00:00', 'REGULASI.png', 1, ''),
(699, 1, 0, 'admin', 'LAPAN Lantik 9 Pejabat Struktural', 'LAPAN Lantik 9 Pejabat Struktural', '', 'Lapan_lantik_9_pejabat', 'Y', 'N', 'Y', '<p>Acara pengambilan sumpah pejabat administrator dan pejabat pengawas telah dilaksanakan di kantor pusat LAPAN pada hari Rabu (14/8). Pelantikan dan pengambilan sumpah tersebut dilakukan oleh Kepala LAPAN, Prof. Dr. Thomas Djamaluddin serta didampingi rohaniawan dari dua agama yaitu Islam dan Kristen. Hadir pada acara pelantikan tersebut beberapa pejabat struktural dan fungsional di lingkungan LAPAN. </p><p><span xss=removed>Acara dimulai dengan menyanyikan lagu Kebangsaan Indonesia Raya dilanjutkan Pembacaan Keputusan Kepala LAPAN tentang Pengangkatan Pegawai Negeri Sipil dalam Jabatan Administrator dan Jabatan Pengawas. Kemudian Kepala LAPAN memimpin pembacaan sumpah jabatan yang diikuti oleh para pejabat yang dilantik.</span><br></p><p><span xss=removed>Para pejabat yang dilantik pun menandatangani sumpah jabatan dan pakta integritas yang menyatakan berperan secara pro aktif dalam upaya pencegahan dan pemberantasan korupsi, tidak meminta atau menerima pemberian secara langsung atau tidak langsung yang tidak sesuai dengan ketentuan yang berlaku, bersikap transparan dalam menjalankan tugas, menghindari pertentangan kepentingan dalam bertugas, memberi contoh dalam kepatuhan terhadap peraturan perundang-undangan, akan menyampaikan informasi jika terjadi penyimpangan integritas, dan siap menghadapi konsekuensinya apabila melanggar hal tersebut.</span><br></p><p><span xss=removed>“Pergantian pejabat adalah hal biasa dan akan terus berulang. Karena pada dasarnya seluruh pegawai LAPAN adalah pejabat. Sehingga tidak ada yang namanya ujung tombak. Peneliti, perekayasa, pengawas, pejabat administrator harus bekerja sama mewujudkan visi Indonesia yang maju dan mandiri.” kata Thomas dalam sambutannya. Thomas juga menyampaikan nilai-nilai LAPAN yang baru, yaitu Berorientasi pada Pelanggan (Pemangku Kepentingan), Akuntabel, Integritas, Inovatif, dan yang terakhir Kolaboratif. Dengan semangat baru ini diharapkan dapat mewujudkan visi Indonesia yang maju dan mandiri.</span><br></p><p><br></p><p>Berikut nama-nama pejabat administrator dan pejabat pengawas yang dilantik :</p><p>JABATAN ADMINISTRATOR</p><p>1. Kuncoro Wisnu, SE., M.M. diangkat dalam jabatan Kepala Balai Pengamatan Antariksa dan Atmosfer Pontianak.</p><p>2. Syafrijon S.Pd., M.Kom. Diangkat dalam jabatan Kepala Balai Pengamatan Antariksa dan Atmosfer Agam</p><p>3. Aries Kurniawan S.T. diangkat dalam jabatan Kepala Balai Pengamatan Antariksa dan Atmosfer Sumedang</p><p><br></p><p>JABATAN PENGAWAS</p><p>1. Rosita Christina Ronsumbre, S.SI diangkat dalam jabatan Kepala Subbagian Sumber Daya Manusia dan Tata Usaha , Pusat Teknologi Roket</p><p>2. Ardi Riawan Ardjasoebrata, S.E diangkat dalam jabatan Kepala Subbagian Sumber Daya Manusia dan Tata Usaha, Pusat Sains Antariksa.</p><p>3. Noer Abdillah Sahri Noto Soepono Ninoi, M.MT diangkat dalam jabatan Kepala Subbagian Tata Usaha, Balai Pengamatan Antariksa dan Atmosfer Pasuruan</p><p>4. Alita Rachmawati S.E diangkat dalam jabatan Kepala Subbagian Keuangan dan Barang Milik Negara, Pusat Teknologi Roket</p><p>5. Neneng Destiyani S.E. diangkat dalam jabatan Kepala Subbagian Tata Usaha Balai Pengamatan Antariksa dan Atmosfer Sumedang</p><p>6. Indra Bahrizal S.T. diangkat dalam jabatan Kepala Subbagian Tata Usaha Balai Pengamatan Antariksa dan Atmosfer Agam.</p>', 'lantik_pejabat', '', '2019-08-26', '00:00:00', 'LANTIK.jpg', 1, ''),
(700, 1, 0, 'admin', 'Upacara HUT ke-74 RI Semangati Impian SDM LAPAN yang Unggul', 'Upacara HUT ke-74', '', 'upacara_hut_ri', 'Y', 'N', 'Y', '<p>LAPAN turut menyemarakkan peringatan Hari Ulang Tahun (HUT) ke-74 Kemerdekaan Republik Indonesia yang kali ini mengusung tema “SDM Unggul Indonesia Maju”. Sabtu (17/08), LAPAN menyelenggarakan upacara peringatan Hari Kemerdekaan ke-74 Republik Indonesia. Acara berlangsung di halaman Kantor LAPAN Pusat, Rawamangun, Jakarta, selaku Pembina Upacara Kepala LAPAN, Prof. Dr. Thomas Djamaludin. LAPAN juga melaksanakan upacara di beberapa kantor pusat dan balai yang berlokasi di beberapa daerah di Indonesia.</p><p>Pada rangkaian penghujung upacara, Kepala LAPAN memimpin seremoni penyematan pin Satya Lancana Karya Satya (SLKS) dan penyerahan Piagam SLKS di lingkungan Sekretariat Utama dan Pusat Kajian Kebijakan Penerbangan dan Antariksa. Kali ini, sejumlah 20 pegawai LAPAN menerima penghargaan SLKS dari Presiden Republik Indonesia, Joko Widodo. Penghargaan diberikan untuk para pegawai dengan masa bakti jenjang periode 30 tahun, 20 tahun, dan 10 tahun. </p>', 'upacara_17_agustus', '', '2019-08-26', '00:00:00', 'upacara_17_ags_2019_-_2.jpg', 1, ''),
(701, 1, 0, 'admin', 'Peserta Komurindo Kombat 2019 Ikuti Persiapan Kompetisi', 'Peserta Komurindo Kombat 2019 Ikuti Persiapan Kompetisi', '', 'persiapan_kompetisi_komurindo', 'Y', 'N', 'Y', '<p>Jumat (23/08), berlangsung persiapan tahapan Kompetisi Muatan Roket dan Roket Indonesia (Komurindo) ke-11 dan Kompetisi Muatan Balon Atmosfer (Kombat) ke-5. Tahapan ini diisi dengan registrasi peserta di Kantor LAPAN Bandung. Selanjutnya, seluruh peserta diakomodir keberangkatannya menuju lokasi kompetisi yang terletak di Balai Uji Teknologi dan Pengamatan Antariksa dan Atmosfer Garut. </p><p><span xss=removed>Komurindo Kombat 2019 merupakan ajang kompetisi bergengsi mahasiswa se-Indonesia yang diselenggarakan LAPAN, sebagai salah satu upaya menumbuhkembangkan kecintaan dan minat generasi muda terhadap teknologi penerbangan dan antariksa. </span><br></p><p><span xss=removed>Berbeda dengan tahun-tahun sebelumnya yang diselenggarakan setiap tahun, mulai periode kali ini, LAPAN melaksanakan setiap dua tahun. Kategori perlombaan masih terbagi tiga, yaitu Muatan Roket dengan tema Pemantauan Grafis Sikap Luncur Roket Uji Muatan dalam Visualisasi Odometri Tiga Dimensi (3D odometry graphics visualization), Wahana Sistem Kendali dengan tema Perancangan wahana dengan propulsi EDF (Electric Ducted Fan) dan sistem kendali untuk mencapai sasaran secara horizontal, serta Muatan Balon Atmosfer dengan tema KOMBAT Rawinsonda for Tropopause Observation.</span><br></p><p><span xss=removed>Sebagai informasi, pada tahun 2018 telah dilakukan seleksi tahap I (proposal) yang meloloskan Tim Muatan Roket (30), Wahana Sistem Kendali (32), dan Muatan Balon Atmosfer (30). Selanjutnya seleksi Tahap II yang diakhiri dengan workshop telah menyeleksi Tim Muatan Roket (20), Wahana Sistem Kendali (25), dan Muatan Balon Atmosfer (24). Dibanding dengan tahun 2017, terdapat peningkatan jumlah peserta untuk kategori Muatan Balon Atmosfer yang semula 16 Tim menjadi 24 Tim. Hasil seleksi tahap kedua ini yang selanjutnya akan dilanjutkan pada tahap uji fungsi dan uji terbang esok hari.</span><br></p><p><span xss=removed>Setiba di lokasi tahapan kompetisi, seluruh peserta menyimak paparan panitia dalam kegiatan technical meeting. Kegiatan ini untuk memandu peserta agar bisa mengikuti proses lomba sesuai mekanisme yang ditentukan oleh Tim Jumat (23/08), berlangsung persiapan tahapan Kompetisi Muatan Roket dan Roket Indonesia (Komurindo) ke-11 dan Kompetisi Muatan Balon Atmosfer (Kombat) ke-5. Tahapan ini diisi dengan registrasi peserta di Kantor LAPAN Bandung. Selanjutnya, seluruh peserta diakomodir keberangkatannya menuju lokasi kompetisi yang terletak di Balai Uji Teknologi dan Pengamatan Antariksa dan Atmosfer Garut. </span><br></p><p><span xss=removed>Tim Juri yang terlibat dalam penilaian tidak hanya dari LAPAN saja, namun juga dihadirkan Juri Tamu. Adapun Tim Juri LAPAN untuk kategori muatan roket yaitu Herma Yudhi Irwanto, M. Eng., Dr. Effendi Dodi Arisandi, dan Drs. Ari Sugeng Budiyanta, M. Eng. Sedangkan untuk Kategori Wahana Sistem Kendali yaitu Dr. Arif Nur Hakim, Ing. Anita Pascawati, ST., dan Ahmad Riyadl, ST. Komurindo tahun ini menghadirkan Juri Tamu Dr. Ir. Indrawanto dari ITB. Juri Kategori Kombat kali ini adalah Dr. Didi Satiadi, Dr. Laras Tursilowati, dan Dr. Asif Awaludin, MT. Lalu untuk Juri Tamunya yaitu Dr. Ir. Endra Pitowarno dari Politeknik Elektronika Negeri Surabaya (PENS).. Acara ini dipandu oleh Kepala Bagian Humas, selaku Wakil Ketua Panitia, Ir. Jasyanto, MM.</span><br></p>', 'persiapan_komurindo', '', '2019-08-26', '00:00:00', 'uji_trust1.jpg', 1, ''),
(702, 1, 0, 'admin', 'Uji Terbang Akhiri Puncak Acara Komurindo-Kombat 2019', 'Uji Terbang Akhiri Puncak Acara Komurindo-Kombat 2019', '', 'uji_terbang_komurindo_2019', 'Y', 'N', 'Y', '<p>Puncak acara Komurindo – Kombat 2019 akhirnya diselenggarakan dengan sukses di Landasan Udara TNI AU Cikelet, Garut, Jawa Barat, Minggu (25/08). Kegiatan dimulai dengan peluncuran muatan balon dari 24 Tim yang lolos untuk diujiterbangkan. Dua balon atmosfer dipersiapkan LAPAN untuk membawa muatan peserta tersebut, dengan interval waktu peluncuran kurang lebih 30 menit.</p><p><span xss=removed>Seremonial acara Komurindo – Kombat 2019 dibuka secara resmi oleh Kepala LAPAN, Prof. Dr. Thomas Djamaluddin. Hadir dalam kegiatan tersebut, para pejabat eselon 1 LAPAN, Kepala Dinas Pariwisata dan Kebudayaan Garut, Budi Gangan Gumilar, Wakil Ketua DPRD Garut, serta perwakilan Lanud TNI AU Cikelet, aparat kepolisian setempat, pelajar sekolah di wilayah Garut, dan masyarakat setempat.</span><br></p><p><span xss=removed>Acara diawali laporan Kepala Biro Kerja Sama, Hubungan Masyarakat, dan Umum, selaku Ketua Panitia, Christianus R. Dewanto, ia mengatakan kegiatan-Komurindo Kombat 2019 ini merupakan kompetisi yang ke-11 sedangkan Kombat ke-5. Peserta telah melakukan serangkaian seleksi yang diawali dengan pengajuan proposal, seleksi Tahap I dan II yang diakhiri workshop. Workshop itu sendiri telah dilaksanakan pada tanggal 24 agustus 2018. </span><br></p><p><span xss=removed>Pada tahun ini, kegiatan kompetisi dilakukan untuk melakukan tahapan uji fungsi dan uji terbang. Uji Fungsi dilakukan untuk pengukuran dimensi, uji lingkungan (Shock dan G Force), Uji GCS (uji tampilan data di monitor), serta uji telemetri. Masih sama dengan periode sebelumnya, ada tiga kategori yang diperlombakan pada saat ini, yaitu Muatan Roket, Wahana Sistem Kendali, dan Muatan Balon Atmosfer. </span><br></p><p><span xss=removed>Chris mengatakan, kegiatan ini dilakukan untuk menumbuhkembangkan generasi muda, dengan harapan, kompetisi menjadi modal dasar kemajuan bangsa. Sementara Kepala LAPAN menjelaskan, acara diselenggarakan atas dukungan kerja sama Kemenristekdikti dan Pemkab Garut. Kegiatan tersebut termasuk rangkaian agenda besar dari peringatan Hari Keantariksaan yang jatuh pada tanggal 06 Agustus, Hari Ulang Tahun ke-56 LAPAN, dan Hari Kebangkitan Teknologi Nasional (Hakteknas) ke-24. </span><br></p><p><span xss=removed>Mewakili Bupati Garut, Budi Gangan berharap Komurindo – Kombat menjadi event yang konsisten dan dan diharapkan bisa mendunia. Ia berharap, Komurindo-Kombat menjadi Triger wilayah Selatan dan dapat dikembangkan untuk meningkatkan ekonomi wilayah selatan. “Lomba tidak harus dinikmati oleh perguruan tinggi saja, namun ilmu pengetahuan bisa ditularkan pelajar sekolah dasar, pertama, dan menengah, serta masyarakat umum. </span><br></p>', 'uji_terbang_komurindo', '', '2019-08-26', '00:00:00', 'uji_terbang_1.jpg', 1, ''),
(703, 2, 0, 'admin', 'asd', 'asda', '', '', 'Y', 'N', 'Y', '', '', '', '2019-09-14', '00:00:00', 'default.jpg', 1, ''),
(704, 1, 0, 'admin', 'Tes percobaan judul baru berita di pusispan', 'tes percobaan', '', 'Tes_percobaan_judul_baru_berita_di_pusispan_14102019', 'Y', 'N', 'Y', '<p xss=removed>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet aliquid repellat nemo nesciunt unde reiciendis dolor eius, expedita dolores voluptatibus id quas consectetur nisi esse. Soluta ipsa impedit est nesciunt.</p>', '', '', '2019-10-14', '00:00:00', 'default.jpg', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ddesainindustri`
--

CREATE TABLE `ddesainindustri` (
  `ID` int(11) NOT NULL,
  `ID_DESAIN_INDUSTRI` int(11) NOT NULL,
  `NIK` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ddesainindustri`
--

INSERT INTO `ddesainindustri` (`ID`, `ID_DESAIN_INDUSTRI`, `NIK`) VALUES
(74, 18, 3272),
(75, 18, 3271),
(76, 18, 3502),
(77, 1, 3271),
(81, 2, 3271),
(82, 2, 3777),
(83, 2, 3510),
(84, 2, 3272),
(86, 3, 327501),
(92, 5, 327503);

-- --------------------------------------------------------

--
-- Table structure for table `dhakcipta`
--

CREATE TABLE `dhakcipta` (
  `ID` int(11) NOT NULL,
  `ID_HAKCIPTA` int(11) NOT NULL,
  `NIK` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dhakcipta`
--

INSERT INTO `dhakcipta` (`ID`, `ID_HAKCIPTA`, `NIK`) VALUES
(8, 1, 0),
(9, 1, 0),
(14, 3, 0),
(15, 4, 0),
(16, 5, 0),
(17, 6, 0),
(18, 7, 0),
(21, 8, 3271),
(22, 8, 3502),
(36, 11, 3272),
(37, 11, 3501),
(38, 12, 3272),
(39, 13, 3272),
(40, 13, 3501),
(41, 13, 3509),
(43, 14, 327503);

-- --------------------------------------------------------

--
-- Table structure for table `dmerek`
--

CREATE TABLE `dmerek` (
  `ID` int(11) NOT NULL,
  `ID_MEREK` int(11) NOT NULL,
  `NIK` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dmerek`
--

INSERT INTO `dmerek` (`ID`, `ID_MEREK`, `NIK`) VALUES
(7, 2, 327502),
(10, 3, 327501),
(13, 4, 327501),
(14, 4, 327501);

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_panduan`
--

CREATE TABLE `dokumen_panduan` (
  `ID` int(11) NOT NULL,
  `NAMA` varchar(50) NOT NULL,
  `NAMA_FILE` varchar(50) NOT NULL,
  `SIZE` float NOT NULL DEFAULT '0',
  `TYPE` varchar(50) NOT NULL,
  `KODE_INPUT` int(11) NOT NULL,
  `TGL_INPUT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokumen_panduan`
--

INSERT INTO `dokumen_panduan` (`ID`, `NAMA`, `NAMA_FILE`, `SIZE`, `TYPE`, `KODE_INPUT`, `TGL_INPUT`) VALUES
(1, 'Dokumen Panduan 1', 'DOKUMEN_PANDUAN_1.pdf', 29.93, '.pdf', 1, '2019-09-03 13:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE `download` (
  `id_download` int(5) NOT NULL,
  `judul` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `nama_file` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `publisher` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `penulis` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tgl_posting` date NOT NULL,
  `hits` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `download`
--

INSERT INTO `download` (`id_download`, `judul`, `nama_file`, `publisher`, `penulis`, `tgl_posting`, `hits`) VALUES
(18, 'UU Keantariksaan', 'UU_no.21-2013_keantariksaan_.pdf', 'PPID', 'LAPAN', '2014-10-12', 0),
(19, 'Laporan Tahunan LAPAN 2016', 'Laporan_Tahunan_LAPAN_2016_compressed.pdf', 'Biro Kerja sama, Humas, dan Umum', 'Humas', '2017-10-09', 0),
(20, 'Buletin LAPAN Vol. 4', 'Buletin_LAPAN_Vol_4_No_1.pdf', 'Humas', 'Humas', '2017-10-08', 0),
(21, 'Laporan Kinerja Layanan Triwulan I 2018', 'Laporan-Kinerja-LAYANAN-TW-I-2018.pdf', 'Pustikpan', 'LAPAN', '2019-10-13', 0),
(22, 'Laporan Kinerja Layanan Triwulan II 2018', 'Laporan-Kinerja-LAYANAN-TW-II-2018.pdf', 'Pustikpan', 'LAPAN', '2019-10-14', 0),
(23, 'Laporan Sample 2019', 'SAMPLE_DOCUMENT_1.pdf', '', '', '2019-10-14', 1),
(25, 'Judul', 'SAMPLE_DOCUMENT_1.pdf', '', '', '2019-10-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dpaten`
--

CREATE TABLE `dpaten` (
  `ID` int(11) NOT NULL,
  `ID_PATEN` int(11) NOT NULL,
  `NIK` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dpaten`
--

INSERT INTO `dpaten` (`ID`, `ID_PATEN`, `NIK`) VALUES
(297, 370, 327502),
(299, 371, 327501),
(305, 369, 327501),
(314, 372, 327501),
(315, 372, 327502);

-- --------------------------------------------------------

--
-- Table structure for table `d_acuan_nonsni`
--

CREATE TABLE `d_acuan_nonsni` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_acuan_nonsni`
--

INSERT INTO `d_acuan_nonsni` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'AN'),
(2, 3, 'Acn'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_acuan_sni`
--

CREATE TABLE `d_acuan_sni` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_acuan_sni`
--

INSERT INTO `d_acuan_sni` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'A'),
(2, 3, 'Ac'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_bibliografi`
--

CREATE TABLE `d_bibliografi` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_bibliografi`
--

INSERT INTO `d_bibliografi` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'B'),
(2, 3, 'B'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_konseptor`
--

CREATE TABLE `d_konseptor` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(50) NOT NULL,
  `INSTANSI` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_konseptor`
--

INSERT INTO `d_konseptor` (`ID`, `ID_USULAN`, `NAMA`, `INSTANSI`) VALUES
(1, 2, 'Kons 1', 'Ins 1'),
(2, 2, 'Kons 2', 'Ins 2'),
(3, 3, 'Budiman', 'Instansi 1'),
(4, 4, 'Budiman', 'Kon1');

-- --------------------------------------------------------

--
-- Table structure for table `d_konseptor_utama`
--

CREATE TABLE `d_konseptor_utama` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL DEFAULT '0',
  `NAMA` varchar(50) NOT NULL,
  `ALAMAT` varchar(300) NOT NULL,
  `TELEPON` varchar(20) NOT NULL,
  `EMAIL` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_konseptor_utama`
--

INSERT INTO `d_konseptor_utama` (`ID`, `ID_USULAN`, `NAMA`, `ALAMAT`, `TELEPON`, `EMAIL`) VALUES
(1, 1, 'Budiman', 'Bekasi Utara', '0821', 'budidummy3228@gmail.com'),
(2, 2, 'Budiman', 'Bekasi Utara', '0821', 'budidummy3228@gmail.com'),
(3, 3, 'Budiman', 'Bekasi Utara', '0821', 'budidummy3228@gmail.com'),
(4, 4, 'Budiman', 'Bekasi Utara', '0821', 'budidummy3228@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `d_lpk`
--

CREATE TABLE `d_lpk` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_lpk`
--

INSERT INTO `d_lpk` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'L'),
(2, 3, 'L'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_manfaat`
--

CREATE TABLE `d_manfaat` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `ISI` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_manfaat`
--

INSERT INTO `d_manfaat` (`ID`, `ID_USULAN`, `ISI`) VALUES
(1, 2, 'M'),
(2, 3, 'Manfaat'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_perbaikan`
--

CREATE TABLE `d_perbaikan` (
  `ID_USULAN` int(11) NOT NULL,
  `SURAT_PENGANTAR_1` varchar(150) NOT NULL,
  `RSNI_1` varchar(150) NOT NULL,
  `NOTULENSI_1` varchar(150) NOT NULL,
  `DOK_PERBAIKAN_1` varchar(150) NOT NULL,
  `SURAT_PENGANTAR_2` varchar(150) NOT NULL,
  `RSNI_2` varchar(150) NOT NULL,
  `NOTULENSI_2` varchar(150) NOT NULL,
  `DOK_PERBAIKAN_2` varchar(150) NOT NULL,
  `SURAT_PENGANTAR_3` varchar(150) NOT NULL,
  `RSNI_3` varchar(150) NOT NULL,
  `NOTULENSI_3` varchar(150) NOT NULL,
  `DOK_PERBAIKAN_3` varchar(150) NOT NULL,
  `SURAT_PENGANTAR_4` varchar(150) NOT NULL,
  `RSNI_4` varchar(150) NOT NULL,
  `NOTULENSI_4` varchar(150) NOT NULL,
  `DOK_PERBAIKAN_4` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_perbaikan`
--

INSERT INTO `d_perbaikan` (`ID_USULAN`, `SURAT_PENGANTAR_1`, `RSNI_1`, `NOTULENSI_1`, `DOK_PERBAIKAN_1`, `SURAT_PENGANTAR_2`, `RSNI_2`, `NOTULENSI_2`, `DOK_PERBAIKAN_2`, `SURAT_PENGANTAR_3`, `RSNI_3`, `NOTULENSI_3`, `DOK_PERBAIKAN_3`, `SURAT_PENGANTAR_4`, `RSNI_4`, `NOTULENSI_4`, `DOK_PERBAIKAN_4`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `d_pihak_berkepentingan`
--

CREATE TABLE `d_pihak_berkepentingan` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_pihak_berkepentingan`
--

INSERT INTO `d_pihak_berkepentingan` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'P'),
(2, 3, 'Pihak'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `d_regulasi`
--

CREATE TABLE `d_regulasi` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `d_regulasi`
--

INSERT INTO `d_regulasi` (`ID`, `ID_USULAN`, `NAMA`) VALUES
(1, 2, 'R'),
(2, 3, 'Re'),
(3, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `halamanstatis`
--

CREATE TABLE `halamanstatis` (
  `id_halaman` int(5) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `judul_seo` varchar(100) NOT NULL,
  `isi_halaman` varchar(1000) DEFAULT NULL,
  `tgl_posting` date NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `dibaca` int(5) NOT NULL DEFAULT '1',
  `jam` time NOT NULL,
  `hari` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `rekap` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `halamanstatis`
--

INSERT INTO `halamanstatis` (`id_halaman`, `judul`, `judul_seo`, `isi_halaman`, `tgl_posting`, `gambar`, `username`, `dibaca`, `jam`, `hari`, `rekap`) VALUES
(64, 'Litbangyasa', 'litbangyasa', '<p>Isi Halaman Litbangyasa</p><p><br></p><ol><li>Isi 1</li><li>Isi 2</li><li>Isi 3</li></ol>', '2019-08-20', 'satellite-1030782_960_720.jpg', 'admin', 1, '00:00:00', '', 0),
(63, 'Publikasi', 'publikasi', '<p><b>ISI HALAMAN PUBLIKASI</b></p><p><b><br></b></p><ol><li>ISI 1</li><li>ISI 2</li><li>ISI 3</li></ol>', '2019-08-20', 'rocket-launch-67643_960_720.jpg', 'admin', 1, '00:00:00', '', 0),
(68, 'Struktur Organisasi', 'struktur_organisasi', '<p>Struktur Organisasi</p>', '2019-10-06', 'Struktur-Organisasi.jpg', 'admin', 1, '00:00:00', '', 0),
(69, 'Peran dan Tanggung Jawab', 'peran_tanggungjawab', '<p><b>Peran dan Tanggung Jawab</b></p>', '2019-10-06', 'default.jpg', 'admin', 1, '00:00:00', '', 0),
(65, 'Sejarah Singkat', 'sejarah_singkat', '   <h5 xss=\"removed\"><b>Kronologi Pembentukan LAPAN</b></h5><ul><li xss=\"removed\">Pada tanggal 31 Mei 1962, dibentuk Panitia Astronautika oleh Menteri Pertama RI, Ir. Juanda (selaku Ketua Dewan Penerbangan RI) dan R.J. Salatun (selaku Sekretaris Dewan Penerbangan RI).</li></ul><p><br></p><ul><li xss=\"removed\">Tanggal 22 September 1962, terbentuknya Proyek Roket Ilmiah dan Militer Awal (PRIMA) afiliasi AURI dan ITB. Berhasil membuat dan meluncurkan dua roket seri Kartika berikut telemetrinya.</li></ul><p><br></p><ul><li xss=\"removed\">Tanggal 27 November 1963, Lembaga Penerbangan dan Antariksa Nasional (LAPAN) dibentuk dengan Keputusan Presiden Nomor 236 Tahun 1963 tentang LAPAN.</li></ul>', '2019-10-06', 'default.jpg', '', 1, '00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `id_identitas` int(5) NOT NULL,
  `nama_website` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `satker` varchar(50) NOT NULL,
  `facebook` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `google` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `meta_deskripsi` varchar(250) NOT NULL,
  `meta_keyword` varchar(250) NOT NULL,
  `favicon` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `nama_kategori` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `kategori_seo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Ya','Tidak') COLLATE latin1_general_ci NOT NULL DEFAULT 'Ya'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `username`, `kategori_seo`, `aktif`) VALUES
(1, 'Kategori 1', '', '', 'Ya'),
(2, 'Kategori 2', '', '', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `id_posisi` int(11) DEFAULT NULL,
  `nama_kegiatan` varchar(200) DEFAULT NULL,
  `tempat` varchar(200) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `id_posisi`, `nama_kegiatan`, `tempat`, `tanggal`, `gambar`) VALUES
(1, 2, 'Kegiatan MT', 'Ruang Antariksa', '0000-00-00', 'category_3_-_Copy.jpg'),
(2, 4, 'Kegiatan AT', 'Ruang Antariksa', '2019-08-05', '24juli.jpg'),
(3, 3, 'Kegiatan Standar', 'Ruang Antariksa', '0000-00-00', '24juli.jpg'),
(4, 2, 'Kegiatan MT 2', 'Ruang Antariksa', '0000-00-00', 'astronaut-11080_960_720.jpg'),
(5, 4, 'Kegiatan AT 2', 'Ruang Antariksa', '2019-08-05', '24juli.jpg'),
(6, 3, 'Kegiatan Standar 2', 'Ruang Antariksa', '2019-08-05', '31juli.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `link_terkait`
--

CREATE TABLE `link_terkait` (
  `id_link` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `nama_link` varchar(50) NOT NULL,
  `url_web` text NOT NULL,
  `logo` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link_terkait`
--

INSERT INTO `link_terkait` (`id_link`, `kategori`, `nama_link`, `url_web`, `logo`) VALUES
(13, '', 'Tautan 1', '#', ''),
(14, '', 'Tautan 2', '#', '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL,
  `id_posisi` int(5) NOT NULL DEFAULT '0',
  `id_parent` int(5) NOT NULL DEFAULT '0',
  `nama_menu` varchar(50) NOT NULL,
  `punya_sub` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `link` varchar(100) NOT NULL,
  `status_aktif` enum('Ya','Tidak') NOT NULL DEFAULT 'Ya',
  `urutan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_posisi`, `id_parent`, `nama_menu`, `punya_sub`, `link`, `status_aktif`, `urutan`) VALUES
(1, 1, 0, 'Beranda', 'Tidak', 'home', 'Ya', NULL),
(2, 1, 0, 'Profile', 'Ya', '', 'Ya', 0),
(3, 1, 0, 'Berita', 'Ya', '', 'Ya', NULL),
(4, 1, 0, 'Litbangyasa', 'Tidak', 'litbangyasa', 'Ya', NULL),
(5, 1, 0, 'Publikasi', 'Tidak', 'publikasi', 'Ya', NULL),
(6, 1, 0, 'PPID', 'Tidak', 'http://ppid.lapan.go.id/', 'Ya', NULL),
(7, 1, 0, 'Link', 'Tidak', '', 'Ya', NULL),
(8, 1, 2, 'Sejarah Singkat', 'Tidak', 'profile/sejarah_singkat', 'Ya', NULL),
(9, 1, 2, 'Struktur Organisasi', 'Tidak', 'profile/struktur_organisasi', 'Ya', NULL),
(10, 1, 2, 'Peran dan Tanggung Jawab', 'Tidak', 'profile/peran_tanggungjawab', 'Ya', NULL),
(11, 1, 3, 'Berita Terbaru', 'Tidak', 'berita/', 'Ya', NULL),
(12, 1, 3, 'Program', 'Tidak', '', 'Ya', NULL),
(13, 1, 3, 'Agenda', 'Tidak', '', 'Ya', NULL),
(14, 2, 0, 'Beranda', 'Tidak', 'home', 'Ya', NULL),
(16, 2, 0, 'Berita', 'Ya', '', 'Ya', NULL),
(17, 2, 0, 'Litbangyasa', 'Tidak', 'litbangyasa', 'Ya', NULL),
(18, 2, 0, 'Publikasi', 'Tidak', 'publikasi', 'Ya', NULL),
(19, 2, 0, 'PPID', 'Tidak', 'http://ppid.lapan.go.id/', 'Ya', NULL),
(20, 2, 0, 'Link', 'Tidak', '', 'Ya', NULL),
(21, 2, 0, 'HAKI', 'Ya', '', 'Ya', NULL),
(22, 2, 21, 'Paten', 'Tidak', 'paten', 'Ya', NULL),
(23, 2, 21, 'Merek', 'Tidak', 'merek', 'Ya', NULL),
(24, 2, 21, 'Hak Cipta', 'Tidak', 'hakcipta', 'Ya', NULL),
(25, 2, 21, 'Desain Industri', 'Tidak', 'desain', 'Ya', NULL),
(26, 2, 21, 'Desain Tata Letak', 'Tidak', '', 'Ya', NULL),
(27, 2, 0, 'Support', 'Ya', '', 'Ya', NULL),
(28, 2, 27, 'Regulasi', 'Tidak', '', 'Ya', NULL),
(29, 2, 27, 'SOP', 'Tidak', 'sop', 'Ya', NULL),
(30, 2, 27, 'Q & A', 'Tidak', '', 'Ya', NULL),
(31, 2, 16, 'Agenda', 'Tidak', '', 'Ya', NULL),
(32, 2, 16, 'Program', 'Tidak', '', 'Ya', NULL),
(33, 2, 16, 'Berita Terbaru', 'Tidak', 'berita/', 'Ya', NULL),
(57, 3, 0, 'Beranda', 'Tidak', 'home', 'Ya', NULL),
(58, 3, 0, 'Standar', 'Tidak', '', 'Ya', NULL),
(59, 3, 0, 'Komite Teknis', 'Tidak', '', 'Ya', NULL),
(60, 3, 0, 'Sertifikasi', 'Ya', '', 'Ya', NULL),
(61, 3, 0, 'LPK', 'Tidak', '', 'Ya', NULL),
(62, 3, 0, 'Regulasi', 'Ya', '', 'Ya', NULL),
(63, 3, 0, 'Informasi Lain', 'Ya', '', 'Ya', NULL),
(64, 3, 0, 'Tentang Kami', 'Tidak', 'tentang', 'Ya', NULL),
(65, 3, 60, 'Layanan Sertifikasi', 'Tidak', '', 'Ya', NULL),
(66, 3, 60, 'Cek Sertifikasi', 'Tidak', 'sertifikasi/cek_sertifikasi', 'Ya', NULL),
(67, 3, 62, 'Daftar PNRT', 'Tidak', '', 'Ya', NULL),
(68, 3, 62, 'Daftar Regulasi Teknis', 'Tidak', '', 'Ya', NULL),
(69, 3, 63, 'Panduan', 'Tidak', 'panduan', 'Ya', NULL),
(70, 3, 63, 'JDIH', 'Tidak', 'https://jdih.lapan.go.id', 'Ya', NULL),
(71, 4, 0, 'Beranda', 'Tidak', 'home', 'Ya', NULL),
(72, 4, 0, 'Intermediasi', 'Ya', '', 'Ya', NULL),
(73, 4, 0, 'Kegiatan', 'Ya', '', 'Ya', NULL),
(74, 4, 0, 'Support', 'Ya', '', 'Ya', NULL),
(75, 4, 73, 'Valuasi Teknologi', 'Tidak', '', 'Ya', NULL),
(76, 4, 73, 'Temu Bisnis', 'Tidak', '', 'Ya', NULL),
(77, 4, 73, 'Inkubasi', 'Tidak', '', 'Ya', NULL),
(78, 4, 73, 'Perjanjian Lisesnsi', 'Tidak', '', 'Ya', NULL),
(79, 4, 74, 'Regulasi', 'Tidak', '', 'Ya', NULL),
(80, 4, 74, 'SOP', 'Tidak', '', 'Ya', NULL),
(81, 4, 72, 'Sub Intermediasi 1', 'Tidak', '', 'Ya', NULL),
(82, 4, 72, 'Sub Intermediasi 2', 'Tidak', '', 'Ya', NULL),
(83, 1, 0, 'Galeri', '', 'galeri', '', 0),
(85, 1, 0, 'Unduh', 'Tidak', 'arsip', 'Ya', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(11) NOT NULL,
  `nama_modul` varchar(50) NOT NULL,
  `link` varchar(40) NOT NULL,
  `gambar` varchar(30) DEFAULT NULL,
  `publish` int(11) NOT NULL,
  `aktif` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msdesainindustri`
--

CREATE TABLE `msdesainindustri` (
  `ID` int(11) NOT NULL,
  `JUDUL` text,
  `UNIT_KERJA` int(11) NOT NULL,
  `NO_HANDPHONE` varchar(50) NOT NULL,
  `IPMAN_CODE` varchar(50) NOT NULL,
  `STATUS` int(11) NOT NULL,
  `PERNAH_DIAJUKAN` int(11) NOT NULL DEFAULT '0',
  `TAHUN_PENDAFTAR` int(11) DEFAULT NULL,
  `TAHUN_GRANTED` int(11) DEFAULT NULL,
  `SERTIFIKASI` date DEFAULT NULL,
  `PEMERIKSA_DESAIN` varchar(50) DEFAULT NULL,
  `KONTAK_PEMERIKSA` varchar(50) DEFAULT NULL,
  `EMAIL_PEMERIKSA` varchar(50) DEFAULT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `NOMOR_DESAIN` varchar(15) DEFAULT NULL,
  `KETERANGAN` text,
  `INDEX` int(11) NOT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL,
  `TGL_UBAH` datetime DEFAULT NULL,
  `KODE_UBAH` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msdesainindustri`
--

INSERT INTO `msdesainindustri` (`ID`, `JUDUL`, `UNIT_KERJA`, `NO_HANDPHONE`, `IPMAN_CODE`, `STATUS`, `PERNAH_DIAJUKAN`, `TAHUN_PENDAFTAR`, `TAHUN_GRANTED`, `SERTIFIKASI`, `PEMERIKSA_DESAIN`, `KONTAK_PEMERIKSA`, `EMAIL_PEMERIKSA`, `NOMOR_PENDAFTAR`, `NOMOR_DESAIN`, `KETERANGAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`, `TGL_UBAH`, `KODE_UBAH`) VALUES
(1, 'asdas', 7, '1', 'DI_0016', 21, 0, NULL, NULL, '0000-00-00', NULL, NULL, NULL, '', NULL, NULL, 0, '2019-08-28 11:39:35', '1', NULL, NULL),
(2, 'vxccvxcv', 6, '123', 'DI_0017', 21, 1, 0, 0, '0000-00-00', NULL, NULL, NULL, '', '', '', 0, '2019-08-28 11:53:32', '1', '2019-08-28 11:54:17', '1'),
(3, 'Tes edit', 6, '0821', 'DI_0018', 19, 0, NULL, NULL, '0000-00-00', NULL, NULL, NULL, '', NULL, NULL, 0, '2019-09-24 02:35:24', '1', '2019-09-24 02:35:46', '1'),
(5, 'n', 5, '0821', 'DI_0020', 20, 1, 2019, 2019, '2019-01-01', 'adi', '0812', 'adi32@gmail.com', '12', '12', 'ket', 0, '2019-09-24 04:31:39', '1', '2019-09-24 04:34:23', '1');

-- --------------------------------------------------------

--
-- Table structure for table `msdokumen`
--

CREATE TABLE `msdokumen` (
  `ID` int(11) NOT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `NAME` varchar(128) NOT NULL,
  `SIZE` float DEFAULT NULL,
  `TYPE` char(15) DEFAULT NULL,
  `REV` tinyint(4) DEFAULT '0',
  `ROLE` int(11) NOT NULL,
  `JENIS_DOKUMEN` int(11) NOT NULL,
  `DOWNLOADABLE` int(11) NOT NULL DEFAULT '0',
  `TGL_INPUT` datetime DEFAULT '0000-00-00 00:00:00',
  `KODE_INPUT` varchar(15) DEFAULT '0',
  `TGL_UBAH` datetime DEFAULT '0000-00-00 00:00:00',
  `KODE_UBAH` varchar(15) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msdokumen`
--

INSERT INTO `msdokumen` (`ID`, `NOMOR_PENDAFTAR`, `NAME`, `SIZE`, `TYPE`, `REV`, `ROLE`, `JENIS_DOKUMEN`, `DOWNLOADABLE`, `TGL_INPUT`, `KODE_INPUT`, `TGL_UBAH`, `KODE_UBAH`) VALUES
(1833, 'MR_0014', 'formulir_pengajuan_MR_0014.pdf', 29.93, '.pdf', 0, 1, 15, 0, '2019-08-22 03:07:37', '1', '0000-00-00 00:00:00', '0'),
(1834, 'MR_0014', 'surat_kepemilikan_hak_MR_00141.pdf', 29.93, '.pdf', 0, 1, 16, 0, '2019-08-22 03:07:37', '1', '2019-08-22 03:08:15', '1'),
(1835, 'MR_0014', 'surat_pengalihan_hak_MR_0014', 0, '', 0, 1, 17, 0, '2019-08-22 03:07:37', '1', '0000-00-00 00:00:00', '0'),
(1836, 'MR_0014', 'bukti_pembayaran_MR_0014', 0, '', 0, 1, 18, 0, '2019-08-22 03:07:37', '1', '0000-00-00 00:00:00', '0'),
(1873, 'DI_0015', 'deskripsi_DI_0015.pdf', 29.93, '.pdf', 0, 1, 21, 1, '2019-08-22 03:37:51', '1', '2019-08-22 03:57:51', '1'),
(1874, 'DI_0015', 'ktp_DI_0015.pdf', 29.93, '.pdf', 0, 1, 22, 0, '2019-08-22 03:37:51', '1', '2019-08-22 03:57:39', '1'),
(1875, 'DI_0015', 'bukti_pembayaran_DI_0015.pdf', 29.93, '.pdf', 0, 1, 23, 0, '2019-08-22 03:37:51', '1', '0000-00-00 00:00:00', '0'),
(1878, 'HC_0009', 'formulir_pengajuan_HC_0009.pdf', 29.93, '.pdf', 0, 1, 19, 0, '2019-08-22 04:01:08', '1', '0000-00-00 00:00:00', '0'),
(1879, 'HC_0009', 'bukti_pembayaran_HC_0009.pdf', 29.93, '.pdf', 0, 1, 20, 0, '2019-08-22 04:01:08', '1', '2019-08-22 04:01:21', '1'),
(2057, 'MR_0014', 'dok_verifikator_1_MR_0014.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-08-23 11:02:52', '1', '0000-00-00 00:00:00', '0'),
(2058, 'MR_0014', 'dok_verifikator_2_MR_0014.pdf', 29.93, '.pdf', 0, 2, 9, 0, '2019-08-23 11:02:52', '1', '0000-00-00 00:00:00', '0'),
(2059, 'MR_0014', 'dok_verifikator_3_MR_00143.pdf', 29.93, '.pdf', 0, 2, 10, 0, '2019-08-23 11:02:52', '1', '0000-00-00 00:00:00', '0'),
(2060, 'MR_0014', 'dok_verifikator_4_MR_0014', 0, '', 0, 2, 11, 0, '2019-08-23 11:02:52', '1', '0000-00-00 00:00:00', '0'),
(2061, 'MR_0014', 'dok_verifikator_5_MR_0014.pdf', 29.93, '.pdf', 0, 2, 12, 0, '2019-08-23 11:02:52', '1', '0000-00-00 00:00:00', '0'),
(2075, 'HC_0009', 'dok_verifikator_1_HC_00094.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-08-24 12:48:17', '1', '0000-00-00 00:00:00', '0'),
(2076, 'HC_0009', 'dok_verifikator_2_HC_0009', 0, '', 0, 2, 9, 0, '2019-08-24 12:48:17', '1', '0000-00-00 00:00:00', '0'),
(2077, 'HC_0009', 'dok_verifikator_3_HC_0009', 0, '', 0, 2, 10, 0, '2019-08-24 12:48:17', '1', '0000-00-00 00:00:00', '0'),
(2078, 'HC_0009', 'dok_verifikator_4_HC_0009', 0, '', 0, 2, 11, 0, '2019-08-24 12:48:17', '1', '0000-00-00 00:00:00', '0'),
(2079, 'HC_0009', 'dok_verifikator_5_HC_0009.pdf', 29.93, '.pdf', 0, 2, 12, 0, '2019-08-24 12:48:17', '1', '0000-00-00 00:00:00', '0'),
(2085, 'DI_0015', 'dok_verifikator_1_DI_0015.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-08-24 01:48:06', '1', '0000-00-00 00:00:00', '0'),
(2086, 'DI_0015', 'dok_verifikator_2_DI_0015.pdf', 29.93, '.pdf', 0, 2, 9, 0, '2019-08-24 01:48:06', '1', '0000-00-00 00:00:00', '0'),
(2087, 'DI_0015', 'dok_verifikator_3_DI_0015', 0, '', 0, 2, 10, 0, '2019-08-24 01:48:06', '1', '0000-00-00 00:00:00', '0'),
(2088, 'DI_0015', 'dok_verifikator_4_DI_0015', 0, '', 0, 2, 11, 0, '2019-08-24 01:48:06', '1', '0000-00-00 00:00:00', '0'),
(2089, 'DI_0015', 'dok_verifikator_5_DI_0015', 0, '', 0, 2, 12, 0, '2019-08-24 01:48:06', '1', '0000-00-00 00:00:00', '0'),
(2109, 'MR_0015', 'formulir_pengajuan_MR_0015.pdf', 29.93, '.pdf', 0, 1, 15, 0, '2019-08-24 12:20:21', '1', '0000-00-00 00:00:00', '0'),
(2110, 'MR_0015', 'surat_kepemilikan_hak_MR_0015.pdf', 29.93, '.pdf', 0, 1, 16, 0, '2019-08-24 12:20:21', '1', '2019-08-26 12:47:38', '1'),
(2111, 'MR_0015', 'surat_pengalihan_hak_MR_0015', 0, '', 0, 1, 17, 0, '2019-08-24 12:20:21', '1', '0000-00-00 00:00:00', '0'),
(2112, 'MR_0015', 'bukti_pembayaran_MR_0015', 0, '', 0, 1, 18, 0, '2019-08-24 12:20:21', '1', '0000-00-00 00:00:00', '0'),
(2122, 'HC_0010', 'formulir_pengajuan_HC_0010.pdf', 29.93, '.pdf', 0, 1, 19, 0, '2019-08-28 10:34:59', '1', '0000-00-00 00:00:00', '0'),
(2123, 'HC_0010', 'bukti_pembayaran_HC_0010.pdf', 29.93, '.pdf', 0, 1, 20, 0, '2019-08-28 10:34:59', '1', '0000-00-00 00:00:00', '0'),
(2124, 'HC_0011', 'formulir_pengajuan_HC_0011.pdf', 29.93, '.pdf', 0, 1, 19, 0, '2019-08-28 10:48:21', '1', '0000-00-00 00:00:00', '0'),
(2125, 'HC_0011', 'bukti_pembayaran_HC_0011', 0, '', 0, 1, 20, 0, '2019-08-28 10:48:21', '1', '0000-00-00 00:00:00', '0'),
(2126, 'DI_0016', 'deskripsi_DI_0016.pdf', 29.93, '.pdf', 0, 1, 21, 0, '2019-08-28 11:39:17', '1', '0000-00-00 00:00:00', '0'),
(2127, 'DI_0016', 'ktp_DI_0016', 0, '', 0, 1, 22, 0, '2019-08-28 11:39:17', '1', '0000-00-00 00:00:00', '0'),
(2128, 'DI_0016', 'bukti_pembayaran_DI_0016', 0, '', 0, 1, 23, 0, '2019-08-28 11:39:17', '1', '0000-00-00 00:00:00', '0'),
(2129, 'DI_0016', 'deskripsi_DI_00161.pdf', 29.93, '.pdf', 0, 1, 21, 0, '2019-08-28 11:39:35', '1', '0000-00-00 00:00:00', '0'),
(2130, 'DI_0016', 'ktp_DI_0016', 0, '', 0, 1, 22, 0, '2019-08-28 11:39:35', '1', '0000-00-00 00:00:00', '0'),
(2131, 'DI_0016', 'bukti_pembayaran_DI_0016', 0, '', 0, 1, 23, 0, '2019-08-28 11:39:35', '1', '0000-00-00 00:00:00', '0'),
(2135, 'DI_0017', 'deskripsi_DI_0017.pdf', 29.93, '.pdf', 0, 1, 21, 1, '2019-08-28 11:53:32', '1', '0000-00-00 00:00:00', '0'),
(2136, 'DI_0017', 'ktp_DI_00171.pdf', 29.93, '.pdf', 0, 1, 22, 0, '2019-08-28 11:53:32', '1', '2019-08-28 11:54:17', '1'),
(2137, 'DI_0017', 'bukti_pembayaran_DI_0017', 0, '', 0, 1, 23, 0, '2019-08-28 11:53:32', '1', '0000-00-00 00:00:00', '0'),
(2138, 'DI_0017', 'dok_verifikator_1_DI_0017', 0, '', 0, 2, 8, 0, '2019-08-28 11:55:16', '1', '0000-00-00 00:00:00', '0'),
(2139, 'DI_0017', 'dok_verifikator_2_DI_0017', 0, '', 0, 2, 9, 0, '2019-08-28 11:55:16', '1', '0000-00-00 00:00:00', '0'),
(2140, 'DI_0017', 'dok_verifikator_3_DI_0017', 0, '', 0, 2, 10, 0, '2019-08-28 11:55:16', '1', '0000-00-00 00:00:00', '0'),
(2141, 'DI_0017', 'dok_verifikator_4_DI_0017', 0, '', 0, 2, 11, 0, '2019-08-28 11:55:16', '1', '0000-00-00 00:00:00', '0'),
(2142, 'DI_0017', 'dok_verifikator_5_DI_0017', 0, '', 0, 2, 12, 0, '2019-08-28 11:55:16', '1', '0000-00-00 00:00:00', '0'),
(2638, 'DI_0018', 'deskripsi_DI_0018.pdf', 29.93, '.pdf', 0, 1, 21, 0, '2019-09-24 02:35:24', '1', '0000-00-00 00:00:00', '0'),
(2639, 'DI_0018', 'ktp_DI_0018', 0, '', 0, 1, 22, 0, '2019-09-24 02:35:24', '1', '0000-00-00 00:00:00', '0'),
(2640, 'DI_0018', 'bukti_pembayaran_DI_0018', 0, '', 0, 1, 23, 0, '2019-09-24 02:35:24', '1', '0000-00-00 00:00:00', '0'),
(2713, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2714, 'PB_0052', 'nodin_PB_0052_v1.pdf', 29.93, '.pdf', 1, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:43:03', '1'),
(2722, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2723, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2755, 'MR_0017', 'formulir_pengajuan_MR_0017_v1.pdf', 29.93, '.pdf', 1, 1, 15, 0, '2019-09-24 04:02:35', '1', '2019-09-24 04:26:29', '1'),
(2756, 'MR_0017', 'surat_kepemilikan_hak_MR_0017.pdf', 29.93, '.pdf', 0, 1, 16, 0, '2019-09-24 04:02:35', '1', '0000-00-00 00:00:00', '0'),
(2757, 'MR_0017', 'surat_pengalihan_hak_MR_0017.pdf', 29.93, '.pdf', 0, 1, 17, 0, '2019-09-24 04:02:35', '1', '2019-09-24 04:03:00', '1'),
(2758, 'MR_0017', 'bukti_pembayaran_MR_0017', 0, '', 0, 1, 18, 0, '2019-09-24 04:02:35', '1', '0000-00-00 00:00:00', '0'),
(2763, 'HC_0012', 'formulir_pengajuan_HC_0012_v1.pdf', 29.93, '.pdf', 1, 1, 19, 0, '2019-09-24 04:28:08', '1', '2019-09-24 04:28:53', '1'),
(2764, 'HC_0012', 'bukti_pembayaran_HC_0012.pdf', 29.93, '.pdf', 0, 1, 20, 0, '2019-09-24 04:28:08', '1', '0000-00-00 00:00:00', '0'),
(2780, 'DI_0020', 'deskripsi_DI_0020_v1.pdf', 29.93, '.pdf', 1, 1, 21, 0, '2019-09-24 04:31:39', '1', '2019-09-24 04:31:53', '1'),
(2781, 'DI_0020', 'ktp_DI_0020.pdf', 29.93, '.pdf', 1, 1, 22, 0, '2019-09-24 04:31:39', '1', '2019-09-24 04:31:53', '1'),
(2782, 'DI_0020', 'bukti_pembayaran_DI_0020_v2.pdf', 29.93, '.pdf', 2, 1, 23, 0, '2019-09-24 04:31:39', '1', '2019-09-24 04:34:23', '1'),
(2792, 'PB_0053', 'deskripsi_PB_0053_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2794, 'PB_0053', 'surat_kepemilikan_hak_PB_0053.pdf', 29.93, '.pdf', 1, 1, 3, 0, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2801, 'PB_0053', 'deskripsi_PB_0053_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2803, 'PB_0053', 'surat_kepemilikan_hak_PB_0053.pdf', 29.93, '.pdf', 1, 1, 3, 0, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2810, 'PB_0053', 'deskripsi_PB_0053_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2812, 'PB_0053', 'surat_kepemilikan_hak_PB_0053.pdf', 29.93, '.pdf', 1, 1, 3, 0, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2819, 'PB_0053', 'deskripsi_PB_0053_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2820, 'PB_0053', 'nodin_PB_0053.pdf', 29.93, '.pdf', 0, 1, 2, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2821, 'PB_0053', 'surat_kepemilikan_hak_PB_0053.pdf', 29.93, '.pdf', 1, 1, 3, 0, '2019-09-24 04:40:26', '1', '2019-09-24 04:41:28', '1'),
(2822, 'PB_0053', 'surat_pengalihan_hak_PB_0053.pdf', 29.93, '.pdf', 0, 1, 4, 0, '2019-09-24 04:40:26', '1', '2019-09-24 05:16:48', '1'),
(2823, 'PB_0053', 'ktp_PB_0053', 0, '', 0, 1, 5, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2824, 'PB_0053', 'identifikasi_invensi_PB_0053', 0, '', 0, 1, 6, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2825, 'PB_0053', 'valuasi_atb_PB_0053', 0, '', 0, 1, 7, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2826, 'PB_0053', 'dokumen_lain_1_PB_0053', 0, '', 0, 1, 13, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2827, 'PB_0053', 'dokumen_lain_2_PB_0053', 0, '', 0, 1, 14, 0, '2019-09-24 04:40:26', '1', '0000-00-00 00:00:00', '0'),
(2837, 'PB_0054', 'deskripsi_PB_0054_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-09-24 05:18:02', '1', '2019-09-24 05:18:48', '1'),
(2838, 'PB_0054', 'nodin_PB_0054.pdf', 29.93, '.pdf', 0, 1, 2, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2839, 'PB_0054', 'surat_kepemilikan_hak_PB_0054.pdf', 29.93, '.pdf', 0, 1, 3, 0, '2019-09-24 05:18:02', '1', '2019-09-24 05:18:48', '1'),
(2840, 'PB_0054', 'surat_pengalihan_hak_PB_0054', 0, '', 0, 1, 4, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2841, 'PB_0054', 'ktp_PB_0054', 0, '', 0, 1, 5, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2842, 'PB_0054', 'identifikasi_invensi_PB_0054', 0, '', 0, 1, 6, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2843, 'PB_0054', 'valuasi_atb_PB_0054', 0, '', 0, 1, 7, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2844, 'PB_0054', 'dokumen_lain_1_PB_0054', 0, '', 0, 1, 13, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2845, 'PB_0054', 'dokumen_lain_2_PB_0054', 0, '', 0, 1, 14, 0, '2019-09-24 05:18:02', '1', '0000-00-00 00:00:00', '0'),
(2846, 'PB_0054', 'dok_verifikator_1_PB_0054.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-09-24 05:28:48', '1', '0000-00-00 00:00:00', '0'),
(2847, 'PB_0054', 'dok_verifikator_2_PB_0054', 0, '', 0, 2, 9, 0, '2019-09-24 05:28:48', '1', '0000-00-00 00:00:00', '0'),
(2848, 'PB_0054', 'dok_verifikator_3_PB_0054', 0, '', 0, 2, 10, 0, '2019-09-24 05:28:48', '1', '0000-00-00 00:00:00', '0'),
(2849, 'PB_0054', 'dok_verifikator_4_PB_0054', 0, '', 0, 2, 11, 0, '2019-09-24 05:28:48', '1', '0000-00-00 00:00:00', '0'),
(2850, 'PB_0054', 'dok_verifikator_5_PB_0054', 0, '', 0, 2, 12, 0, '2019-09-24 05:28:48', '1', '0000-00-00 00:00:00', '0'),
(2851, 'MR_0017', 'dok_verifikator_1_MR_0017.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-09-24 05:40:15', '1', '0000-00-00 00:00:00', '0'),
(2852, 'MR_0017', 'dok_verifikator_2_MR_0017', 0, '', 0, 2, 9, 0, '2019-09-24 05:40:15', '1', '0000-00-00 00:00:00', '0'),
(2853, 'MR_0017', 'dok_verifikator_3_MR_0017', 0, '', 0, 2, 10, 0, '2019-09-24 05:40:15', '1', '0000-00-00 00:00:00', '0'),
(2854, 'MR_0017', 'dok_verifikator_4_MR_0017', 0, '', 0, 2, 11, 0, '2019-09-24 05:40:15', '1', '0000-00-00 00:00:00', '0'),
(2855, 'MR_0017', 'dok_verifikator_5_MR_0017', 0, '', 0, 2, 12, 0, '2019-09-24 05:40:15', '1', '0000-00-00 00:00:00', '0'),
(2866, 'HC_0012', 'dok_verifikator_1_HC_00121.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-09-24 06:13:57', '1', '0000-00-00 00:00:00', '0'),
(2867, 'HC_0012', 'dok_verifikator_2_HC_0012', 0, '', 0, 2, 9, 0, '2019-09-24 06:13:57', '1', '0000-00-00 00:00:00', '0'),
(2868, 'HC_0012', 'dok_verifikator_3_HC_0012', 0, '', 0, 2, 10, 0, '2019-09-24 06:13:57', '1', '0000-00-00 00:00:00', '0'),
(2869, 'HC_0012', 'dok_verifikator_4_HC_0012', 0, '', 0, 2, 11, 0, '2019-09-24 06:13:57', '1', '0000-00-00 00:00:00', '0'),
(2870, 'HC_0012', 'dok_verifikator_5_HC_0012', 0, '', 0, 2, 12, 0, '2019-09-24 06:13:57', '1', '0000-00-00 00:00:00', '0'),
(2871, 'DI_0020', 'dok_verifikator_1_DI_0020.pdf', 29.93, '.pdf', 0, 2, 8, 0, '2019-09-24 06:26:41', '1', '0000-00-00 00:00:00', '0'),
(2872, 'DI_0020', 'dok_verifikator_2_DI_0020', 0, '', 0, 2, 9, 0, '2019-09-24 06:26:41', '1', '0000-00-00 00:00:00', '0'),
(2873, 'DI_0020', 'dok_verifikator_3_DI_0020', 0, '', 0, 2, 10, 0, '2019-09-24 06:26:41', '1', '0000-00-00 00:00:00', '0'),
(2874, 'DI_0020', 'dok_verifikator_4_DI_0020', 0, '', 0, 2, 11, 0, '2019-09-24 06:26:41', '1', '0000-00-00 00:00:00', '0'),
(2875, 'DI_0020', 'dok_verifikator_5_DI_0020', 0, '', 0, 2, 12, 0, '2019-09-24 06:26:41', '1', '0000-00-00 00:00:00', '0'),
(2876, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2877, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2885, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2886, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2894, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2895, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2903, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2904, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2912, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2913, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2921, 'PB_0052', 'deskripsi_PB_0052_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-09-24 03:39:01', '1', '2019-09-24 03:41:46', '1'),
(2922, 'PB_0052', 'nodin_PB_0052_v2.pdf', 30.29, '.pdf', 2, 1, 2, 0, '2019-09-24 03:39:01', '1', '2019-09-24 03:45:45', '1'),
(2923, 'PB_0052', 'surat_kepemilikan_hak_PB_0052', 0, '', 0, 1, 3, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2924, 'PB_0052', 'surat_pengalihan_hak_PB_0052', 0, '', 0, 1, 4, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2925, 'PB_0052', 'ktp_PB_0052', 0, '', 0, 1, 5, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2926, 'PB_0052', 'identifikasi_invensi_PB_0052', 0, '', 0, 1, 6, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2927, 'PB_0052', 'valuasi_atb_PB_0052', 0, '', 0, 1, 7, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2928, 'PB_0052', 'dokumen_lain_1_PB_0052', 0, '', 0, 1, 13, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2929, 'PB_0052', 'dokumen_lain_2_PB_0052', 0, '', 0, 1, 14, 0, '2019-09-24 03:39:01', '1', '0000-00-00 00:00:00', '0'),
(2939, 'PB_0055', 'PB_0055_deskripsi_v1.pdf', 29.93, '.pdf', 1, 1, 1, 1, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2940, 'PB_0055', 'PB_0055_nodin_v1.pdf', 29.93, '.pdf', 1, 1, 2, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2941, 'PB_0055', 'PB_0055_surat_kepemilikan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 3, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2942, 'PB_0055', 'PB_0055_surat_pengalihan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 4, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2943, 'PB_0055', 'PB_0055_ktp_v1.pdf', 29.93, '.pdf', 1, 1, 5, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2944, 'PB_0055', 'PB_0055_identifikasi_invensi_v1.pdf', 29.93, '.pdf', 1, 1, 6, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2945, 'PB_0055', 'PB_0055_valuasi_atb_v1.pdf', 29.93, '.pdf', 1, 1, 7, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2948, 'PB_0055', 'PB_0055_deskripsi_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2949, 'PB_0055', 'PB_0055_nodin_v2.pdf', 29.93, '.pdf', 2, 1, 2, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2950, 'PB_0055', 'PB_0055_surat_kepemilikan_hak_v2.pdf', 29.93, '.pdf', 2, 1, 3, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2951, 'PB_0055', 'PB_0055_surat_pengalihan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 4, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2952, 'PB_0055', 'PB_0055_ktp_v2.pdf', 29.93, '.pdf', 2, 1, 5, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2953, 'PB_0055', 'PB_0055_identifikasi_invensi_v2.pdf', 29.93, '.pdf', 2, 1, 6, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2954, 'PB_0055', 'PB_0055_valuasi_atb_v2.pdf', 29.93, '.pdf', 2, 1, 7, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2957, 'PB_0055', 'PB_0055_deskripsi_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2958, 'PB_0055', 'PB_0055_nodin_v2.pdf', 29.93, '.pdf', 2, 1, 2, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2959, 'PB_0055', 'PB_0055_surat_kepemilikan_hak_v2.pdf', 29.93, '.pdf', 2, 1, 3, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2960, 'PB_0055', 'PB_0055_surat_pengalihan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 4, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2961, 'PB_0055', 'PB_0055_ktp_v2.pdf', 29.93, '.pdf', 2, 1, 5, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2962, 'PB_0055', 'PB_0055_identifikasi_invensi_v2.pdf', 29.93, '.pdf', 2, 1, 6, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2963, 'PB_0055', 'PB_0055_valuasi_atb_v2.pdf', 29.93, '.pdf', 2, 1, 7, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2966, 'PB_0055', 'PB_0055_deskripsi_v2.pdf', 29.93, '.pdf', 2, 1, 1, 1, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2967, 'PB_0055', 'PB_0055_nodin_v2.pdf', 29.93, '.pdf', 2, 1, 2, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2968, 'PB_0055', 'PB_0055_surat_kepemilikan_hak_v2.pdf', 29.93, '.pdf', 2, 1, 3, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2969, 'PB_0055', 'PB_0055_surat_pengalihan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 4, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:15:27', '12'),
(2970, 'PB_0055', 'PB_0055_ktp_v2.pdf', 29.93, '.pdf', 2, 1, 5, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2971, 'PB_0055', 'PB_0055_identifikasi_invensi_v2.pdf', 29.93, '.pdf', 2, 1, 6, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2972, 'PB_0055', 'PB_0055_valuasi_atb_v2.pdf', 29.93, '.pdf', 2, 1, 7, 0, '2019-10-10 08:12:45', '12', '2019-10-10 08:19:23', '12'),
(2973, 'PB_0055', 'dokumen_lain_1_PB_0055', 0, '', 0, 1, 13, 0, '2019-10-10 08:12:45', '12', '0000-00-00 00:00:00', '0'),
(2974, 'PB_0055', 'dokumen_lain_2_PB_0055', 0, '', 0, 1, 14, 0, '2019-10-10 08:12:45', '12', '0000-00-00 00:00:00', '0'),
(2979, 'MR_0018', 'MR_0018_formulir_pengajuan_v1.pdf', 29.93, '.pdf', 1, 1, 15, 0, '2019-10-10 08:27:43', '12', '2019-10-10 08:28:27', '12'),
(2980, 'MR_0018', 'MR_0018_surat_kepemilikan_hak_v1.pdf', 29.93, '.pdf', 1, 1, 16, 0, '2019-10-10 08:27:43', '12', '2019-10-10 08:28:27', '12'),
(2983, 'MR_0018', 'MR_0018_formulir_pengajuan_v1.pdf', 29.93, '.pdf', 1, 1, 15, 0, '2019-10-10 08:27:43', '12', '2019-10-10 08:28:27', '12'),
(2984, 'MR_0018', 'MR_0018_surat_kepemilikan_hak_v2.pdf', 29.93, '.pdf', 2, 1, 16, 0, '2019-10-10 08:27:43', '12', '2019-10-10 08:33:08', '12'),
(2985, 'MR_0018', 'MR_0018_surat_pengalihan_hak.pdf', 29.93, '.pdf', 0, 1, 17, 0, '2019-10-10 08:27:43', '12', '0000-00-00 00:00:00', '0'),
(2986, 'MR_0018', 'MR_0018_bukti_pembayaran.pdf', 29.93, '.pdf', 0, 1, 18, 0, '2019-10-10 08:27:43', '12', '0000-00-00 00:00:00', '0'),
(2991, 'MR_0019', 'MR_0019_formulir_pengajuan_v1.pdf', 29.93, '.pdf', 1, 1, 15, 0, '2019-10-10 08:33:39', '12', '2019-10-10 08:33:56', '12'),
(2992, 'MR_0019', 'MR_0019_surat_kepemilikan_hak', 0, '', 0, 1, 16, 0, '2019-10-10 08:33:39', '12', '0000-00-00 00:00:00', '0'),
(2993, 'MR_0019', 'MR_0019_surat_pengalihan_hak', 0, '', 0, 1, 17, 0, '2019-10-10 08:33:39', '12', '0000-00-00 00:00:00', '0'),
(2994, 'MR_0019', 'MR_0019_bukti_pembayaran', 0, '', 0, 1, 18, 0, '2019-10-10 08:33:39', '12', '0000-00-00 00:00:00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mshakcipta`
--

CREATE TABLE `mshakcipta` (
  `ID` int(11) NOT NULL,
  `JUDUL` text,
  `OBJECT` int(11) NOT NULL,
  `UNIT_KERJA` int(11) NOT NULL,
  `NO_HANDPHONE` varchar(50) NOT NULL,
  `IPMAN_CODE` varchar(50) NOT NULL,
  `NOMOR_PENCATAT` varchar(15) DEFAULT NULL,
  `NOMOR_HAKCIPTA` varchar(15) DEFAULT NULL,
  `SERTIFIKASI` date DEFAULT NULL,
  `PEMERIKSA_HAKCIPTA` varchar(50) DEFAULT NULL,
  `KONTAK_PEMERIKSA` varchar(50) DEFAULT NULL,
  `EMAIL_PEMERIKSA` varchar(50) DEFAULT NULL,
  `TGL_PERMOHONAN` date DEFAULT NULL,
  `TGL_PUBLISH` date DEFAULT NULL,
  `LOKASI` varchar(20) DEFAULT NULL,
  `STATUS` int(11) NOT NULL,
  `PERNAH_DIAJUKAN` int(11) NOT NULL DEFAULT '0',
  `KETERANGAN` text,
  `INDEX` int(11) NOT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL,
  `TGL_UBAH` datetime DEFAULT NULL,
  `KODE_UBAH` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mshakcipta`
--

INSERT INTO `mshakcipta` (`ID`, `JUDUL`, `OBJECT`, `UNIT_KERJA`, `NO_HANDPHONE`, `IPMAN_CODE`, `NOMOR_PENCATAT`, `NOMOR_HAKCIPTA`, `SERTIFIKASI`, `PEMERIKSA_HAKCIPTA`, `KONTAK_PEMERIKSA`, `EMAIL_PEMERIKSA`, `TGL_PERMOHONAN`, `TGL_PUBLISH`, `LOKASI`, `STATUS`, `PERNAH_DIAJUKAN`, `KETERANGAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`, `TGL_UBAH`, `KODE_UBAH`) VALUES
(8, 'sdfdsf', 12, 6, '2', 'HC_0006', '123', '123', '2019-09-24', 'ADI', '0812', 'adi32@gmail.com', '2019-09-25', '2019-09-24', NULL, 20, 0, 'ket', 0, '2019-07-08 11:22:47', '1', '2019-07-08 11:25:03', '1'),
(11, 'ASD', 12, 6, '1', 'HC_0009', '123', '123', '2019-09-24', 'ADI', '0812', 'adi32@gmail.com', '2019-09-25', '2019-09-24', NULL, 20, 0, 'ket', 0, '2019-08-22 04:01:08', '1', '2019-08-22 04:01:21', '1'),
(12, 'asdasd', 13, 6, '12312', 'HC_0010', '123', '123', '2019-09-24', 'ADI', '0812', 'adi32@gmail.com', '2019-09-25', '2019-09-24', NULL, 20, 1, 'ket', 0, '2019-08-28 10:34:59', '1', NULL, NULL),
(13, 'asdas', 13, 6, '11', 'HC_0011', '123', '123', '2019-09-24', 'ADI', '0812', 'adi32@gmail.com', '2019-09-25', '2019-09-24', NULL, 20, 0, 'ket', 0, '2019-08-28 10:48:22', '1', NULL, NULL),
(14, 'j', 12, 6, '0821', 'HC_0012', '123', '123', '2019-09-24', 'ADI', '0812', 'adi32@gmail.com', '2019-09-25', '2019-09-24', NULL, 20, 1, 'ket', 0, '2019-09-24 04:28:08', '1', '2019-09-24 04:28:53', '1');

-- --------------------------------------------------------

--
-- Table structure for table `msipmancode`
--

CREATE TABLE `msipmancode` (
  `ID` int(11) NOT NULL,
  `KODE` char(11) DEFAULT NULL,
  `ID_JENIS` int(11) DEFAULT NULL,
  `JENIS_KI` varchar(50) DEFAULT NULL,
  `NO_URUT` int(10) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msipmancode`
--

INSERT INTO `msipmancode` (`ID`, `KODE`, `ID_JENIS`, `JENIS_KI`, `NO_URUT`) VALUES
(1, 'PB', 24, 'Paten Biasa', 0000000056),
(3, 'PS', 25, 'Paten Sederhana', 0000000022),
(4, 'DI', NULL, 'Desain Industri', 0000000021),
(5, 'MR', NULL, 'Merek', 0000000020),
(6, 'HC', NULL, 'Hak Cipta', 0000000013),
(7, 'DT', NULL, 'Desain Tata Letak Siskuit Terpadu ', 0000000001);

-- --------------------------------------------------------

--
-- Table structure for table `msjenisdokumen`
--

CREATE TABLE `msjenisdokumen` (
  `ID` int(11) NOT NULL,
  `ID_HAKI` int(11) NOT NULL DEFAULT '0',
  `ID_ROLE` int(11) NOT NULL DEFAULT '0',
  `JENIS_DOKUMEN` varchar(70) NOT NULL,
  `PENAMAAN_FILE` varchar(50) DEFAULT NULL,
  `DOWNLOADABLE` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `msjenisdokumen`
--

INSERT INTO `msjenisdokumen` (`ID`, `ID_HAKI`, `ID_ROLE`, `JENIS_DOKUMEN`, `PENAMAAN_FILE`, `DOWNLOADABLE`) VALUES
(1, 1, 1, 'Deskripsi', 'deskripsi', 1),
(2, 1, 1, 'Nodin', 'nodin', 0),
(3, 1, 1, 'Surat Pernyataan Kepemilikan Hak', 'surat_kepemilikan_hak', 0),
(4, 1, 1, 'Surat Pernyataan Pengalihan Hak', 'surat_pengalihan_hak', 0),
(5, 1, 1, 'KTP', 'ktp', 0),
(6, 1, 1, 'Identifikasi Invensi', 'identifikasi_invensi', 0),
(7, 1, 1, 'Valuasi ATB', 'valuasi_atb', 0),
(8, 1, 2, 'Dokumen Verifikator 1', 'dok_verifikator_1', 0),
(9, 1, 2, 'Dokumen Verifikator 2', 'dok_verifikator_2', 0),
(10, 1, 2, 'Dokumen Verifikator 3', 'dok_verifikator_3', 0),
(11, 1, 2, 'Dokumen Verifikator 4', 'dok_verifikator_4', 0),
(12, 1, 2, 'Dokumen Verifikator 5', 'dok_verifikator_5', 0),
(13, 1, 1, 'Dokumen Lainnya 1', 'dokumen_lain_1', 0),
(14, 1, 1, 'Dokumen Lainnya 2', 'dokumen_lain_2', 0),
(15, 2, 1, 'Formulir Pengajuan', 'formulir_pengajuan', 0),
(16, 2, 1, 'Surat Pernyataan Kepemilikan Hak', 'surat_kepemilikan_hak', 0),
(17, 2, 1, 'Surat Pernyataan Pengalihan Hak', 'surat_pengalihan_hak', 0),
(18, 2, 1, 'Bukti Pembayaran', 'bukti_pembayaran', 0),
(19, 3, 1, 'Formulir Pengajuan', 'formulir_pengajuan', 0),
(20, 3, 1, 'Bukti Pembayaran', 'bukti_pembayaran', 0),
(21, 4, 1, 'Deskripsi', 'deskripsi', 0),
(22, 4, 1, 'KTP', 'ktp', 0),
(23, 4, 1, 'Bukti Pembayaran', 'bukti_pembayaran', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mskonseptor`
--

CREATE TABLE `mskonseptor` (
  `ID` int(11) NOT NULL,
  `NIK` varchar(20) NOT NULL,
  `NAMA` varchar(50) NOT NULL,
  `ALAMAT` varchar(200) NOT NULL,
  `TELEPON` varchar(20) NOT NULL,
  `EMAIL` varchar(40) NOT NULL,
  `INSTANSI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mskonseptor`
--

INSERT INTO `mskonseptor` (`ID`, `NIK`, `NAMA`, `ALAMAT`, `TELEPON`, `EMAIL`, `INSTANSI`) VALUES
(1, '321', 'Abdul', 'Bekasi', '082112345678', 'abdul02@gmail.com', 'Instansi 1'),
(2, '322', 'Bambang', 'Jakarta', '085745677654', 'bambang009@gmail.com', 'Instansi 2'),
(3, '333', 'Reza', 'Bekasi', '081519198765', 'rezarez@gmail.com', 'Instansi 3');

-- --------------------------------------------------------

--
-- Table structure for table `mskota`
--

CREATE TABLE `mskota` (
  `id_kota` int(11) NOT NULL,
  `id_prov` int(11) DEFAULT NULL,
  `nama` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mskota`
--

INSERT INTO `mskota` (`id_kota`, `id_prov`, `nama`) VALUES
(1101, 11, 'KABUPATEN SIMEULUE'),
(1102, 11, 'KABUPATEN ACEH SINGKIL'),
(1103, 11, 'KABUPATEN ACEH SELATAN'),
(1104, 11, 'KABUPATEN ACEH TENGGARA'),
(1105, 11, 'KABUPATEN ACEH TIMUR'),
(1106, 11, 'KABUPATEN ACEH TENGAH'),
(1107, 11, 'KABUPATEN ACEH BARAT'),
(1108, 11, 'KABUPATEN ACEH BESAR'),
(1109, 11, 'KABUPATEN PIDIE'),
(1110, 11, 'KABUPATEN BIREUEN'),
(1111, 11, 'KABUPATEN ACEH UTARA'),
(1112, 11, 'KABUPATEN ACEH BARAT DAYA'),
(1113, 11, 'KABUPATEN GAYO LUES'),
(1114, 11, 'KABUPATEN ACEH TAMIANG'),
(1115, 11, 'KABUPATEN NAGAN RAYA'),
(1116, 11, 'KABUPATEN ACEH JAYA'),
(1117, 11, 'KABUPATEN BENER MERIAH'),
(1118, 11, 'KABUPATEN PIDIE JAYA'),
(1171, 11, 'KOTA BANDA ACEH'),
(1172, 11, 'KOTA SABANG'),
(1173, 11, 'KOTA LANGSA'),
(1174, 11, 'KOTA LHOKSEUMAWE'),
(1175, 11, 'KOTA SUBULUSSALAM'),
(1201, 12, 'KABUPATEN NIAS'),
(1202, 12, 'KABUPATEN MANDAILING NATAL'),
(1203, 12, 'KABUPATEN TAPANULI SELATAN'),
(1204, 12, 'KABUPATEN TAPANULI TENGAH'),
(1205, 12, 'KABUPATEN TAPANULI UTARA'),
(1206, 12, 'KABUPATEN TOBA SAMOSIR'),
(1207, 12, 'KABUPATEN LABUHAN BATU'),
(1208, 12, 'KABUPATEN ASAHAN'),
(1209, 12, 'KABUPATEN SIMALUNGUN'),
(1210, 12, 'KABUPATEN DAIRI'),
(1211, 12, 'KABUPATEN KARO'),
(1212, 12, 'KABUPATEN DELI SERDANG'),
(1213, 12, 'KABUPATEN LANGKAT'),
(1214, 12, 'KABUPATEN NIAS SELATAN'),
(1215, 12, 'KABUPATEN HUMBANG HASUNDUTAN'),
(1216, 12, 'KABUPATEN PAKPAK BHARAT'),
(1217, 12, 'KABUPATEN SAMOSIR'),
(1218, 12, 'KABUPATEN SERDANG BEDAGAI'),
(1219, 12, 'KABUPATEN BATU BARA'),
(1220, 12, 'KABUPATEN PADANG LAWAS UTARA'),
(1221, 12, 'KABUPATEN PADANG LAWAS'),
(1222, 12, 'KABUPATEN LABUHAN BATU SELATAN'),
(1223, 12, 'KABUPATEN LABUHAN BATU UTARA'),
(1224, 12, 'KABUPATEN NIAS UTARA'),
(1225, 12, 'KABUPATEN NIAS BARAT'),
(1271, 12, 'KOTA SIBOLGA'),
(1272, 12, 'KOTA TANJUNG BALAI'),
(1273, 12, 'KOTA PEMATANG SIANTAR'),
(1274, 12, 'KOTA TEBING TINGGI'),
(1275, 12, 'KOTA MEDAN'),
(1276, 12, 'KOTA BINJAI'),
(1277, 12, 'KOTA PADANGSIDIMPUAN'),
(1278, 12, 'KOTA GUNUNGSITOLI'),
(1301, 13, 'KABUPATEN KEPULAUAN MENTAWAI'),
(1302, 13, 'KABUPATEN PESISIR SELATAN'),
(1303, 13, 'KABUPATEN SOLOK'),
(1304, 13, 'KABUPATEN SIJUNJUNG'),
(1305, 13, 'KABUPATEN TANAH DATAR'),
(1306, 13, 'KABUPATEN PADANG PARIAMAN'),
(1307, 13, 'KABUPATEN AGAM'),
(1308, 13, 'KABUPATEN LIMA PULUH KOTA'),
(1309, 13, 'KABUPATEN PASAMAN'),
(1310, 13, 'KABUPATEN SOLOK SELATAN'),
(1311, 13, 'KABUPATEN DHARMASRAYA'),
(1312, 13, 'KABUPATEN PASAMAN BARAT'),
(1371, 13, 'KOTA PADANG'),
(1372, 13, 'KOTA SOLOK'),
(1373, 13, 'KOTA SAWAH LUNTO'),
(1374, 13, 'KOTA PADANG PANJANG'),
(1375, 13, 'KOTA BUKITTINGGI'),
(1376, 13, 'KOTA PAYAKUMBUH'),
(1377, 13, 'KOTA PARIAMAN'),
(1401, 14, 'KABUPATEN KUANTAN SINGINGI'),
(1402, 14, 'KABUPATEN INDRAGIRI HULU'),
(1403, 14, 'KABUPATEN INDRAGIRI HILIR'),
(1404, 14, 'KABUPATEN PELALAWAN'),
(1405, 14, 'KABUPATEN S I A K'),
(1406, 14, 'KABUPATEN KAMPAR'),
(1407, 14, 'KABUPATEN ROKAN HULU'),
(1408, 14, 'KABUPATEN BENGKALIS'),
(1409, 14, 'KABUPATEN ROKAN HILIR'),
(1410, 14, 'KABUPATEN KEPULAUAN MERANTI'),
(1471, 14, 'KOTA PEKANBARU'),
(1473, 14, 'KOTA D U M A I'),
(1501, 15, 'KABUPATEN KERINCI'),
(1502, 15, 'KABUPATEN MERANGIN'),
(1503, 15, 'KABUPATEN SAROLANGUN'),
(1504, 15, 'KABUPATEN BATANG HARI'),
(1505, 15, 'KABUPATEN MUARO JAMBI'),
(1506, 15, 'KABUPATEN TANJUNG JABUNG TIMUR'),
(1507, 15, 'KABUPATEN TANJUNG JABUNG BARAT'),
(1508, 15, 'KABUPATEN TEBO'),
(1509, 15, 'KABUPATEN BUNGO'),
(1571, 15, 'KOTA JAMBI'),
(1572, 15, 'KOTA SUNGAI PENUH'),
(1601, 16, 'KABUPATEN OGAN KOMERING ULU'),
(1602, 16, 'KABUPATEN OGAN KOMERING ILIR'),
(1603, 16, 'KABUPATEN MUARA ENIM'),
(1604, 16, 'KABUPATEN LAHAT'),
(1605, 16, 'KABUPATEN MUSI RAWAS'),
(1606, 16, 'KABUPATEN MUSI BANYUASIN'),
(1607, 16, 'KABUPATEN BANYU ASIN'),
(1608, 16, 'KABUPATEN OGAN KOMERING ULU SELATAN'),
(1609, 16, 'KABUPATEN OGAN KOMERING ULU TIMUR'),
(1610, 16, 'KABUPATEN OGAN ILIR'),
(1611, 16, 'KABUPATEN EMPAT LAWANG'),
(1612, 16, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR'),
(1613, 16, 'KABUPATEN MUSI RAWAS UTARA'),
(1671, 16, 'KOTA PALEMBANG'),
(1672, 16, 'KOTA PRABUMULIH'),
(1673, 16, 'KOTA PAGAR ALAM'),
(1674, 16, 'KOTA LUBUKLINGGAU'),
(1701, 17, 'KABUPATEN BENGKULU SELATAN'),
(1702, 17, 'KABUPATEN REJANG LEBONG'),
(1703, 17, 'KABUPATEN BENGKULU UTARA'),
(1704, 17, 'KABUPATEN KAUR'),
(1705, 17, 'KABUPATEN SELUMA'),
(1706, 17, 'KABUPATEN MUKOMUKO'),
(1707, 17, 'KABUPATEN LEBONG'),
(1708, 17, 'KABUPATEN KEPAHIANG'),
(1709, 17, 'KABUPATEN BENGKULU TENGAH'),
(1771, 17, 'KOTA BENGKULU'),
(1801, 18, 'KABUPATEN LAMPUNG BARAT'),
(1802, 18, 'KABUPATEN TANGGAMUS'),
(1803, 18, 'KABUPATEN LAMPUNG SELATAN'),
(1804, 18, 'KABUPATEN LAMPUNG TIMUR'),
(1805, 18, 'KABUPATEN LAMPUNG TENGAH'),
(1806, 18, 'KABUPATEN LAMPUNG UTARA'),
(1807, 18, 'KABUPATEN WAY KANAN'),
(1808, 18, 'KABUPATEN TULANGBAWANG'),
(1809, 18, 'KABUPATEN PESAWARAN'),
(1810, 18, 'KABUPATEN PRINGSEWU'),
(1811, 18, 'KABUPATEN MESUJI'),
(1812, 18, 'KABUPATEN TULANG BAWANG BARAT'),
(1813, 18, 'KABUPATEN PESISIR BARAT'),
(1871, 18, 'KOTA BANDAR LAMPUNG'),
(1872, 18, 'KOTA METRO'),
(1901, 19, 'KABUPATEN BANGKA'),
(1902, 19, 'KABUPATEN BELITUNG'),
(1903, 19, 'KABUPATEN BANGKA BARAT'),
(1904, 19, 'KABUPATEN BANGKA TENGAH'),
(1905, 19, 'KABUPATEN BANGKA SELATAN'),
(1906, 19, 'KABUPATEN BELITUNG TIMUR'),
(1971, 19, 'KOTA PANGKAL PINANG'),
(2101, 21, 'KABUPATEN KARIMUN'),
(2102, 21, 'KABUPATEN BINTAN'),
(2103, 21, 'KABUPATEN NATUNA'),
(2104, 21, 'KABUPATEN LINGGA'),
(2105, 21, 'KABUPATEN KEPULAUAN ANAMBAS'),
(2171, 21, 'KOTA B A T A M'),
(2172, 21, 'KOTA TANJUNG PINANG'),
(3101, 31, 'KABUPATEN KEPULAUAN SERIBU'),
(3171, 31, 'KOTA JAKARTA SELATAN'),
(3172, 31, 'KOTA JAKARTA TIMUR'),
(3173, 31, 'KOTA JAKARTA PUSAT'),
(3174, 31, 'KOTA JAKARTA BARAT'),
(3175, 31, 'KOTA JAKARTA UTARA'),
(3201, 32, 'KABUPATEN BOGOR'),
(3202, 32, 'KABUPATEN SUKABUMI'),
(3203, 32, 'KABUPATEN CIANJUR'),
(3204, 32, 'KABUPATEN BANDUNG'),
(3205, 32, 'KABUPATEN GARUT'),
(3206, 32, 'KABUPATEN TASIKMALAYA'),
(3207, 32, 'KABUPATEN CIAMIS'),
(3208, 32, 'KABUPATEN KUNINGAN'),
(3209, 32, 'KABUPATEN CIREBON'),
(3210, 32, 'KABUPATEN MAJALENGKA'),
(3211, 32, 'KABUPATEN SUMEDANG'),
(3212, 32, 'KABUPATEN INDRAMAYU'),
(3213, 32, 'KABUPATEN SUBANG'),
(3214, 32, 'KABUPATEN PURWAKARTA'),
(3215, 32, 'KABUPATEN KARAWANG'),
(3216, 32, 'KABUPATEN BEKASI'),
(3217, 32, 'KABUPATEN BANDUNG BARAT'),
(3218, 32, 'KABUPATEN PANGANDARAN'),
(3271, 32, 'KOTA BOGOR'),
(3272, 32, 'KOTA SUKABUMI'),
(3273, 32, 'KOTA BANDUNG'),
(3274, 32, 'KOTA CIREBON'),
(3275, 32, 'KOTA BEKASI'),
(3276, 32, 'KOTA DEPOK'),
(3277, 32, 'KOTA CIMAHI'),
(3278, 32, 'KOTA TASIKMALAYA'),
(3279, 32, 'KOTA BANJAR'),
(3301, 33, 'KABUPATEN CILACAP'),
(3302, 33, 'KABUPATEN BANYUMAS'),
(3303, 33, 'KABUPATEN PURBALINGGA'),
(3304, 33, 'KABUPATEN BANJARNEGARA'),
(3305, 33, 'KABUPATEN KEBUMEN'),
(3306, 33, 'KABUPATEN PURWOREJO'),
(3307, 33, 'KABUPATEN WONOSOBO'),
(3308, 33, 'KABUPATEN MAGELANG'),
(3309, 33, 'KABUPATEN BOYOLALI'),
(3310, 33, 'KABUPATEN KLATEN'),
(3311, 33, 'KABUPATEN SUKOHARJO'),
(3312, 33, 'KABUPATEN WONOGIRI'),
(3313, 33, 'KABUPATEN KARANGANYAR'),
(3314, 33, 'KABUPATEN SRAGEN'),
(3315, 33, 'KABUPATEN GROBOGAN'),
(3316, 33, 'KABUPATEN BLORA'),
(3317, 33, 'KABUPATEN REMBANG'),
(3318, 33, 'KABUPATEN PATI'),
(3319, 33, 'KABUPATEN KUDUS'),
(3320, 33, 'KABUPATEN JEPARA'),
(3321, 33, 'KABUPATEN DEMAK'),
(3322, 33, 'KABUPATEN SEMARANG'),
(3323, 33, 'KABUPATEN TEMANGGUNG'),
(3324, 33, 'KABUPATEN KENDAL'),
(3325, 33, 'KABUPATEN BATANG'),
(3326, 33, 'KABUPATEN PEKALONGAN'),
(3327, 33, 'KABUPATEN PEMALANG'),
(3328, 33, 'KABUPATEN TEGAL'),
(3329, 33, 'KABUPATEN BREBES'),
(3371, 33, 'KOTA MAGELANG'),
(3372, 33, 'KOTA SURAKARTA'),
(3373, 33, 'KOTA SALATIGA'),
(3374, 33, 'KOTA SEMARANG'),
(3375, 33, 'KOTA PEKALONGAN'),
(3376, 33, 'KOTA TEGAL'),
(3401, 34, 'KABUPATEN KULON PROGO'),
(3402, 34, 'KABUPATEN BANTUL'),
(3403, 34, 'KABUPATEN GUNUNG KIDUL'),
(3404, 34, 'KABUPATEN SLEMAN'),
(3471, 34, 'KOTA YOGYAKARTA'),
(3501, 35, 'KABUPATEN PACITAN'),
(3502, 35, 'KABUPATEN PONOROGO'),
(3503, 35, 'KABUPATEN TRENGGALEK'),
(3504, 35, 'KABUPATEN TULUNGAGUNG'),
(3505, 35, 'KABUPATEN BLITAR'),
(3506, 35, 'KABUPATEN KEDIRI'),
(3507, 35, 'KABUPATEN MALANG'),
(3508, 35, 'KABUPATEN LUMAJANG'),
(3509, 35, 'KABUPATEN JEMBER'),
(3510, 35, 'KABUPATEN BANYUWANGI'),
(3511, 35, 'KABUPATEN BONDOWOSO'),
(3512, 35, 'KABUPATEN SITUBONDO'),
(3513, 35, 'KABUPATEN PROBOLINGGO'),
(3514, 35, 'KABUPATEN PASURUAN'),
(3515, 35, 'KABUPATEN SIDOARJO'),
(3516, 35, 'KABUPATEN MOJOKERTO'),
(3517, 35, 'KABUPATEN JOMBANG'),
(3518, 35, 'KABUPATEN NGANJUK'),
(3519, 35, 'KABUPATEN MADIUN'),
(3520, 35, 'KABUPATEN MAGETAN'),
(3521, 35, 'KABUPATEN NGAWI'),
(3522, 35, 'KABUPATEN BOJONEGORO'),
(3523, 35, 'KABUPATEN TUBAN'),
(3524, 35, 'KABUPATEN LAMONGAN'),
(3525, 35, 'KABUPATEN GRESIK'),
(3526, 35, 'KABUPATEN BANGKALAN'),
(3527, 35, 'KABUPATEN SAMPANG'),
(3528, 35, 'KABUPATEN PAMEKASAN'),
(3529, 35, 'KABUPATEN SUMENEP'),
(3571, 35, 'KOTA KEDIRI'),
(3572, 35, 'KOTA BLITAR'),
(3573, 35, 'KOTA MALANG'),
(3574, 35, 'KOTA PROBOLINGGO'),
(3575, 35, 'KOTA PASURUAN'),
(3576, 35, 'KOTA MOJOKERTO'),
(3577, 35, 'KOTA MADIUN'),
(3578, 35, 'KOTA SURABAYA'),
(3579, 35, 'KOTA BATU'),
(3601, 36, 'KABUPATEN PANDEGLANG'),
(3602, 36, 'KABUPATEN LEBAK'),
(3603, 36, 'KABUPATEN TANGERANG'),
(3604, 36, 'KABUPATEN SERANG'),
(3671, 36, 'KOTA TANGERANG'),
(3672, 36, 'KOTA CILEGON'),
(3673, 36, 'KOTA SERANG'),
(3674, 36, 'KOTA TANGERANG SELATAN'),
(5101, 51, 'KABUPATEN JEMBRANA'),
(5102, 51, 'KABUPATEN TABANAN'),
(5103, 51, 'KABUPATEN BADUNG'),
(5104, 51, 'KABUPATEN GIANYAR'),
(5105, 51, 'KABUPATEN KLUNGKUNG'),
(5106, 51, 'KABUPATEN BANGLI'),
(5107, 51, 'KABUPATEN KARANG ASEM'),
(5108, 51, 'KABUPATEN BULELENG'),
(5171, 51, 'KOTA DENPASAR'),
(5201, 52, 'KABUPATEN LOMBOK BARAT'),
(5202, 52, 'KABUPATEN LOMBOK TENGAH'),
(5203, 52, 'KABUPATEN LOMBOK TIMUR'),
(5204, 52, 'KABUPATEN SUMBAWA'),
(5205, 52, 'KABUPATEN DOMPU'),
(5206, 52, 'KABUPATEN BIMA'),
(5207, 52, 'KABUPATEN SUMBAWA BARAT'),
(5208, 52, 'KABUPATEN LOMBOK UTARA'),
(5271, 52, 'KOTA MATARAM'),
(5272, 52, 'KOTA BIMA'),
(5301, 53, 'KABUPATEN SUMBA BARAT'),
(5302, 53, 'KABUPATEN SUMBA TIMUR'),
(5303, 53, 'KABUPATEN KUPANG'),
(5304, 53, 'KABUPATEN TIMOR TENGAH SELATAN'),
(5305, 53, 'KABUPATEN TIMOR TENGAH UTARA'),
(5306, 53, 'KABUPATEN BELU'),
(5307, 53, 'KABUPATEN ALOR'),
(5308, 53, 'KABUPATEN LEMBATA'),
(5309, 53, 'KABUPATEN FLORES TIMUR'),
(5310, 53, 'KABUPATEN SIKKA'),
(5311, 53, 'KABUPATEN ENDE'),
(5312, 53, 'KABUPATEN NGADA'),
(5313, 53, 'KABUPATEN MANGGARAI'),
(5314, 53, 'KABUPATEN ROTE NDAO'),
(5315, 53, 'KABUPATEN MANGGARAI BARAT'),
(5316, 53, 'KABUPATEN SUMBA TENGAH'),
(5317, 53, 'KABUPATEN SUMBA BARAT DAYA'),
(5318, 53, 'KABUPATEN NAGEKEO'),
(5319, 53, 'KABUPATEN MANGGARAI TIMUR'),
(5320, 53, 'KABUPATEN SABU RAIJUA'),
(5321, 53, 'KABUPATEN MALAKA'),
(5371, 53, 'KOTA KUPANG'),
(6101, 61, 'KABUPATEN SAMBAS'),
(6102, 61, 'KABUPATEN BENGKAYANG'),
(6103, 61, 'KABUPATEN LANDAK'),
(6104, 61, 'KABUPATEN MEMPAWAH'),
(6105, 61, 'KABUPATEN SANGGAU'),
(6106, 61, 'KABUPATEN KETAPANG'),
(6107, 61, 'KABUPATEN SINTANG'),
(6108, 61, 'KABUPATEN KAPUAS HULU'),
(6109, 61, 'KABUPATEN SEKADAU'),
(6110, 61, 'KABUPATEN MELAWI'),
(6111, 61, 'KABUPATEN KAYONG UTARA'),
(6112, 61, 'KABUPATEN KUBU RAYA'),
(6171, 61, 'KOTA PONTIANAK'),
(6172, 61, 'KOTA SINGKAWANG'),
(6201, 62, 'KABUPATEN KOTAWARINGIN BARAT'),
(6202, 62, 'KABUPATEN KOTAWARINGIN TIMUR'),
(6203, 62, 'KABUPATEN KAPUAS'),
(6204, 62, 'KABUPATEN BARITO SELATAN'),
(6205, 62, 'KABUPATEN BARITO UTARA'),
(6206, 62, 'KABUPATEN SUKAMARA'),
(6207, 62, 'KABUPATEN LAMANDAU'),
(6208, 62, 'KABUPATEN SERUYAN'),
(6209, 62, 'KABUPATEN KATINGAN'),
(6210, 62, 'KABUPATEN PULANG PISAU'),
(6211, 62, 'KABUPATEN GUNUNG MAS'),
(6212, 62, 'KABUPATEN BARITO TIMUR'),
(6213, 62, 'KABUPATEN MURUNG RAYA'),
(6271, 62, 'KOTA PALANGKA RAYA'),
(6301, 63, 'KABUPATEN TANAH LAUT'),
(6302, 63, 'KABUPATEN KOTA BARU'),
(6303, 63, 'KABUPATEN BANJAR'),
(6304, 63, 'KABUPATEN BARITO KUALA'),
(6305, 63, 'KABUPATEN TAPIN'),
(6306, 63, 'KABUPATEN HULU SUNGAI SELATAN'),
(6307, 63, 'KABUPATEN HULU SUNGAI TENGAH'),
(6308, 63, 'KABUPATEN HULU SUNGAI UTARA'),
(6309, 63, 'KABUPATEN TABALONG'),
(6310, 63, 'KABUPATEN TANAH BUMBU'),
(6311, 63, 'KABUPATEN BALANGAN'),
(6371, 63, 'KOTA BANJARMASIN'),
(6372, 63, 'KOTA BANJAR BARU'),
(6401, 64, 'KABUPATEN PASER'),
(6402, 64, 'KABUPATEN KUTAI BARAT'),
(6403, 64, 'KABUPATEN KUTAI KARTANEGARA'),
(6404, 64, 'KABUPATEN KUTAI TIMUR'),
(6405, 64, 'KABUPATEN BERAU'),
(6409, 64, 'KABUPATEN PENAJAM PASER UTARA'),
(6411, 64, 'KABUPATEN MAHAKAM HULU'),
(6471, 64, 'KOTA BALIKPAPAN'),
(6472, 64, 'KOTA SAMARINDA'),
(6474, 64, 'KOTA BONTANG'),
(6501, 65, 'KABUPATEN MALINAU'),
(6502, 65, 'KABUPATEN BULUNGAN'),
(6503, 65, 'KABUPATEN TANA TIDUNG'),
(6504, 65, 'KABUPATEN NUNUKAN'),
(6571, 65, 'KOTA TARAKAN'),
(7101, 71, 'KABUPATEN BOLAANG MONGONDOW'),
(7102, 71, 'KABUPATEN MINAHASA'),
(7103, 71, 'KABUPATEN KEPULAUAN SANGIHE'),
(7104, 71, 'KABUPATEN KEPULAUAN TALAUD'),
(7105, 71, 'KABUPATEN MINAHASA SELATAN'),
(7106, 71, 'KABUPATEN MINAHASA UTARA'),
(7107, 71, 'KABUPATEN BOLAANG MONGONDOW UTARA'),
(7108, 71, 'KABUPATEN SIAU TAGULANDANG BIARO'),
(7109, 71, 'KABUPATEN MINAHASA TENGGARA'),
(7110, 71, 'KABUPATEN BOLAANG MONGONDOW SELATAN'),
(7111, 71, 'KABUPATEN BOLAANG MONGONDOW TIMUR'),
(7171, 71, 'KOTA MANADO'),
(7172, 71, 'KOTA BITUNG'),
(7173, 71, 'KOTA TOMOHON'),
(7174, 71, 'KOTA KOTAMOBAGU'),
(7201, 72, 'KABUPATEN BANGGAI KEPULAUAN'),
(7202, 72, 'KABUPATEN BANGGAI'),
(7203, 72, 'KABUPATEN MOROWALI'),
(7204, 72, 'KABUPATEN POSO'),
(7205, 72, 'KABUPATEN DONGGALA'),
(7206, 72, 'KABUPATEN TOLI-TOLI'),
(7207, 72, 'KABUPATEN BUOL'),
(7208, 72, 'KABUPATEN PARIGI MOUTONG'),
(7209, 72, 'KABUPATEN TOJO UNA-UNA'),
(7210, 72, 'KABUPATEN SIGI'),
(7211, 72, 'KABUPATEN BANGGAI LAUT'),
(7212, 72, 'KABUPATEN MOROWALI UTARA'),
(7271, 72, 'KOTA PALU'),
(7301, 73, 'KABUPATEN KEPULAUAN SELAYAR'),
(7302, 73, 'KABUPATEN BULUKUMBA'),
(7303, 73, 'KABUPATEN BANTAENG'),
(7304, 73, 'KABUPATEN JENEPONTO'),
(7305, 73, 'KABUPATEN TAKALAR'),
(7306, 73, 'KABUPATEN GOWA'),
(7307, 73, 'KABUPATEN SINJAI'),
(7308, 73, 'KABUPATEN MAROS'),
(7309, 73, 'KABUPATEN PANGKAJENE DAN KEPULAUAN'),
(7310, 73, 'KABUPATEN BARRU'),
(7311, 73, 'KABUPATEN BONE'),
(7312, 73, 'KABUPATEN SOPPENG'),
(7313, 73, 'KABUPATEN WAJO'),
(7314, 73, 'KABUPATEN SIDENRENG RAPPANG'),
(7315, 73, 'KABUPATEN PINRANG'),
(7316, 73, 'KABUPATEN ENREKANG'),
(7317, 73, 'KABUPATEN LUWU'),
(7318, 73, 'KABUPATEN TANA TORAJA'),
(7322, 73, 'KABUPATEN LUWU UTARA'),
(7325, 73, 'KABUPATEN LUWU TIMUR'),
(7326, 73, 'KABUPATEN TORAJA UTARA'),
(7371, 73, 'KOTA MAKASSAR'),
(7372, 73, 'KOTA PAREPARE'),
(7373, 73, 'KOTA PALOPO'),
(7401, 74, 'KABUPATEN BUTON'),
(7402, 74, 'KABUPATEN MUNA'),
(7403, 74, 'KABUPATEN KONAWE'),
(7404, 74, 'KABUPATEN KOLAKA'),
(7405, 74, 'KABUPATEN KONAWE SELATAN'),
(7406, 74, 'KABUPATEN BOMBANA'),
(7407, 74, 'KABUPATEN WAKATOBI'),
(7408, 74, 'KABUPATEN KOLAKA UTARA'),
(7409, 74, 'KABUPATEN BUTON UTARA'),
(7410, 74, 'KABUPATEN KONAWE UTARA'),
(7411, 74, 'KABUPATEN KOLAKA TIMUR'),
(7412, 74, 'KABUPATEN KONAWE KEPULAUAN'),
(7413, 74, 'KABUPATEN MUNA BARAT'),
(7414, 74, 'KABUPATEN BUTON TENGAH'),
(7415, 74, 'KABUPATEN BUTON SELATAN'),
(7471, 74, 'KOTA KENDARI'),
(7472, 74, 'KOTA BAUBAU'),
(7501, 75, 'KABUPATEN BOALEMO'),
(7502, 75, 'KABUPATEN GORONTALO'),
(7503, 75, 'KABUPATEN POHUWATO'),
(7504, 75, 'KABUPATEN BONE BOLANGO'),
(7505, 75, 'KABUPATEN GORONTALO UTARA'),
(7571, 75, 'KOTA GORONTALO'),
(7601, 76, 'KABUPATEN MAJENE'),
(7602, 76, 'KABUPATEN POLEWALI MANDAR'),
(7603, 76, 'KABUPATEN MAMASA'),
(7604, 76, 'KABUPATEN MAMUJU'),
(7605, 76, 'KABUPATEN MAMUJU UTARA'),
(7606, 76, 'KABUPATEN MAMUJU TENGAH'),
(8101, 81, 'KABUPATEN MALUKU TENGGARA BARAT'),
(8102, 81, 'KABUPATEN MALUKU TENGGARA'),
(8103, 81, 'KABUPATEN MALUKU TENGAH'),
(8104, 81, 'KABUPATEN BURU'),
(8105, 81, 'KABUPATEN KEPULAUAN ARU'),
(8106, 81, 'KABUPATEN SERAM BAGIAN BARAT'),
(8107, 81, 'KABUPATEN SERAM BAGIAN TIMUR'),
(8108, 81, 'KABUPATEN MALUKU BARAT DAYA'),
(8109, 81, 'KABUPATEN BURU SELATAN'),
(8171, 81, 'KOTA AMBON'),
(8172, 81, 'KOTA TUAL'),
(8201, 82, 'KABUPATEN HALMAHERA BARAT'),
(8202, 82, 'KABUPATEN HALMAHERA TENGAH'),
(8203, 82, 'KABUPATEN KEPULAUAN SULA'),
(8204, 82, 'KABUPATEN HALMAHERA SELATAN'),
(8205, 82, 'KABUPATEN HALMAHERA UTARA'),
(8206, 82, 'KABUPATEN HALMAHERA TIMUR'),
(8207, 82, 'KABUPATEN PULAU MOROTAI'),
(8208, 82, 'KABUPATEN PULAU TALIABU'),
(8271, 82, 'KOTA TERNATE'),
(8272, 82, 'KOTA TIDORE KEPULAUAN'),
(9101, 91, 'KABUPATEN FAKFAK'),
(9102, 91, 'KABUPATEN KAIMANA'),
(9103, 91, 'KABUPATEN TELUK WONDAMA'),
(9104, 91, 'KABUPATEN TELUK BINTUNI'),
(9105, 91, 'KABUPATEN MANOKWARI'),
(9106, 91, 'KABUPATEN SORONG SELATAN'),
(9107, 91, 'KABUPATEN SORONG'),
(9108, 91, 'KABUPATEN RAJA AMPAT'),
(9109, 91, 'KABUPATEN TAMBRAUW'),
(9110, 91, 'KABUPATEN MAYBRAT'),
(9111, 91, 'KABUPATEN MANOKWARI SELATAN'),
(9112, 91, 'KABUPATEN PEGUNUNGAN ARFAK'),
(9171, 91, 'KOTA SORONG'),
(9401, 94, 'KABUPATEN MERAUKE'),
(9402, 94, 'KABUPATEN JAYAWIJAYA'),
(9403, 94, 'KABUPATEN JAYAPURA'),
(9404, 94, 'KABUPATEN NABIRE'),
(9408, 94, 'KABUPATEN KEPULAUAN YAPEN'),
(9409, 94, 'KABUPATEN BIAK NUMFOR'),
(9410, 94, 'KABUPATEN PANIAI'),
(9411, 94, 'KABUPATEN PUNCAK JAYA'),
(9412, 94, 'KABUPATEN MIMIKA'),
(9413, 94, 'KABUPATEN BOVEN DIGOEL'),
(9414, 94, 'KABUPATEN MAPPI'),
(9415, 94, 'KABUPATEN ASMAT'),
(9416, 94, 'KABUPATEN YAHUKIMO'),
(9417, 94, 'KABUPATEN PEGUNUNGAN BINTANG'),
(9418, 94, 'KABUPATEN TOLIKARA'),
(9419, 94, 'KABUPATEN SARMI'),
(9420, 94, 'KABUPATEN KEEROM'),
(9426, 94, 'KABUPATEN WAROPEN'),
(9427, 94, 'KABUPATEN SUPIORI'),
(9428, 94, 'KABUPATEN MAMBERAMO RAYA'),
(9429, 94, 'KABUPATEN NDUGA'),
(9430, 94, 'KABUPATEN LANNY JAYA'),
(9431, 94, 'KABUPATEN MAMBERAMO TENGAH'),
(9432, 94, 'KABUPATEN YALIMO'),
(9433, 94, 'KABUPATEN PUNCAK'),
(9434, 94, 'KABUPATEN DOGIYAI'),
(9435, 94, 'KABUPATEN INTAN JAYA'),
(9436, 94, 'KABUPATEN DEIYAI'),
(9471, 94, 'KOTA JAYAPURA');

-- --------------------------------------------------------

--
-- Table structure for table `msmerek`
--

CREATE TABLE `msmerek` (
  `ID` int(11) NOT NULL,
  `JUDUL` text,
  `KELAS` varchar(50) DEFAULT NULL,
  `UNIT_KERJA` int(11) NOT NULL,
  `JUMLAH_KLAIM` int(11) NOT NULL,
  `PEMERIKSA_MEREK` varchar(50) NOT NULL,
  `KONTAK_PEMERIKSA` varchar(50) NOT NULL,
  `EMAIL_PEMERIKSA` varchar(50) NOT NULL,
  `NO_HANDPHONE` varchar(50) NOT NULL,
  `IPMAN_CODE` varchar(50) NOT NULL,
  `STATUS` int(11) NOT NULL,
  `PERNAH_DIAJUKAN` int(11) NOT NULL DEFAULT '0',
  `SERTIFIKASI` date NOT NULL,
  `TAHUN_PENDAFTARAN` int(11) DEFAULT NULL,
  `TAHUN_GRANTED` int(11) DEFAULT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `KETERANGAN` text,
  `INDEX` int(11) NOT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL,
  `TGL_UBAH` datetime DEFAULT NULL,
  `KODE_UBAH` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msmerek`
--

INSERT INTO `msmerek` (`ID`, `JUDUL`, `KELAS`, `UNIT_KERJA`, `JUMLAH_KLAIM`, `PEMERIKSA_MEREK`, `KONTAK_PEMERIKSA`, `EMAIL_PEMERIKSA`, `NO_HANDPHONE`, `IPMAN_CODE`, `STATUS`, `PERNAH_DIAJUKAN`, `SERTIFIKASI`, `TAHUN_PENDAFTARAN`, `TAHUN_GRANTED`, `NOMOR_PENDAFTAR`, `KETERANGAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`, `TGL_UBAH`, `KODE_UBAH`) VALUES
(2, 'm e', 'm', 5, 0, '', '', '', '0821', 'MR_0017', 21, 1, '0000-00-00', 2019, 2019, 'p002', 'keterangan', 0, '2019-09-24 04:02:35', '1', '2019-09-24 04:26:29', '1'),
(3, 'Judul', 'Kelas', 5, 0, '', '', '', '0812', 'MR_0018', 19, 0, '0000-00-00', NULL, NULL, '', NULL, 0, '2019-10-10 08:27:43', '12', '2019-10-10 08:33:08', '12'),
(4, 'jkl', 'ls', 5, 0, '', '', '', '0812', 'MR_0019', 19, 0, '0000-00-00', NULL, NULL, '', NULL, 0, '2019-10-10 08:33:39', '12', '2019-10-10 08:33:56', '12');

-- --------------------------------------------------------

--
-- Table structure for table `msnonpegawai`
--

CREATE TABLE `msnonpegawai` (
  `ID` int(12) NOT NULL,
  `NIK` int(15) NOT NULL,
  `NAMA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `msnonpegawai`
--

INSERT INTO `msnonpegawai` (`ID`, `NIK`, `NAMA`) VALUES
(1, 3501, 'Septian David'),
(2, 3502, 'Evan Dimas'),
(3, 3503, 'Fahrudin'),
(4, 3504, 'Rizky'),
(5, 3509, 'Udin'),
(7, 3510, 'Alex'),
(8, 3777, 'Ardi'),
(9, 1234321, 'asdasd'),
(10, 43231, 'asdasdasd'),
(11, 54321, 'fdsa');

-- --------------------------------------------------------

--
-- Table structure for table `mspaten`
--

CREATE TABLE `mspaten` (
  `ID` int(11) NOT NULL,
  `JUDUL` text,
  `ABSTRAK` varchar(50) DEFAULT NULL,
  `GAMBAR` varchar(50) DEFAULT NULL,
  `JENIS_PATEN` int(11) DEFAULT NULL,
  `UNIT_KERJA` int(11) DEFAULT NULL,
  `BIDANG_INVENSI` varchar(50) DEFAULT NULL,
  `JUMLAH_KLAIM` varchar(50) DEFAULT NULL,
  `PEMERIKSA_PATEN` varchar(50) DEFAULT NULL,
  `KONTAK_PEMERIKSA` varchar(50) DEFAULT NULL,
  `EMAIL_PEMERIKSA` varchar(50) DEFAULT NULL,
  `NO_HANDPHONE` varchar(20) DEFAULT NULL,
  `IPMAN_CODE` varchar(50) DEFAULT NULL,
  `NOMOR_PERMOHONAN` varchar(15) DEFAULT NULL,
  `SERTIFIKASI` varchar(50) DEFAULT NULL,
  `FILLING` date DEFAULT NULL,
  `FORMALITAS` date DEFAULT NULL,
  `PUBLISH` date DEFAULT NULL,
  `PEMBAYARAN` date DEFAULT NULL,
  `PEMBERIAN` date DEFAULT NULL,
  `NOMOR_PATEN` varchar(15) DEFAULT NULL,
  `TAHUN_GRANTED` int(11) DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL,
  `PERNAH_DIAJUKAN` int(11) DEFAULT NULL,
  `TINDAK_LANJUT` int(11) DEFAULT NULL,
  `KETERANGAN` text,
  `INDEX` int(11) DEFAULT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL,
  `TGL_UBAH` datetime DEFAULT NULL,
  `KODE_UBAH` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mspaten`
--

INSERT INTO `mspaten` (`ID`, `JUDUL`, `ABSTRAK`, `GAMBAR`, `JENIS_PATEN`, `UNIT_KERJA`, `BIDANG_INVENSI`, `JUMLAH_KLAIM`, `PEMERIKSA_PATEN`, `KONTAK_PEMERIKSA`, `EMAIL_PEMERIKSA`, `NO_HANDPHONE`, `IPMAN_CODE`, `NOMOR_PERMOHONAN`, `SERTIFIKASI`, `FILLING`, `FORMALITAS`, `PUBLISH`, `PEMBAYARAN`, `PEMBERIAN`, `NOMOR_PATEN`, `TAHUN_GRANTED`, `STATUS`, `PERNAH_DIAJUKAN`, `TINDAK_LANJUT`, `KETERANGAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`, `TGL_UBAH`, `KODE_UBAH`) VALUES
(369, 'PBA2', 'abstrak_PB_0052.txt', '', 24, 6, 'B', NULL, NULL, NULL, NULL, '0821', 'PB_0052', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL, NULL, NULL, NULL, '2019-09-24 03:39:01', '1', '2019-10-10 07:19:01', '10'),
(370, 'JBG', NULL, 'gambar_paten_PB_0053.jpg', 24, 5, 'B', NULL, NULL, NULL, NULL, '0821', 'PB_0053', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL, NULL, NULL, NULL, '2019-09-24 04:40:26', '1', '2019-09-24 05:16:48', '1'),
(371, 'asd', NULL, 'gambar_paten_PB_0054.jpg', 24, 6, 'b', NULL, 'Adi', '0821', 'adi23@gmail.com', '0821', 'PB_0054', '1002', '2019-09-23', '2019-09-24', '2019-09-24', '2019-09-24', '2019-09-24', '2019-09-24', 'P0099', 2019, 20, 1, 42, 'keterangan', NULL, '2019-09-24 05:18:02', '1', '2019-09-24 05:18:48', '1'),
(372, 'Judul P', 'PB_0055_abstrak.txt', 'PB_0055_gambar_paten.jpg', 24, 5, 'Invensi', NULL, NULL, NULL, NULL, '0812', 'PB_0055', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, NULL, NULL, NULL, NULL, '2019-10-10 08:12:45', '12', '2019-10-10 08:21:51', '12');

-- --------------------------------------------------------

--
-- Table structure for table `mspegawai`
--

CREATE TABLE `mspegawai` (
  `ID` int(12) NOT NULL,
  `KODE_KEPEGAWAIAN` varchar(50) NOT NULL,
  `NIK` int(15) NOT NULL,
  `NAMA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mspegawai`
--

INSERT INTO `mspegawai` (`ID`, `KODE_KEPEGAWAIAN`, `NIK`, `NAMA`) VALUES
(1, 'P001', 327501, 'Nama 1'),
(2, 'P002', 327502, 'Nama 2'),
(3, 'P003', 327503, 'Nama 3'),
(4, 'P004', 327504, 'Nama 4'),
(5, 'P005', 327505, 'Nama 5');

-- --------------------------------------------------------

--
-- Table structure for table `mspembatalan`
--

CREATE TABLE `mspembatalan` (
  `ID` int(11) NOT NULL,
  `ID_USULAN` int(11) NOT NULL,
  `ALASAN` text NOT NULL,
  `DOK_PEMBATALAN` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mspembatalan`
--

INSERT INTO `mspembatalan` (`ID`, `ID_USULAN`, `ALASAN`, `DOK_PEMBATALAN`) VALUES
(1, 6, '', ''),
(2, 10, 'Alasan', 'surat_pembatalan_10_02-10-2019.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `msperiode`
--

CREATE TABLE `msperiode` (
  `ID` int(11) NOT NULL,
  `TAHUN` int(11) DEFAULT NULL,
  `PERIODE` char(12) DEFAULT NULL,
  `INDEX` int(11) DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msprovinsi`
--

CREATE TABLE `msprovinsi` (
  `id_prov` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msprovinsi`
--

INSERT INTO `msprovinsi` (`id_prov`, `nama`) VALUES
(11, 'ACEH'),
(12, 'SUMATERA UTARA'),
(13, 'SUMATERA BARAT'),
(14, 'RIAU'),
(15, 'JAMBI'),
(16, 'SUMATERA SELATAN'),
(17, 'BENGKULU'),
(18, 'LAMPUNG'),
(19, 'KEPULAUAN BANGKA BELITUNG'),
(21, 'KEPULAUAN RIAU'),
(31, 'DKI JAKARTA'),
(32, 'JAWA BARAT'),
(33, 'JAWA TENGAH'),
(34, 'DI YOGYAKARTA'),
(35, 'JAWA TIMUR'),
(36, 'BANTEN'),
(51, 'BALI'),
(52, 'NUSA TENGGARA BARAT'),
(53, 'NUSA TENGGARA TIMUR'),
(61, 'KALIMANTAN BARAT'),
(62, 'KALIMANTAN TENGAH'),
(63, 'KALIMANTAN SELATAN'),
(64, 'KALIMANTAN TIMUR'),
(65, 'KALIMANTAN UTARA'),
(71, 'SULAWESI UTARA'),
(72, 'SULAWESI TENGAH'),
(73, 'SULAWESI SELATAN'),
(74, 'SULAWESI TENGGARA'),
(75, 'GORONTALO'),
(76, 'SULAWESI BARAT'),
(81, 'MALUKU'),
(82, 'MALUKU UTARA'),
(91, 'PAPUA BARAT'),
(94, 'PAPUA');

-- --------------------------------------------------------

--
-- Table structure for table `msrev`
--

CREATE TABLE `msrev` (
  `ID` int(11) NOT NULL,
  `NAMA_REV` varchar(50) DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL,
  `KETERANGAN` text,
  `GOLONGAN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msrev`
--

INSERT INTO `msrev` (`ID`, `NAMA_REV`, `STATUS`, `KETERANGAN`, `GOLONGAN`) VALUES
(1, 'Laki-Laki', 3, NULL, 1),
(2, 'Perempuan', 3, NULL, 1),
(3, 'Aktif', 3, NULL, 2),
(4, 'Tidak Aktif', 3, NULL, 2),
(5, 'PSTA', 3, NULL, 3),
(6, 'Pusfatja', 3, NULL, 3),
(7, 'Pussainsa', 3, NULL, 3),
(8, 'Pustekbang', 3, NULL, 3),
(9, 'Pustekdata', 3, NULL, 3),
(10, 'Pustekroket', 3, NULL, 3),
(11, 'Pusteksat', 3, NULL, 3),
(12, 'Buku', 3, NULL, 4),
(13, 'Program Komputer', 3, NULL, 4),
(14, 'Pengembang', 3, NULL, 5),
(15, 'Administrator', 3, NULL, 5),
(16, 'Ka Satker', 3, NULL, 5),
(17, 'Tim Verifikasi', 3, NULL, 5),
(18, 'Pengguna', 3, NULL, 5),
(19, 'Draft', 3, NULL, 6),
(20, 'Proses Verifikasi', 3, NULL, 6),
(21, 'Terverifikasi', 3, NULL, 6),
(22, 'Ditolak', 3, NULL, 6),
(23, 'Ditarik Kembali', 3, NULL, 6),
(24, 'Paten Biasa', 3, NULL, 7),
(25, 'Paten Sederhana', 3, NULL, 7),
(26, 'Deskripsi', 3, 'Dokumen Paten', 8),
(27, 'Nodin', 3, 'Dokumen Paten', 8),
(28, 'Surat Pernyataan Kepemilikan Hak', 3, 'Dokumen Paten', 8),
(29, 'Surat Pernyataan Pengalihan Hak', 3, 'Dokumen Paten', 8),
(30, 'KTP', 3, 'Dokumen Paten', 8),
(31, 'Dokumen Tambahan', 3, 'Dokumen Paten', 8),
(32, 'Formulir Pengajuan', 3, 'Dokumen Merek', 9),
(33, 'Surat Pernyataan Kepemilikan Hak', 3, 'Dokumen Merek', 9),
(34, 'Surat Pernyataan Pengalihan Hak', 3, 'Dokumen Merek', 9),
(35, 'Bukti Pembayaran', 3, 'Dokumen Merek', 9),
(36, 'Formulir Pengajuan', 3, 'Dokumen Hak Cipta', 10),
(37, 'Bukti Pembayaran', 3, 'Dokumen Hak Cipta', 10),
(38, 'Deskripsi', 3, 'Dokumen Desain Industri', 11),
(39, 'KTP', 3, 'Dokumen Desain Industri', 11),
(40, 'Bukti Pembayaran', 3, 'Dokumen Desain Industri', 11),
(41, 'Dokumen Tambahan 2', 3, 'Dok Paten', 8),
(42, 'Formalitas', 3, NULL, 12),
(43, 'Publikasi', 3, NULL, 12),
(44, 'Substatif', 3, NULL, 12),
(45, 'Permohonan Paten', 3, NULL, 13),
(46, 'Percepatan Pengumuman', 3, NULL, 13),
(47, 'Pemeriksaan Substantif', 3, NULL, 13),
(48, 'SNI', NULL, '', 14),
(49, 'SL', NULL, NULL, 14),
(50, '49-01', 3, '48', 15),
(51, '49-02', 3, '48', 15),
(52, '07-01', 3, '48', 15),
(53, 'LAPAN', 3, '49', 15),
(54, 'Baru', 3, '', 16),
(55, 'Revisi', 3, '', 16),
(56, 'Ralat', 3, NULL, 16),
(57, 'Amandemen', 3, NULL, 16),
(58, 'Terjemahan SNI', 3, NULL, 16),
(59, 'Republikasi Reprint', 3, NULL, 16),
(67, 'Perumusan Sendiri', 3, NULL, 17),
(68, 'Perumusan Adopsi', 3, NULL, 17),
(69, 'Identik', 3, NULL, 18),
(70, 'Modifikasi', 3, NULL, 18),
(71, 'Publikasi Ulang', 3, NULL, 19),
(72, 'Terjemahan 1 Bahasa(Indonesia)', 3, NULL, 19),
(73, 'Terjemahan 2 Bahasa(Indonesia dan Inggris)', 3, NULL, 19),
(80, 'RSNI1-Menunggu Rapat Teknis', 3, NULL, 22),
(81, 'RSNI2-Menunggu Perbaikan RSNI', 3, NULL, 22),
(82, 'RSNI2-Menunggu Rapat Teknis', 3, NULL, 22),
(83, 'RSNI3-Menunggu Pengesahan', 3, NULL, 22),
(84, 'JP-Proses Jajak Pendapat', 3, NULL, 22),
(85, 'JP-Menunggu Pengesahan', 3, NULL, 22),
(86, 'RSNI4-Menunggu Perbaikan RSNI', 3, NULL, 22),
(87, 'RSNI4-Menunggu Rapat Teknis', 3, NULL, 22),
(88, 'RASNI-Menunggu Pengesahan', 3, NULL, 22),
(89, 'SNI', 3, NULL, 22),
(90, 'RSL1-Menunggu Rapat Teknis', 3, NULL, 23),
(91, 'RSL2-Menunggu Perbaikan RSL', 3, NULL, 23),
(92, 'RSL2-Menunggu Rapat Teknis', 3, NULL, 23),
(93, 'RSL3-Menunggu Pengesahan', 3, NULL, 23),
(94, 'Penetapan SL-Menunggu Pengesahan', 3, NULL, 23),
(95, 'SL', 3, NULL, 23),
(96, 'Administrator', 3, NULL, 24),
(97, 'Pengusul', 3, NULL, 24),
(98, 'Sekretariat', 3, NULL, 24),
(99, 'Draft', 3, NULL, 25),
(100, 'Diajukan', 3, NULL, 25),
(101, 'Ditolak', 3, NULL, 25),
(102, 'Diterima', 3, NULL, 25),
(103, 'Menunggu Pengesahan', 3, NULL, 20),
(104, 'Menunggu Verifikasi Dokumen', 3, NULL, 20),
(105, 'Menunggu Verifikasi Subtansi', 3, NULL, 20),
(106, 'Menunggu Pengesahan', 3, NULL, 20),
(107, 'Pengajuan', 3, NULL, 20),
(108, 'Proses Publikasi', 3, NULL, 20),
(109, 'Menunggu Pengesahan PNPS', 3, NULL, 20),
(110, 'Menunggu Pengesahan', 3, NULL, 21),
(111, 'Menunggu Verifikasi Dokumen', 3, NULL, 21),
(112, 'Menunggu Verifikasi Subtansi', 3, NULL, 21),
(113, 'Menunggu Pengesahan', 3, NULL, 21),
(114, 'Pengajuan', 3, NULL, 21);

-- --------------------------------------------------------

--
-- Table structure for table `mstarif`
--

CREATE TABLE `mstarif` (
  `ID` int(11) NOT NULL,
  `NOMINAL` decimal(18,0) NOT NULL,
  `TAHUN` int(11) DEFAULT NULL,
  `STATUS` int(11) NOT NULL,
  `KETERANGAN` text,
  `KODE` char(5) DEFAULT NULL,
  `INDEX` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msuser`
--

CREATE TABLE `msuser` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msuser`
--

INSERT INTO `msuser` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`) VALUES
(1, 'Rifai', 'rifai26@gmail.com', 'user1.png', '$2y$10$ZOTVL.eIpM6S1GwSrpQtOOPv5JpeO7mti1AdGes2hRER58ixdWTcK', 18, 3),
(10, 'Administrator', 'admin@lapan.go.id', 'default.jpg', '$2y$10$NlZK/buUmSFJT0HDtus7wOC1pB1mTMxpoeQQyFLxw9LY6ZEkarfga', 15, 3),
(11, 'Arif', 'arif02@gmail.com', 'default.jpg', '$2y$10$HRwI3IEY6R83goWedpigaeTIgTMkxH7073vGKkCKcEnscQ8CcZuKS', 15, 4),
(12, 'Budi', 'budidummy3228@gmail.com', 'default.jpg', '$2y$10$E8orkd367cl.B6nLhACD9OI54II8GavK89TfYJAHsJOjE2gypaudy', 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `msuserstandar`
--

CREATE TABLE `msuserstandar` (
  `ID` int(11) NOT NULL,
  `NO_KTP` int(11) DEFAULT NULL,
  `NAMA_LENGKAP` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `ROLE_ID` tinyint(4) DEFAULT NULL,
  `IMAGE` varchar(150) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `NO_HANDPHONE` varchar(50) DEFAULT NULL,
  `FAX` varchar(50) DEFAULT NULL,
  `STAKEHOLDER` varchar(50) DEFAULT NULL,
  `ALAMAT` varchar(255) DEFAULT NULL,
  `ID_PROVINSI` int(11) DEFAULT NULL,
  `ID_KOTA` int(11) DEFAULT NULL,
  `IS_ACTIVE` int(11) DEFAULT '0',
  `DATE_CREATED` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msuserstandar`
--

INSERT INTO `msuserstandar` (`ID`, `NO_KTP`, `NAMA_LENGKAP`, `EMAIL`, `ROLE_ID`, `IMAGE`, `PASSWORD`, `NO_HANDPHONE`, `FAX`, `STAKEHOLDER`, `ALAMAT`, `ID_PROVINSI`, `ID_KOTA`, `IS_ACTIVE`, `DATE_CREATED`) VALUES
(4, 327503, 'Admin', 'admin@lapan.go.id', 96, 'default.jpg', '$2y$10$NlZK/buUmSFJT0HDtus7wOC1pB1mTMxpoeQQyFLxw9LY6ZEkarfga', '0812', '', NULL, 'Bekasi Utara', 1, 1, 3, 1569369006),
(9, 32155, 'Budiman', 'budidummy3228@gmail.com', 96, 'default.jpg', '$2y$10$hWoCaAzTZYZemKdPRb4clekpmp2RwlpeG9fVrQ9mzAjgTe7uXkXoO', '0821', '', NULL, 'Bekasi Utara', 32, 3275, 3, 1570067664);

-- --------------------------------------------------------

--
-- Table structure for table `msusertoken`
--

CREATE TABLE `msusertoken` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msusertoken`
--

INSERT INTO `msusertoken` (`id`, `email`, `token`, `date_created`) VALUES
(2, 'rifai.banisaleh@gmail.com', 't3Uxmb7aljq7CWkym2Ub5mAiAdMm/z5bULDXkcjF1CU=', 1569363729),
(3, 'rifai.banisaleh@gmail.com', 'Y8mEgOq3MxDEo6ktGJkViND1Mc5A4R8vF/W9Y4BNACA=', 1569365066),
(4, 'rifai.banisaleh@gmail.com', 'ttNkhWDzADYpVKW/Z9zgWtvLMUTHcxsar2WUpvC3d7A=', 1569368166),
(5, 'rifai.banisaleh@gmail.com', '5BLw49OHlNFows0gsIf6b0j7eKQBo/5pVK0IrGsBy7o=', 1569368724),
(6, 'rifai.banisaleh@gmail.com', 'BTszHGBQ5MTrmjx5Mj5O2mUNYMfAAnRMw6aXfb8FKug=', 1569368874);

-- --------------------------------------------------------

--
-- Table structure for table `msusertokenstd`
--

CREATE TABLE `msusertokenstd` (
  `ID` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `TOKEN` varchar(255) NOT NULL,
  `DATE_CREATED` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `msusulan`
--

CREATE TABLE `msusulan` (
  `ID` int(11) NOT NULL,
  `JENIS_STANDAR` int(11) NOT NULL,
  `KOMITE_TEKNIS` int(11) NOT NULL,
  `KODE` varchar(50) NOT NULL,
  `JUDUL` varchar(255) NOT NULL,
  `RUANG_LINGKUP` varchar(255) NOT NULL,
  `JENIS_PERUMUSAN` int(11) NOT NULL,
  `JALUR_PERUMUSAN` int(11) NOT NULL,
  `NO_SNI_RALAT` varchar(100) NOT NULL,
  `P_SNI_RALAT` varchar(300) NOT NULL,
  `NO_SNI_AMANDEMEN` varchar(100) NOT NULL,
  `P_SNI_AMANDEMEN` varchar(300) NOT NULL,
  `NO_SNI_TERJEMAH` varchar(100) NOT NULL,
  `JENIS_ADOPSI` int(11) NOT NULL,
  `METODE_ADOPSI` int(11) NOT NULL,
  `KEB_MENDESAK` int(11) NOT NULL,
  `DOK_KEB_MENDESAK` varchar(200) NOT NULL,
  `TERKAIT_PATEN` int(11) NOT NULL,
  `DOK_KESEDIAAN_PATEN` varchar(200) NOT NULL,
  `INFORMASI_PATEN` text NOT NULL,
  `DETAIL_PENELITIAN` text NOT NULL,
  `DOK_DETAIL_PENELITIAN` varchar(100) NOT NULL,
  `TUJUAN_PERUMUSAN` varchar(100) NOT NULL,
  `KESESUAIAN` text NOT NULL,
  `ULASAN` text NOT NULL,
  `ORG_PENDUKUNG` int(11) NOT NULL,
  `DOK_ORG_PENDUKUNG` varchar(100) NOT NULL,
  `EVALUASI` text NOT NULL,
  `SURAT_PENGAJUAN` varchar(100) NOT NULL,
  `OUTLINE` varchar(100) NOT NULL,
  `PROSES_USULAN` int(11) NOT NULL,
  `PROSES_PERUMUSAN` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL,
  `ALASAN_PENOLAKAN` text NOT NULL,
  `DOK_PEMBATALAN` varchar(100) NOT NULL,
  `USER_INPUT` int(11) NOT NULL,
  `TGL_INPUT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `msusulan`
--

INSERT INTO `msusulan` (`ID`, `JENIS_STANDAR`, `KOMITE_TEKNIS`, `KODE`, `JUDUL`, `RUANG_LINGKUP`, `JENIS_PERUMUSAN`, `JALUR_PERUMUSAN`, `NO_SNI_RALAT`, `P_SNI_RALAT`, `NO_SNI_AMANDEMEN`, `P_SNI_AMANDEMEN`, `NO_SNI_TERJEMAH`, `JENIS_ADOPSI`, `METODE_ADOPSI`, `KEB_MENDESAK`, `DOK_KEB_MENDESAK`, `TERKAIT_PATEN`, `DOK_KESEDIAAN_PATEN`, `INFORMASI_PATEN`, `DETAIL_PENELITIAN`, `DOK_DETAIL_PENELITIAN`, `TUJUAN_PERUMUSAN`, `KESESUAIAN`, `ULASAN`, `ORG_PENDUKUNG`, `DOK_ORG_PENDUKUNG`, `EVALUASI`, `SURAT_PENGAJUAN`, `OUTLINE`, `PROSES_USULAN`, `PROSES_PERUMUSAN`, `STATUS`, `ALASAN_PENOLAKAN`, `DOK_PEMBATALAN`, `USER_INPUT`, `TGL_INPUT`) VALUES
(2, 48, 50, '', 'Judul Standar SNI 1', 'R', 54, 67, '', '', '', '', '', 0, 0, 1, 'surat_kebutuhan_mendesak_2.pdf', 1, 'surat_kesediaan_pencantuman_paten_2.docx', '', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius repellendus quas veritatis eveniet qui eligendi, ut aut animi sint, sit quibusdam. Quae ipsam iure qui iste laborum doloribus laboriosam ut.', 'detail_penelitian_1570845400.pdf', 'T', '                                                                                        K                                                                                                                ', '                                                                                        U                                                                                                                  ', 1, 'lampiran_organisasi_pendukung_1570845400.pdf', 'EV', 'surat_pengajuan_1570845400.pdf', 'outline_1570845400.pdf', 109, 80, 100, '', '', 9, '2019-10-12'),
(3, 48, 50, '2019.49-01.15', 'Judul Standar 1310', 'Ruang', 54, 67, '', '', '', '', '', 0, 0, 1, 'surat_kebutuhan_mendesak_3.pdf', 0, '', '', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius repellendus quas veritatis eveniet qui eligendi, ut aut animi sint, sit quibusdam. Quae ipsam iure qui iste laborum doloribus laboriosam ut.', 'detail_penelitian_1570962600.pdf', 'Tujaun', '                                                                                                                                    Kesesuaian                                                                                                                                  ', '                                                                                                                                    Ulasan                                                                                                                        ', 1, 'lampiran_organisasi_pendukung_1570962600.pdf', 'Evaluasi', 'surat_pengajuan_1570962600.pdf', 'outline_1570962600.pdf', 109, 80, 102, '', '', 9, '2019-10-13'),
(4, 48, 50, '', 'j', 't', 0, 0, '', '', '', '', '', 0, 0, 0, '', 0, '', '', 'ew', 'detail_penelitian_1571034542.pdf', '', '', '', 0, '', '', 'surat_pengajuan_1571034542.pdf', 'outline_1571034542.pdf', 103, 0, 100, '', '', 9, '2019-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `posisi`
--

CREATE TABLE `posisi` (
  `id_posisi` int(11) NOT NULL,
  `nama_web` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posisi`
--

INSERT INTO `posisi` (`id_posisi`, `nama_web`) VALUES
(1, 'PUSISPAN'),
(2, 'IP-MAN'),
(3, 'SISPAN'),
(4, 'SILAT');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`id`, `email`, `code`) VALUES
(1, 'rifaigame29@gmail.com', '15d88c46ecc83b'),
(2, 'rifaigame29@gmail.com', '15d88c479a1530');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi`
--

CREATE TABLE `sertifikasi` (
  `id` int(11) NOT NULL,
  `no_sertifikasi` int(11) NOT NULL DEFAULT '0',
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sertifikasi`
--

INSERT INTO `sertifikasi` (`id`, `no_sertifikasi`, `nama`, `keterangan`) VALUES
(1, 1, 'Sertifikasi 1', 'Keterangan 1'),
(2, 2, 'Sertifikasi 2', 'Keterangan 2');

-- --------------------------------------------------------

--
-- Table structure for table `sop`
--

CREATE TABLE `sop` (
  `id_sop` int(5) NOT NULL,
  `judul` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_judul` varchar(100) NOT NULL,
  `nama_file` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tgl_posting` date NOT NULL,
  `hits` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sop`
--

INSERT INTO `sop` (`id_sop`, `judul`, `nama_judul`, `nama_file`, `tgl_posting`, `hits`) VALUES
(9, 'sop1', 'SOP 1', 'sample1.pdf', '2019-08-14', 0),
(10, 'sop2', 'SOP 2', '', '2019-08-14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tes`
--

CREATE TABLE `tes` (
  `as` varchar(50) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tes`
--

INSERT INTO `tes` (`as`, `tahun`) VALUES
('A', 2014),
('A', 2014),
('A', 2014),
('A', 2015),
('A', 2015),
('A', 2015),
('A', 2016),
('A', 2016),
('A', 2016),
('A', 2016),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2017),
('A', 2018),
('A', 2018),
('A', 2018),
('A', 2019);

-- --------------------------------------------------------

--
-- Table structure for table `trpembayaran`
--

CREATE TABLE `trpembayaran` (
  `ID` int(11) NOT NULL,
  `NOKWITANSI` varchar(15) DEFAULT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `KODE_TARIF` char(5) NOT NULL,
  `JENIS_PEMBAYARAN` varchar(50) NOT NULL,
  `PEMBAYARAN` decimal(10,0) NOT NULL,
  `BUKTI_PEMBAYARAN` varchar(100) NOT NULL,
  `INDEX` int(11) NOT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trpembayaran`
--

INSERT INTO `trpembayaran` (`ID`, `NOKWITANSI`, `NOMOR_PENDAFTAR`, `KODE_TARIF`, `JENIS_PEMBAYARAN`, `PEMBAYARAN`, `BUKTI_PEMBAYARAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`) VALUES
(9, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran5_P006.pdf', 0, '2019-08-20 07:42:30', NULL),
(10, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran6_P006.pdf', 0, '2019-08-20 07:43:03', NULL),
(11, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran7_P006.pdf', 0, '2019-08-20 08:41:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trpembayaran_backup`
--

CREATE TABLE `trpembayaran_backup` (
  `ID` int(11) NOT NULL,
  `NOKWITANSI` varchar(15) DEFAULT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `KODE_TARIF` char(5) NOT NULL,
  `JENIS_PEMBAYARAN` varchar(50) NOT NULL,
  `PEMBAYARAN` decimal(10,0) NOT NULL,
  `BUKTI_PEMBAYARAN` varchar(100) NOT NULL,
  `INDEX` int(11) NOT NULL,
  `TGL_INPUT` datetime DEFAULT NULL,
  `KODE_INPUT` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `trpembayaran_backup`
--

INSERT INTO `trpembayaran_backup` (`ID`, `NOKWITANSI`, `NOMOR_PENDAFTAR`, `KODE_TARIF`, `JENIS_PEMBAYARAN`, `PEMBAYARAN`, `BUKTI_PEMBAYARAN`, `INDEX`, `TGL_INPUT`, `KODE_INPUT`) VALUES
(9, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran5_P006.pdf', 0, '2019-08-20 07:42:30', NULL),
(10, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran6_P006.pdf', 0, '2019-08-20 07:43:03', NULL),
(11, NULL, 'P006', '', 'Permohonan Paten', '100000', 'bukti_pembayaran7_P006.pdf', 0, '2019-08-20 08:41:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trsaldo`
--

CREATE TABLE `trsaldo` (
  `ID` int(11) NOT NULL,
  `NOMOR_PENDAFTAR` varchar(15) NOT NULL,
  `TAHUN` int(11) DEFAULT NULL,
  `TAGIHAN` decimal(18,0) NOT NULL,
  `PEMBAYARAN` decimal(18,0) NOT NULL,
  `SISA` decimal(18,0) NOT NULL,
  `INDEX` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_message`
--

CREATE TABLE `visitor_message` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` varchar(600) DEFAULT NULL,
  `date` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitor_message`
--

INSERT INTO `visitor_message` (`id`, `name`, `email`, `subject`, `message`, `date`) VALUES
(18, 'Arif', 'arif02@gmail.com', 'arif', 'asdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdfasfdasdfasdfasfsafzxcasdfsafasdf', '2019-09-03 08:29:58'),
(19, 'Bryan', 'bryan0909@gmail.com', 'tes', 'tes isi pesan', '2019-09-09 06:00:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indexes for table `akses_cepat`
--
ALTER TABLE `akses_cepat`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `ddesainindustri`
--
ALTER TABLE `ddesainindustri`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dhakcipta`
--
ALTER TABLE `dhakcipta`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dmerek`
--
ALTER TABLE `dmerek`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dokumen_panduan`
--
ALTER TABLE `dokumen_panduan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`id_download`);

--
-- Indexes for table `dpaten`
--
ALTER TABLE `dpaten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_acuan_nonsni`
--
ALTER TABLE `d_acuan_nonsni`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_acuan_sni`
--
ALTER TABLE `d_acuan_sni`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_bibliografi`
--
ALTER TABLE `d_bibliografi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_konseptor`
--
ALTER TABLE `d_konseptor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_konseptor_utama`
--
ALTER TABLE `d_konseptor_utama`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_lpk`
--
ALTER TABLE `d_lpk`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_manfaat`
--
ALTER TABLE `d_manfaat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_perbaikan`
--
ALTER TABLE `d_perbaikan`
  ADD PRIMARY KEY (`ID_USULAN`);

--
-- Indexes for table `d_pihak_berkepentingan`
--
ALTER TABLE `d_pihak_berkepentingan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `d_regulasi`
--
ALTER TABLE `d_regulasi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `halamanstatis`
--
ALTER TABLE `halamanstatis`
  ADD PRIMARY KEY (`id_halaman`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`id_identitas`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `link_terkait`
--
ALTER TABLE `link_terkait`
  ADD PRIMARY KEY (`id_link`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `msdesainindustri`
--
ALTER TABLE `msdesainindustri`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msdokumen`
--
ALTER TABLE `msdokumen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mshakcipta`
--
ALTER TABLE `mshakcipta`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msipmancode`
--
ALTER TABLE `msipmancode`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msjenisdokumen`
--
ALTER TABLE `msjenisdokumen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mskonseptor`
--
ALTER TABLE `mskonseptor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mskota`
--
ALTER TABLE `mskota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `msmerek`
--
ALTER TABLE `msmerek`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msnonpegawai`
--
ALTER TABLE `msnonpegawai`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mspaten`
--
ALTER TABLE `mspaten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mspegawai`
--
ALTER TABLE `mspegawai`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mspembatalan`
--
ALTER TABLE `mspembatalan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msperiode`
--
ALTER TABLE `msperiode`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msrev`
--
ALTER TABLE `msrev`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mstarif`
--
ALTER TABLE `mstarif`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msuser`
--
ALTER TABLE `msuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msuserstandar`
--
ALTER TABLE `msuserstandar`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msusertoken`
--
ALTER TABLE `msusertoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msusertokenstd`
--
ALTER TABLE `msusertokenstd`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `msusulan`
--
ALTER TABLE `msusulan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `posisi`
--
ALTER TABLE `posisi`
  ADD PRIMARY KEY (`id_posisi`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sop`
--
ALTER TABLE `sop`
  ADD PRIMARY KEY (`id_sop`);

--
-- Indexes for table `trpembayaran`
--
ALTER TABLE `trpembayaran`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `trpembayaran_backup`
--
ALTER TABLE `trpembayaran_backup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `trsaldo`
--
ALTER TABLE `trsaldo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `visitor_message`
--
ALTER TABLE `visitor_message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `akses_cepat`
--
ALTER TABLE `akses_cepat`
  MODIFY `id_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;
--
-- AUTO_INCREMENT for table `ddesainindustri`
--
ALTER TABLE `ddesainindustri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `dhakcipta`
--
ALTER TABLE `dhakcipta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `dmerek`
--
ALTER TABLE `dmerek`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `dokumen_panduan`
--
ALTER TABLE `dokumen_panduan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `download`
--
ALTER TABLE `download`
  MODIFY `id_download` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `dpaten`
--
ALTER TABLE `dpaten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;
--
-- AUTO_INCREMENT for table `d_acuan_nonsni`
--
ALTER TABLE `d_acuan_nonsni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_acuan_sni`
--
ALTER TABLE `d_acuan_sni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_bibliografi`
--
ALTER TABLE `d_bibliografi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_konseptor`
--
ALTER TABLE `d_konseptor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `d_konseptor_utama`
--
ALTER TABLE `d_konseptor_utama`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `d_lpk`
--
ALTER TABLE `d_lpk`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_manfaat`
--
ALTER TABLE `d_manfaat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_pihak_berkepentingan`
--
ALTER TABLE `d_pihak_berkepentingan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `d_regulasi`
--
ALTER TABLE `d_regulasi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `halamanstatis`
--
ALTER TABLE `halamanstatis`
  MODIFY `id_halaman` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `identitas`
--
ALTER TABLE `identitas`
  MODIFY `id_identitas` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `link_terkait`
--
ALTER TABLE `link_terkait`
  MODIFY `id_link` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `msdesainindustri`
--
ALTER TABLE `msdesainindustri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `msdokumen`
--
ALTER TABLE `msdokumen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2995;
--
-- AUTO_INCREMENT for table `mshakcipta`
--
ALTER TABLE `mshakcipta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `msipmancode`
--
ALTER TABLE `msipmancode`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `msjenisdokumen`
--
ALTER TABLE `msjenisdokumen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `mskonseptor`
--
ALTER TABLE `mskonseptor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `msmerek`
--
ALTER TABLE `msmerek`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `msnonpegawai`
--
ALTER TABLE `msnonpegawai`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `mspaten`
--
ALTER TABLE `mspaten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;
--
-- AUTO_INCREMENT for table `mspegawai`
--
ALTER TABLE `mspegawai`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mspembatalan`
--
ALTER TABLE `mspembatalan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `msrev`
--
ALTER TABLE `msrev`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `mstarif`
--
ALTER TABLE `mstarif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `msuser`
--
ALTER TABLE `msuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `msuserstandar`
--
ALTER TABLE `msuserstandar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `msusertoken`
--
ALTER TABLE `msusertoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `msusertokenstd`
--
ALTER TABLE `msusertokenstd`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `msusulan`
--
ALTER TABLE `msusulan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posisi`
--
ALTER TABLE `posisi`
  MODIFY `id_posisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sop`
--
ALTER TABLE `sop`
  MODIFY `id_sop` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `trpembayaran`
--
ALTER TABLE `trpembayaran`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `trpembayaran_backup`
--
ALTER TABLE `trpembayaran_backup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `trsaldo`
--
ALTER TABLE `trsaldo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visitor_message`
--
ALTER TABLE `visitor_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
