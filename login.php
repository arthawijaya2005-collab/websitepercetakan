<?php
// login.php — Halaman Login Admin
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

require_once 'koneksi.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        $error = 'Username dan password wajib diisi.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT id, password, nama_lengkap FROM admin WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        $loginOk = false;

        if ($admin) {
            $storedHash = $admin['password'];
            $isBcrypt   = (strlen($storedHash) >= 60 && strpos($storedHash, '$2') === 0);

            if ($isBcrypt) {
                $loginOk = password_verify($password, $storedHash);
                if (!$loginOk) {
                    $error = 'Username atau password salah. Coba lagi.';
                }
            } else {
                // Hash belum valid — belum diinisialisasi via setup_password.php
                $error = 'Password admin belum diinisialisasi. Buka setup_password.php di browser untuk mengatur password awal.';
            }

            if ($loginOk) {
                // Auto-upgrade hash jika cost kurang
                if (password_needs_rehash($storedHash, PASSWORD_BCRYPT, ['cost' => 12])) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                    $db->prepare("UPDATE admin SET password=? WHERE id=?")->execute([$newHash, $admin['id']]);
                }
                session_regenerate_id(true);
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_nama'] = $admin['nama_lengkap'];
                $_SESSION['login_time'] = time();
                header('Location: admin/dashboard.php');
                exit;
            }
        } else {
            $error = 'Username tidak ditemukan di database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — Budi Percetakan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --red-soft:  #E57373;
    --red-main:  #EF5350;
    --red-deep:  #C62828;
    --red-pale:  #FFEBEE;
    --red-light: #FFCDD2;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    display: flex;
    background: #1a0a0a;
    overflow: hidden;
  }

  @keyframes fadeUp   { from { opacity:0; transform:translateY(28px); } to { opacity:1; transform:translateY(0); } }
  @keyframes float    { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-14px); } }
  @keyframes rotate   { to { transform:rotate(360deg); } }
  @keyframes shimmer  { 0% { background-position:-200% center; } 100% { background-position:200% center; } }
  @keyframes shake    { 0%,100% { transform:translateX(0); } 20%,60% { transform:translateX(-8px); } 40%,80% { transform:translateX(8px); } }

  /* ── Left decorative panel ── */
  .left-panel {
    width: 55%;
    background: linear-gradient(145deg, #2d0a0a 0%, #1a0a0a 40%, #3d1212 100%);
    display: flex; flex-direction: column;
    justify-content: center; align-items: center;
    padding: 4rem;
    position: relative;
    overflow: hidden;
  }
  .left-panel::before {
    content: '';
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse at 20% 20%, rgba(239,83,80,.2) 0%, transparent 55%),
      radial-gradient(ellipse at 80% 80%, rgba(198,40,40,.15) 0%, transparent 50%);
  }
  .orb {
    position: absolute;
    border-radius: 50%;
    animation: float linear infinite;
  }
  .orb-1 {
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(239,83,80,.25), transparent 70%);
    top: -60px; right: -60px;
    animation-duration: 7s;
  }
  .orb-2 {
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(229,115,115,.18), transparent 70%);
    bottom: 40px; left: -40px;
    animation-duration: 9s;
    animation-direction: reverse;
  }
  .orb-3 {
    width: 120px; height: 120px;
    background: radial-gradient(circle, rgba(239,83,80,.2), transparent 70%);
    top: 50%; left: 60%;
    animation-duration: 5s;
  }

  .left-content { position: relative; z-index: 1; text-align: center; }
  .brand-logo {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem;
    font-weight: 900;
    color: white;
    letter-spacing: -.5px;
    margin-bottom: .4rem;
  }
  .brand-logo span { color: var(--red-soft); }
  .brand-tagline { color: rgba(255,255,255,.45); font-size: .82rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4rem; }

  .deco-card {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    padding: 2rem 2.4rem;
    backdrop-filter: blur(12px);
    margin-bottom: 1.5rem;
    animation: fadeUp .8s ease both;
  }
  .deco-num {
    font-family: 'Playfair Display', serif;
    font-size: 3rem; font-weight: 900;
    background: linear-gradient(135deg, #fff, var(--red-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
  }
  .deco-label { color: rgba(255,255,255,.5); font-size: .75rem; text-transform: uppercase; letter-spacing: 1.5px; margin-top: .3rem; }

  .deco-row { display: flex; gap: 1rem; }
  .deco-mini {
    flex: 1;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 14px;
    padding: 1.2rem 1rem;
    text-align: center;
    animation: fadeUp .8s ease .2s both;
  }
  .deco-mini-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 700; color: var(--red-soft);
  }
  .deco-mini-label { font-size: .68rem; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 1px; margin-top: .2rem; }

  /* ── Right / Form panel ── */
  .right-panel {
    width: 45%;
    background: #fefefe;
    display: flex; align-items: center; justify-content: center;
    padding: 3rem 3.5rem;
  }

  .login-box { width: 100%; max-width: 380px; animation: fadeUp .6s ease both; }

  .login-header { margin-bottom: 2.5rem; }
  .login-eyebrow {
    font-size: .72rem; font-weight: 600; letter-spacing: 2.5px;
    text-transform: uppercase; color: var(--red-main);
    margin-bottom: .6rem;
  }
  .login-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 700; color: #1a1a1a; line-height: 1.2;
  }
  .login-sub { color: #aaa; font-size: .85rem; margin-top: .5rem; font-weight: 300; }

  /* Alert */
  .alert {
    border-radius: 10px; padding: .85rem 1.1rem;
    font-size: .84rem; margin-bottom: 1.4rem; line-height: 1.5;
  }
  .alert-error   { background: #ffebee; border: 1px solid var(--red-light); color: var(--red-deep); }
  .alert-success { background: #e8f5e9; border: 1px solid #a5d6a7; color: #2e7d32; }
  .alert.shake   { animation: shake .4s ease; }

  /* Form */
  .form-group { margin-bottom: 1.3rem; }
  .form-label  { display: block; font-size: .8rem; font-weight: 600; color: #555; margin-bottom: .45rem; }
  .input-wrap  { position: relative; }
  .input-icon  {
    position: absolute; left: .95rem; top: 50%; transform: translateY(-50%);
    color: #ccc; pointer-events: none;
    transition: color .2s;
  }
  .form-control {
    width: 100%;
    padding: .78rem 1rem .78rem 2.6rem;
    border: 1.5px solid #e8e0e0;
    border-radius: 11px;
    font-family: 'DM Sans', sans-serif;
    font-size: .92rem; color: #333;
    background: white;
    outline: none;
    transition: all .2s;
  }
  .form-control:focus { border-color: var(--red-main); box-shadow: 0 0 0 3px rgba(239,83,80,.12); }
  .form-control:focus + .input-icon,
  .input-wrap:focus-within .input-icon { color: var(--red-main); }
  /* fix icon positioning — icon comes after input in DOM but positioned absolute */
  .input-wrap .form-control { order: 1; }

  .show-pw-btn {
    position: absolute; right: .9rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #bbb; padding: .2rem; transition: color .2s;
  }
  .show-pw-btn:hover { color: var(--red-main); }

  .btn-submit {
    width: 100%;
    padding: .9rem;
    background: linear-gradient(135deg, var(--red-main), var(--red-deep));
    color: white; border: none; border-radius: 11px;
    font-family: 'DM Sans', sans-serif;
    font-size: .97rem; font-weight: 600;
    cursor: pointer; margin-top: .6rem;
    transition: all .3s;
    letter-spacing: .2px;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(198,40,40,.38); }

  .login-footer {
    margin-top: 2rem; text-align: center;
    font-size: .8rem; color: #bbb;
  }
  .login-footer a { color: var(--red-main); text-decoration: none; font-weight: 500; }
  .login-footer a:hover { text-decoration: underline; }

  .divider {
    display: flex; align-items: center; gap: .8rem;
    color: #e0e0e0; font-size: .75rem; margin: 1.4rem 0;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: #f0e0e0;
  }

  @media (max-width: 768px) {
    body { flex-direction: column; }
    .left-panel { width: 100%; padding: 3rem 2rem; }
    .right-panel { width: 100%; padding: 2.5rem 1.5rem; }
    .deco-card { display: none; }
  }
</style>
</head>
<body>

<!-- ══ LEFT PANEL ══ -->
<div class="left-panel">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="left-content">
    <div class="brand-logo">Budi <span>Percetakan</span></div>
    <div class="brand-tagline">Panel Manajemen Admin</div>

    <div class="deco-card">
      <div class="deco-num">500+</div>
      <div class="deco-label">Total Pesanan Diproses</div>
    </div>

    <div class="deco-row">
      <div class="deco-mini">
        <div class="deco-mini-num">4.9</div>
        <div class="deco-mini-label">Rating</div>
      </div>
      <div class="deco-mini">
        <div class="deco-mini-num">24h</div>
        <div class="deco-mini-label">Proses</div>
      </div>
      <div class="deco-mini">
        <div class="deco-mini-num">4</div>
        <div class="deco-mini-label">Jenis Bahan</div>
      </div>
    </div>
  </div>
</div>

<!-- ══ RIGHT PANEL ══ -->
<div class="right-panel">
  <div class="login-box">
    <div class="login-header">
      <div class="login-eyebrow">🔐 Admin Area</div>
      <h1 class="login-title">Selamat Datang<br>Kembali</h1>
      <p class="login-sub">Masuk untuk mengelola pesanan & laporan percetakan.</p>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-error shake" id="alertErr">
      ⚠️ <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label">Username</label>
        <div class="input-wrap">
          <input
            type="text"
            name="username"
            class="form-control"
            placeholder="admin"
            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
            autocomplete="username"
            required
            style="padding-left:2.6rem"
          >
          <span class="input-icon" style="left:.95rem; top:50%; transform:translateY(-50%); position:absolute; pointer-events:none;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
          </span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-wrap" style="position:relative;">
          <input
            type="password"
            name="password"
            id="pwInput"
            class="form-control"
            placeholder="••••••••"
            autocomplete="current-password"
            required
            style="padding-left:2.6rem; padding-right:2.8rem;"
          >
          <span style="position:absolute; left:.95rem; top:50%; transform:translateY(-50%); color:#ccc; pointer-events:none;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
          </span>
          <button type="button" class="show-pw-btn" id="showPw" onclick="togglePw()" title="Tampilkan password">
            <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-submit">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
        </svg>
        Masuk ke Dashboard
      </button>
    </form>

    <div class="divider">atau</div>

    <div class="login-footer">
      <a href="index.php">← Kembali ke Beranda</a>
      &nbsp;·&nbsp;
      <span style="color:#ddd;">Default: admin / admin123</span>
    </div>
  </div>
</div>

<script>
function togglePw() {
  const input = document.getElementById('pwInput');
  input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>
