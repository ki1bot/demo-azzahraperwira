<div id="divUtama">
    <div class="bg-az-green py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Tenaga Pengajar</h1>
            <p class="text-az-gold text-lg italic">Profil Pendidik & Tenaga Kependidikan Profesional</p>
        </div>
    </div>

    <main class="container mx-auto px-6 py-12">
        
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-az-green mb-8 border-l-4 border-az-gold pl-4">Pendidik Rumah Quran (RTQ)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php 
                // Data berdasarkan dokumen [cite: 2]
				$rtq_staff = [
					["Nama" => "Galih Muharik, M.Pd", "Jabatan" => "Mudir & Guru Tahfidz", "Lulusan" => "S2", "urlFoto" => "Galih-Munarik.jpg"],
					["Nama" => "Ahmad Zaki Fannani", "Jabatan" => "Guru Tahfidz", "Lulusan" => "Madrasah A’liyah", "urlFoto" => ""],
					["Nama" => "Nusaibah Az Zahri, S.Pd.I", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Siti Nurul Mu’minah", "Jabatan" => "Guru Tahfidz", "Lulusan" => "D2", "urlFoto" => ""],
					["Nama" => "Shaffa Muthiara M.C, S.Ag", "Jabatan" => "Guru Tahfidz", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Nahda Tsabita, S.Ag", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Fahmia Nuha Tsabita, S.Pd", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Fairuz Silmi Nabilah, S.Psi", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Farhah Millati K, S.Pd", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Luthfiah Kamili, S.Pd", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Fauziyyatusy Syarif A", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""]
				];

                foreach($rtq_staff as $staff): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 hover:shadow-lg transition text-center">
					<div class="w-24 h-24 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden border-2 border-az-gold shadow-sm">
						<?php if (!empty($staff['urlFoto'])): ?>
							<img src="<?php echo base_url('assets/img/tenagaPengajar/'.$staff['urlFoto']); ?>" alt="<?php echo $staff['Nama']; ?>" class="w-full h-full object-cover">
						<?php else: ?>
							<svg class="w-12 h-12 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
							</svg>
						<?php endif; ?>
					</div>
                    <h3 class="font-bold text-az-green"><?php echo $staff['Nama']; ?></h3>
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mt-2 mb-2">
                        <?php echo $staff['Lulusan']; ?>
                    </span>
                    <p class="text-sm text-gray-600"><?php echo $staff['Jabatan']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-3xl font-bold text-az-green mb-8 border-l-4 border-az-gold pl-4">Pendidik TPQ</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php 
                // Data berdasarkan dokumen [cite: 4]
                $tpq_staff = [
					["Nama" => "Galih Muharik, M.Pd", "Jabatan" => "Mudir & Guru Tahfidz", "Lulusan" => "S2", "urlFoto" => "Galih-Munarik.jpg"],
					["Nama" => "Luthfiah Kamili, S.Pd", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],
					["Nama" => "Fahmia Nuha Tsabita, S.Pd", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""],

                    ["Nama" => "Lucky Hidayati, S.Pd", "Jabatan" => "Guru", "Lulusan" => "S1", "urlFoto" => ""],
                    ["Nama" => "Nadhifa Qurota A’ini", "Jabatan" => "Guru", "Lulusan" => "Madrasah A’liyah", "urlFoto" => ""],
                ];
				

                foreach($tpq_staff as $staff): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 hover:shadow-lg transition text-center">
					<div class="w-24 h-24 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden border-2 border-az-gold shadow-sm">
						<?php if (!empty($staff['urlFoto'])): ?>
							<img src="<?php echo base_url('assets/img/tenagaPengajar/'.$staff['urlFoto']); ?>" alt="<?php echo $staff['Nama']; ?>" class="w-full h-full object-cover">
						<?php else: ?>
							<svg class="w-12 h-12 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
							</svg>
						<?php endif; ?>
					</div>
                    <h3 class="font-bold text-az-green"><?php echo $staff['Nama']; ?></h3>
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mt-2 mb-2">
                        <?php echo $staff['Lulusan']; ?>
                    </span>
                    <p class="text-sm text-gray-600"><?php echo $staff['Jabatan']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
		
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-az-green mb-8 border-l-4 border-az-gold pl-4">Pendidik Day Care</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php 
                // Data berdasarkan dokumen [cite: 4]
                $dc_staff = [
                     ["Nama" => "Fauziyyatusy Syarif A", "Jabatan" => "Guru Tahfidz Juz 30", "Lulusan" => "S1", "urlFoto" => ""]
               ];

                foreach($dc_staff as $staff): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 hover:shadow-lg transition text-center">
					<div class="w-24 h-24 bg-slate-100 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden border-2 border-az-gold shadow-sm">
						<?php if (!empty($staff['urlFoto'])): ?>
							<img src="<?php echo base_url('assets/img/tenagaPengajar/'.$staff['urlFoto']); ?>" alt="<?php echo $staff['Nama']; ?>" class="w-full h-full object-cover">
						<?php else: ?>
							<svg class="w-12 h-12 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
							</svg>
						<?php endif; ?>
					</div>
                    <h3 class="font-bold text-az-green"><?php echo $staff['Nama']; ?></h3>
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full mt-2 mb-2">
                        <?php echo $staff['Lulusan']; ?>
                    </span>
                    <p class="text-sm text-gray-600"><?php echo $staff['Jabatan']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>		


    </main>
</div>