<?php
// ─── Config ───────────────────────────────────────────────
define('SECRET_KEY', 'your_secret_key_here_2026');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $action = $_POST['action'];

    if ($action === 'login') {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'لطفاً همه فیلدها را پر کنید']);
            exit;
        }
        // Demo: accept any non-empty credentials
        echo json_encode(['success' => true, 'message' => 'خوش آمدید! در حال انتقال...', 'redirect' => '/dashboard']);
        exit;

    } elseif ($action === 'register') {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm'] ?? '');

        if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
            echo json_encode(['success' => false, 'message' => 'لطفاً همه فیلدها را پر کنید']);
            exit;
        }
        if ($password !== $confirm) {
            echo json_encode(['success' => false, 'message' => 'رمزعبور با تکرار آن مطابقت ندارد']);
            exit;
        }
        if (strlen($password) < 8) {
            echo json_encode(['success' => false, 'message' => 'رمزعبور باید حداقل ۸ کاراکتر باشد']);
            exit;
        }
        echo json_encode(['success' => true, 'message' => 'حساب با موفقیت ساخته شد!']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ورود | پلتفرم نکست</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;900&family=Space+Grotesk:wght@300;400;700&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════
   ROOT & RESET
══════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --c-bg:        #04040f;
  --c-surface:   rgba(255,255,255,0.045);
  --c-border:    rgba(255,255,255,0.10);
  --c-border-h:  rgba(255,255,255,0.22);
  --c-text:      #e8e8f5;
  --c-muted:     rgba(232,232,245,0.45);
  --c-accent:    #7c6bff;
  --c-accent2:   #ff6bcd;
  --c-success:   #4fffb0;
  --c-error:     #ff4f7b;
  --blur:        22px;
  --radius-card: 28px;
  --radius-inp:  14px;
  --transition:  0.35s cubic-bezier(.4,0,.2,1);
}

html, body {
  height: 100%;
  font-family: 'Vazirmatn', sans-serif;
  background: var(--c-bg);
  color: var(--c-text);
  overflow: hidden;
}

/* ══════════════════════════════════════════════
   CANVAS BACKGROUND
══════════════════════════════════════════════ */
#bgCanvas {
  position: fixed;
  inset: 0;
  width: 100%; height: 100%;
  z-index: 0;
}

/* ══════════════════════════════════════════════
   FLOATING ORBS
══════════════════════════════════════════════ */
.orb {
  position: fixed;
  border-radius: 50%;
  filter: blur(90px);
  pointer-events: none;
  z-index: 0;
  animation: orbFloat linear infinite;
}
.orb-1 {
  width: 520px; height: 520px;
  background: radial-gradient(circle, rgba(124,107,255,.55), transparent 70%);
  top: -120px; right: -100px;
  animation-duration: 18s;
}
.orb-2 {
  width: 420px; height: 420px;
  background: radial-gradient(circle, rgba(255,107,205,.45), transparent 70%);
  bottom: -100px; left: -80px;
  animation-duration: 22s; animation-delay: -7s;
}
.orb-3 {
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(79,255,176,.35), transparent 70%);
  top: 50%; left: 30%;
  animation-duration: 26s; animation-delay: -13s;
}
@keyframes orbFloat {
  0%,100% { transform: translate(0,0) scale(1); }
  33%      { transform: translate(30px,-40px) scale(1.06); }
  66%      { transform: translate(-20px,30px) scale(.96); }
}

/* ══════════════════════════════════════════════
   LAYOUT
══════════════════════════════════════════════ */
.scene {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 24px;
}

/* ══════════════════════════════════════════════
   GLASS CARD
══════════════════════════════════════════════ */
.card {
  width: 100%;
  max-width: 440px;
  background: rgba(255,255,255,0.045);
  backdrop-filter: blur(var(--blur)) saturate(180%);
  -webkit-backdrop-filter: blur(var(--blur)) saturate(180%);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-card);
  padding: 44px 40px 40px;
  box-shadow:
    0 0 0 1px rgba(255,255,255,.04) inset,
    0 40px 80px rgba(0,0,0,.45),
    0 0 120px rgba(124,107,255,.08);
  animation: cardIn .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes cardIn {
  from { opacity:0; transform: translateY(32px) scale(.96); }
  to   { opacity:1; transform: translateY(0) scale(1); }
}

