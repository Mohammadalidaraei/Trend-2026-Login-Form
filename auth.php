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
            die();
        }
        // Demo: accept any non-empty credentials
        echo json_encode(['success' => true, 'message' => 'ورود موفقیت‌آمیز! در حال انتقال...', 'redirect' => '/dashboard']);
        die();

    } elseif ($action === 'register') {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm'] ?? '');

        if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
            echo json_encode(['success' => false, 'message' => 'لطفاً همه فیلدها را پر کنید']);
            die();
        }
        if ($password !== $confirm) {
            echo json_encode(['success' => false, 'message' => 'رمزعبور با تکرار آن مطابقت ندارد']);
            die();
        }
        if (strlen($password) < 8) {
            echo json_encode(['success' => false, 'message' => 'رمزعبور باید حداقل ۸ کاراکتر باشد']);
            die();
        }
        echo json_encode(['success' => true, 'message' => 'حساب کاربری با موفقیت ساخته شد!']);
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ورود به سیستم</title>
<link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
<style>
/* Reset & Base Variables */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --bg-color: #0d1117;
    --glass-bg: rgba(255, 255, 255, 0.03);
    --glass-border: rgba(255, 255, 255, 0.08);
    --glass-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    --text-main: #ffffff;
    --text-muted: #9ca3af;
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --secondary: #ec4899;
    --error: #ef4444;
    --success: #10b981;
    --radius: 24px;
    --transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
body {
    font-family: 'Vazirmatn', sans-serif;
    background-color: var(--bg-color);
    color: var(--text-main);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    position: relative;
}

/* Animated Background Orbs */
.bg-orbs {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    overflow: hidden;
    z-index: 0;
    pointer-events: none;
}
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.5;
    animation: float 20s infinite ease-in-out alternate;
}
.orb-1 {
    width: 600px; height: 600px;
    background: var(--primary);
    top: -200px; right: -200px;
    animation-delay: -5s;
}
.orb-2 {
    width: 500px; height: 500px;
    background: var(--secondary);
    bottom: -200px; left: -100px;
    animation-duration: 25s;
}
.orb-3 {
    width: 400px; height: 400px;
    background: #8b5cf6;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation-duration: 15s;
    animation-delay: -10s;
}

@keyframes float {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(50px, 50px) scale(1.1); }
}

/* Glass Container */
.container {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 420px;
    padding: 2rem;
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    box-shadow: var(--glass-shadow);
    transform-style: preserve-3d;
    perspective: 1000px;
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* Header & Tabs */
.header {
    text-align: center;
    margin-bottom: 2rem;
}
.header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #fff, #a5b4fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.header p {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.tabs {
    display: flex;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    padding: 0.3rem;
    margin-bottom: 2rem;
    position: relative;
}
.tab-active-bg {
    position: absolute;
    top: 0.3rem;
    bottom: 0.3rem;
    width: calc(50% - 0.3rem);
    background: var(--primary);
    border-radius: 12px;
    transition: transform var(--transition);
    z-index: 0;
}
.tabs button {
    flex: 1;
    background: none;
    border: none;
    color: var(--text-muted);
    padding: 0.8rem;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    z-index: 1;
    transition: color var(--transition);
}
.tabs button.active {
    color: #fff;
}
.tab-login .tab-active-bg { transform: translateX(0); }
.tab-register .tab-active-bg { transform: translateX(-100%); }

/* Forms */
.form-wrapper {
    position: relative;
    min-height: 250px;
}
.form-container {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    visibility: hidden;
    transform: translateX(30px);
    transition: all var(--transition);
}
.form-container.active {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
    position: relative;
}

.input-group {
    margin-bottom: 1.2rem;
    position: relative;
}
.input-group label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
    transition: color var(--transition);
}
.input-group:focus-within label {
    color: var(--primary);
}
.input-group input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--glass-border);
    padding: 0.9rem 1rem;
    border-radius: 14px;
    color: #fff;
    font-family: inherit;
    font-size: 0.95rem;
    transition: all var(--transition);
    direction: ltr;
    text-align: right;
}
.input-group input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
}
.input-group input::placeholder {
    color: rgba(255, 255, 255, 0.2);
}

.pass-wrapper {
    position: relative;
}
.pass-wrapper input {
    padding-left: 3rem;
}
.toggle-pass {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    transition: color var(--transition);
}
.toggle-pass:hover {
    color: #fff;
}

/* Button */
.btn {
    width: 100%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    border: none;
    padding: 1rem;
    border-radius: 14px;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all var(--transition);
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.5);
}
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px -10px rgba(99, 102, 241, 0.7);
}
.btn:active {
    transform: translateY(0);
}
.btn .spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
}
@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
.btn.loading .btn-text {
    opacity: 0;
}
.btn.loading .spinner {
    display: block;
}

/* Password Strength */
.strength-meter {
    display: flex;
    gap: 5px;
    margin-top: 0.5rem;
    height: 4px;
}
.strength-meter span {
    flex: 1;
    background: rgba(255,255,255,0.1);
    border-radius: 2px;
    transition: background 0.3s;
}

/* Toast Notification */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.toast {
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    color: #fff;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    transform: translateX(120%);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s;
    opacity: 0;
}
.toast.show {
    transform: translateX(0);
    opacity: 1;
}
.toast.success { border-right: 4px solid var(--success); }
.toast.error { border-right: 4px solid var(--error); }

