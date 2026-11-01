<?php
// index.php — Landing Page Budi Percetakan
require_once 'koneksi.php';

// Ambil data bahan untuk seksi informasi
$db    = getDB();
$bahan = $db->query("SELECT * FROM bahan_spanduk WHERE aktif=1 ORDER BY urutan")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Budi Percetakan — Spanduk Berkualitas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style>
  :root {
    --red-soft:   #E57373;
    --red-main:   #EF5350;
    --red-deep:   #C62828;
    --red-pale:   #FFEBEE;
    --red-light:  #FFCDD2;
    --cream:      #FFF8F8;
    --gray-light: #F5F5F5;
    --gray-mid:   #9E9E9E;
    --gray-dark:  #424242;
    --white:      #FFFFFF;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--gray-dark);
    overflow-x: hidden;
  }

  /* ── Animations ── */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(32px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
  }
  @keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(229,115,115,.45); }
    70%  { box-shadow: 0 0 0 14px rgba(229,115,115,0); }
    100% { box-shadow: 0 0 0 0 rgba(229,115,115,0); }
  }
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
  }
  @keyframes slideInRight {
    from { opacity: 0; transform: translateX(40px); }
    to   { opacity: 1; transform: translateX(0); }
  }
  @keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
  }

  .anim-fade-up  { animation: fadeUp  .7s ease both; }
  .anim-fade-in  { animation: fadeIn  .6s ease both; }
  .anim-delay-1  { animation-delay: .15s; }
  .anim-delay-2  { animation-delay: .30s; }
  .anim-delay-3  { animation-delay: .45s; }
  .anim-delay-4  { animation-delay: .60s; }

  /* ── Navbar ── */
  .navbar {
    position: fixed; top: 0; width: 100%; z-index: 100;
    background: rgba(255,255,255,.88);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--red-light);
    padding: 0 2rem;
    height: 64px;
    display: flex; align-items: center; justify-content: space-between;
    animation: fadeIn .5s ease;
  }
  .navbar .brand {
    font-family: 'Playfair Display', serif;
    font-size: 1.45rem;
    font-weight: 900;
    color: var(--red-deep);
    letter-spacing: -.5px;
  }
  .navbar .brand span { color: var(--red-soft); }

  .btn-login {
    background: transparent;
    border: 2px solid var(--red-main);
    color: var(--red-main);
    padding: .45rem 1.2rem;
    border-radius: 50px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: .85rem;
    cursor: pointer;
    transition: all .25s ease;
    text-decoration: none;
    letter-spacing: .3px;
  }
  .btn-login:hover {
    background: var(--red-main);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(239,83,80,.35);
  }

  /* ── Hero ── */
  .hero {
    min-height: 100vh;
    background: linear-gradient(145deg, #fff 0%, var(--red-pale) 60%, var(--red-light) 100%);
    display: flex; align-items: center;
    padding: 80px 2rem 3rem;
    position: relative;
    overflow: hidden;
  }
  .hero::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(229,115,115,.18) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
  }
  .hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(239,83,80,.12) 0%, transparent 70%);
    animation: float 8s ease-in-out infinite reverse;
  }

  .hero-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 1;
  }

  .hero-tag {
    display: inline-block;
    background: var(--red-pale);
    border: 1px solid var(--red-light);
    color: var(--red-deep);
    font-size: .78rem;
    font-weight: 600;
    padding: .35rem 1rem;
    border-radius: 50px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 1.2rem;
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.1;
    color: #1a1a1a;
    margin-bottom: 1.2rem;
  }
  .hero-title .accent {
    background: linear-gradient(135deg, var(--red-main), var(--red-deep));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .hero-desc {
    color: #666;
    font-size: 1.05rem;
    line-height: 1.75;
    margin-bottom: 2rem;
    font-weight: 300;
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .6rem;
    background: linear-gradient(135deg, var(--red-main), var(--red-deep));
    color: white;
    padding: .85rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all .3s ease;
    animation: pulse-ring 2.5s infinite;
    letter-spacing: .2px;
  }
  .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(198,40,40,.4);
    animation: none;
  }
  .btn-primary svg { transition: transform .3s; }
  .btn-primary:hover svg { transform: translateX(4px); }

  /* Hero Visual */
  .hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
    animation: slideInRight .9s ease both;
  }
  .hero-card-stack {
    position: relative;
    width: 320px;
    height: 320px;
  }
  .hc {
    position: absolute;
    border-radius: 20px;
    display: flex; flex-direction: column;
    justify-content: flex-end;
    padding: 1.4rem;
    font-weight: 600;
    font-size: .95rem;
    box-shadow: 0 20px 60px rgba(0,0,0,.12);
  }
  .hc-1 {
    width: 260px; height: 260px;
    background: linear-gradient(145deg, var(--red-main), var(--red-deep));
    color: white;
    top: 0; left: 0;
    animation: float 5s ease-in-out infinite;
  }
  .hc-2 {
    width: 180px; height: 130px;
    background: white;
    color: var(--gray-dark);
    bottom: 0; right: 0;
    border: 2px solid var(--red-light);
    animation: float 7s ease-in-out infinite reverse;
  }
  .hc-big-num {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: .3rem;
  }
  .hc-label { font-size: .75rem; opacity: .8; font-weight: 400; letter-spacing: .5px; text-transform: uppercase; }

  /* ── Stats Strip ── */
  .stats-strip {
    background: var(--red-deep);
    padding: 1.8rem 2rem;
    display: flex;
    justify-content: center;
    gap: 5rem;
    flex-wrap: wrap;
  }
  .stat-item { text-align: center; color: white; }
  .stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    background: linear-gradient(135deg, #fff, var(--red-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .stat-label { font-size: .75rem; opacity: .7; margin-top: .25rem; letter-spacing: .5px; text-transform: uppercase; }

  /* ── Section Wrapper ── */
  .section { padding: 5rem 2rem; }
  .section-inner { max-width: 1100px; margin: 0 auto; }
  .section-label {
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--red-main);
    margin-bottom: .6rem;
  }
  .section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 1rem;
  }
  .section-desc { color: #777; line-height: 1.8; max-width: 580px; font-weight: 300; }

  /* ── Keunggulan ── */
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
  }
  .feat-card {
    background: white;
    border-radius: 16px;
    padding: 2rem 1.6rem;
    border: 1px solid #f0e0e0;
    transition: all .3s ease;
    position: relative;
    overflow: hidden;
  }
  .feat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    background: linear-gradient(180deg, var(--red-main), var(--red-soft));
    border-radius: 4px 0 0 4px;
    transform: scaleY(0);
    transition: transform .3s ease;
  }
  .feat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(229,115,115,.18); }
  .feat-card:hover::before { transform: scaleY(1); }

  .feat-icon {
    width: 52px; height: 52px;
    background: var(--red-pale);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1.2rem;
    transition: background .3s;
  }
  .feat-card:hover .feat-icon { background: var(--red-light); }
  .feat-title { font-weight: 600; font-size: 1rem; margin-bottom: .5rem; color: #1a1a1a; }
  .feat-text { font-size: .88rem; color: #777; line-height: 1.7; font-weight: 300; }

  /* ── Bahan Cards ── */
  .bahan-section { background: var(--gray-light); }
  .bahan-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
  }
  .bahan-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    transition: all .35s ease;
    cursor: default;
  }
  .bahan-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(229,115,115,.2); }
  .bahan-card-top {
    background: linear-gradient(135deg, var(--red-main), var(--red-deep));
    padding: 1.8rem 1.6rem 1.2rem;
    color: white;
    position: relative;
  }
  .bahan-badge {
    position: absolute;
    top: 1rem; right: 1rem;
    background: rgba(255,255,255,.2);
    border-radius: 50px;
    padding: .2rem .7rem;
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .5px;
  }
  .bahan-name { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; margin-bottom: .2rem; }
  .bahan-price { font-size: .85rem; opacity: .85; }
  .bahan-card-body { padding: 1.4rem 1.6rem 1.8rem; }
  .bahan-desc { font-size: .875rem; color: #666; line-height: 1.7; margin-bottom: 1rem; font-weight: 300; }
  .bahan-tag {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--red-pale);
    color: var(--red-deep);
    border-radius: 50px;
    padding: .3rem .9rem;
    font-size: .75rem;
    font-weight: 600;
  }

  /* ── Kontak ── */
  .kontak-section { background: #1a1a1a; }
  .kontak-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
  }
  .kontak-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: white; margin-bottom: 1rem; }
  .kontak-desc { color: #aaa; line-height: 1.8; font-weight: 300; margin-bottom: 2rem; }
  .kontak-info { display: flex; flex-direction: column; gap: 1rem; }
  .kontak-item {
    display: flex; align-items: flex-start; gap: 1rem;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 12px;
    padding: 1rem 1.2rem;
  }
  .kontak-icon {
    width: 40px; height: 40px;
    background: var(--red-main);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
  }
  .kontak-detail { color: white; }
  .kontak-detail strong { display: block; font-size: .78rem; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: .2rem; }
  .kontak-detail span { font-size: .92rem; }

  .kontak-cta { background: rgba(239,83,80,.1); border: 1px solid rgba(239,83,80,.3); border-radius: 20px; padding: 2.5rem; }
  .kontak-cta-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: white; font-weight: 700; margin-bottom: .8rem; }
  .kontak-cta-desc { color: #aaa; font-size: .9rem; line-height: 1.7; margin-bottom: 1.8rem; font-weight: 300; }

  /* ── Footer ── */
  footer {
    background: #111;
    padding: 1.8rem 2rem;
    text-align: center;
    color: #555;
    font-size: .82rem;
    border-top: 1px solid #222;
  }
  footer span { color: var(--red-soft); }

  /* ── Responsive ── */
  @media (max-width: 768px) {
    .hero-inner { grid-template-columns: 1fr; gap: 2.5rem; text-align: center; }
    .hero-visual { display: none; }
    .kontak-grid { grid-template-columns: 1fr; }
    .stats-strip { gap: 2.5rem; }
  }
</style>
</head>
<body>

<!-- ══════════════════ NAVBAR ══════════════════ -->
<nav class="navbar">
  <div class="brand">Budi <span>Percetakan</span></div>
  <a href="login.php" class="btn-login">Login Admin</a>
</nav>

<!-- ══════════════════ HERO ══════════════════ -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-text">
      <div class="hero-tag anim-fade-up">🖨️ Cetak Cepat · Kualitas Terbaik</div>
      <h1 class="hero-title anim-fade-up anim-delay-1">
        Spanduk <span class="accent">Impresif</span><br>
        Untuk Bisnis Anda
      </h1>
      <p class="hero-desc anim-fade-up anim-delay-2">
        Budi Percetakan hadir melayani kebutuhan cetak spanduk Anda dengan bahan pilihan, warna tajam, dan pengiriman cepat. Dari promosi toko hingga backdrop pameran — kami siap!
      </p>
      <div class="anim-fade-up anim-delay-3">
        <a href="pesan.php" class="btn-primary">
          Pesan Spanduk Sekarang
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-card-stack">
        <div class="hc hc-1">
          <div class="hc-big-num">500+</div>
          <div class="hc-label">Pesanan Selesai</div>
        </div>
        <div class="hc hc-2">
          <div style="color:var(--red-main); font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:.4rem;">Rating</div>
          <div style="font-size:1.4rem; font-weight:900; color:#1a1a1a;">4.9 ⭐</div>
          <div style="font-size:.7rem; color:#999; margin-top:.2rem; font-weight:400;">Kepuasan Pelanggan</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ STATS STRIP ══════════════════ -->
<div class="stats-strip anim-fade-in">
  <div class="stat-item">
    <div class="stat-num">500+</div>
    <div class="stat-label">Pesanan Selesai</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">4</div>
    <div class="stat-label">Jenis Bahan</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24h</div>
    <div class="stat-label">Proses Cepat</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">100%</div>
    <div class="stat-label">Kepuasan Klien</div>
  </div>
</div>

<!-- ══════════════════ KEUNGGULAN ══════════════════ -->
<section class="section">
  <div class="section-inner">
    <div class="section-label">Mengapa Kami?</div>
    <h2 class="section-title">Keunggulan Budi Percetakan</h2>
    <p class="section-desc">Kami berkomitmen memberikan hasil cetak terbaik dengan proses yang mudah dan transparan untuk setiap pelanggan.</p>

    <div class="features-grid">
      <div class="feat-card anim-fade-up">
        <div class="feat-icon">🎨</div>
        <div class="feat-title">Warna Tajam & Akurat</div>
        <div class="feat-text">Teknologi cetak digital terkini memastikan warna desain Anda tercetak akurat dan tahan lama, bahkan di bawah terik matahari.</div>
      </div>
      <div class="feat-card anim-fade-up anim-delay-1">
        <div class="feat-icon">⚡</div>
        <div class="feat-title">Proses Cepat 24 Jam</div>
        <div class="feat-text">Butuh spanduk mendadak? Kami siap memproses pesanan Anda dalam waktu 24 jam untuk memenuhi deadline acara Anda.</div>
      </div>
      <div class="feat-card anim-fade-up anim-delay-2">
        <div class="feat-icon">📐</div>
        <div class="feat-title">Ukuran Custom</div>
        <div class="feat-text">Tersedia dalam berbagai ukuran sesuai kebutuhan — dari spanduk kecil toko hingga billboard jalan besar.</div>
      </div>
      <div class="feat-card anim-fade-up anim-delay-3">
        <div class="feat-icon">💬</div>
        <div class="feat-title">Konsultasi Gratis</div>
        <div class="feat-text">Tim kami siap membantu memilih bahan dan ukuran yang tepat sesuai budget dan kebutuhan promosi Anda.</div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ INFORMASI BAHAN ══════════════════ -->
<section class="section bahan-section">
  <div class="section-inner">
    <div class="section-label">Material Pilihan</div>
    <h2 class="section-title">Jenis Bahan Spanduk Kami</h2>
    <p class="section-desc">Pilih bahan yang tepat untuk kebutuhan cetak Anda. Setiap bahan memiliki keunggulan berbeda.</p>

    <div class="bahan-grid">
      <?php foreach ($bahan as $i => $b): ?>
      <div class="bahan-card anim-fade-up" style="animation-delay:<?= $i * .12 ?>s">
        <div class="bahan-card-top">
          <div class="bahan-badge">Rp <?= number_format($b['harga_per_m2'], 0, ',', '.') ?>/m²</div>
          <div class="bahan-name"><?= htmlspecialchars($b['nama_bahan']) ?></div>
          <div class="bahan-price">Harga per meter persegi</div>
        </div>
        <div class="bahan-card-body">
          <div class="bahan-desc"><?= htmlspecialchars($b['deskripsi']) ?></div>
          <div class="bahan-tag">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            <?= htmlspecialchars($b['keunggulan']) ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:3rem;">
      <a href="pesan.php" class="btn-primary" style="animation:none; display:inline-flex;">
        Pesan Sekarang
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════ KONTAK ══════════════════ -->
<section class="section kontak-section">
  <div class="section-inner">
    <div class="kontak-grid">
      <div>
        <div class="section-label" style="color:var(--red-soft);">Hubungi Kami</div>
        <h2 class="kontak-title">Siap Membantu<br>Kebutuhan Cetak Anda</h2>
        <p class="kontak-desc">Kunjungi toko kami atau hubungi langsung via WhatsApp. Tim kami siap melayani dari Senin–Sabtu, pukul 09.00–17.00 WITA.</p>

        <div class="kontak-info">
          <div class="kontak-item">
            <div class="kontak-icon">📍</div>
            <div class="kontak-detail">
              <strong>Alamat</strong>
              <span>Jl. Sorumba, kec. kadia, kota kendari, provinsi sulawesi tenggara</span>
            </div>
          </div>
          <div class="kontak-item">
            <div class="kontak-icon">📱</div>
            <div class="kontak-detail">
              <strong>WhatsApp</strong>
              <span>+62 813-4006-1687</span>
            </div>
          </div>
          <div class="kontak-item">
            <div class="kontak-icon">🕐</div>
            <div class="kontak-detail">
              <strong>Jam Operasional</strong>
              <span>Senin – Sabtu, 09.00 – 17.00 WITA</span>
            </div>
          </div>
        </div>
      </div>

      <div class="kontak-cta">
        <div class="kontak-cta-title">Mulai Pesan Sekarang</div>
        <p class="kontak-cta-desc">Tidak perlu daftar atau login. Langsung isi formulir pemesanan dan tim kami akan segera memproses pesanan Anda.</p>
        <a href="pesan.php" class="btn-primary" style="animation:none; display:inline-flex;">
          Buat Pesanan
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ FOOTER ══════════════════ -->
<footer>
  © <?= date('Y') ?> <span>Budi Percetakan</span> — Kendari, Sulawesi Tenggara. Dibuat dengan ❤️ untuk kualitas terbaik.
</footer>

</body>
</html>