/* shine sweep */
.card::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: inherit;
  background: linear-gradient(135deg, rgba(255,255,255,.07) 0%, transparent 60%);
  pointer-events: none;
}

/* ══════════════════════════════════════════════
   LOGO / BRAND
══════════════════════════════════════════════ */
.brand {
  text-align: center;
  margin-bottom: 32px;
}
.brand-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 64px; height: 64px;
  border-radius: 18px;
  background: linear-gradient(135deg, var(--c-accent), var(--c-accent2));
  box-shadow: 0 8px 32px rgba(124,107,255,.5);
  margin-bottom: 16px;
  animation: iconPulse 3s ease-in-out infinite;
}
@keyframes iconPulse {
  0%,100% { box-shadow: 0 8px 32px rgba(124,107,255,.5); }
  50%      { box-shadow: 0 8px 52px rgba(124,107,255,.8); }
}
.brand-icon svg { width:32px; height:32px; }
.brand h1 {
  font-size: 1.6rem;
  font-weight: 700;
  letter-spacing: -.5px;
  background: linear-gradient(135deg, #fff 30%, rgba(255,255,255,.6));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.brand p {
  font-size: .85rem;
  color: var(--c-muted);
  margin-top: 4px;
}

/* ══════════════════════════════════════════════
   TAB SWITCHER
══════════════════════════════════════════════ */
.tabs {
  display: grid;
  grid-template-columns: 1fr 1fr;
  background: rgba(255,255,255,.06);
  border-radius: 12px;
  padding: 4px;
  margin-bottom: 32px;
  position: relative;
}
.tab-pill {
  position: absolute;
  top: 4px; bottom: 4px;
  width: calc(50% - 4px);
  background: linear-gradient(135deg, var(--c-accent), var(--c-accent2));
  border-radius: 9px;
  transition: transform var(--transition);
  box-shadow: 0 4px 20px rgba(124,107,255,.4);
}
.tab-pill.right { transform: translateX(-100%); }

.tab-btn {
  position: relative;
  z-index: 1;
  border: none;
  background: transparent;
  color: var(--c-muted);
  font-family: 'Vazirmatn', sans-serif;
  font-size: .9rem;
  font-weight: 500;
  padding: 10px 0;
  cursor: pointer;
  border-radius: 9px;
  transition: color var(--transition);
}
.tab-btn.active { color: #fff; font-weight: 700; }

/* ══════════════════════════════════════════════
   FORMS
══════════════════════════════════════════════ */
.form-panel { display: none; }
.form-panel.active {
  display: block;
  animation: panelIn .4s cubic-bezier(.4,0,.2,1) both;
}
@keyframes panelIn {
  from { opacity:0; transform: translateX(-12px); }
  to   { opacity:1; transform: translateX(0); }
}

.field {
  position: relative;
  margin-bottom: 18px;
}
.field label {
  display: block;
  font-size: .78rem;
  font-weight: 600;
  color: var(--c-muted);
  margin-bottom: 8px;
  letter-spacing: .3px;
  transition: color var(--transition);
}
.field:focus-within label { color: var(--c-accent); }

.field input {
  width: 100%;
  background: rgba(255,255,255,.06);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-inp);
  padding: 13px 16px;
  color: var(--c-text);
  font-family: 'Vazirmatn', sans-serif;
  font-size: .95rem;
  outline: none;
  transition: border-color var(--transition), background var(--transition), box-shadow var(--transition);
  direction: ltr;
  text-align: right;
}
.field input:focus {
  border-color: var(--c-accent);
  background: rgba(124,107,255,.08);
  box-shadow: 0 0 0 3px rgba(124,107,255,.15);
}
.field input::placeholder { color: rgba(232,232,245,.25); }

/* eye toggle */
.field-wrap {
  position: relative;
  display: flex;
  align-items: center;
}
.field-wrap input { padding-left: 44px; }
.eye-btn {
  position: absolute;
  left: 14px;
  background: transparent;
  border: none;
  cursor: pointer;
  color: var(--c-muted);
  display: flex;
  align-items: center;
  padding: 0;
  transition: color var(--transition);
}
.eye-btn:hover { color: var(--c-text); }

/* strength bar */
.strength-wrap {
  display: flex;
  gap: 5px;
  margin-top: 8px;
}
.strength-seg {
  flex: 1;
  height: 3px;
  border-radius: 99px;
  background: rgba(255,255,255,.1);
  transition: background .4s;
}
.strength-seg.s1 { background: var(--c-error); }
.strength-seg.s2 { background: #ffaa4f; }
.strength-seg.s3 { background: #ffe04f; }
.strength-seg.s4 { background: var(--c-success); }

/* ══════════════════════════════════════════════
   SUBMIT BUTTON
══════════════════════════════════════════════ */
.btn-submit {
  width: 100%;
  margin-top: 8px;
  padding: 14px;
  border: none;
  border-radius: var(--radius-inp);
  background: linear-gradient(135deg, var(--c-accent) 0%, var(--c-accent2) 100%);
  color: #fff;
  font-family: 'Vazirmatn', sans-serif;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: transform .2s, box-shadow .3s;
  box-shadow: 0 6px 30px rgba(124,107,255,.4);
  letter-spacing: .3px;
}
.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 40px rgba(124,107,255,.6);
}
.btn-submit:active { transform: translateY(0); }

/* ripple */
.btn-submit .ripple {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,.35);
  transform: scale(0);
  animation: rippleAnim .6s linear;
  pointer-events: none;
}
@keyframes rippleAnim {
  to { transform: scale(4); opacity: 0; }
}

/* loading spinner inside button */
.btn-submit .spinner {
  display: none;
  width: 18px; height: 18px;
  border: 2.5px solid rgba(255,255,255,.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin .7s linear infinite;
  margin: 0 auto;
}
@keyframes spin { to { transform: rotate(360deg); } }
.btn-submit.loading .btn-text { display: none; }
.btn-submit.loading .spinner { display: block; }

/* ══════════════════════════════════════════════
   TOAST / ALERT
══════════════════════════════════════════════ */
#toast {
  position: fixed;
  bottom: 32px;
  left: 50%;
  transform: translateX(-50%) translateY(80px);
  background: rgba(20,20,40,.92);
  backdrop-filter: blur(20px);
  border: 1px solid var(--c-border);
  border-radius: 14px;
  padding: 14px 24px;
  font-size: .9rem;
  font-weight: 500;
  color: var(--c-text);
  display: flex;
  align-items: center;
  gap: 10px;
  z-index: 999;
  transition: transform .4s cubic-bezier(.34,1.56,.64,1), opacity .3s;
  opacity: 0;
  white-space: nowrap;
}
#toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
#toast.success { border-color: rgba(79,255,176,.35); color: var(--c-success); }
#toast.error   { border-color: rgba(255,79,123,.35); color: var(--c-error); }
.toast-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: currentColor;
  animation: dotPulse 1s ease-in-out infinite;
}
@keyframes dotPulse {
  0%,100% { transform: scale(1); opacity:1; }
  50%      { transform: scale(.5); opacity:.5; }
}

