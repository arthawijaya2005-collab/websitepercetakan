<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
$adminNama = htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — Budi Percetakan</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ─────────────────────────────────────────
   DESIGN TOKENS
───────────────────────────────────────── */
:root {
  --red:        #EF5350;
  --red-deep:   #C62828;
  --red-soft:   #E57373;
  --red-pale:   #FFEBEE;
  --red-light:  #FFCDD2;
  --green:      #43A047;
  --green-pale: #E8F5E9;
  --blue:       #1E88E5;
  --blue-pale:  #E3F2FD;
  --orange:     #FB8C00;
  --orange-pale:#FFF3E0;
  --sidebar-w:  220px;
  --topbar-h:   60px;
  --bg:         #F4F6F8;
  --surface:    #FFFFFF;
  --border:     #EEE4E4;
  --text:       #1A1A1A;
  --text-sub:   #9E9E9E;
  --r-lg:       16px;
  --r-md:       10px;
  --shadow-sm:  0 2px 8px rgba(0,0,0,.06);
  --shadow-md:  0 6px 24px rgba(0,0,0,.09);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

/* ─────────────────────────────────────────
   KEYFRAMES
───────────────────────────────────────── */
@keyframes fadeUp   { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes fadeIn   { from { opacity:0; } to { opacity:1; } }
@keyframes spin     { to { transform:rotate(360deg); } }
@keyframes pulse    { 0%,100%{opacity:1} 50%{opacity:.25} }
@keyframes countUp  { from{opacity:0;transform:translateY(5px)} to{opacity:1;transform:translateY(0)} }
@keyframes toastIn  { from{opacity:0;transform:translateX(110%)} to{opacity:1;transform:translateX(0)} }
@keyframes toastOut { to{opacity:0;transform:translateX(110%)} }
@keyframes shimmer  { 0%{background-position:-400px 0} 100%{background-position:400px 0} }

/* ─────────────────────────────────────────
   SIDEBAR
───────────────────────────────────────── */
.sidebar {
  width: var(--sidebar-w); min-height: 100vh;
  background: #170707;
  display: flex; flex-direction: column;
  position: fixed; top:0; left:0; z-index:200;
  transition: transform .28s ease;
}
.sb-brand   { padding: 1.4rem 1.4rem 1rem; border-bottom: 1px solid rgba(255,255,255,.06); }
.sb-logo    { font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:900; color:#fff; }
.sb-logo span { color: var(--red-soft); }
.sb-sub     { font-size:.6rem; color:rgba(255,255,255,.28); text-transform:uppercase; letter-spacing:2px; margin-top:.25rem; }

.sb-user    { display:flex; align-items:center; gap:.7rem; padding:.9rem 1.4rem; border-bottom:1px solid rgba(255,255,255,.04); }
.sb-avatar  { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--red),var(--red-deep)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.82rem; color:#fff; flex-shrink:0; }
.sb-uname   { font-size:.8rem; font-weight:600; color:rgba(255,255,255,.82); }
.sb-urole   { font-size:.62rem; color:rgba(255,255,255,.3); }

.sb-nav     { flex:1; padding:.8rem 0; }
.sb-section { font-size:.58rem; font-weight:700; color:rgba(255,255,255,.18); letter-spacing:2px; text-transform:uppercase; padding:.65rem 1.4rem .3rem; }
.sb-item    { display:flex; align-items:center; gap:.65rem; padding:.62rem 1.4rem; color:rgba(255,255,255,.42); font-size:.82rem; font-weight:500; text-decoration:none; border:none; background:none; width:100%; cursor:pointer; font-family:'DM Sans',sans-serif; border-left:3px solid transparent; transition:all .18s; }
.sb-item svg { opacity:.65; flex-shrink:0; }
.sb-item:hover  { background:rgba(255,255,255,.05); color:rgba(255,255,255,.78); border-left-color:rgba(239,83,80,.35); }
.sb-item.active { background:rgba(239,83,80,.13); color:#fff; border-left-color:var(--red); }
.sb-item.active svg { opacity:1; color:var(--red-soft); }

.sb-bottom  { padding:.9rem 1.2rem 1.4rem; border-top:1px solid rgba(255,255,255,.05); }
.sb-logout  { display:flex; align-items:center; gap:.6rem; padding:.62rem .9rem; background:rgba(239,83,80,.1); border:1px solid rgba(239,83,80,.18); border-radius:9px; color:var(--red-soft); font-family:'DM Sans',sans-serif; font-size:.8rem; font-weight:600; cursor:pointer; width:100%; text-decoration:none; transition:all .18s; }
.sb-logout:hover { background:rgba(239,83,80,.22); }

/* ─────────────────────────────────────────
   TOPBAR
───────────────────────────────────────── */
.topbar {
  position:fixed; top:0; left:var(--sidebar-w); right:0;
  height:var(--topbar-h); z-index:100;
  background:rgba(255,255,255,.95); backdrop-filter:blur(12px);
  border-bottom:1px solid var(--border);
  display:flex; align-items:center; justify-content:space-between;
  padding:0 1.8rem;
}
.topbar-l    { display:flex; align-items:center; gap:.9rem; }
.topbar-page { font-family:'Playfair Display',serif; font-size:1.15rem; font-weight:700; color:var(--text); }
.topbar-r    { display:flex; align-items:center; gap:.8rem; }
.topbar-date { font-size:.78rem; color:var(--text-sub); }
#clock       { font-weight:600; color:#555; }
.live-badge  { display:flex; align-items:center; gap:.35rem; font-size:.68rem; font-weight:700; color:var(--green); background:var(--green-pale); border-radius:50px; padding:.25rem .75rem; }
.live-dot    { width:6px; height:6px; border-radius:50%; background:var(--green); animation:pulse 1.6s ease-in-out infinite; }
#hamburger   { display:none; background:none; border:none; cursor:pointer; padding:.3rem; }

/* ─────────────────────────────────────────
   LAYOUT
───────────────────────────────────────── */
.main {
  margin-left:var(--sidebar-w);
  margin-top:var(--topbar-h);
  padding:1.8rem 2rem 3rem;
  min-height:calc(100vh - var(--topbar-h));
  animation:fadeIn .4s ease;
}

/* Section divider */
.section-divider {
  display:flex; align-items:flex-end; justify-content:space-between;
  margin:2rem 0 1rem; flex-wrap:wrap; gap:.5rem;
}
.section-divider:first-child { margin-top:0; }
.sd-left  {}
.sd-tag   { font-size:.62rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--red); margin-bottom:.2rem; }
.sd-title { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:700; color:var(--text); }
.sd-sub   { font-size:.74rem; color:var(--text-sub); margin-top:.15rem; }

/* ─────────────────────────────────────────
   KPI CARDS
───────────────────────────────────────── */
.kpi-row {
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:1rem;
  margin-bottom:1.2rem;
}
.kpi {
  background:var(--surface);
  border-radius:var(--r-lg);
  padding:1.1rem 1.2rem 1rem;
  border:1px solid var(--border);
  border-top:3px solid transparent;
  position:relative; overflow:hidden;
  box-shadow:var(--shadow-sm);
  transition:transform .22s, box-shadow .22s;
  animation:fadeUp .5s ease both;
}
.kpi:hover { transform:translateY(-3px); box-shadow:var(--shadow-md); }
.kpi::after {
  content:''; position:absolute; top:-18px; right:-18px;
  width:72px; height:72px; border-radius:50%; opacity:.07;
}
.kpi.c-red    { border-top-color:var(--red);    } .kpi.c-red::after    { background:var(--red); }
.kpi.c-green  { border-top-color:var(--green);  } .kpi.c-green::after  { background:var(--green); }
.kpi.c-blue   { border-top-color:var(--blue);   } .kpi.c-blue::after   { background:var(--blue); }
.kpi.c-orange { border-top-color:var(--orange); } .kpi.c-orange::after { background:var(--orange); }
.kpi.c-gray   { border-top-color:#9E9E9E;       } .kpi.c-gray::after   { background:#9E9E9E; }

.kpi-ico  { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:.95rem; margin-bottom:.7rem; }
.kpi.c-red    .kpi-ico { background:var(--red-pale); }
.kpi.c-green  .kpi-ico { background:var(--green-pale); }
.kpi.c-blue   .kpi-ico { background:var(--blue-pale); }
.kpi.c-orange .kpi-ico { background:var(--orange-pale); }
.kpi.c-gray   .kpi-ico { background:#F5F5F5; }

.kpi-lbl  { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.9px; color:var(--text-sub); margin-bottom:.3rem; }
.kpi-val  { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--text); line-height:1; letter-spacing:-.5px; animation:countUp .45s ease both; }
.kpi-foot { font-size:.68rem; color:var(--text-sub); margin-top:.3rem; }

/* ─────────────────────────────────────────
   HISTORI PANEL
───────────────────────────────────────── */
.panel {
  background:var(--surface);
  border-radius:var(--r-lg);
  border:1px solid var(--border);
  box-shadow:var(--shadow-sm);
  overflow:hidden;
  margin-bottom:1.4rem;
  animation:fadeUp .5s ease both;
}
.panel-head {
  display:flex; align-items:center; justify-content:space-between;
  padding:1.1rem 1.5rem;
  border-bottom:1px solid #f7eeee;
  flex-wrap:wrap; gap:.6rem;
}
.panel-title { font-family:'Playfair Display',serif; font-size:1rem; font-weight:700; color:var(--text); }

/* Pill toggle */
.pill-group { display:flex; gap:.25rem; background:#f5eeee; border-radius:50px; padding:.22rem; }
.pill       { padding:.28rem .9rem; border-radius:50px; border:none; background:transparent; font-family:'DM Sans',sans-serif; font-size:.72rem; font-weight:600; color:var(--text-sub); cursor:pointer; transition:all .18s; white-space:nowrap; }
.pill.active { background:var(--surface); color:var(--red); box-shadow:0 1px 4px rgba(0,0,0,.1); }

/* Metric toggle row */
.metric-row { display:flex; gap:.35rem; flex-wrap:wrap; padding:.7rem 1.5rem; border-bottom:1px solid #f9f3f3; }
.mtog       { padding:.26rem .78rem; border-radius:50px; border:1.5px solid var(--border); background:var(--surface); font-family:'DM Sans',sans-serif; font-size:.7rem; font-weight:600; color:var(--text-sub); cursor:pointer; transition:all .18s; }
.mtog:hover { border-color:var(--red); color:var(--red); }
.mtog.active { background:var(--red); color:#fff; border-color:var(--red); }

/* Bar chart */
.chart-wrap { padding:1rem 1.5rem .8rem; }
.bar-chart  { display:flex; align-items:flex-end; gap:3px; height:130px; overflow-x:auto; padding-bottom:2px; }
.bar-chart::-webkit-scrollbar { height:3px; }
.bar-chart::-webkit-scrollbar-thumb { background:var(--red-light); border-radius:3px; }
.bc         { flex-shrink:0; min-width:20px; display:flex; flex-direction:column; align-items:center; gap:.28rem; height:100%; }
.bc-w       { flex:1; width:100%; display:flex; align-items:flex-end; justify-content:center; }
.bc-b       { width:100%; max-width:26px; min-height:3px; border-radius:4px 4px 0 0; background:linear-gradient(180deg,var(--red),var(--red-soft)); transition:height .55s cubic-bezier(.34,1.56,.64,1); cursor:pointer; position:relative; }
.bc-b.hi    { background:linear-gradient(180deg,var(--red-deep),var(--red)); }
.bc-b:hover::after { content:attr(data-tip); position:absolute; bottom:calc(100%+5px); left:50%; transform:translateX(-50%); background:#1a1a1a; color:#fff; font-size:.63rem; padding:.2rem .5rem; border-radius:5px; white-space:nowrap; pointer-events:none; z-index:10; }
.bc-l       { font-size:.57rem; color:#ccc; white-space:nowrap; }

/* Summary strip */
.sum-strip  { display:flex; gap:.8rem; flex-wrap:wrap; padding:.85rem 1.5rem 1rem; background:#fdf9f9; border-top:1px solid #f7eeee; border-bottom:1px solid #f7eeee; }
.sum-item   { flex:1; min-width:110px; }
.sum-lbl    { font-size:.6rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:var(--text-sub); margin-bottom:.22rem; }
.sum-val    { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:700; color:var(--text); }
.sum-sub    { font-size:.63rem; color:var(--text-sub); margin-top:.1rem; }

/* Histori table */
.htbl       { width:100%; border-collapse:collapse; font-size:.79rem; }
.htbl th    { padding:.58rem 1.1rem; text-align:left; font-size:.62rem; font-weight:700; color:var(--text-sub); text-transform:uppercase; letter-spacing:.8px; background:#fafafa; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.htbl td    { padding:.62rem 1.1rem; border-bottom:1px solid #f9f9f9; vertical-align:middle; }
.htbl tr:last-child td { border-bottom:none; }
.htbl tr:hover td { background:#fffafa; }
.htbl tr.now td   { background:#fff8f8; }
.htbl tr.now .hl  { color:var(--red); font-weight:700; }
.now-badge  { display:inline-block; background:var(--red-pale); color:var(--red); border-radius:4px; padding:.07rem .38rem; font-size:.6rem; font-weight:700; margin-left:.35rem; }
.vg { font-weight:700; color:var(--green); }
.vr { font-weight:600; color:var(--red); }
.vb-chip { display:inline-block; background:var(--blue-pale); color:var(--blue); border-radius:50px; padding:.1rem .5rem; font-size:.66rem; font-weight:700; }

/* ─────────────────────────────────────────
   ORDERS PANEL
───────────────────────────────────────── */
.ord-panel  { background:var(--surface); border-radius:var(--r-lg); border:1px solid var(--border); box-shadow:var(--shadow-sm); overflow:hidden; animation:fadeUp .5s ease both; }
.ord-head   { padding:1rem 1.5rem 0; border-bottom:1px solid #f7eeee; }
.ord-top    { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.8rem; margin-bottom:.85rem; }
.ord-title  { font-family:'Playfair Display',serif; font-size:1rem; font-weight:700; color:var(--text); }

.search-box { display:flex; align-items:center; gap:.42rem; border:1.5px solid var(--border); border-radius:9px; padding:.4rem .82rem; background:var(--surface); transition:border-color .18s; }
.search-box:focus-within { border-color:var(--red); box-shadow:0 0 0 3px rgba(239,83,80,.1); }
.search-box svg   { color:#ccc; flex-shrink:0; }
.search-box input { border:none; outline:none; background:transparent; font-family:'DM Sans',sans-serif; font-size:.8rem; color:var(--text); min-width:160px; }

.ftabs      { display:flex; gap:0; overflow-x:auto; }
.ftab       { padding:.48rem .95rem .72rem; font-size:.76rem; font-weight:600; border:none; background:none; cursor:pointer; color:var(--text-sub); border-bottom:2px solid transparent; font-family:'DM Sans',sans-serif; transition:all .18s; white-space:nowrap; }
.ftab:hover { color:#555; }
.ftab.active { color:var(--red); border-bottom-color:var(--red); }

.tbl-wrap   { overflow-x:auto; -webkit-overflow-scrolling:touch; }
.otbl       { width:100%; border-collapse:collapse; font-size:.79rem; }
.otbl th    { padding:.6rem .9rem; text-align:left; font-size:.62rem; font-weight:700; color:var(--text-sub); text-transform:uppercase; letter-spacing:.8px; background:#fafafa; border-bottom:1px solid #f0f0f0; white-space:nowrap; }
.otbl td    { padding:.68rem .9rem; border-bottom:1px solid #f9f9f9; vertical-align:middle; }
.otbl tr:last-child td { border-bottom:none; }
.otbl tr:hover td      { background:#fffafa; }
@media(max-width:1200px) { .c-bahan, .c-tgl    { display:none; } }
@media(max-width:960px)  { .c-ukuran           { display:none; } }

.kode-chip  { font-family:monospace; font-size:.73rem; background:#F5F5F5; border-radius:5px; padding:.13rem .48rem; color:#666; font-weight:600; }
.cname      { font-weight:600; font-size:.82rem; }
.cwa        { font-size:.7rem; color:var(--text-sub); margin-top:.08rem; }
.sp         { display:inline-block; border-radius:50px; padding:.2rem .7rem; font-size:.67rem; font-weight:700; }
.sp-Menunggu   { background:var(--orange-pale); color:var(--orange); }
.sp-Diproses   { background:var(--blue-pale);   color:var(--blue);   }
.sp-Selesai    { background:var(--green-pale);  color:var(--green);  }
.sp-Dibatalkan { background:var(--red-pale);    color:var(--red-deep); }

.btn-kelola { padding:.3rem .78rem; border-radius:7px; border:none; font-family:'DM Sans',sans-serif; font-size:.73rem; font-weight:600; cursor:pointer; background:var(--red-pale); color:var(--red-deep); transition:all .18s; white-space:nowrap; }
.btn-kelola:hover { background:var(--red-light); transform:translateY(-1px); }

.tbl-empty   { text-align:center; padding:2.5rem; color:#ccc; font-size:.82rem; }
.tbl-loading { text-align:center; padding:2rem;   color:#ccc; font-size:.78rem; }
.spin-inline { display:inline-block; width:13px; height:13px; border:2px solid #eee; border-top-color:var(--red); border-radius:50%; animation:spin .7s linear infinite; vertical-align:middle; margin-right:.35rem; }

.pager      { display:flex; align-items:center; justify-content:space-between; padding:.8rem 1.5rem; border-top:1px solid #f5f5f5; }
.pager-info { font-size:.73rem; color:var(--text-sub); }
.pager-btns { display:flex; gap:.28rem; }
.pgr-btn    { width:29px; height:29px; border-radius:7px; border:1.5px solid var(--border); background:var(--surface); display:flex; align-items:center; justify-content:center; cursor:pointer; font-family:'DM Sans',sans-serif; font-size:.76rem; font-weight:600; color:#888; transition:all .18s; }
.pgr-btn:hover:not(:disabled) { border-color:var(--red); color:var(--red); }
.pgr-btn:disabled { opacity:.3; cursor:not-allowed; }
.pgr-btn.cur      { background:var(--red); color:#fff; border-color:var(--red); }

/* ─────────────────────────────────────────
   MODAL
───────────────────────────────────────── */
.modal-mask {
  display:none; position:fixed; inset:0; z-index:500;
  background:rgba(0,0,0,.5); backdrop-filter:blur(4px);
  align-items:center; justify-content:center;
  padding:1rem; overflow-y:auto;
}
.modal-mask.open { display:flex; }
.modal-box  { background:var(--surface); border-radius:18px; width:100%; max-width:480px; max-height:calc(100vh - 2rem); display:flex; flex-direction:column; box-shadow:0 24px 64px rgba(0,0,0,.18); animation:fadeUp .3s ease; overflow:hidden; }
.modal-hd   { padding:1.15rem 1.5rem .9rem; border-bottom:1px solid #f5f0f0; flex-shrink:0; display:flex; justify-content:space-between; align-items:flex-start; }
.modal-title { font-family:'Playfair Display',serif; font-size:1.12rem; font-weight:700; color:var(--text); }
.modal-kode  { font-size:.75rem; color:var(--text-sub); margin-top:.12rem; }
.modal-cls   { background:none; border:none; cursor:pointer; color:#bbb; font-size:1.1rem; padding:.15rem; line-height:1; transition:color .18s; }
.modal-cls:hover { color:var(--text); }
.modal-body { flex:1; overflow-y:auto; padding:.9rem 1.5rem 0; }
.modal-body::-webkit-scrollbar { width:3px; }
.modal-body::-webkit-scrollbar-thumb { background:var(--red-light); border-radius:3px; }
.drow { display:flex; justify-content:space-between; padding:.4rem 0; border-bottom:1px solid #f5f0f0; font-size:.79rem; }
.drow:last-child { border-bottom:none; }
.dk   { color:var(--text-sub); font-weight:500; flex-shrink:0; padding-right:.8rem; }
.dv   { font-weight:600; color:var(--text); text-align:right; word-break:break-word; }
.flbl { font-size:.73rem; font-weight:600; color:#555; display:block; margin:.85rem 0 .32rem; }
.fsel { width:100%; padding:.6rem .88rem; border:1.5px solid #e8e0e0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:.83rem; color:var(--text); outline:none; background:var(--surface); transition:border-color .18s; appearance:none; }
.fsel:focus  { border-color:var(--red); box-shadow:0 0 0 3px rgba(239,83,80,.1); }
.farea { width:100%; padding:.6rem .88rem; border:1.5px solid #e8e0e0; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:.8rem; color:var(--text); outline:none; resize:vertical; min-height:55px; transition:border-color .18s; margin-top:.35rem; }
.farea:focus { border-color:var(--red); box-shadow:0 0 0 3px rgba(239,83,80,.1); }
.modal-ft   { padding:.88rem 1.5rem 1.15rem; border-top:1px solid #f5f0f0; flex-shrink:0; background:var(--surface); display:flex; gap:.65rem; justify-content:flex-end; }
.btn-cncl   { padding:.58rem 1.25rem; border:1.5px solid #e0e0e0; border-radius:9px; background:var(--surface); color:#777; font-family:'DM Sans',sans-serif; font-size:.8rem; font-weight:600; cursor:pointer; transition:all .18s; }
.btn-cncl:hover { border-color:#bbb; color:var(--text); }
.btn-sv     { padding:.58rem 1.4rem; background:linear-gradient(135deg,var(--red),var(--red-deep)); color:#fff; border:none; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:.8rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:.42rem; transition:all .18s; }
.btn-sv:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(239,83,80,.35); }

/* ─────────────────────────────────────────
   TOAST
───────────────────────────────────────── */
#toastWrap { position:fixed; bottom:1.4rem; right:1.4rem; z-index:9999; display:flex; flex-direction:column; gap:.55rem; }
.toast     { display:flex; align-items:center; gap:.62rem; background:var(--surface); border-radius:11px; padding:.75rem 1.05rem; box-shadow:0 8px 28px rgba(0,0,0,.12); border-left:4px solid var(--green); animation:toastIn .3s ease; min-width:250px; max-width:330px; font-size:.8rem; font-weight:500; line-height:1.4; }
.toast.err  { border-left-color:var(--red); }
.toast.warn { border-left-color:var(--orange); }
.toast.out  { animation:toastOut .3s ease forwards; }
.ti         { font-size:.95rem; flex-shrink:0; }

/* Skeleton */
.skel { background:linear-gradient(90deg,#f0f0f0 25%,#e8e8e8 50%,#f0f0f0 75%); background-size:400px 100%; animation:shimmer 1.4s ease-in-out infinite; border-radius:5px; display:inline-block; }

/* File desain preview di modal */
.file-thumb {
  margin-top:.6rem; border-radius:10px; overflow:hidden;
  border:1.5px solid var(--border); background:#fafafa;
}
.file-thumb img  { width:100%; max-height:180px; object-fit:contain; display:block; }
.file-thumb-bar  { display:flex; align-items:center; justify-content:space-between; padding:.55rem .9rem; background:var(--surface); border-top:1px solid var(--border); }
.file-thumb-name { font-size:.74rem; font-weight:600; color:var(--text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:220px; }
.file-thumb-link { font-size:.72rem; font-weight:600; color:var(--blue); text-decoration:none; white-space:nowrap; }
.file-thumb-link:hover { text-decoration:underline; }
.no-file { font-size:.78rem; color:#ccc; font-style:italic; padding:.4rem 0; }

/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media(max-width:1300px) { .kpi-row { grid-template-columns:repeat(3,1fr); } }
@media(max-width:900px) {
  .sidebar { transform:translateX(-100%); }
  .sidebar.open { transform:translateX(0); }
  .main, .topbar { margin-left:0; left:0; }
  .kpi-row { grid-template-columns:repeat(2,1fr); }
  #hamburger { display:block !important; }
}
@media(max-width:520px) { .kpi-row { grid-template-columns:1fr; } .main { padding:1rem 1rem 2rem; } }
</style>
</head>
<body>

<!-- ════════════════ SIDEBAR ════════════════ -->
<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
    <div class="sb-logo">Budi<span>Percetakan</span></div>
    <div class="sb-sub">Admin Panel</div>
  </div>
  <div class="sb-user">
    <div class="sb-avatar"><?= strtoupper(substr($adminNama,0,1)) ?></div>
    <div>
      <div class="sb-uname"><?= $adminNama ?></div>
      <div class="sb-urole">Administrator</div>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="sb-section">Menu</div>
    <a class="sb-item active" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <button class="sb-item" onclick="filterTab('semua')">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Semua Pesanan
    </button>
    <button class="sb-item" onclick="filterTab('Menunggu')">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Menunggu
    </button>
    <button class="sb-item" onclick="filterTab('Diproses')">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
      Diproses
    </button>
    <button class="sb-item" onclick="filterTab('Selesai')">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      Selesai
    </button>
    <div class="sb-section" style="margin-top:.5rem;">Lainnya</div>
    <a class="sb-item" href="../index.php" target="_blank">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Lihat Toko
    </a>
  </nav>
  <div class="sb-bottom">
    <a href="../logout.php" class="sb-logout">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      Keluar
    </a>
  </div>
</aside>

<!-- ════════════════ TOPBAR ════════════════ -->
<header class="topbar">
  <div class="topbar-l">
    <button id="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">
      <svg width="20" height="20" fill="none" stroke="#555" stroke-width="2" viewBox="0 0 24 24">
        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>
    <div class="topbar-page">Dashboard</div>
  </div>
  <div class="topbar-r">
    <div class="live-badge"><div class="live-dot"></div> Live</div>
    <div class="topbar-date"><span id="clock">--:--:--</span> WITA</div>
  </div>
</header>

<!-- ════════════════ MAIN ════════════════ -->
<main class="main">

  <!-- ══════════════════════════════
       §1  KPI HARI INI
  ══════════════════════════════ -->
  <div class="section-divider">
    <div class="sd-left">
      <div class="sd-tag">Ringkasan Harian</div>
      <div class="sd-title">Hari Ini &mdash; <span id="labelHari" style="font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:400;color:var(--text-sub);">—</span></div>
    </div>
  </div>
  <div class="kpi-row">
    <div class="kpi c-red"    style="animation-delay:.04s"><div class="kpi-ico">💰</div><div class="kpi-lbl">Pendapatan</div><div class="kpi-val" id="h-pend"><span class="skel" style="width:90px;height:22px">&nbsp;</span></div><div class="kpi-foot">Pesanan selesai hari ini</div></div>
    <div class="kpi c-green"  style="animation-delay:.08s"><div class="kpi-ico">📈</div><div class="kpi-lbl">Keuntungan</div><div class="kpi-val" id="h-untung"><span class="skel" style="width:80px;height:22px">&nbsp;</span></div><div class="kpi-foot">Estimasi margin 35%</div></div>
    <div class="kpi c-blue"   style="animation-delay:.12s"><div class="kpi-ico">📐</div><div class="kpi-lbl">Luas Terjual</div><div class="kpi-val" id="h-luas"><span class="skel" style="width:65px;height:22px">&nbsp;</span></div><div class="kpi-foot" id="h-pcs">— pcs</div></div>
    <div class="kpi c-orange" style="animation-delay:.16s"><div class="kpi-ico">🧾</div><div class="kpi-lbl">Transaksi</div><div class="kpi-val" id="h-trx"><span class="skel" style="width:50px;height:22px">&nbsp;</span></div><div class="kpi-foot">Order masuk hari ini</div></div>
    <div class="kpi c-gray"   style="animation-delay:.20s"><div class="kpi-ico">⚠️</div><div class="kpi-lbl">Dibatalkan</div><div class="kpi-val" id="h-batal"><span class="skel" style="width:65px;height:22px">&nbsp;</span></div><div class="kpi-foot" id="h-batal-sub">—</div></div>
  </div>

  <!-- ══════════════════════════════
       §2  KPI BULAN INI
  ══════════════════════════════ -->
  <div class="section-divider">
    <div class="sd-left">
      <div class="sd-tag">Ringkasan Bulanan</div>
      <div class="sd-title">Bulan Ini &mdash; <span id="labelBulan" style="font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:400;color:var(--text-sub);">—</span></div>
    </div>
  </div>
  <div class="kpi-row">
    <div class="kpi c-red"    style="animation-delay:.06s"><div class="kpi-ico">💰</div><div class="kpi-lbl">Pendapatan</div><div class="kpi-val" id="b-pend">—</div><div class="kpi-foot">Pesanan selesai bulan ini</div></div>
    <div class="kpi c-green"  style="animation-delay:.10s"><div class="kpi-ico">📈</div><div class="kpi-lbl">Keuntungan</div><div class="kpi-val" id="b-untung">—</div><div class="kpi-foot">Estimasi margin 35%</div></div>
    <div class="kpi c-blue"   style="animation-delay:.14s"><div class="kpi-ico">📐</div><div class="kpi-lbl">Luas Terjual</div><div class="kpi-val" id="b-luas">—</div><div class="kpi-foot" id="b-pcs">— pcs</div></div>
    <div class="kpi c-orange" style="animation-delay:.18s"><div class="kpi-ico">🧾</div><div class="kpi-lbl">Transaksi</div><div class="kpi-val" id="b-trx">—</div><div class="kpi-foot">Order masuk bulan ini</div></div>
    <div class="kpi c-gray"   style="animation-delay:.22s"><div class="kpi-ico">⚠️</div><div class="kpi-lbl">Dibatalkan</div><div class="kpi-val" id="b-batal">—</div><div class="kpi-foot" id="b-batal-sub">—</div></div>
  </div>

  <!-- ══════════════════════════════
       §3  HISTORI PENDAPATAN
  ══════════════════════════════ -->
  <div class="section-divider">
    <div class="sd-left">
      <div class="sd-tag">Laporan</div>
      <div class="sd-title">Histori Pendapatan</div>
      <div class="sd-sub">Grafik & tabel rincian harian / bulanan</div>
    </div>
  </div>

  <div class="panel" style="animation-delay:.1s;">
    <!-- Panel header: judul + toggle harian/bulanan -->
    <div class="panel-head">
      <div class="panel-title" id="panelTitle">30 Hari Terakhir</div>
      <div class="pill-group">
        <button class="pill active" data-v="harian"  onclick="switchView('harian')">📅 Harian</button>
        <button class="pill"        data-v="bulanan" onclick="switchView('bulanan')">📆 Bulanan</button>
      </div>
    </div>

    <!-- Metric toggle -->
    <div class="metric-row">
      <button class="mtog active" data-m="pendapatan" onclick="switchMetric('pendapatan')">💰 Pendapatan</button>
      <button class="mtog"        data-m="keuntungan" onclick="switchMetric('keuntungan')">📈 Keuntungan</button>
      <button class="mtog"        data-m="luas"       onclick="switchMetric('luas')">📐 Luas m²</button>
      <button class="mtog"        data-m="trx"        onclick="switchMetric('trx')">🧾 Transaksi</button>
    </div>

    <!-- Bar chart -->
    <div class="chart-wrap">
      <div class="bar-chart" id="barChart">
        <?php for($i=0;$i<12;$i++): ?>
        <div class="bc"><div class="bc-w"><div class="bc-b skel" style="height:55px;width:22px;border-radius:4px;"></div></div><div class="bc-l"><span class="skel" style="width:18px;height:7px;display:inline-block;">&nbsp;</span></div></div>
        <?php endfor; ?>
      </div>
    </div>

    <!-- Summary strip -->
    <div class="sum-strip" id="sumStrip"></div>

    <!-- Tabel histori -->
    <div style="overflow-x:auto;">
      <table class="htbl">
        <thead id="hthead"></thead>
        <tbody id="htbody"><tr><td colspan="7" class="tbl-loading"><span class="spin-inline"></span>Memuat data...</td></tr></tbody>
      </table>
    </div>
  </div>

  <!-- ══════════════════════════════
       §4  TABEL PESANAN MASUK
  ══════════════════════════════ -->
  <div class="section-divider">
    <div class="sd-left">
      <div class="sd-tag">Manajemen</div>
      <div class="sd-title">Daftar Pesanan Masuk</div>
      <div class="sd-sub">Kelola status & kirim notifikasi WhatsApp</div>
    </div>
  </div>

  <div class="ord-panel" style="animation-delay:.14s;">
    <div class="ord-head">
      <div class="ord-top">
        <div class="ord-title">Semua Pesanan</div>
        <div class="search-box">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          <input type="text" id="searchInput" placeholder="Cari nama, kode, WA…" oninput="onSearch()">
        </div>
      </div>
      <div class="ftabs">
        <button class="ftab active" data-s="semua"      onclick="filterTab('semua')">Semua</button>
        <button class="ftab"        data-s="Menunggu"   onclick="filterTab('Menunggu')">⏳ Menunggu</button>
        <button class="ftab"        data-s="Diproses"   onclick="filterTab('Diproses')">🔵 Diproses</button>
        <button class="ftab"        data-s="Selesai"    onclick="filterTab('Selesai')">✅ Selesai</button>
        <button class="ftab"        data-s="Dibatalkan" onclick="filterTab('Dibatalkan')">❌ Dibatalkan</button>
      </div>
    </div>
    <div class="tbl-wrap">
      <table class="otbl">
        <thead><tr>
          <th>Kode</th>
          <th>Pelanggan</th>
          <th class="c-bahan">Bahan</th>
          <th class="c-ukuran">Ukuran</th>
          <th>Total</th>
          <th>Status</th>
          <th class="c-tgl">Tanggal</th>
          <th style="text-align:center;">Aksi</th>
        </tr></thead>
        <tbody id="ordersBody"><tr><td colspan="8" class="tbl-loading"><span class="spin-inline"></span>Memuat data…</td></tr></tbody>
      </table>
    </div>
    <div class="pager">
      <div class="pager-info" id="pagerInfo">—</div>
      <div class="pager-btns" id="pagerBtns"></div>
    </div>
  </div>

</main>

<!-- ════════════════ MODAL ════════════════ -->
<div class="modal-mask" id="modalMask">
  <div class="modal-box">
    <div class="modal-hd">
      <div>
        <div class="modal-title">Detail Pesanan</div>
        <div class="modal-kode" id="modalKode">—</div>
      </div>
      <button class="modal-cls" onclick="closeModal()">✕</button>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-ft">
      <button class="btn-cncl" onclick="closeModal()">Batal</button>
      <button class="btn-sv"   id="btnSave" onclick="saveStatus()">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan
      </button>
    </div>
  </div>
</div>

<div id="toastWrap"></div>

<!-- ════════════════ JAVASCRIPT ════════════════ -->
<script>
'use strict';
/* ──────────────────────────────────────────
   STATE
──────────────────────────────────────────── */
let page         = 1;
let filterStatus = 'semua';
let searchQuery  = '';
let searchTimer  = null;
let activeId     = null;
let cache        = null;   // last stats data
let hView        = 'harian';
let hMetric      = 'pendapatan';

/* ──────────────────────────────────────────
   CLOCK
──────────────────────────────────────────── */
(function tick() {
  document.getElementById('clock').textContent =
    new Date().toLocaleTimeString('id-ID', { hour12: false });
  setTimeout(tick, 1000);
})();

/* ──────────────────────────────────────────
   HELPERS
──────────────────────────────────────────── */
const fmtRp   = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
const fmtDate = s => {
  if (!s) return '—';
  const d = new Date(s);
  return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' })
       + ' ' + d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
};
const esc = s => { const d = document.createElement('div'); d.textContent = s; return d.innerHTML; };

function anim(el, v) {
  if (!el || el.textContent === v) return;
  el.style.animation = 'none';
  el.offsetHeight;
  el.style.animation = 'countUp .45s ease both';
  el.textContent = v;
}

/* ──────────────────────────────────────────
   FETCH STATS
──────────────────────────────────────────── */
async function fetchStats() {
  try {
    const res = await fetch('api/dashboard_stats.php');
    if (res.status === 401) { location.href = '../login.php'; return; }
    const d = await res.json();
    if (d.error) return;
    cache = d;

    /* Labels */
    document.getElementById('labelHari').textContent  =
      new Date().toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
    document.getElementById('labelBulan').textContent =
      new Date().toLocaleDateString('id-ID', { month:'long', year:'numeric' });

    /* KPI Harian */
    anim($('h-pend'),      fmtRp(d.pendapatan));
    anim($('h-untung'),    fmtRp(d.keuntungan));
    anim($('h-luas'),      d.luas_terjual + ' m²');
    $('h-pcs').textContent       = d.pcs_terjual + ' pcs';
    anim($('h-trx'),       d.total_transaksi + ' order');
    anim($('h-batal'),     fmtRp(d.kerugian_nilai));
    $('h-batal-sub').textContent = d.kerugian_jml + ' pesanan dibatalkan';

    /* KPI Bulanan */
    anim($('b-pend'),      fmtRp(d.pend_bulan));
    anim($('b-untung'),    fmtRp(d.untung_bulan));
    anim($('b-luas'),      d.luas_bulan + ' m²');
    $('b-pcs').textContent       = d.pcs_bulan + ' pcs';
    anim($('b-trx'),       d.trx_bulan + ' order');
    anim($('b-batal'),     fmtRp(d.batal_bulan_nilai));
    $('b-batal-sub').textContent = d.batal_bulan_jml + ' pesanan dibatalkan';

    renderHistori();
  } catch (e) { console.error('fetchStats:', e); }
}

const $ = id => document.getElementById(id);

/* ──────────────────────────────────────────
   HISTORI — SWITCH VIEW / METRIC
──────────────────────────────────────────── */
function switchView(v) {
  hView = v;
  document.querySelectorAll('.pill').forEach(t => t.classList.toggle('active', t.dataset.v === v));
  $('panelTitle').textContent = v === 'harian' ? '30 Hari Terakhir' : '12 Bulan Terakhir';
  renderHistori();
}
function switchMetric(m) {
  hMetric = m;
  document.querySelectorAll('.mtog').forEach(t => t.classList.toggle('active', t.dataset.m === m));
  renderHistori();
}

/* ──────────────────────────────────────────
   HISTORI — RENDER
──────────────────────────────────────────── */
function renderHistori() {
  if (!cache) return;
  const daily  = hView === 'harian';
  const labels = daily ? cache.chart_daily_lbl  : cache.chart_monthly_lbl;
  const cdata  = daily ? cache.chart_daily      : cache.chart_monthly;
  const tdata  = daily ? cache.tabel_harian     : cache.tabel_bulanan;
  renderChart(labels, cdata);
  renderSummary(tdata, daily);
  renderTable(tdata, daily);
}

function renderChart(labels, data) {
  const today = new Date().toISOString().slice(0, 10);
  const bulan = new Date().toISOString().slice(0, 7);
  const vals  = data.map(r => {
    if (hMetric === 'keuntungan') return (r.pendapatan || 0) * .35;
    if (hMetric === 'luas')       return r.luas || 0;
    if (hMetric === 'trx')        return r.trx  || 0;
    return r.pendapatan || 0;
  });
  const max = Math.max(...vals, 1);

  $('barChart').innerHTML = labels.map((lbl, i) => {
    const h      = Math.max((vals[i] / max) * 100, 2);
    const isNow  = hView === 'harian' ? lbl === today : lbl === bulan;
    const delay  = Math.min(i * 14, 480);
    const lbl2   = hView === 'harian'
      ? new Date(lbl).toLocaleDateString('id-ID', { day:'2-digit', month:'short' })
      : (([y, m]) => new Date(y, m-1).toLocaleDateString('id-ID', { month:'short' }) + "'" + y.slice(2))(lbl.split('-'));
    const tipVal = hMetric === 'luas' ? vals[i].toFixed(1) + ' m²'
                 : hMetric === 'trx'  ? vals[i] + ' trx'
                 : fmtRp(vals[i]);
    return `<div class="bc">
      <div class="bc-w">
        <div class="bc-b${isNow ? ' hi' : ''}"
             style="height:${h}%;transition:height .55s cubic-bezier(.34,1.56,.64,1) ${delay}ms"
             data-tip="${lbl2}: ${tipVal}">
        </div>
      </div>
      <div class="bc-l">${lbl2}</div>
    </div>`;
  }).join('');
}

function renderSummary(data, daily) {
  const label = daily ? '30 Hari Terakhir' : '12 Bulan Terakhir';
  const totP  = data.reduce((s, r) => s + (parseFloat(r.pendapatan) || 0), 0);
  const totL  = data.reduce((s, r) => s + (parseFloat(r.luas)       || 0), 0);
  const totT  = data.reduce((s, r) => s + (parseInt(r.trx_selesai)  || 0), 0);
  const totB  = data.reduce((s, r) => s + (parseInt(r.trx_batal)    || 0), 0);
  $('sumStrip').innerHTML = `
    <div class="sum-item"><div class="sum-lbl">💰 Total Pendapatan</div><div class="sum-val">${fmtRp(totP)}</div><div class="sum-sub">${label}</div></div>
    <div class="sum-item"><div class="sum-lbl">📈 Total Keuntungan</div><div class="sum-val" style="color:var(--green)">${fmtRp(totP * .35)}</div><div class="sum-sub">Margin 35%</div></div>
    <div class="sum-item"><div class="sum-lbl">📐 Total Luas</div><div class="sum-val">${totL.toFixed(1)} m²</div><div class="sum-sub">${totT} pesanan selesai</div></div>
    <div class="sum-item"><div class="sum-lbl">❌ Dibatalkan</div><div class="sum-val" style="color:var(--red)">${totB} pesanan</div><div class="sum-sub">${label}</div></div>`;
}

function renderTable(data, daily) {
  const today = new Date().toISOString().slice(0, 10);
  const bulan = new Date().toISOString().slice(0, 7);
  $('hthead').innerHTML = `<tr>
    <th>${daily ? 'Tanggal' : 'Bulan'}</th>
    <th>Pendapatan</th><th>Keuntungan</th>
    <th>Luas Terjual</th><th>Trx Selesai</th>
    <th>Trx Batal</th><th>Kerugian</th>
  </tr>`;
  if (!data.length) {
    $('htbody').innerHTML = `<tr><td colspan="7" class="tbl-empty">Belum ada data.</td></tr>`;
    return;
  }
  $('htbody').innerHTML = data.map(r => {
    const periode = daily ? r.tgl : r.bln;
    const isNow   = daily ? periode === today : periode === bulan;
    const p       = parseFloat(r.pendapatan) || 0;
    const rugi    = parseFloat(r.kerugian)   || 0;
    const luas    = parseFloat(r.luas)       || 0;
    let plbl;
    if (daily) {
      plbl = new Date(r.tgl).toLocaleDateString('id-ID', { weekday:'short', day:'2-digit', month:'short', year:'numeric' });
    } else {
      const [y, m] = r.bln.split('-');
      plbl = new Date(y, m-1).toLocaleDateString('id-ID', { month:'long', year:'numeric' });
    }
    return `<tr class="${isNow ? 'now' : ''}">
      <td><span class="hl">${plbl}</span>${isNow ? `<span class="now-badge">${daily ? 'Hari ini' : 'Bln ini'}</span>` : ''}</td>
      <td style="font-weight:600;">${fmtRp(p)}</td>
      <td class="vg">${fmtRp(p * .35)}</td>
      <td>${luas.toFixed(2)} m²</td>
      <td><span class="vb-chip">${r.trx_selesai || 0}</span></td>
      <td style="color:#aaa;">${r.trx_batal || 0}</td>
      <td class="${rugi > 0 ? 'vr' : ''}">${rugi > 0 ? fmtRp(rugi) : '—'}</td>
    </tr>`;
  }).join('');
}

/* ──────────────────────────────────────────
   ORDERS TABLE
──────────────────────────────────────────── */
function filterTab(s) {
  filterStatus = s;
  page = 1;
  document.querySelectorAll('.ftab').forEach(t => t.classList.toggle('active', t.dataset.s === s));
  fetchOrders();
  document.querySelector('.ord-panel').scrollIntoView({ behavior:'smooth', block:'start' });
}
function onSearch() {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    searchQuery = $('searchInput').value.trim();
    page = 1;
    fetchOrders();
  }, 400);
}

async function fetchOrders() {
  $('ordersBody').innerHTML = `<tr><td colspan="8" class="tbl-loading"><span class="spin-inline"></span>Memuat data…</td></tr>`;
  const params = new URLSearchParams({ status: filterStatus, search: searchQuery, page });
  try {
    const res = await fetch('api/pesanan_list.php?' + params);
    if (res.status === 401) { location.href = '../login.php'; return; }
    const d = await res.json();
    if (!d.data || !d.data.length) {
      $('ordersBody').innerHTML = `<tr><td colspan="8" class="tbl-empty">📭 Tidak ada pesanan ditemukan.</td></tr>`;
      renderPager(d);
      return;
    }
    $('ordersBody').innerHTML = d.data.map(r => {
      const kShort = r.kode_pesanan.split('-').pop();
      const luas   = (parseFloat(r.panjang) * parseFloat(r.lebar)).toFixed(2);
      const safe   = JSON.stringify(r).replace(/"/g, '&quot;');
      return `<tr>
        <td><span class="kode-chip" title="${r.kode_pesanan}">…${kShort}</span></td>
        <td><div class="cname">${esc(r.nama_pelanggan)}</div><div class="cwa">${esc(r.no_whatsapp)}</div></td>
        <td class="c-bahan" style="max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="${esc(r.nama_bahan)}">${esc(r.nama_bahan)}</td>
        <td class="c-ukuran" style="white-space:nowrap;">${r.panjang}×${r.lebar}m<br><span style="font-size:.67rem;color:#bbb;">${r.jumlah}pcs · ${luas}m²</span></td>
        <td style="font-weight:700;color:var(--red-deep);white-space:nowrap;">${fmtRp(r.total_harga)}</td>
        <td><span class="sp sp-${r.status}">${r.status}</span></td>
        <td class="c-tgl" style="font-size:.71rem;color:#aaa;white-space:nowrap;">${fmtDate(r.created_at)}</td>
        <td style="text-align:center;"><button class="btn-kelola" onclick='openModal(${safe})'>✏️ Kelola</button></td>
      </tr>`;
    }).join('');
    renderPager(d);
  } catch (e) {
    $('ordersBody').innerHTML = `<tr><td colspan="8" class="tbl-empty">Gagal memuat data.</td></tr>`;
  }
}

function renderPager(d) {
  const from = d.total ? (d.page - 1) * 10 + 1 : 0;
  const to   = Math.min(d.page * 10, d.total);
  $('pagerInfo').textContent = d.total ? `${from}–${to} dari ${d.total} pesanan` : 'Tidak ada data';
  let h = `<button class="pgr-btn" onclick="goPage(${d.page-1})" ${d.page<=1?'disabled':''}>‹</button>`;
  for (let i = 1; i <= d.last_page; i++) {
    if (d.last_page > 7 && i > 2 && i < d.last_page - 1 && Math.abs(i - d.page) > 1) {
      if (i === 3 || i === d.last_page - 2) h += `<span style="padding:0 .2rem;color:#ccc;">…</span>`;
      continue;
    }
    h += `<button class="pgr-btn ${i === d.page ? 'cur' : ''}" onclick="goPage(${i})">${i}</button>`;
  }
  h += `<button class="pgr-btn" onclick="goPage(${d.page+1})" ${d.page>=d.last_page?'disabled':''}>›</button>`;
  $('pagerBtns').innerHTML = h;
}
function goPage(p) { page = p; fetchOrders(); }

/* ──────────────────────────────────────────
   MODAL
──────────────────────────────────────────── */
function openModal(p) {
  activeId = p.id;
  const luas = (parseFloat(p.panjang) * parseFloat(p.lebar)).toFixed(2);
  $('modalKode').textContent = p.kode_pesanan;
  $('modalBody').innerHTML = `
    <div style="padding:.15rem 0;">
      ${dr('Pelanggan',     esc(p.nama_pelanggan))}
      ${dr('WhatsApp',      esc(p.no_whatsapp))}
      ${dr('Alamat',        esc(p.alamat))}
      ${dr('Bahan',         esc(p.nama_bahan))}
      ${dr('Dimensi',       `${p.panjang}m × ${p.lebar}m = ${luas} m²`)}
      ${dr('Jumlah',        `${p.jumlah} pcs`)}
      ${dr('Total',         `<span style="color:var(--red-deep);font-weight:700;">${fmtRp(p.total_harga)}</span>`)}
      ${dr('Catatan Desain', esc(p.catatan_desain || '—'))}
      ${dr('Tgl Pesan',     fmtDate(p.created_at))}
    </div>
    <div class="drow" style="flex-direction:column;align-items:flex-start;gap:.4rem;">
      <span class="dk">File Desain</span>
      ${fileThumb(p.file_desain)}
    </div>
    <label class="flbl">Ubah Status</label>
    <select class="fsel" id="modalStatus">
      <option value="Menunggu"   ${p.status==='Menunggu'   ?'selected':''}>⏳ Menunggu</option>
      <option value="Diproses"   ${p.status==='Diproses'   ?'selected':''}>🔵 Diproses</option>
      <option value="Selesai"    ${p.status==='Selesai'    ?'selected':''}>✅ Selesai</option>
      <option value="Dibatalkan" ${p.status==='Dibatalkan' ?'selected':''}>❌ Dibatalkan</option>
    </select>
    <label class="flbl">Catatan Admin (opsional)</label>
    <textarea class="farea" id="modalCatatan" placeholder="Contoh: desain diterima, sedang cetak...">${esc(p.catatan_admin || '')}</textarea>`;
  $('modalMask').classList.add('open');
}
function dr(k, v) {
  return `<div class="drow"><span class="dk">${k}</span><span class="dv">${v}</span></div>`;
}
function fileThumb(filename) {
  if (!filename) return `<div class="no-file">Tidak ada file desain</div>`;
  const url  = '../uploads/desain/' + filename;
  const ext  = filename.split('.').pop().toLowerCase();
  const isImg = ['jpg','jpeg','png','webp','gif'].includes(ext);
  const icon  = isImg ? `<img src="${url}" alt="Desain" onerror="this.style.display='none'">` : `<div style="padding:1.2rem;text-align:center;font-size:2rem;">📄</div>`;
  return `<div class="file-thumb">
    ${icon}
    <div class="file-thumb-bar">
      <span class="file-thumb-name">${filename}</span>
      <a class="file-thumb-link" href="${url}" target="_blank">⬇ Buka File</a>
    </div>
  </div>`;
}
function closeModal() { $('modalMask').classList.remove('open'); activeId = null; }
$('modalMask').addEventListener('click', e => { if (e.target === $('modalMask')) closeModal(); });

/* ──────────────────────────────────────────
   SAVE STATUS
──────────────────────────────────────────── */
async function saveStatus() {
  if (!activeId) return;
  const btn     = $('btnSave');
  const status  = $('modalStatus').value;
  const catatan = $('modalCatatan').value.trim();
  btn.disabled  = true;
  btn.innerHTML = `<span class="spin-inline" style="border-top-color:#fff;"></span>Menyimpan…`;
  const fd = new FormData();
  fd.append('id', activeId);
  fd.append('status', status);
  fd.append('catatan_admin', catatan);
  try {
    const res = await fetch('api/update_status.php', { method:'POST', body:fd });
    const d   = await res.json();
    if (d.success) {
      closeModal();
      fetchOrders();
      fetchStats();
      toast(d.message, 'ok');
      if (['Diproses','Selesai','Dibatalkan'].includes(status))
        setTimeout(() => showWAPanel(d.pesanan, status), 420);
    } else {
      toast(d.error || 'Gagal menyimpan.', 'err');
    }
  } catch (e) { toast('Koneksi gagal.', 'err'); }
  finally {
    btn.disabled  = false;
    btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>Simpan`;
  }
}

/* ──────────────────────────────────────────
   WA PANEL
──────────────────────────────────────────── */
function buildWaText(p, s) {
  const luas  = (parseFloat(p.panjang) * parseFloat(p.lebar)).toFixed(2);
  const total = fmtRp(p.total_harga);
  const cat   = p.catatan_admin || '-';
  const tgl   = new Date(p.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' });
  if (s === 'Selesai') return `✅ *PESANAN ANDA TELAH SELESAI!*\n━━━━━━━━━━━━━━━━━━━━\n🖨️ *Budi Percetakan*\n\nHalo *${p.nama_pelanggan}*, pesanan spanduk Anda sudah selesai dan siap diambil! 🎉\n\n📋 *DETAIL PESANAN*\n━━━━━━━━━━━━━━━━━━━━\n🔖 Kode       : *${p.kode_pesanan}*\n📅 Tgl Pesan  : ${tgl}\n🎨 Bahan      : ${p.nama_bahan}\n📐 Ukuran     : ${p.panjang} × ${p.lebar} m (${luas} m²)\n📦 Jumlah     : ${p.jumlah} pcs\n💬 Catatan    : ${p.catatan_desain||'-'}\n\n💰 *TOTAL: ${total}*\n📝 Catatan Admin: ${cat}\n\n━━━━━━━━━━━━━━━━━━━━\n🏪 *PENGAMBILAN*\n📍 Jl. Sorumba, kec. Kadia, Kota Kendari, Provinsi Sulawesi Tenggara\n🕐 Senin–Sabtu, 09.00–17.00 WITA\n\nMohon konfirmasi pengambilan ya!\nTerima kasih 🙏\n_Budi Percetakan_`;
  if (s === 'Diproses') return `🔵 *PESANAN SEDANG DIPROSES*\n━━━━━━━━━━━━━━━━━━━━\n🖨️ *Budi Percetakan*\n\nHalo *${p.nama_pelanggan}*! 👋\n\nPesanan Anda *${p.kode_pesanan}* kini sedang dikerjakan 🖨️\n\n• Bahan  : ${p.nama_bahan}\n• Ukuran : ${p.panjang} × ${p.lebar} m · ${p.jumlah} pcs\n\nEstimasi selesai *1×24 jam*. Kami kabarkan lagi ya!\n_Budi Percetakan_`;
  return `❌ *INFO PESANAN DIBATALKAN*\n━━━━━━━━━━━━━━━━━━━━\n🖨️ *Budi Percetakan*\n\nHalo *${p.nama_pelanggan}*, pesanan *${p.kode_pesanan}* telah *dibatalkan*.\n\n📝 Keterangan: ${cat}\n\nHubungi kami jika ada pertanyaan 🙏\n_Budi Percetakan_`;
}
function bukaWA(p, s) {
  let n = p.no_whatsapp.replace(/\D/g, '');
  if (n.startsWith('0')) n = '62' + n.slice(1);
  window.open('https://wa.me/' + n + '?text=' + encodeURIComponent(buildWaText(p, s)), '_blank');
}
function showWAPanel(p, s) {
  document.getElementById('wap')?.remove();
  const C = { Selesai:'#25D366', Diproses:'#1E88E5', Dibatalkan:'#EF5350' };
  const L = { Selesai:'Pesanan Selesai', Diproses:'Sedang Diproses', Dibatalkan:'Pesanan Dibatalkan' };
  const I = { Selesai:'✅', Diproses:'🔵', Dibatalkan:'❌' };
  const c    = C[s];
  const safe = JSON.stringify(p).replace(/"/g, '&quot;');
  const ov   = document.createElement('div');
  ov.id      = 'wap';
  ov.style.cssText = 'position:fixed;inset:0;z-index:600;background:rgba(0,0,0,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:1rem;';
  ov.innerHTML = `
    <div style="background:#fff;border-radius:18px;width:100%;max-width:440px;max-height:calc(100vh - 2rem);display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,.2);animation:fadeUp .3s ease;overflow:hidden;">
      <div style="background:${c};padding:1.15rem 1.5rem;color:#fff;flex-shrink:0;">
        <div style="font-size:.62rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;opacity:.8;margin-bottom:.2rem;">Kirim Notifikasi WhatsApp</div>
        <div style="font-family:'Playfair Display',serif;font-size:1.08rem;font-weight:700;">${I[s]} ${L[s]}</div>
        <div style="font-size:.73rem;opacity:.85;margin-top:.2rem;">Kepada: <strong>${esc(p.nama_pelanggan)}</strong> · ${esc(p.no_whatsapp)}</div>
      </div>
      <div style="flex:1;overflow-y:auto;padding:1.05rem 1.4rem;">
        <div style="font-size:.62rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:.5rem;">Preview Pesan</div>
        <div style="background:#f0fff4;border:1px solid #b2dfdb;border-radius:10px;padding:.88rem 1rem;font-size:.75rem;line-height:1.75;color:#333;white-space:pre-wrap;word-break:break-word;max-height:210px;overflow-y:auto;">${esc(buildWaText(p, s))}</div>
      </div>
      <div style="padding:.88rem 1.4rem 1.1rem;border-top:1px solid #f5f5f5;display:flex;gap:.65rem;justify-content:flex-end;flex-shrink:0;">
        <button onclick="document.getElementById('wap').remove()" style="padding:.58rem 1.2rem;border:1.5px solid #e0e0e0;border-radius:9px;background:#fff;color:#777;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:600;cursor:pointer;">Nanti Saja</button>
        <button onclick="bukaWA(${safe},'${s}');document.getElementById('wap').remove();" style="padding:.58rem 1.35rem;background:${c};color:#fff;border:none;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:.4rem;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.558 4.121 1.534 5.853L.054 23.5l5.805-1.523A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.9 0-3.678-.523-5.2-1.432l-.373-.22-3.444.904.921-3.363-.242-.388A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
          Kirim via WhatsApp
        </button>
      </div>
    </div>`;
  ov.addEventListener('click', e => { if (e.target === ov) ov.remove(); });
  document.body.appendChild(ov);
}

/* ──────────────────────────────────────────
   TOAST
──────────────────────────────────────────── */
function toast(msg, type = 'ok') {
  const icons = { ok:'✅', err:'❌', warn:'⚠️' };
  const dur   = type === 'err' ? 4500 : 3000;
  const el    = document.createElement('div');
  el.className = `toast ${type === 'err' ? 'err' : type === 'warn' ? 'warn' : ''}`;
  el.innerHTML = `<span class="ti">${icons[type] || '✅'}</span><span>${msg}</span>`;
  $('toastWrap').appendChild(el);
  setTimeout(() => { el.classList.add('out'); setTimeout(() => el.remove(), 350); }, dur);
}

/* ──────────────────────────────────────────
   BOOT
──────────────────────────────────────────── */
fetchStats();
fetchOrders();
setInterval(fetchStats,  20000);
setInterval(fetchOrders, 30000);
</script>
</body>
</html>
