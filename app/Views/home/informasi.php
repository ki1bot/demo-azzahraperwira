<section class="bg-az-green py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Informasi & Berita</h1>
        <p class="text-az-gold text-lg italic">Pusat informasi terbaru seputar kegiatan dan agenda sekolah</p>
    </div>
</section>

<main class="container mx-auto px-6 py-12">
    
	<section class="mb-16 bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-8 md:p-12 text-white shadow-xl">
		<div class="grid md:grid-cols-2 gap-8 items-center">
			<div>
				<span class="inline-block bg-az-gold text-az-green font-bold px-4 py-1 rounded-full text-sm mb-4">
					PENGUMUMAN PENTING
				</span>
				
				<h2 class="text-3xl md:text-4xl font-bold mb-4">
					Penerimaan Siswa Baru Tahun Ajaran 2026/2027
				</h2>
				
				<p class="text-indigo-100 mb-6 leading-relaxed">
					Kami membuka pendaftaran untuk KB, TK, Daycare, dan Program Tahfidz. Pastikan buah hati Anda mendapatkan pendidikan terbaik dengan fondasi akhlak Islami. Segera daftar sebelum kuota terpenuhi!
				</p>
				
				<a href="<?php echo base_url('assets/file/brosur-azzahra-2025.pdf'); ?>" 
				   target="_blank" 
				   class="inline-block bg-white text-indigo-900 font-bold px-8 py-3 rounded-full hover:bg-indigo-50 transition duration-300">
				   Download Brosur Pendaftaran
				</a>
			</div>
		</div>
	</section>

	
    <section>
		<h3 class="text-3xl font-bold text-az-green mb-10 text-center">Kegiatan Terbaru</h3>
        
		<?php
		// Contoh array data (nantinya bisa diganti dengan query database)
		$kegiatanList = [
			[
				'idInformasi' => 1,
				'image'       => 'kegiatan_00001.jpg',
				'date'        => '15 April 2026',
				'title'       => 'Kajian Rutin Majelis Ta\'lim',
				'excerpt'     => 'Membahas tema "Membangun Keluarga Sakinah di Usia Senja" bersama Ustadz kondang di lingkungan yayasan...'
			],
			[
				'idInformasi' => 2,
				'image'       => 'kegiatan_00002.jpg',
				'date'        => '20 April 2026',
				'title'       => 'Mansasik Haji Siswa TK',
				'excerpt'     => 'Kegiatan Mansik Haji bagi siswa KB-TK Az-Zahra sebagai bagian dari penguatan Rukun Islam...'
			],
			[
				'idInformasi' => 3,
				'image'       => 'kegiatan_00003.jpg',
				'date'        => '10 April 2026',
				'title'       => 'Field Trip Edukasi',
				'excerpt'     => 'Siswa Daycare dan KB mengunjungi taman edukasi untuk mengenal alam dan lingkungan sekitar...'
			]
		];
		?>		
				
		
		
		<div class="grid md:grid-cols-3 gap-8">
			<?php foreach ($kegiatanList as $item): ?>
				<div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
					<img src="<?php echo base_url('assets/img/informasi/' . $item['image']); ?>" 
						 class="w-full h-48 object-cover" 
						 alt="<?php echo $item['title']; ?>">
					
					<div class="p-6">
						<span class="text-az-gold text-sm font-semibold uppercase">
							<?php echo $item['date']; ?>
						</span>
						
						<h4 class="text-xl font-bold text-az-green mt-2 mb-3">
							<?php echo $item['title']; ?>
						</h4>
						
						<p class="text-gray-600 text-sm leading-relaxed mb-4">
							<?php echo $item['excerpt']; ?>
						</p>
						
						<a href="<?php echo '#'; ?>" 
						   class="text-az-green font-bold hover:underline">
							Baca Selengkapnya →
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>


    </section>
</main>