/* ══════════════════════════════════════════════
   DIVIDER / OAUTH (decorative)
══════════════════════════════════════════════ */
.divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 22px 0;
  color: var(--c-muted);
  font-size: .78rem;
}
.divider::before, .divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--c-border);
}

.oauth-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}
.oauth-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 11px 0;
  border: 1px solid var(--c-border);
  border-radius: 12px;
  background: rgba(255,255,255,.04);
  color: var(--c-text);
  font-family: 'Vazirmatn', sans-serif;
  font-size: .82rem;
  font-weight: 500;
  cursor: pointer;
  transition: background var(--transition), border-color var(--transition), transform .2s;
}
.oauth-btn:hover {
  background: rgba(255,255,255,.09);
  border-color: var(--c-border-h);
  transform: translateY(-1px);
}
.oauth-btn svg { width: 18px; height: 18px; }

/* ══════════════════════════════════════════════
   CHECKBOX
══════════════════════════════════════════════ */
.check-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
  cursor: pointer;
}
.check-row input[type=checkbox] { display: none; }
.check-box {
  width: 18px; height: 18px;
  border: 1.5px solid var(--c-border-h);
  border-radius: 5px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background var(--transition), border-color var(--transition);
}
.check-row input:checked + .check-box {
  background: var(--c-accent);
  border-color: var(--c-accent);
}
.check-box svg { display:none; }
.check-row input:checked + .check-box svg { display:block; }
.check-label { font-size: .82rem; color: var(--c-muted); }
.check-label a { color: var(--c-accent); text-decoration: none; }