/* Decorative */
.forgot-pass {
    display: block;
    text-align: left;
    font-size: 0.8rem;
    color: var(--text-muted);
    text-decoration: none;
    margin-top: -0.5rem;
    margin-bottom: 1.5rem;
    transition: color 0.3s;
}
.forgot-pass:hover { color: var(--primary); }

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 1.5rem 0;
    color: var(--text-muted);
    font-size: 0.85rem;
}
.divider::before, .divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid var(--glass-border);
}
.divider:not(:empty)::before { margin-left: .25em; }
.divider:not(:empty)::after { margin-right: .25em; }

/* 3D Tilt Effect on Container */
.container {
    transition: transform 0.1s ease-out;
}

</style>
</head>
<body>

<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="container" id="glass-card">
    <div class="header">
        <h1>خوش آمدید</h1>
        <p>به پنل کاربری خود وارد شوید</p>
    </div>

    <div class="tabs" id="tabs">
        <div class="tab-active-bg"></div>
        <button class="active" onclick="switchTab('login')" id="btn-login">ورود</button>
        <button onclick="switchTab('register')" id="btn-register">ثبت‌نام</button>
    </div>

    <div class="form-wrapper">
        <!-- Login Form -->
        <form id="loginForm" class="form-container active" onsubmit="handleAuth(event, 'login')">
            <div class="input-group">
                <label>ایمیل</label>
                <input type="email" name="email" placeholder="example@email.com" required>
            </div>
            <div class="input-group">
                <label>رمز عبور</label>
                <div class="pass-wrapper">
                    <input type="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword(this)">👁️</button>
                </div>
            </div>
            <a href="#" class="forgot-pass">رمز عبور را فراموش کردید؟</a>
            <button type="submit" class="btn">
                <span class="btn-text">ورود</span>
                <div class="spinner"></div>
            </button>

            <div class="divider">یا</div>
            <button type="button" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--glass-border);">
                ورود با گوگل
            </button>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="form-container" onsubmit="handleAuth(event, 'register')">
            <div class="input-group">
                <label>نام و نام خانوادگی</label>
                <input type="text" name="name" placeholder="علی محمدی" required>
            </div>
            <div class="input-group">
                <label>ایمیل</label>
                <input type="email" name="email" placeholder="example@email.com" required>
            </div>
            <div class="input-group">
                <label>رمز عبور</label>
                <div class="pass-wrapper">
                    <input type="password" name="password" placeholder="حداقل ۸ کاراکتر" oninput="checkStrength(this.value)" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword(this)">👁️</button>
                </div>
                <div class="strength-meter" id="strengthMeter">
                    <span></span><span></span><span></span><span></span>
                </div>
            </div>
            <div class="input-group">
                <label>تکرار رمز عبور</label>
                <div class="pass-wrapper">
                    <input type="password" name="confirm" placeholder="••••••••" required>
                    <button type="button" class="toggle-pass" onclick="togglePassword(this)">👁️</button>
                </div>
            </div>
            <button type="submit" class="btn">
                <span class="btn-text">ثبت‌نام</span>
                <div class="spinner"></div>
            </button>
        </form>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script>
    // Tab Switching
    function switchTab(tab) {
        const tabsEl = document.getElementById('tabs');
        const loginBtn = document.getElementById('btn-login');
        const regBtn = document.getElementById('btn-register');
        const loginForm = document.getElementById('loginForm');
        const regForm = document.getElementById('registerForm');

        if(tab === 'login') {
            tabsEl.className = 'tabs tab-login';
            loginBtn.classList.add('active');
            regBtn.classList.remove('active');
            loginForm.classList.add('active');
            regForm.classList.remove('active');
        } else {
            tabsEl.className = 'tabs tab-register';
            regBtn.classList.add('active');
            loginBtn.classList.remove('active');
            regForm.classList.add('active');
            loginForm.classList.remove('active');
        }
    }

    // Initialize tab state
    switchTab('login');

    // Password Toggle
    function togglePassword(btn) {
        const input = btn.previousElementSibling;
        if(input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈';
        } else {
            input.type = 'password';
            btn.textContent = '👁️';
        }
    }

    // Password Strength
    function checkStrength(val) {
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const spans = document.querySelectorAll('#strengthMeter span');
        const colors = ['#ef4444', '#f59e0b', '#10b981', '#10b981'];

        spans.forEach((span, index) => {
            if(index < score) {
                span.style.background = colors[score-1] || colors[0];
            } else {
                span.style.background = 'rgba(255,255,255,0.1)';
            }
        });
    }

    // Toast Notification
    function showToast(message, type = 'error') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div>${type === 'success' ? '✅' : '❌'}</div>
            <div>${message}</div>
        `;
        container.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }

    // Form Handling
    async function handleAuth(e, action) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('.btn');
        btn.classList.add('loading');

        const formData = new FormData(form);
        formData.append('action', action);

        try {
            const res = await fetch('', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if(data.success) {
                showToast(data.message, 'success');
                if(data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1500);
                } else if(action === 'register') {
                    setTimeout(() => switchTab('login'), 1500);
                    form.reset();
                }
            } else {
                showToast(data.message, 'error');
            }
        } catch(err) {
            showToast('خطا در ارتباط با سرور', 'error');
        } finally {
            btn.classList.remove('loading');
        }
    }

    // 3D Tilt Effect
    const card = document.getElementById('glass-card');
    document.addEventListener('mousemove', (e) => {
        const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
        const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
        card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
    });

    // Reset tilt on mouse leave
    document.addEventListener('mouseleave', () => {
        card.style.transform = `rotateY(0deg) rotateX(0deg)`;
        card.style.transition = `transform 0.5s ease`;
    });

    document.addEventListener('mouseenter', () => {
        card.style.transition = `transform 0.1s ease-out`;
    });

</script>
</body>
</html>
