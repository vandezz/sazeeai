<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="relative min-h-screen bg-gray-950 overflow-hidden">

    <!-- Ambient glow blobs -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -left-40 w-80 h-80 bg-violet-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/3 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
    </div>

<section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
         x-data="promptGenerator()">

    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-semibold mb-4 uppercase tracking-widest">
            <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-pulse"></span>
            AI-Powered Prompt Generator
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">Generator AI Prompt Banner Iklan</h1>
        <p class="text-gray-400 max-w-xl mx-auto">Isi detail Judul, Deskripsi Produk Anda, dan dapatkan prompt AI profesional siap pakai dalam hitungan detik.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

        <!-- ========================
             INPUT FORM
             ======================== -->
        <div class="bg-gray-900/70 backdrop-blur-sm rounded-2xl border border-gray-700/60 shadow-xl shadow-black/40 overflow-hidden">

            <form @submit.prevent="generate()" class="divide-y divide-gray-800/70">
                <?= csrf_field() ?>

                <!-- MODE TOGGLE: Manual vs Template -->
                <?php if (! empty($templates)): ?>
                <div class="px-6 pt-5 pb-4">
                    <div class="flex items-center bg-gray-800/60 rounded-xl p-1 gap-1">
                        <button type="button"
                                @click="setMode('manual')"
                                :class="mode === 'manual' ? 'bg-gray-700 text-white shadow' : 'text-gray-400 hover:text-gray-300'"
                                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Isi Manual
                        </button>
                        <button type="button"
                                @click="setMode('template')"
                                :class="mode === 'template' ? 'bg-violet-600 text-white shadow' : 'text-gray-400 hover:text-gray-300'"
                                class="flex-1 flex items-center justify-center gap-2 py-2 px-3 rounded-lg text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Pakai Template
                        </button>
                    </div>

                    <!-- Template cards — hanya tampil saat mode template -->
                    <div x-show="mode === 'template'" x-transition class="mt-3 space-y-2" x-cloak>
                        <p class="text-xs text-gray-500">Pilih jenis output prompt yang diinginkan:</p>
                        <div class="grid grid-cols-2 gap-2">
                            <?php
                            $catIcons = [
                                'flyer'  => ['color' => 'bg-orange-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                                'social' => ['color' => 'bg-blue-500',   'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>'],
                                'poster' => ['color' => 'bg-purple-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                                'email'  => ['color' => 'bg-teal-500',   'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
                            ];
                            $defaultIcon = ['color' => 'bg-gray-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>'];
                            foreach ($templates as $tpl):
                                $icon = $catIcons[$tpl['category']] ?? $defaultIcon;
                            ?>
                            <button type="button"
                                    @click="form.template_slug = '<?= esc($tpl['slug']) ?>'"
                                    :class="form.template_slug === '<?= esc($tpl['slug']) ?>' ? 'border-violet-500 bg-violet-900/30 ring-1 ring-violet-500/40' : 'border-gray-700/80 bg-gray-800/40 hover:border-gray-500'"
                                    class="relative flex items-start gap-2.5 p-3 rounded-xl border transition-all text-left">
                                <div class="w-7 h-7 rounded-lg <?= $icon['color'] ?> flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $icon['svg'] ?></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-white leading-tight"><?= esc($tpl['name']) ?></p>
                                    <p class="text-[10px] uppercase tracking-widest text-gray-500 mt-0.5"><?= esc($tpl['category']) ?></p>
                                </div>
                                <div x-show="form.template_slug === '<?= esc($tpl['slug']) ?>'" class="absolute top-2 right-2" x-cloak>
                                    <svg class="w-3.5 h-3.5 text-violet-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- SECTION A: Informasi Brand & Produk -->
                <div class="px-6 pt-6 pb-5 space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">A. Informasi Brand &amp; Produk</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Nama Brand <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.brand_name" required maxlength="255"
                                   class="form-input" placeholder="Contoh: NexaTech">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" x-model="form.product_name" maxlength="255"
                                   class="form-input" placeholder="Contoh: AirMax Pro">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Judul Utama (Headline)</label>
                        <input type="text" x-model="form.headline" maxlength="255"
                               class="form-input" placeholder="Contoh: Supercharge Your Workflow">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sub Judul / Tagline</label>
                        <input type="text" x-model="form.subheadline" maxlength="255"
                               class="form-input" placeholder="Contoh: The ultimate AI-powered productivity tool.">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Singkat <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea x-model="form.product_description" rows="3"
                                  class="form-input min-h-[72px]" style="resize: vertical;" placeholder="Gambarkan produk secara singkat..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">CTA / Call-to-Action <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" x-model="form.cta_text" maxlength="150"
                               class="form-input" placeholder="Contoh: Order Sekarang / WA: 0812xxxxxxxx">
                        <p class="form-hint">Opsional — isi jika ingin banner memiliki tombol CTA atau kontak WhatsApp.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Audiens <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" x-model="form.target_audience" maxlength="255"
                               class="form-input" placeholder="Contoh: Pebisnis 25–40 tahun">
                    </div>
                </div>

                <!-- SECTION B: Fitur & Layout Produk -->
                <div class="px-6 pt-6 pb-5 space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-violet-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">B. Fitur &amp; Layout Produk</h3>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fitur Unggulan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea x-model="form.features" rows="4"
                                  class="form-input resize-none" placeholder="Pisahkan dengan Enter atau koma&#10;Contoh:&#10;Integrasi API Mudah&#10;Keamanan Data End-to-End&#10;Laporan Real-Time"></textarea>
                        <p class="form-hint">Biarkan kosong jika tidak ingin menampilkan poin fitur di banner.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Jumlah Foto Produk</label>
                            <select x-model="form.image_count" class="form-input">
                                <?php foreach (['1','2','3','4'] as $n): ?>
                                <option value="<?= $n ?>"><?= $n ?> foto</option>
                                <?php endforeach; ?>
                            </select>
                            <p class="form-hint">Sesuaikan dengan jumlah foto produk yang akan di-upload ke AI.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Posisi Produk di Banner</label>
                            <select x-model="form.image_position" class="form-input">
                                <?php foreach (['Center','Left','Right','Bottom','Top'] as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION C: Gaya Visual -->
                <div class="px-6 pt-6 pb-5 space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-pink-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">C. Gaya Visual</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Design Style <span class="text-red-500">*</span></label>
                            <select x-model="form.design_style" required class="form-input">
                                <option value="">Pilih style...</option>
                                <?php foreach ($styles as $style): ?>
                                <option value="<?= esc($style['name']) ?>"><?= esc($style['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Color Theme <span class="text-red-500">*</span></label>
                            <select x-model="colorThemeSelect"
                                    @change="colorThemeSelect === '__custom__' ? updateCustomColor() : (form.color_theme = colorThemeSelect)"
                                    :required="colorThemeSelect !== '__custom__'"
                                    class="form-input">
                                <option value="">Pilih warna...</option>
                                <?php foreach (['Gold & Black','Blue & White','Red & Black','Green & White','Purple & Gold','Monochrome','Pastel Tones','Neon & Dark','Earthy Tones','Vibrant Multi-Color'] as $c): ?>
                                <option value="<?= $c ?>"><?= $c ?></option>
                                <?php endforeach; ?>
                                <option value="__custom__">✏️ Custom...</option>
                            </select>

                            <!-- Custom color section -->
                            <div x-show="colorThemeSelect === '__custom__'" class="mt-2 space-y-2" x-cloak>
                                <!-- Color pickers -->
                                <div class="flex items-center gap-2">
                                    <div class="flex-1">
                                        <p class="text-[11px] text-gray-500 mb-1">Warna Utama</p>
                                        <div class="flex items-center gap-2">
                                            <input type="color" x-model="colorPrimary"
                                                   @input="updateCustomColor()"
                                                   class="w-9 h-9 rounded-lg border border-gray-600 bg-transparent cursor-pointer p-0.5">
                                            <span class="text-xs font-mono text-gray-400" x-text="colorPrimary"></span>
                                        </div>
                                    </div>
                                    <div class="text-gray-500 font-bold mt-4">&amp;</div>
                                    <div class="flex-1">
                                        <p class="text-[11px] text-gray-500 mb-1">Warna Sekunder</p>
                                        <div class="flex items-center gap-2">
                                            <input type="color" x-model="colorSecondary"
                                                   @input="updateCustomColor()"
                                                   class="w-9 h-9 rounded-lg border border-gray-600 bg-transparent cursor-pointer p-0.5">
                                            <span class="text-xs font-mono text-gray-400" x-text="colorSecondary"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Preview + text override -->
                                <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-700 bg-gray-800/50">
                                    <div class="w-6 h-6 rounded shrink-0" :style="'background: linear-gradient(135deg,' + colorPrimary + ' 50%,' + colorSecondary + ' 50%)'" ></div>
                                    <input x-model="form.color_theme"
                                           type="text"
                                           :required="colorThemeSelect === '__custom__'"
                                           class="flex-1 bg-transparent text-xs text-white outline-none"
                                           placeholder="Nama warna bebas, contoh: Tosca &amp; Gold">
                                </div>
                                <p class="text-[11px] text-gray-500">Pilih dari color picker atau ketik nama warna langsung.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label class="form-label">Mood / Suasana</label>
                            <select x-model="form.image_mood" class="form-input">
                                <option value="">Pilih mood</option>
                                <?php foreach (['Luxurious','Energetic','Calm & Serene','Bold & Powerful','Playful','Professional','Dark & Moody','Bright & Cheerful'] as $m): ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipografi</label>
                            <select x-model="form.typography_style" class="form-input">
                                <option value="">Pilih tipografi</option>
                                <?php foreach (['Modern Sans-Serif','Elegant Serif','Bold Display','Handwritten Script','Futuristic','Classic Condensed'] as $t): ?>
                                <option value="<?= $t ?>"><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pencahayaan</label>
                            <select x-model="form.lighting_style" class="form-input">
                                <option value="">Pilih lighting</option>
                                <?php foreach (['Studio Lighting','Cinematic','Soft Diffused','Dramatic Shadows','Golden Hour','Neon Glow','High Key','Low Key'] as $l): ?>
                                <option value="<?= $l ?>"><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION D: Pengaturan Output -->
                <div class="px-6 pt-6 pb-5 space-y-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-white">D. Pengaturan Output</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">AI Platform <span class="text-red-500">*</span></label>
                            <select x-model="form.ai_platform" required class="form-input">
                                <option value="">Pilih platform...</option>
                                <?php foreach ($platforms as $platform): ?>
                                <option value="<?= esc($platform['slug']) ?>"><?= esc($platform['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="form-hint">Pilih sesuai AI tool yang akan kamu gunakan.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ukuran / Aspect Ratio <span class="text-red-500">*</span></label>
                            <select x-model="form.aspect_ratio" required class="form-input">
                                <option value="">Pilih ukuran...</option>
                                <?php foreach (['1:1 (Square)','4:5 (Portrait)','9:16 (Story)','16:9 (Landscape)','3:4 (Portrait)','2:3 (Print)','A4 Portrait','A4 Landscape'] as $r): ?>
                                <option value="<?= $r ?>"><?= $r ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea x-model="form.additional_notes" rows="2"
                                  class="form-input resize-none" placeholder="Permintaan khusus, referensi, atau detail lain yang perlu AI ketahui..."></textarea>
                    </div>
                </div>

                <!-- Validation errors & Submit -->
                <div class="px-6 py-5 bg-gray-800/40 space-y-3">
                    <template x-if="errors && Object.keys(errors).length > 0">
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-3">
                            <template x-for="(err, key) in errors" :key="key">
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-start gap-1.5">
                                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="err"></span>
                                </p>
                            </template>
                        </div>
                    </template>

                    <button type="submit" :disabled="loading"
                            class="w-full py-3.5 bg-brand-600 hover:bg-brand-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-brand-600/30 text-sm flex items-center justify-center gap-2">
                        <svg x-show="loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span x-text="loading ? 'Sedang Generate...' : 'Generate AI Prompt'"></span>
                    </button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500">Field bertanda <span class="text-red-500 font-bold">*</span> wajib diisi</p>
                </div>
            </form>
        </div>

        <!-- ========================
             OUTPUT AREA
             ======================== -->
        <div class="space-y-4 lg:sticky lg:top-20 lg:self-start">

            <!-- Result card -->
            <div class="bg-gray-900/70 backdrop-blur-sm rounded-2xl border border-gray-700/60 shadow-xl shadow-black/40 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-700/60 bg-gray-800/50 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-white flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            Hasil Prompt
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Siap dipakai di semua AI tool</p>
                    </div>
                    <div x-show="result" class="flex items-center gap-2" x-cloak>
                        <button @click="copyPrompt()" title="Salin ke clipboard"
                                :class="copied ? 'bg-green-600 border-green-500 text-white' : 'bg-green-600 hover:bg-green-500 border-green-500 text-white'"
                                class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl border shadow-lg shadow-green-900/40 transition-all">
                            <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? '✓ Tersalin!' : 'Salin Prompt'"></span>
                        </button>
                        <button @click="downloadTxt()" title="Download"
                                class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl border border-brand-600 bg-brand-700 hover:bg-brand-600 text-white shadow-lg shadow-brand-900/40 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download
                        </button>
                        <?php if (session()->get('user_id')): ?>
                        <button @click="savePrompt()"
                                :class="saved ? 'bg-amber-500 border-amber-400 text-gray-900 shadow-amber-900/40' : 'bg-amber-600 hover:bg-amber-500 border-amber-500 text-white shadow-amber-900/40'"
                                class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl border shadow-lg transition-all">
                            <svg class="w-4 h-4" :fill="saved ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            <span x-text="saved ? '✓ Tersimpan' : 'Simpan'"></span>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Output area -->
                <div class="p-6 min-h-[300px] flex items-center justify-center">
                    <!-- Placeholder -->
                    <div x-show="!result && !loading" class="text-center py-10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Belum ada prompt</p>
                        <p class="text-xs text-gray-600 mt-1">Isi form di sebelah kiri dan klik<br><strong class="text-gray-500">Generate AI Prompt</strong></p>
                    </div>

                    <!-- Loading skeleton -->
                    <div x-show="loading" class="w-full space-y-3" x-cloak>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-4 h-4 bg-brand-500 rounded-full animate-pulse"></div>
                            <div class="h-3 bg-gray-700 rounded animate-pulse w-32"></div>
                        </div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse w-5/6"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse w-4/5"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse w-3/4"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse w-5/6"></div>
                        <div class="h-3 bg-gray-700 rounded animate-pulse w-2/3"></div>
                        <p class="text-xs text-center text-gray-500 pt-2">Sedang membuat prompt...</p>
                    </div>

                    <!-- Prompt result -->
                    <div x-show="result && !loading" class="w-full" x-cloak>

                        <!-- Cara pakai — di atas output -->
                        <div class="mb-3 bg-blue-950/60 border border-blue-800/50 rounded-xl p-3.5">
                            <p class="text-xs font-bold text-blue-400 mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Cara menggunakan prompt ini:
                            </p>
                            <ol class="space-y-1.5 text-xs text-blue-400">
                                <li class="flex items-start gap-2">
                                    <span class="flex items-center justify-center w-4 h-4 rounded-full bg-blue-800 text-blue-300 font-bold shrink-0 mt-0.5 text-[10px]">1</span>
                                    <span>Klik tombol <strong>Salin</strong> di atas, lalu buka <strong>ChatGPT, Claude, Gemini</strong>, atau AI lain pilihanmu.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="flex items-center justify-center w-4 h-4 rounded-full bg-blue-800 text-blue-300 font-bold shrink-0 mt-0.5 text-[10px]">2</span>
                                    <span>Paste prompt ini ke kolom chat, lalu kirim — AI akan memahami instruksi secara otomatis.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="flex items-center justify-center w-4 h-4 rounded-full bg-blue-800 text-blue-300 font-bold shrink-0 mt-0.5 text-[10px]">3</span>
                                    <span>Untuk <strong>Midjourney / Leonardo / Ideogram</strong>: paste ke kolom prompt generator gambar mereka beserta foto produkmu.</span>
                                </li>
                            </ol>
                        </div>

                        <div class="bg-gray-950 rounded-xl border border-gray-700 overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-2.5 bg-gray-800 border-b border-gray-700">
                                <span class="text-xs text-gray-400 font-mono flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                    prompt.json
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500/60"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/60"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-500/60"></span>
                                </div>
                            </div>
                            <pre class="text-xs text-green-300 whitespace-pre-wrap leading-relaxed font-mono p-4 max-h-[520px] overflow-y-auto prompt-output" x-text="result"></pre>
                        </div>

                        <!-- Simpan prompt — tombol utama di bawah hasil -->
                        <?php if (session()->get('user_id')): ?>
                        <div class="mt-4" x-show="result && !saved">
                            <button @click="savePrompt()"
                                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-gray-900 font-bold text-sm transition-all shadow-md shadow-amber-900/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                Simpan Prompt — Buka Kembali Nanti
                            </button>
                        </div>
                        <div class="mt-4" x-show="result && saved">
                            <a :href="'<?= base_url('dashboard/saved') ?>'"
                               class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-amber-900/40 border border-amber-600 text-amber-400 font-bold text-sm transition-all hover:bg-amber-900/60">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                ✓ Tersimpan — Lihat Daftar Prompt Saya
                            </a>
                        </div>
                        <?php endif; ?>

                        <!-- Status + catatan bawah -->
                        <div class="mt-3 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Prompt berhasil dibuat &middot; <span x-text="result.length + ' karakter'"></span>
                            </div>
                            <div class="bg-amber-950/50 border border-amber-800/40 rounded-lg px-3 py-2 flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                <p class="text-xs text-amber-400">
                                    <strong>Catatan:</strong> Prompt ini bersifat instruksi untuk AI — <strong>bukan</strong> teks yang langsung menghasilkan gambar. Upload juga foto produkmu agar AI dapat memadukannya ke dalam banner.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips card -->
            <div class="bg-gradient-to-br from-brand-900/30 to-indigo-900/30 rounded-2xl border border-brand-700/30 p-5">
                <h3 class="text-sm font-bold text-brand-300 mb-3 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Tips Pro
                </h3>
                <ul class="space-y-2 text-xs text-brand-400">
                    <li class="flex items-start gap-1.5"><span class="text-brand-500 shrink-0 mt-0.5">•</span> Semakin spesifik deskripsi produk, semakin baik hasil promptnya.</li>
                    <li class="flex items-start gap-1.5"><span class="text-brand-500 shrink-0 mt-0.5">•</span> Untuk Midjourney, parameter tambahan otomatis disisipkan di akhir prompt.</li>
                    <li class="flex items-start gap-1.5"><span class="text-brand-500 shrink-0 mt-0.5">•</span> Coba berbagai Design Style untuk mendapat arah kreatif yang berbeda-beda.</li>
                    <li class="flex items-start gap-1.5"><span class="text-brand-500 shrink-0 mt-0.5">•</span> Untuk teks di banner, gunakan <strong class="text-white">Ideogram</strong> — AI terbaik untuk tipografi.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

    <!-- ========================
         COPY INFO POPUP
         ======================== -->
    <div x-show="showCopyModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         @click="showCopyModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(0,0,0,0.75);">
        <div @click.stop
             class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-5">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white text-center">Prompt Berhasil Disalin!</h3>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 mb-4">
                    <p class="text-sm text-blue-800 dark:text-blue-200 flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Prompt sudah tersimpan di clipboard. Buka aplikasi AI favorit Anda dan paste (Ctrl+V) untuk mulai generate gambar.</span>
                    </p>
                </div>
                
                <!-- Platform buttons -->
                <div class="space-y-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-3">Buka AI Platform:</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="window.open('https://chatgpt.com/', '_blank'); showCopyModal = false;"
                                class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-all">
                            <span class="text-lg">🤖</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">ChatGPT</span>
                        </button>
                        <button @click="window.open('https://www.midjourney.com/', '_blank'); showCopyModal = false;"
                                class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-all">
                            <span class="text-lg">🎨</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Midjourney</span>
                        </button>
                        <button @click="window.open('https://ideogram.ai/', '_blank'); showCopyModal = false;"
                                class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-all">
                            <span class="text-lg">✨</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Ideogram</span>
                        </button>
                        <button @click="window.open('https://leonardo.ai/', '_blank'); showCopyModal = false;"
                                class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-all">
                            <span class="text-lg">🖼️</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Leonardo AI</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 pb-6">
                <button @click="showCopyModal = false"
                        class="w-full py-3 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium rounded-xl text-sm transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ========================
         SAVE PROMPT MODAL
         ======================== -->
    <div x-show="showSaveModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(0,0,0,0.7);">
        <div @click.outside="showSaveModal = false"
             class="bg-gray-900 rounded-2xl border border-gray-700 shadow-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-white mb-1">Simpan Prompt</h3>
            <p class="text-sm text-gray-400 mb-4">Beri nama agar mudah ditemukan nanti.</p>
            <input type="text" x-model="saveName" placeholder="Nama prompt, contoh: Banner Ramadan NexaTech"
                   @keydown.enter="confirmSave()"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-600 bg-gray-800 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-brand-500 mb-4">
            <div class="flex items-center gap-3">
                <button @click="confirmSave()" :disabled="saveLoading"
                        class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-400 disabled:opacity-60 text-gray-900 font-bold rounded-xl text-sm transition-all flex items-center justify-center gap-2">
                    <svg x-show="saveLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <svg x-show="!saveLoading" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span x-text="saveLoading ? 'Menyimpan...' : 'Simpan'"></span>
                </button>
                <button @click="showSaveModal = false"
                        class="px-5 py-2.5 rounded-xl border border-gray-600 text-gray-400 hover:text-white hover:border-gray-500 text-sm font-medium transition-all">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.form-group { display: flex; flex-direction: column; }
.form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #d1d5db; margin-bottom: 0.375rem; }
.form-input {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border-radius: 0.5rem;
    border: 1px solid rgba(75,85,99,0.8);
    background-color: rgba(17,24,39,0.8);
    color: #f9fafb;
    font-size: 0.875rem;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input::placeholder { color: #4b5563; }
.form-input:hover { border-color: #6b7280; }
.form-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2); }
.form-input option { background-color: #1f2937; color: #f9fafb; }
.form-hint { font-size: 0.75rem; color: #60a5fa; margin-top: 0.375rem; }

@keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>

<script>
function promptGenerator() {
    return {
        form: {
            product_name: '',
            brand_name: '',
            headline: '',
            subheadline: '',
            product_description: '',
            features: '',
            cta_text: '',
            target_audience: '',
            image_count: '1',
            image_position: 'Center',
            design_style: '',
            color_theme: '',
            aspect_ratio: '',
            ai_platform: 'chatgpt-dalle',
            image_mood: '',
            typography_style: '',
            lighting_style: '',
            additional_notes: '',
            template_slug: '',
            <?php
            $firstTemplateSlug = ! empty($templates) ? esc($templates[0]['slug'] ?? '') : '';
            ?>
        },
        result: '',
        loading: false,
        errors: {},
        copied: false,
        saved: false,
        promptId: null,
        downloadUrl: '#',
        colorThemeSelect: '',
        colorPrimary: '#7C3AED',
        colorSecondary: '#F59E0B',
        mode: 'manual',
        csrfHash: '<?= csrf_hash() ?>',
        // Save modal state
        showSaveModal: false,
        saveName: '',
        saveLoading: false,
        // Copy instruction modal state
        showCopyModal: false,

        async init() {
            const params = new URLSearchParams(window.location.search);
            const loadId = params.get('load');
            if (loadId) {
                await this.loadSavedPrompt(parseInt(loadId, 10));
            }
        },

        async loadSavedPrompt(id) {
            try {
                const res  = await fetch(`<?= base_url('generator/load/') ?>${id}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                if (data.success) {
                    const d = data.data;
                    Object.keys(d).forEach(k => {
                        if (k in this.form) this.form[k] = d[k];
                    });
                    // Handle custom color theme
                    const presets = ['Gold & Black','Blue & White','Red & Black','Green & White','Purple & Gold','Monochrome','Pastel Tones','Neon & Dark','Earthy Tones','Vibrant Multi-Color'];
                    if (d.color_theme && !presets.includes(d.color_theme)) {
                        this.colorThemeSelect = '__custom__';
                    } else {
                        this.colorThemeSelect = d.color_theme || '';
                    }
                    // Restore last generated prompt in output
                    if (data.generated_prompt) {
                        this.result   = data.generated_prompt;
                        this.promptId = data.prompt_id;
                        this.saved    = true;
                    }
                    // Clean URL param without reload
                    const url = new URL(window.location);
                    url.searchParams.delete('load');
                    window.history.replaceState({}, '', url);
                }
            } catch (e) {
                console.error('Load failed', e);
            }
        },

        updateCustomColor() {
            this.form.color_theme = this.colorPrimary + ' & ' + this.colorSecondary;
        },

        setMode(m) {
            this.mode = m;
            if (m === 'manual') {
                this.form.template_slug = '';
            } else {
                this.form.template_slug = '<?= $firstTemplateSlug ?? '' ?>';
            }
        },

        async generate() {
            this.loading = true;
            this.errors  = {};
            this.result  = '';

            try {
                const res = await fetch('<?= base_url('generator/generate') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams({
                        ...this.form,
                        '<?= csrf_token() ?>': this.csrfHash,
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    this.result    = data.prompt;
                    this.promptId  = data.promptId;
                    this.saved     = false;
                    if (data.csrf_hash) this.csrfHash = data.csrf_hash;
                    this.$nextTick(() => window.scrollTo({ top: 0, behavior: 'smooth' }));
                } else if (data.errors) {
                    this.errors = data.errors;
                } else {
                    this.errors = { general: data.message || 'An error occurred.' };
                }
            } catch (e) {
                this.errors = { general: 'Koneksi gagal. Periksa internet dan coba lagi.' };
            } finally {
                this.loading = false;
            }
        },

        async copyPrompt() {
            if (!this.result) return;
            try {
                await navigator.clipboard.writeText(this.result);
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
                
                // Tampilkan modal instruksi
                this.showCopyModal = true;
                
                // Buka ChatGPT di tab baru setelah jeda 1 detik
                setTimeout(() => {
                    window.open('https://chatgpt.com/', '_blank');
                }, 1000);
            } catch (e) {
                // Fallback
                const el = document.createElement('textarea');
                el.value = this.result;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
                
                // Tampilkan modal instruksi
                this.showCopyModal = true;
                
                // Buka ChatGPT di tab baru setelah jeda 1 detik
                setTimeout(() => {
                    window.open('https://chatgpt.com/', '_blank');
                }, 1000);
            }
        },

        downloadTxt() {
            if (!this.result) return;
            const blob = new Blob([this.result], { type: 'text/plain' });
            const url  = URL.createObjectURL(blob);
            const a    = document.createElement('a');
            a.href     = url;
            a.download = `sazeeai-prompt-${this.promptId || 'new'}.txt`;
            a.click();
            URL.revokeObjectURL(url);
        },

        async savePrompt() {
            if (!this.promptId) return;
            // If not yet saved, show modal to let user pick a name
            if (!this.saved) {
                this.saveName = this.form.headline || this.form.product_name || '';
                this.showSaveModal = true;
                return;
            }
            // Already saved → toggle off (unsave immediately)
            await this._doSaveToggle('');
        },

        async confirmSave() {
            this.saveLoading = true;
            await this._doSaveToggle(this.saveName);
            this.saveLoading  = false;
            this.showSaveModal = false;
        },

        async _doSaveToggle(name) {
            try {
                const body = { '<?= csrf_token() ?>': this.csrfHash };
                if (name) body.save_name = name;
                const res = await fetch(`<?= base_url('dashboard/save-prompt/') ?>${this.promptId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams(body),
                });
                const data = await res.json();
                if (data.success) {
                    this.saved    = data.saved;
                    if (data.csrf_hash) this.csrfHash = data.csrf_hash;
                }
            } catch (e) {
                console.error('Save failed', e);
            }
        },
    };
}
</script>

<?= $this->endSection() ?>
