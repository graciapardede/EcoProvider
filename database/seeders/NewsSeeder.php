<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua berita lama jika ada
        News::truncate();

        $newsData = [
            [
                'title' => 'Program Bank Sampah Nasional Tingkatkan Partisipasi Warga',
                'summary' => 'Program Bank Sampah Nasional berhasil meningkatkan partisipasi masyarakat dalam pengelolaan sampah di berbagai daerah dengan melibatkan lebih dari 5.000 bank sampah aktif.',
                'content' => 'Program Bank Sampah Nasional yang diluncurkan pemerintah berhasil meningkatkan partisipasi warga dalam pengelolaan sampah. Hingga saat ini, tercatat lebih dari 5.000 bank sampah telah beroperasi di seluruh Indonesia dengan melibatkan jutaan warga. Program ini tidak hanya membantu mengurangi volume sampah, tetapi juga memberikan nilai ekonomis bagi masyarakat. Warga dapat menukarkan sampah yang telah dipilah dengan uang atau barang kebutuhan sehari-hari. Keberhasilan program ini menunjukkan bahwa dengan edukasi dan sistem yang tepat, masyarakat dapat berperan aktif dalam menjaga lingkungan.',
                'category' => 'Pengelolaan Sampah',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&h=400&fit=crop',
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Kampanye Pemilahan Sampah Berhasil Kurangi 40% Sampah Plastik',
                'summary' => 'Kampanye pemilahan sampah di beberapa kota besar Indonesia berhasil mengurangi sampah plastik hingga 40 persen.',
                'content' => 'Kampanye pemilahan sampah yang dilakukan selama 6 bulan terakhir di Jakarta, Surabaya, dan Bandung menunjukkan hasil menggembirakan. Data menunjukkan pengurangan sampah plastik hingga 40% setelah masyarakat aktif memilah sampah organik dan anorganik. Pemerintah daerah memberikan apresiasi kepada kelurahan-kelurahan yang berhasil menerapkan program ini dengan baik. Pemilahan sampah dari sumbernya terbukti efektif mengurangi beban TPA dan memudahkan proses daur ulang. Program ini akan terus dikembangkan ke kota-kota lain di Indonesia.',
                'category' => 'Daur Ulang',
                'thumbnail_url' => 'https://picsum.photos/600/400?random=2',
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Startup Energi Terbarukan Kembangkan Panel Surya Murah',
                'summary' => 'Startup lokal berhasil mengembangkan panel surya dengan harga terjangkau untuk masyarakat Indonesia.',
                'content' => 'Sebuah startup energi terbarukan asal Bandung berhasil mengembangkan panel surya dengan harga 30% lebih murah dari produk impor. Inovasi ini diharapkan dapat mempercepat adopsi energi terbarukan di Indonesia, terutama di daerah-daerah yang belum terjangkau listrik PLN. Panel surya ini menggunakan teknologi sel surya generasi terbaru dengan efisiensi konversi energi hingga 22%. Startup ini juga menawarkan skema pembiayaan yang memudahkan masyarakat untuk beralih ke energi bersih. Pemerintah memberikan dukungan penuh melalui insentif pajak dan kemudahan perizinan.',
                'category' => 'Energi Terbarukan',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Mahasiswa Ciptakan IoT Tempat Sampah Pintar',
                'summary' => 'Mahasiswa ITS Surabaya menciptakan tempat sampah pintar berbasis IoT yang dapat memilah sampah otomatis.',
                'content' => 'Tiga mahasiswa Institut Teknologi Sepuluh Nopember (ITS) Surabaya berhasil menciptakan tempat sampah pintar berbasis Internet of Things (IoT). Tempat sampah ini dilengkapi dengan sensor yang dapat mendeteksi jenis sampah dan memilahnya secara otomatis ke dalam kategori organik, anorganik, dan B3. Inovasi ini juga dilengkapi dengan sistem monitoring kapasitas tempat sampah yang terhubung dengan aplikasi mobile, sehingga petugas kebersihan dapat mengetahui kapan tempat sampah perlu dikosongkan. Tempat sampah pintar ini telah diuji coba di kampus ITS dan mendapat respons positif. Tim mahasiswa ini berencana untuk mengkomersialkan produknya.',
                'category' => 'Teknologi',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Kota Hijau 2030: Pemerintah Targetkan 1 Juta Pohon',
                'summary' => 'Program Kota Hijau 2030 menargetkan penanaman 1 juta pohon di kawasan perkotaan untuk mengurangi polusi udara.',
                'content' => 'Kementerian Lingkungan Hidup dan Kehutanan meluncurkan program Kota Hijau 2030 dengan target penanaman 1 juta pohon di berbagai kota di Indonesia. Program ini bertujuan untuk meningkatkan kualitas udara, mengurangi suhu perkotaan, dan menciptakan ruang terbuka hijau yang lebih luas. Jenis pohon yang ditanam adalah pohon-pohon yang memiliki kemampuan tinggi dalam menyerap karbon dioksida dan menghasilkan oksigen. Masyarakat, perusahaan, dan komunitas lingkungan diajak untuk berpartisipasi dalam program ini. Setiap pohon yang ditanam akan dipantau pertumbuhannya menggunakan sistem digital untuk memastikan keberhasilan program.',
                'category' => 'Lingkungan',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Komunitas Zero Waste Ajak Masyarakat Kurangi Sampah Plastik',
                'summary' => 'Komunitas Zero Waste Indonesia mengajak masyarakat untuk menerapkan gaya hidup minim sampah dalam kehidupan sehari-hari.',
                'content' => 'Komunitas Zero Waste Indonesia terus mengampanyekan gaya hidup minim sampah kepada masyarakat. Melalui berbagai workshop dan seminar, komunitas ini memberikan edukasi praktis tentang cara mengurangi penggunaan plastik sekali pakai, mengolah sampah organik menjadi kompos, dan memanfaatkan kembali barang-barang bekas. Gerakan ini mendapat sambutan positif dari berbagai kalangan, terutama generasi muda yang semakin peduli terhadap isu lingkungan. Komunitas ini juga menjalin kerjasama dengan pelaku usaha untuk menyediakan produk-produk ramah lingkungan yang mudah diakses masyarakat. Target mereka adalah menginspirasi 1 juta orang untuk menerapkan gaya hidup zero waste pada tahun 2026.',
                'category' => 'Gaya Hidup',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Kendaraan Listrik Ramah Lingkungan Semakin Diminati',
                'summary' => 'Penjualan kendaraan listrik di Indonesia meningkat 150% seiring kesadaran masyarakat terhadap lingkungan.',
                'content' => 'Pasar kendaraan listrik di Indonesia mengalami pertumbuhan signifikan dengan peningkatan penjualan hingga 150% dibandingkan tahun lalu. Faktor utama yang mendorong pertumbuhan ini adalah meningkatnya kesadaran masyarakat akan pentingnya mengurangi emisi karbon dan dukungan pemerintah melalui insentif pajak. Infrastruktur pengisian daya listrik juga terus dikembangkan di berbagai kota besar. Produsen kendaraan listrik berlomba-lomba menawarkan produk dengan harga yang semakin terjangkau. Analis memperkirakan bahwa dalam 5 tahun ke depan, kendaraan listrik akan menjadi pilihan utama masyarakat Indonesia.',
                'category' => 'Transportasi',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Peneliti Temukan Bakteri Pemakan Plastik di Lautan Indonesia',
                'summary' => 'Tim peneliti dari LIPI menemukan bakteri yang dapat mengurai plastik di perairan Indonesia.',
                'content' => 'Tim peneliti dari Lembaga Ilmu Pengetahuan Indonesia (LIPI) menemukan jenis bakteri baru yang memiliki kemampuan mengurai plastik di perairan Indonesia. Bakteri ini ditemukan di kawasan Teluk Jakarta dan mampu mengurai plastik jenis PET dan PE dalam waktu yang relatif singkat. Penemuan ini membuka harapan baru dalam mengatasi masalah pencemaran plastik di laut. Peneliti sedang mengembangkan teknologi untuk mengaplikasikan bakteri ini dalam skala yang lebih besar. Jika berhasil, teknologi ini dapat menjadi solusi efektif untuk membersihkan sampah plastik di lautan Indonesia yang semakin mengkhawatirkan.',
                'category' => 'Penelitian',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Festival Lingkungan 2025 Ajak Generasi Muda Peduli Bumi',
                'summary' => 'Festival Lingkungan 2025 dihadiri ribuan anak muda untuk belajar dan berbagi tentang pelestarian lingkungan.',
                'content' => 'Festival Lingkungan 2025 yang diselenggarakan di Jakarta Convention Center berhasil menarik perhatian lebih dari 10.000 pengunjung, mayoritas adalah generasi muda. Festival ini menampilkan berbagai kegiatan edukatif seperti workshop daur ulang, talkshow dengan aktivis lingkungan, pameran produk ramah lingkungan, dan kompetisi inovasi hijau. Peserta antusias belajar tentang berbagai cara menjaga lingkungan dalam kehidupan sehari-hari. Acara ini juga menjadi wadah bagi startup dan UMKM yang bergerak di bidang lingkungan untuk memamerkan produk mereka. Penyelenggara berharap festival ini dapat menjadi agenda tahunan yang menginspirasi lebih banyak generasi muda untuk peduli lingkungan.',
                'category' => 'Event',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Aplikasi Green Saving Bantu Masyarakat Hidup Lebih Hijau',
                'summary' => 'Aplikasi Green Saving diluncurkan untuk membantu masyarakat menerapkan gaya hidup ramah lingkungan dengan mudah.',
                'content' => 'Aplikasi Green Saving resmi diluncurkan sebagai solusi digital untuk membantu masyarakat menerapkan gaya hidup ramah lingkungan. Aplikasi ini menyediakan berbagai fitur seperti kalkulator jejak karbon, tips hemat energi, direktori produk ramah lingkungan, dan sistem reward untuk pengguna yang konsisten menjalankan kebiasaan hijau. Pengguna juga dapat berbagi pengalaman dan belajar dari komunitas pengguna lainnya. Dalam sebulan pertama, aplikasi ini telah diunduh lebih dari 50.000 kali dan mendapat rating tinggi di toko aplikasi. Developer berkomitmen untuk terus mengembangkan fitur-fitur baru yang dapat membantu masyarakat Indonesia berkontribusi dalam pelestarian lingkungan.',
                'category' => 'Teknologi',
                'thumbnail_url' => null,
                'published_at' => now()->subDays(rand(1, 30)),
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }
    }
}