/* ══════════════════════════════════════════════
   FORGOT LINK
══════════════════════════════════════════════ */
.forgot {
  display: block;
  text-align: left;
  font-size: .78rem;
  color: var(--c-muted);
  text-decoration: none;
  margin-top: -10px;
  margin-bottom: 20px;
  transition: color var(--transition);
}
.forgot:hover { color: var(--c-accent); }

/* ══════════════════════════════════════════════
   PARTICLES
══════════════════════════════════════════════ */
.particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
.particle {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,.6);
  animation: particleDrift linear infinite;
}
@keyframes particleDrift {
  0%   { transform: translateY(0) rotate(0deg); opacity: 0; }
  10%  { opacity: 1; }
  90%  { opacity: .8; }
  100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
}

/* ══════════════════════════════════════════════
   GRID LINES BG
══════════════════════════════════════════════ */
.grid-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 100%);
}

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media (max-width: 480px) {
  .card { padding: 32px 24px 28px; }
  .oauth-row { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- Background layers -->
<div class="grid-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>
<div class="particles" id="particles"></div>

<div class="scene">
  <div class="card">

    <!-- Brand -->
    <div class="brand">
      <div class="brand-icon">
        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 4L28 10V22L16 28L4 22V10L16 4Z" fill="white" fill-opacity=".9"/>
          <path d="M16 10L22 13V19L16 22L10 19V13L16 10Z" fill="white" fill-opacity=".3"/>
        </svg>
      </div>
      <h1>نکست پلتفرم</h1>
      <p>به آینده خوش آمدید</p>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <div class="tab-pill" id="tabPill"></div>
      <button class="tab-btn active" onclick="switchTab('login')">ورود</button>
      <button class="tab-btn" onclick="switchTab('register')">ثبت‌نام</button>
    </div>

    <!-- ── LOGIN FORM ── -->
    <div class="form-panel active" id="loginPanel">
      <div class="field">
        <label>ایمیل</label>
        <input type="email" id="loginEmail" placeholder="you@example.com" autocomplete="email">
      </div>
      <div class="field">
        <label>رمزعبور</label>
        <div class="field-wrap">
          <input type="password" id="loginPass" placeholder="••••••••" autocomplete="current-password">
          <button class="eye-btn" type="button" onclick="toggleEye('loginPass',this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <a href="#" class="forgot">رمزعبور را فراموش کردم</a>
      <button class="btn-submit" onclick="handleLogin(this)">
        <span class="btn-text">ورود به حساب</span>
        <div class="spinner"></div>
      </button>

      <div class="divider">یا با</div>
      <div class="oauth-row">
        <button class="oauth-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
          گوگل
        </button>
        <button class="oauth-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16.365 1.43c0 1.14-.493 2.27-1.177 3.08-.744.9-1.99 1.57-2.987 1.57-.12 0-.23-.02-.3-.03-.01-.06-.04-.22-.04-.39 0-1.15.572-2.27 1.206-2.98.804-.94 2.142-1.64 3.248-1.68.03.13.05.28.05.43zm4.565 15.71c-.03.07-.463 1.58-1.518 3.12-.945 1.34-1.94 2.71-3.43 2.71-1.517 0-1.9-.88-3.63-.88-1.698 0-2.302.91-3.67.91-1.377 0-2.332-1.26-3.428-2.8-1.287-1.82-2.323-4.63-2.323-7.28 0-3.827 2.485-5.857 4.9-5.857 1.307 0 2.395.85 3.217.85.78 0 2.012-.9 3.488-.9.548 0 2.485.06 3.77 1.88-.086.06-2.25 1.32-2.25 3.93 0 3.14 2.793 4.22 2.886 4.25z"/></svg>
          اپل
        </button>
      </div>
    </div>

    <!-- ── REGISTER FORM ── -->
    <div class="form-panel" id="registerPanel">
      <div class="field">
        <label>نام کامل</label>
        <input type="text" id="regName" placeholder="علی رضایی" autocomplete="name">
      </div>
      <div class="field">
        <label>ایمیل</label>
        <input type="email" id="regEmail" placeholder="you@example.com" autocomplete="email">
      </div>
      <div class="field">
        <label>رمزعبور</label>
        <div class="field-wrap">
          <input type="password" id="regPass" placeholder="حداقل ۸ کاراکتر" autocomplete="new-password" oninput="checkStrength(this.value)">
          <button class="eye-btn" type="button" onclick="toggleEye('regPass',this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <div class="strength-wrap" id="strengthBar">
          <div class="strength-seg" id="s1"></div>
          <div class="strength-seg" id="s2"></div>
          <div class="strength-seg" id="s3"></div>
          <div class="strength-seg" id="s4"></div>
        </div>
      </div>
      <div class="field">
        <label>تکرار رمزعبور</label>
        <div class="field-wrap">
          <input type="password" id="regConfirm" placeholder="••••••••" autocomplete="new-password">
          <button class="eye-btn" type="button" onclick="toggleEye('regConfirm',this)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <label class="check-row">
        <input type="checkbox" id="terms">
        <div class="check-box">
          <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M1.5 5L4 7.5L8.5 2" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <span class="check-label">با <a href="#">قوانین استفاده</a> موافقم</span>
      </label>
      <button class="btn-submit" onclick="handleRegister(this)">
        <span class="btn-text">ساخت حساب رایگان</span>
        <div class="spinner"></div>
      </button>
    </div>

  </div>
</div>

<!-- Toast -->
<div id="toast"><div class="toast-dot"></div><span id="toastMsg"></span></div>

<script>
/* ════════════════════════════════════
   TAB SWITCHER
════════════════════════════════════ */
let currentTab = 'login';
function switchTab(tab) {
  if (tab === currentTab) return;
  currentTab = tab;

  const pill    = document.getElementById('tabPill');
  const btns    = document.querySelectorAll('.tab-btn');
  const login   = document.getElementById('loginPanel');
  const reg     = document.getElementById('registerPanel');

  btns.forEach((b, i) => b.classList.toggle('active', (i === 0) === (tab === 'login')));

  if (tab === 'register') {
    pill.classList.add('right');
    login.classList.remove('active');
    reg.classList.add('active');
  } else {
    pill.classList.remove('right');
    reg.classList.remove('active');
    login.classList.add('active');
  }
}

/* ════════════════════════════════════
   EYE TOGGLE
════════════════════════════════════ */
function toggleEye(id, btn) {
  const inp = document.getElementById(id);
  const show = inp.type === 'password';
  inp.type = show ? 'text' : 'password';
  btn.innerHTML = show
    ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
    : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

/* ════════════════════════════════════
   PASSWORD STRENGTH
════════════════════════════════════ */
function checkStrength(val) {
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  const classes = ['', 's1', 's2', 's3', 's4'];
  for (let i = 1; i <= 4; i++) {
    const seg = document.getElementById('s' + i);
    seg.className = 'strength-seg' + (i <= score ? ' ' + classes[score] : '');
  }
}

/* ════════════════════════════════════
   TOAST
════════════════════════════════════ */
let toastTimer;
function showToast(msg, type = 'error') {
  const toast = document.getElementById('toast');
  document.getElementById('toastMsg').textContent = msg;
  toast.className = 'show ' + type;
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.className = '', 3200);
}

/* ════════════════════════════════════
   RIPPLE
════════════════════════════════════ */
function addRipple(btn, e) {
  const r = document.createElement('span');
  r.className = 'ripple';
  const rect = btn.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  r.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
  btn.appendChild(r);
  setTimeout(() => r.remove(), 600);
}

/* ════════════════════════════════════
   API CALL
════════════════════════════════════ */
async function postAction(data) {
  const form = new FormData();
  for (const [k, v] of Object.entries(data)) form.append(k, v);
  const res = await fetch(location.href, { method: 'POST', body: form });
  return res.json();
}

/* ════════════════════════════════════
   LOGIN HANDLER
════════════════════════════════════ */
async function handleLogin(btn) {
  addRipple(btn, event);
  const email = document.getElementById('loginEmail').value.trim();
  const pass  = document.getElementById('loginPass').value;

  if (!email || !pass) return showToast('لطفاً همه فیلدها را پر کنید');

  btn.classList.add('loading');
  try {
    const data = await postAction({ action: 'login', email, password: pass });
    if (data.success) {
      showToast(data.message, 'success');
      // redirect after 1.5s
      if (data.redirect) setTimeout(() => { location.href = data.redirect; }, 1500);
    } else {
      showToast(data.message);
    }
  } catch { showToast('خطا در ارتباط با سرور'); }
  btn.classList.remove('loading');
}

/* ════════════════════════════════════
   REGISTER HANDLER
════════════════════════════════════ */
async function handleRegister(btn) {
  addRipple(btn, event);
  const name    = document.getElementById('regName').value.trim();
  const email   = document.getElementById('regEmail').value.trim();
  const pass    = document.getElementById('regPass').value;
  const confirm = document.getElementById('regConfirm').value;
  const terms   = document.getElementById('terms').checked;

  if (!name || !email || !pass || !confirm) return showToast('لطفاً همه فیلدها را پر کنید');
  if (!terms) return showToast('پذیرش قوانین الزامی است');
  if (pass !== confirm) return showToast('رمزعبور با تکرار آن مطابقت ندارد');

  btn.classList.add('loading');
  try {
    const data = await postAction({ action: 'register', name, email, password: pass, confirm });
    showToast(data.message, data.success ? 'success' : 'error');
    if (data.success) setTimeout(() => switchTab('login'), 1800);
  } catch { showToast('خطا در ارتباط با سرور'); }
  btn.classList.remove('loading');
}

/* ════════════════════════════════════
   PARTICLES
════════════════════════════════════ */
(function spawnParticles() {
  const cont = document.getElementById('particles');
  for (let i = 0; i < 28; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    const size = Math.random() * 3 + 1;
    p.style.cssText = `
      width:${size}px; height:${size}px;
      left:${Math.random()*100}%;
      bottom:${-10}px;
      animation-duration:${Math.random()*15+10}s;
      animation-delay:${Math.random()*-20}s;
      opacity:${Math.random()*.5+.2};
    `;
    cont.appendChild(p);
  }
})();

/* ════════════════════════════════════
   MOUSE-PARALLAX ON CARD
════════════════════════════════════ */
const card = document.querySelector('.card');
document.addEventListener('mousemove', e => {
  const cx = window.innerWidth / 2, cy = window.innerHeight / 2;
  const dx = (e.clientX - cx) / cx, dy = (e.clientY - cy) / cy;
  card.style.transform = `perspective(1200px) rotateY(${dx * 3}deg) rotateX(${-dy * 3}deg)`;
});
document.addEventListener('mouseleave', () => {
  card.style.transform = '';
});
</script>
</body>
</html>
