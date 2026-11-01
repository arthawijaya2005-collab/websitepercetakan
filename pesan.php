<?php
// pesan.php — Halaman Pemesanan & Edit Pesanan Pelanggan
require_once 'koneksi.php';
$db    = getDB();
$bahan = $db->query("SELECT * FROM bahan_spanduk WHERE aktif=1 ORDER BY urutan")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesan Spanduk — Budi Percetakan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ─────────────────────────────────────────
   TOKENS
───────────────────────────────────────── */
:root {
  --red:        #EF5350;
  --red-deep:   #C62828;
  --red-soft:   #E57373;
  --red-pale:   #FFEBEE;
  --red-light:  #FFCDD2;
  --green:      #43A047;
  --green-pale: #E8F5E9;
  --bg:         #FFF8F8;
  --surface:    #FFFFFF;
  --border:     #F0E0E0;
  --text:       #1A1A1A;
  --sub:        #9E9E9E;
  --r:          12px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

/* ─────────────────────────────────────────
   KEYFRAMES
───────────────────────────────────────── */
@keyframes fadeUp   { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeIn   { from{opacity:0} to{opacity:1} }
@keyframes spin     { to{transform:rotate(360deg)} }
@keyframes slideDown{ from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
@keyframes popIn    { 0%{transform:scale(.85);opacity:0} 60%{transform:scale(1.04)} 100%{transform:scale(1);opacity:1} }
@keyframes livePulse{ 0%,100%{opacity:1} 50%{opacity:.25} }

/* ─────────────────────────────────────────
   NAVBAR
───────────────────────────────────────── */
.navbar {
  position: sticky; top: 0; z-index: 100;
  background: rgba(255,255,255,.93);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--red-light);
  height: 62px;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 2rem;
  animation: fadeIn .4s ease;
}
.brand { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:900; color:var(--red-deep); text-decoration:none; }
.brand span { color:var(--red-soft); }
.nav-back { display:flex; align-items:center; gap:.4rem; color:var(--sub); font-size:.82rem; font-weight:500; text-decoration:none; transition:color .2s; }
.nav-back:hover { color:var(--red); }

/* ─────────────────────────────────────────
   LAYOUT
───────────────────────────────────────── */
.page {
  max-width: 1120px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 5rem;
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 2rem;
  align-items: start;
}

/* ─────────────────────────────────────────
   TAB SWITCHER (Pesan Baru / Edit Pesanan)
───────────────────────────────────────── */
.tab-switcher {
  display: flex; gap: .3rem;
  background: #f5eaea;
  border-radius: 50px;
  padding: .28rem;
  margin-bottom: 1.4rem;
  width: fit-content;
}
.tab-sw-btn {
  padding: .42rem 1.3rem;
  border-radius: 50px; border: none;
  font-family: 'DM Sans', sans-serif;
  font-size: .82rem; font-weight: 600;
  cursor: pointer; color: var(--sub);
  background: transparent;
  transition: all .2s;
  white-space: nowrap;
}
.tab-sw-btn.active { background: var(--surface); color: var(--red); box-shadow: 0 2px 8px rgba(0,0,0,.1); }

/* ─────────────────────────────────────────
   CARD
───────────────────────────────────────── */
.card {
  background: var(--surface);
  border-radius: 20px;
  border: 1px solid var(--border);
  box-shadow: 0 6px 32px rgba(239,83,80,.08);
  overflow: hidden;
  animation: fadeUp .6s ease both;
}
.card-head {
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  padding: 1.6rem 2rem;
  color: white;
}
.card-eyebrow { font-size:.68rem; font-weight:600; letter-spacing:2px; text-transform:uppercase; opacity:.75; margin-bottom:.35rem; }
.card-title   { font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:700; }
.card-body    { padding: 1.8rem 2rem; }

/* ─────────────────────────────────────────
   FORM ELEMENTS
───────────────────────────────────────── */
.section-label {
  font-size: .65rem; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: var(--red);
  padding-bottom: .5rem; border-bottom: 1px solid var(--red-light);
  margin: 1.4rem 0 1rem;
}
.section-label:first-child { margin-top: 0; }

.fg { margin-bottom: 1.1rem; }
.fg label { display:block; font-size:.8rem; font-weight:600; color:#555; margin-bottom:.4rem; }
.fg label span { color:var(--red); }
.fc {
  width: 100%; padding: .68rem 1rem;
  border: 1.5px solid #e8e0e0; border-radius: var(--r);
  font-family: 'DM Sans', sans-serif; font-size: .9rem; color: var(--text);
  background: var(--surface); outline: none;
  transition: border-color .2s, box-shadow .2s;
  appearance: none;
}
.fc:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(239,83,80,.12); }
.fc::placeholder { color: #ccc; }
.fc-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
textarea.fc { resize: vertical; min-height: 80px; }

/* ─────────────────────────────────────────
   FILE UPLOAD ZONE
───────────────────────────────────────── */
.upload-zone {
  border: 2px dashed var(--red-light);
  border-radius: var(--r);
  padding: 1.5rem 1rem;
  text-align: center;
  cursor: pointer;
  transition: all .25s;
  background: var(--bg);
  position: relative;
}
.upload-zone:hover, .upload-zone.drag { border-color: var(--red); background: var(--red-pale); }
.upload-zone input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.upload-icon { font-size: 2rem; margin-bottom: .5rem; }
.upload-text { font-size: .82rem; font-weight: 600; color: var(--sub); }
.upload-text b { color: var(--red); }
.upload-hint { font-size: .72rem; color: #bbb; margin-top: .25rem; }

/* Preview gambar */
.file-preview {
  margin-top: .85rem;
  border: 1.5px solid var(--border);
  border-radius: var(--r);
  overflow: hidden;
  background: var(--surface);
  display: none;
  animation: slideDown .3s ease;
}
.file-preview.show { display: block; }
.fp-top { display:flex; align-items:center; justify-content:space-between; padding:.7rem 1rem; border-bottom:1px solid var(--border); }
.fp-name { font-size:.8rem; font-weight:600; color:var(--text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:200px; }
.fp-size { font-size:.72rem; color:var(--sub); }
.fp-del  { background:none; border:none; cursor:pointer; color:#ccc; font-size:1rem; padding:.2rem; transition:color .18s; }
.fp-del:hover { color:var(--red); }
.fp-img  { width:100%; max-height:200px; object-fit:contain; display:block; background:#fafafa; }
.fp-pdf  { display:flex; align-items:center; gap:.7rem; padding:1rem; }
.fp-pdf-icon { font-size:2rem; }
.fp-pdf-info { font-size:.8rem; color:var(--sub); }

/* ─────────────────────────────────────────
   PRICE CALCULATOR
───────────────────────────────────────── */
.price-card {
  background: var(--red-pale);
  border: 1.5px dashed var(--red-light);
  border-radius: var(--r);
  padding: 1.2rem 1.4rem;
  margin-top: 1.4rem;
  transition: all .3s;
}
.price-card.active { background: linear-gradient(135deg,#fff6f6,var(--red-pale)); border-color:var(--red); box-shadow:0 4px 20px rgba(239,83,80,.14); }
.price-lbl  { font-size:.68rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--red); margin-bottom:.3rem; }
.price-breakdown { font-size:.78rem; color:#999; margin-bottom:.5rem; line-height:1.6; }
.price-total { font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:700; color:var(--red-deep); letter-spacing:-.5px; }
.price-placeholder { font-size:.88rem; color:#bbb; font-style:italic; }

/* ─────────────────────────────────────────
   BUTTONS
───────────────────────────────────────── */
.btn-primary {
  width: 100%; padding: .9rem;
  background: linear-gradient(135deg, var(--red), var(--red-deep));
  color: white; border: none; border-radius: var(--r);
  font-family: 'DM Sans', sans-serif; font-size: .95rem; font-weight: 600;
  cursor: pointer; margin-top: 1.8rem;
  display: flex; align-items: center; justify-content: center; gap: .55rem;
  transition: all .3s; letter-spacing: .2px;
}
.btn-primary:hover:not(:disabled) { transform:translateY(-2px); box-shadow:0 10px 28px rgba(198,40,40,.38); }
.btn-primary:disabled { opacity: .65; cursor: not-allowed; transform: none; }
.btn-spin { width:17px; height:17px; border:2.5px solid rgba(255,255,255,.35); border-top-color:white; border-radius:50%; animation:spin .7s linear infinite; display:none; }

/* Alert */
.alert { border-radius: var(--r); padding:.82rem 1.1rem; font-size:.84rem; margin-bottom:1.1rem; display:none; line-height:1.5; animation:slideDown .3s ease; }
.alert.show   { display: block; }
.alert-ok     { background:var(--green-pale); border:1px solid #a5d6a7; color:#2e7d32; }
.alert-err    { background:var(--red-pale); border:1px solid var(--red-light); color:var(--red-deep); }

/* ─────────────────────────────────────────
   EDIT PESANAN — LOOKUP FORM
───────────────────────────────────────── */
.lookup-box {
  background: var(--surface);
  border-radius: 20px;
  border: 1px solid var(--border);
  box-shadow: 0 6px 32px rgba(239,83,80,.08);
  overflow: hidden;
  animation: fadeUp .6s ease both;
}
.lookup-head { padding: 1.5rem 2rem 1.2rem; border-bottom: 1px solid #f7eeee; }
.lookup-title { font-family:'Playfair Display',serif; font-size:1.15rem; font-weight:700; color:var(--text); }
.lookup-sub   { font-size:.78rem; color:var(--sub); margin-top:.25rem; }
.lookup-body  { padding: 1.4rem 2rem 1.8rem; }
.lookup-info  {
  background: #fffde7; border: 1px solid #fff176;
  border-radius: 10px; padding: .85rem 1rem;
  font-size: .8rem; color: #795548; line-height: 1.6;
  margin-bottom: 1.3rem;
}

/* Edit form (tampil setelah verifikasi berhasil) */
.edit-form { display: none; animation: slideDown .35s ease; }
.edit-form.show { display: block; }
.edit-pesanan-badge {
  display: flex; align-items: center; gap: .6rem;
  background: var(--green-pale); border: 1px solid #a5d6a7;
  border-radius: 10px; padding: .8rem 1rem;
  font-size: .82rem; color: #2e7d32; font-weight: 600;
  margin-bottom: 1.3rem;
}
.existing-file {
  background: var(--bg); border: 1px solid var(--border);
  border-radius: var(--r); padding: .75rem 1rem;
  font-size: .8rem; color: var(--sub); margin-bottom: .7rem;
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem;
}
.existing-file a { color: var(--red); font-weight: 600; text-decoration: none; }
.existing-file a:hover { text-decoration: underline; }
.btn-hapus-file { background:none; border:none; cursor:pointer; color:#ccc; font-size:.78rem; font-weight:600; transition:color .18s; padding:.15rem .4rem; border-radius:5px; }
.btn-hapus-file:hover { color:var(--red); background:var(--red-pale); }

/* ─────────────────────────────────────────
   SIDE PANEL
───────────────────────────────────────── */
.side { display:flex; flex-direction:column; gap:1.4rem; }

/* Bahan mini cards */
.bahan-list-title { font-size:.65rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--sub); margin-bottom:.8rem; }
.bahan-mini {
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: 11px; padding: .9rem 1rem;
  display: flex; gap: .75rem; align-items: flex-start;
  transition: all .22s; cursor: default;
}
.bahan-mini:hover { border-color:var(--red); transform:translateX(3px); }
.bahan-mini.sel   { border-color:var(--red); background:var(--red-pale); }
.bm-dot  { width:34px; height:34px; border-radius:8px; flex-shrink:0; background:linear-gradient(135deg,var(--red),var(--red-deep)); display:flex; align-items:center; justify-content:center; font-size:.65rem; font-weight:800; color:white; }
.bm-name { font-weight:600; font-size:.85rem; color:var(--text); }
.bm-price{ font-size:.76rem; color:var(--red); font-weight:600; }
.bm-info { font-size:.72rem; color:#aaa; margin-top:.1rem; }

/* Antrean */
.queue-panel {
  background: var(--surface);
  border-radius: 18px;
  border: 1px solid var(--border);
  overflow: hidden;
  box-shadow: 0 3px 18px rgba(239,83,80,.07);
}
.qp-head { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.3rem; background:#fafafa; border-bottom:1px solid var(--border); }
.qp-title { font-weight:700; font-size:.9rem; }
.live-badge { display:flex; align-items:center; gap:.3rem; font-size:.68rem; font-weight:700; color:var(--green); background:var(--green-pale); border-radius:50px; padding:.2rem .65rem; }
.live-dot   { width:6px; height:6px; border-radius:50%; background:var(--green); animation:livePulse 1.6s ease-in-out infinite; }
.qp-body    { max-height: 320px; overflow-y: auto; }
.qp-body::-webkit-scrollbar { width:3px; }
.qp-body::-webkit-scrollbar-thumb { background:var(--red-light); border-radius:3px; }
.q-item { display:flex; justify-content:space-between; align-items:center; padding:.78rem 1.3rem; border-bottom:1px solid #fafafa; transition:background .18s; }
.q-item:last-child { border-bottom:none; }
.q-item:hover { background:#fafafa; }
.q-name   { font-weight:600; font-size:.84rem; }
.q-detail { font-size:.72rem; color:#bbb; margin-top:.08rem; }
.qsp { font-size:.68rem; font-weight:700; border-radius:50px; padding:.22rem .65rem; white-space:nowrap; }
.qs-Menunggu   { background:var(--orange-pale, #FFF3E0); color:#FB8C00; }
.qs-Diproses   { background:#E3F2FD; color:#1E88E5; }
.qs-Selesai    { background:var(--green-pale); color:var(--green); }
.qs-Dibatalkan { background:var(--red-pale); color:var(--red-deep); }
.q-empty  { text-align:center; padding:2rem; color:#ccc; font-size:.82rem; }
.qp-foot  { padding:.6rem 1.3rem; border-top:1px solid var(--border); background:#fafafa; font-size:.68rem; color:#bbb; text-align:right; }

/* ─────────────────────────────────────────
   SUCCESS MODAL
───────────────────────────────────────── */
.modal-mask {
  display:none; position:fixed; inset:0; z-index:500;
  background:rgba(0,0,0,.5); backdrop-filter:blur(4px);
  align-items:center; justify-content:center; padding:1rem;
}
.modal-mask.open { display:flex; }
.modal-box {
  background:white; border-radius:22px;
  width:100%; max-width:400px;
  padding: 2.5rem 2rem; text-align:center;
  box-shadow:0 24px 64px rgba(0,0,0,.2);
  animation:popIn .45s cubic-bezier(.34,1.56,.64,1) both;
}
.modal-icon  { font-size:3.2rem; margin-bottom:.8rem; }
.modal-title { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; margin-bottom:.4rem; }
.modal-kode  { background:var(--red-pale); border-radius:8px; padding:.45rem 1.1rem; display:inline-block; font-weight:700; color:var(--red-deep); font-size:1rem; margin:.6rem 0 .9rem; letter-spacing:1px; }
.modal-desc  { color:#777; font-size:.85rem; line-height:1.7; margin-bottom:1.6rem; }
.modal-close { background:linear-gradient(135deg,var(--red),var(--red-deep)); color:white; border:none; border-radius:10px; padding:.75rem 2rem; font-family:'DM Sans',sans-serif; font-size:.9rem; font-weight:600; cursor:pointer; transition:all .2s; }
.modal-close:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(239,83,80,.38); }

/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media(max-width:800px) {
  .page { grid-template-columns:1fr; }
  .side { order:-1; }
  .fc-row { grid-template-columns:1fr; }
}
</style>
</head>
<body>

<!-- ══ NAVBAR ══ -->
<nav class="navbar">
  <a href="index.php" class="brand">Budi <span>Percetakan</span></a>
  <a href="index.php" class="nav-back">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Kembali
  </a>
</nav>

<!-- ══ PAGE ══ -->
<div class="page">

  <!-- ══════════════════════════════
       KOLOM KIRI — FORM
  ══════════════════════════════ -->
  <div>

    <!-- Tab switcher -->
    <div class="tab-switcher">
      <button class="tab-sw-btn active" id="tabPesan" onclick="switchTab('pesan')">📋 Pesan Baru</button>
      <button class="tab-sw-btn"        id="tabEdit"  onclick="switchTab('edit')">✏️ Edit Pesanan</button>
    </div>

    <!-- ══════════════════
         FORM PESAN BARU
    ══════════════════ -->
    <div id="panelPesan">
      <div class="card">
        <div class="card-head">
          <div class="card-eyebrow">Formulir Pemesanan</div>
          <div class="card-title">Pesan Spanduk Anda</div>
        </div>
        <div class="card-body">
          <div id="alertPesan" class="alert"></div>

          <div class="section-label">Data Pelanggan</div>
          <div class="fg"><label>Nama Lengkap <span>*</span></label><input type="text" id="p-nama" class="fc" placeholder="Contoh: Budi Santoso" autocomplete="off"></div>
          <div class="fc-row">
            <div class="fg"><label>Nomor WhatsApp <span>*</span></label><input type="int" id="p-wa" class="fc" placeholder="08xx-xxxx-xxxx"></div>
            <div class="fg"><label>Jenis Bahan <span>*</span></label>
              <select id="p-bahan" class="fc" onchange="hitungHarga('p')">
                <option value="">— Pilih Bahan —</option>
                <?php foreach($bahan as $b): ?>
                <option value="<?=$b['id']?>" data-harga="<?=$b['harga_per_m2']?>">
                  <?=htmlspecialchars($b['nama_bahan'])?> — Rp <?=number_format($b['harga_per_m2'],0,',','.')?>/m²
                </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="fg"><label>Alamat <span>*</span></label><textarea id="p-alamat" class="fc" placeholder="Alamat pengiriman / pengambilan..."></textarea></div>

          <div class="section-label">Detail Spanduk</div>
          <div class="fc-row">
            <div class="fg"><label>Panjang (meter) <span>*</span></label><input type="number" id="p-panjang" class="fc" placeholder="5" min="0.1" step="0.1" oninput="hitungHarga('p')"></div>
            <div class="fg"><label>Lebar (meter) <span>*</span></label><input type="number" id="p-lebar" class="fc" placeholder="1" min="0.1" step="0.1" oninput="hitungHarga('p')"></div>
          </div>
          <div class="fg"><label>Jumlah (pcs) <span>*</span></label><input type="number" id="p-jumlah" class="fc" value="1" min="1" max="9999" oninput="hitungHarga('p')"></div>
          <div class="fg"><label>Catatan Desain</label><textarea id="p-catatan" class="fc" placeholder="Warna dominan, teks yang ditampilkan, dll..."></textarea></div>

          <div class="section-label">Upload File Desain</div>
          <div class="upload-zone" id="pUploadZone">
            <input type="file" id="p-file" accept="image/*,.pdf" onchange="previewFile('p')">
            <div class="upload-icon">🖼️</div>
            <div class="upload-text">Klik atau <b>drag & drop</b> file desain</div>
            <div class="upload-hint">JPG · PNG · WEBP · GIF · PDF · Maks 5MB (opsional)</div>
          </div>
          <div class="file-preview" id="pFilePreview"></div>

          <!-- Kalkulator harga -->
          <div class="price-card" id="pPriceCard">
            <div class="price-lbl">💰 Estimasi Total Harga</div>
            <div class="price-breakdown" id="pBreakdown"></div>
            <div id="pPriceDisplay" class="price-placeholder">Isi dimensi & pilih bahan untuk melihat estimasi harga</div>
          </div>

          <button class="btn-primary" id="btnPesan" onclick="submitPesan()">
            <span id="btnPesanTxt">Kirim Pesanan</span>
            <div class="btn-spin" id="btnPesanSpin"></div>
            <svg id="btnPesanIco" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- ══════════════════
         PANEL EDIT PESANAN
    ══════════════════ -->
    <div id="panelEdit" style="display:none;">

      <!-- Step 1: Lookup -->
      <div class="lookup-box" id="lookupBox">
        <div class="lookup-head">
          <div class="lookup-title">✏️ Edit Pesanan</div>
          <div class="lookup-sub">Masukkan kode pesanan & nomor WA untuk memverifikasi</div>
        </div>
        <div class="lookup-body">
          <div class="lookup-info">
            ℹ️ Pesanan hanya dapat diedit selama masih berstatus <strong>Menunggu</strong>. Setelah diproses, hubungi toko langsung.
          </div>
          <div id="alertLookup" class="alert"></div>
          <div class="fg"><label>Kode Pesanan <span>*</span></label><input type="text" id="l-kode" class="fc" placeholder="Contoh: BP-20240601-0001" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()"></div>
          <div class="fg"><label>Nomor WhatsApp <span>*</span></label><input type="text" id="l-wa" class="fc" placeholder="Nomor WA yang dipakai saat pesan"></div>
          <button class="btn-primary" id="btnLookup" onclick="cekPesanan()" style="margin-top:.8rem;">
            <span id="btnLookupTxt">Cek & Verifikasi</span>
            <div class="btn-spin" id="btnLookupSpin"></div>
            <svg id="btnLookupIco" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          </button>
        </div>
      </div>

      <!-- Step 2: Form edit (muncul setelah verifikasi) -->
      <div class="card" id="editFormCard" style="display:none; margin-top:1.2rem;">
        <div class="card-head" style="padding:1.3rem 2rem;">
          <div class="card-eyebrow">Edit Pesanan</div>
          <div class="card-title" id="editKodeLabel">—</div>
        </div>
        <div class="card-body">
          <div id="alertEdit" class="alert"></div>
          <div class="edit-pesanan-badge">
            <span>✅</span>
            <span>Pesanan terverifikasi — ubah data yang perlu diperbarui</span>
          </div>

          <input type="hidden" id="e-id">
          <input type="hidden" id="e-wa-ver">

          <div class="section-label">Detail Spanduk</div>
          <div class="fg"><label>Jenis Bahan <span>*</span></label>
            <select id="e-bahan" class="fc" onchange="hitungHarga('e')">
              <option value="">— Pilih Bahan —</option>
              <?php foreach($bahan as $b): ?>
              <option value="<?=$b['id']?>" data-harga="<?=$b['harga_per_m2']?>">
                <?=htmlspecialchars($b['nama_bahan'])?> — Rp <?=number_format($b['harga_per_m2'],0,',','.')?>/m²
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="fc-row">
            <div class="fg"><label>Panjang (meter) <span>*</span></label><input type="number" id="e-panjang" class="fc" min="0.1" step="0.1" oninput="hitungHarga('e')"></div>
            <div class="fg"><label>Lebar (meter) <span>*</span></label><input type="number"  id="e-lebar"   class="fc" min="0.1" step="0.1" oninput="hitungHarga('e')"></div>
          </div>
          <div class="fg"><label>Jumlah (pcs) <span>*</span></label><input type="number" id="e-jumlah" class="fc" min="1" max="9999" oninput="hitungHarga('e')"></div>
          <div class="fg"><label>Alamat <span>*</span></label><textarea id="e-alamat" class="fc"></textarea></div>
          <div class="fg"><label>Catatan Desain</label><textarea id="e-catatan" class="fc" placeholder="Perubahan catatan desain..."></textarea></div>

          <div class="section-label">File Desain</div>
          <!-- Info file lama -->
          <div id="existingFileWrap" class="existing-file" style="display:none;">
            <div>
              📎 File saat ini: <a id="existingFileLink" href="#" target="_blank">—</a>
            </div>
            <button class="btn-hapus-file" onclick="hapusFileLama()">✕ Hapus file</button>
          </div>
          <input type="hidden" id="e-hapus-file" value="0">
          <!-- Upload baru -->
          <div class="upload-zone" id="eUploadZone">
            <input type="file" id="e-file" accept="image/*,.pdf" onchange="previewFile('e')">
            <div class="upload-icon">🖼️</div>
            <div class="upload-text">Klik untuk <b>ganti / tambah</b> file desain</div>
            <div class="upload-hint">JPG · PNG · WEBP · GIF · PDF · Maks 5MB (opsional)</div>
          </div>
          <div class="file-preview" id="eFilePreview"></div>

          <div class="price-card" id="ePriceCard">
            <div class="price-lbl">💰 Total Harga Baru</div>
            <div class="price-breakdown" id="eBreakdown"></div>
            <div id="ePriceDisplay" class="price-placeholder">Ubah dimensi atau bahan untuk kalkulasi ulang</div>
          </div>

          <button class="btn-primary" id="btnEdit" onclick="submitEdit()" style="margin-top:1.5rem;">
            <span id="btnEditTxt">Simpan Perubahan</span>
            <div class="btn-spin" id="btnEditSpin"></div>
            <svg id="btnEditIco" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          </button>
        </div>
      </div>

    </div><!-- /panelEdit -->

  </div><!-- /kolom kiri -->

  <!-- ══════════════════════════════
       KOLOM KANAN — SIDE PANEL
  ══════════════════════════════ -->
  <div class="side">

    <!-- Daftar bahan -->
    <div>
      <div class="bahan-list-title">Pilihan Bahan Tersedia</div>
      <?php foreach($bahan as $b): ?>
      <div class="bahan-mini" id="bm-<?=$b['id']?>">
        <div class="bm-dot"><?=strtoupper(substr($b['nama_bahan'],0,2))?></div>
        <div>
          <div class="bm-name"><?=htmlspecialchars($b['nama_bahan'])?></div>
          <div class="bm-price">Rp <?=number_format($b['harga_per_m2'],0,',','.')?>/m²</div>
          <div class="bm-info"><?=htmlspecialchars($b['keunggulan'])?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Antrean live -->
    <div class="queue-panel">
      <div class="qp-head">
        <div class="qp-title">📋 Antrean Pesanan</div>
        <div class="live-badge"><div class="live-dot"></div>LIVE</div>
      </div>
      <div class="qp-body" id="queueBody">
        <div class="q-empty"><span style="display:inline-block;width:14px;height:14px;border:2px solid #eee;border-top-color:var(--red);border-radius:50%;animation:spin .7s linear infinite;vertical-align:middle;margin-right:.4rem;"></span>Memuat...</div>
      </div>
      <div class="qp-foot" id="queueFoot">—</div>
    </div>

  </div>

</div><!-- /page -->

<!-- ══ SUCCESS MODAL ══ -->
<div class="modal-mask" id="successModal">
  <div class="modal-box">
    <div class="modal-icon" id="mIcon">🎉</div>
    <div class="modal-title" id="mTitle">Pesanan Berhasil!</div>
    <p style="color:#aaa;font-size:.82rem;margin-bottom:.3rem;">Kode Pesanan:</p>
    <div class="modal-kode" id="mKode">—</div>
    <p class="modal-desc" id="mDesc">Pesanan Anda telah kami terima. Tim kami akan segera memproses dan menghubungi Anda via WhatsApp.</p>
    <button class="modal-close" onclick="closeModal()">Oke, Mengerti!</button>
  </div>
</div>

<!-- ══════════════════════════════
     JAVASCRIPT
══════════════════════════════ -->
<script>
'use strict';

/* ── Data bahan dari PHP ── */
const BAHAN = {
  <?php foreach($bahan as $b): ?>
  <?=$b['id']?>: { harga: <?=$b['harga_per_m2']?>, nama: <?=json_encode($b['nama_bahan'])?> },
  <?php endforeach; ?>
};

/* ── Helpers ── */
const $ = id => document.getElementById(id);
const fmtRp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

/* ═══════════════════════════════
   TAB SWITCHER
═══════════════════════════════ */
function switchTab(tab) {
  const isPesan = tab === 'pesan';
  $('tabPesan').classList.toggle('active', isPesan);
  $('tabEdit').classList.toggle('active', !isPesan);
  $('panelPesan').style.display = isPesan ? '' : 'none';
  $('panelEdit').style.display  = isPesan ? 'none' : '';
}

/* ═══════════════════════════════
   KALKULATOR HARGA (prefix: 'p' atau 'e')
═══════════════════════════════ */
function hitungHarga(pfx) {
  const p    = parseFloat($(pfx+'-panjang')?.value) || 0;
  const l    = parseFloat($(pfx+'-lebar')?.value)   || 0;
  const q    = parseInt($(pfx+'-jumlah')?.value)    || 0;
  const id   = $(pfx+'-bahan')?.value;
  const card = $(pfx === 'p' ? 'pPriceCard' : 'ePriceCard');
  const disp = $(pfx === 'p' ? 'pPriceDisplay' : 'ePriceDisplay');
  const brk  = $(pfx === 'p' ? 'pBreakdown' : 'eBreakdown');

  // Highlight bahan card
  document.querySelectorAll('.bahan-mini').forEach(c => c.classList.remove('sel'));
  if (id) { const bm = $('bm-'+id); if (bm) bm.classList.add('sel'); }

  if (!id || p <= 0 || l <= 0 || q <= 0) {
    card.classList.remove('active');
    disp.className = 'price-placeholder';
    disp.textContent = pfx === 'p'
      ? 'Isi dimensi & pilih bahan untuk melihat estimasi harga'
      : 'Ubah dimensi atau bahan untuk kalkulasi ulang';
    brk.textContent = '';
    return;
  }

  const harga = BAHAN[id]?.harga || 0;
  const total = p * l * harga * q;
  brk.textContent  = `${p}m × ${l}m = ${(p*l).toFixed(2)} m²  ×  ${fmtRp(harga)}/m²  ×  ${q} pcs`;
  disp.className   = 'price-total';
  disp.textContent = fmtRp(total);
  card.classList.add('active');
}

/* ═══════════════════════════════
   UPLOAD & PREVIEW FILE
═══════════════════════════════ */
function previewFile(pfx) {
  const input   = $(pfx+'-file');
  const preview = $(pfx+'FilePreview');
  const file    = input.files[0];
  if (!file) { preview.classList.remove('show'); preview.innerHTML = ''; return; }

  const sizeMB = (file.size / 1048576).toFixed(2);
  const isImg  = file.type.startsWith('image/');
  const isPDF  = file.type === 'application/pdf';

  let html = `<div class="fp-top">
    <span class="fp-name" title="${file.name}">${file.name}</span>
    <span style="display:flex;align-items:center;gap:.5rem;">
      <span class="fp-size">${sizeMB} MB</span>
      <button class="fp-del" onclick="clearFile('${pfx}')" title="Hapus">✕</button>
    </span>
  </div>`;

  if (isImg) {
    const url = URL.createObjectURL(file);
    html += `<img class="fp-img" src="${url}" alt="Preview desain">`;
  } else if (isPDF) {
    html += `<div class="fp-pdf"><div class="fp-pdf-icon">📄</div><div class="fp-pdf-info">File PDF siap diupload<br><small style="color:#bbb;">${file.name}</small></div></div>`;
  }

  preview.innerHTML = html;
  preview.classList.add('show');
}

function clearFile(pfx) {
  const input = $(pfx+'-file');
  input.value = '';
  $(pfx+'FilePreview').classList.remove('show');
  $(pfx+'FilePreview').innerHTML = '';
  // Reset upload zone drag style
  $(pfx+'UploadZone').classList.remove('drag');
}

/* Drag & drop visual */
['pUploadZone','eUploadZone'].forEach(id => {
  const zone = $(id);
  if (!zone) return;
  zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag'); });
  zone.addEventListener('dragleave', () => zone.classList.remove('drag'));
  zone.addEventListener('drop',      e => {
    e.preventDefault(); zone.classList.remove('drag');
    const pfx = id.startsWith('p') ? 'p' : 'e';
    const input = $(pfx+'-file');
    if (e.dataTransfer.files[0]) {
      // Transfer file ke input
      const dt = new DataTransfer();
      dt.items.add(e.dataTransfer.files[0]);
      input.files = dt.files;
      previewFile(pfx);
    }
  });
});

/* ═══════════════════════════════
   SUBMIT PESAN BARU
═══════════════════════════════ */
async function submitPesan() {
  const btn = $('btnPesan');
  showAlert('alertPesan', '', '');

  const fd = new FormData();
  fd.append('nama',     $('p-nama').value.trim());
  fd.append('whatsapp', $('p-wa').value.trim());
  fd.append('alamat',   $('p-alamat').value.trim());
  fd.append('id_bahan', $('p-bahan').value);
  fd.append('panjang',  $('p-panjang').value);
  fd.append('lebar',    $('p-lebar').value);
  fd.append('jumlah',   $('p-jumlah').value);
  fd.append('catatan',  $('p-catatan').value.trim());
  const file = $('p-file').files[0];
  if (file) fd.append('file_desain', file);

  setLoading('btnPesan', true);
  try {
    const res  = await fetch('api/pesan_submit.php', { method:'POST', body:fd });
    const data = await res.json();
    if (data.success) {
      showSuccessModal('🎉', 'Pesanan Berhasil!', data.kode_pesanan,
        'Pesanan Anda telah kami terima dan akan segera diproses. Simpan kode ini untuk melacak atau mengedit pesanan.');
      resetPesanForm();
      fetchQueue();
    } else {
      showAlert('alertPesan', 'err', '⚠️ ' + data.message);
    }
  } catch(e) {
    showAlert('alertPesan', 'err', '❌ Koneksi gagal, coba lagi.');
  } finally { setLoading('btnPesan', false); }
}

function resetPesanForm() {
  ['p-nama','p-wa','p-alamat','p-catatan'].forEach(id => $(id).value = '');
  $('p-panjang').value = '';
  $('p-lebar').value   = '';
  $('p-jumlah').value  = 1;
  $('p-bahan').value   = '';
  clearFile('p');
  hitungHarga('p');
}

/* ═══════════════════════════════
   CEK & VERIFIKASI PESANAN
═══════════════════════════════ */
async function cekPesanan() {
  showAlert('alertLookup', '', '');
  const fd = new FormData();
  fd.append('action',   'cek');
  fd.append('kode',     $('l-kode').value.trim());
  fd.append('whatsapp', $('l-wa').value.trim());

  setLoading('btnLookup', true);
  try {
    const res  = await fetch('api/edit_pesanan.php', { method:'POST', body:fd });
    const data = await res.json();
    if (data.success) {
      populateEditForm(data.pesanan);
    } else {
      showAlert('alertLookup', 'err', '⚠️ ' + data.message);
    }
  } catch(e) {
    showAlert('alertLookup', 'err', '❌ Koneksi gagal.');
  } finally { setLoading('btnLookup', false); }
}

function populateEditForm(p) {
  $('e-id').value     = p.id;
  $('e-wa-ver').value = p.no_whatsapp;
  $('editKodeLabel').textContent = p.kode_pesanan;

  $('e-bahan').value   = p.id_bahan;
  $('e-panjang').value = p.panjang;
  $('e-lebar').value   = p.lebar;
  $('e-jumlah').value  = p.jumlah;
  $('e-alamat').value  = p.alamat;
  $('e-catatan').value = p.catatan_desain || '';

  // File lama
  if (p.file_desain) {
    $('existingFileLink').href        = 'uploads/desain/' + p.file_desain;
    $('existingFileLink').textContent = p.file_desain;
    $('existingFileWrap').style.display = 'flex';
  } else {
    $('existingFileWrap').style.display = 'none';
  }
  $('e-hapus-file').value = '0';

  $('editFormCard').style.display = '';
  hitungHarga('e');
  $('editFormCard').scrollIntoView({ behavior:'smooth', block:'start' });
}

function hapusFileLama() {
  $('e-hapus-file').value = '1';
  $('existingFileWrap').style.display = 'none';
}

/* ═══════════════════════════════
   SUBMIT EDIT PESANAN
═══════════════════════════════ */
async function submitEdit() {
  showAlert('alertEdit', '', '');

  const fd = new FormData();
  fd.append('action',      'simpan');
  fd.append('id',          $('e-id').value);
  fd.append('wa_ver',      $('e-wa-ver').value);
  fd.append('id_bahan',    $('e-bahan').value);
  fd.append('panjang',     $('e-panjang').value);
  fd.append('lebar',       $('e-lebar').value);
  fd.append('jumlah',      $('e-jumlah').value);
  fd.append('alamat',      $('e-alamat').value.trim());
  fd.append('catatan',     $('e-catatan').value.trim());
  fd.append('hapus_file',  $('e-hapus-file').value);
  const file = $('e-file').files[0];
  if (file) fd.append('file_desain', file);

  setLoading('btnEdit', true);
  try {
    const res  = await fetch('api/edit_pesanan.php', { method:'POST', body:fd });
    const data = await res.json();
    if (data.success) {
      showSuccessModal('✅', 'Pesanan Diperbarui!', data.kode_pesanan,
        'Perubahan pesanan Anda berhasil disimpan. Tim kami akan memproses sesuai data terbaru.');
      $('editFormCard').style.display = 'none';
      $('l-kode').value = '';
      $('l-wa').value   = '';
    } else {
      showAlert('alertEdit', 'err', '⚠️ ' + data.message);
    }
  } catch(e) {
    showAlert('alertEdit', 'err', '❌ Koneksi gagal.');
  } finally { setLoading('btnEdit', false); }
}

/* ═══════════════════════════════
   ANTRIAN LIVE
═══════════════════════════════ */
async function fetchQueue() {
  try {
    const res  = await fetch('api/antrian.php');
    const data = await res.json();
    const body = $('queueBody');
    const foot = $('queueFoot');
    if (!data.success || !data.data.length) {
      body.innerHTML = '<div class="q-empty">Belum ada pesanan masuk.</div>';
      foot.textContent = '—';
      return;
    }
    body.innerHTML = data.data.map(q => `
      <div class="q-item">
        <div>
          <div class="q-name">${q.nama}</div>
          <div class="q-detail">${q.bahan} · ${q.luas} m² · ${q.jumlah} pcs</div>
        </div>
        <span class="qsp qs-${q.status}">${q.status}</span>
      </div>`).join('');
    foot.textContent = 'Diperbarui: ' + new Date().toLocaleTimeString('id-ID');
  } catch(e) {
    $('queueBody').innerHTML = '<div class="q-empty">Gagal memuat antrean.</div>';
  }
}
fetchQueue();
setInterval(fetchQueue, 15000);

/* ═══════════════════════════════
   HELPER UI
═══════════════════════════════ */
function showAlert(id, type, msg) {
  const el = $(id);
  if (!type) { el.className = 'alert'; el.textContent = ''; return; }
  el.className = `alert ${type === 'err' ? 'alert-err' : 'alert-ok'} show`;
  el.textContent = msg;
  el.scrollIntoView({ behavior:'smooth', block:'center' });
}

function setLoading(btnId, loading) {
  const btn  = $(btnId);
  const txt  = $(btnId+'Txt');
  const spin = $(btnId+'Spin');
  const ico  = $(btnId+'Ico');
  btn.disabled = loading;
  if (spin) spin.style.display = loading ? 'block' : 'none';
  if (ico)  ico.style.display  = loading ? 'none'  : 'inline';
  if (txt && loading) txt.textContent = 'Mengirim...';
  if (txt && !loading) {
    const defaults = { btnPesan:'Kirim Pesanan', btnLookup:'Cek & Verifikasi', btnEdit:'Simpan Perubahan' };
    txt.textContent = defaults[btnId] || txt.textContent;
  }
}

function showSuccessModal(icon, title, kode, desc) {
  $('mIcon').textContent  = icon;
  $('mTitle').textContent = title;
  $('mKode').textContent  = kode;
  $('mDesc').textContent  = desc;
  $('successModal').classList.add('open');
}
function closeModal() { $('successModal').classList.remove('open'); }
$('successModal').addEventListener('click', e => { if (e.target === $('successModal')) closeModal(); });
</script>

</body>
</html>
