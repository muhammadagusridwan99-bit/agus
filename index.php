<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); 

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Akses Ditolak! Kredensial Salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css" rel="stylesheet">
    <style>
        :root {
            --accent: #00f2fe;
            --secondary: #4facfe;
            --bg-dark: #0f172a;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-dark);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Canvas Background */
        #bg-canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .login-box {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Border Animasi (Neon Line) */
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent));
            animation: btn-anim1 2s linear infinite;
        }

        @keyframes btn-anim1 {
            0% { left: -100%; }
            50%, 100% { left: 100%; }
        }

        .logo-icon {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 20px;
            filter: drop-shadow(0 0 10px var(--accent));
        }

        h2 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        p.subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .input-group:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 10px rgba(0, 242, 254, 0.2);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #64748b;
        }

        .form-control {
            background: transparent;
            border: none;
            color: #fff;
            padding: 12px;
        }

        .form-control:focus {
            background: transparent;
            color: #fff;
            box-shadow: none;
        }

        .btn-cyber {
            background: linear-gradient(45deg, var(--secondary), var(--accent));
            border: none;
            border-radius: 12px;
            color: #000;
            font-weight: 700;
            padding: 14px;
            width: 100%;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-cyber:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 242, 254, 0.4);
            color: #000;
        }

        .alert-cyber {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            color: #fca5a5;
            font-size: 0.8rem;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .forgot-link {
            color: #64748b;
            font-size: 0.8rem;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            transition: 0.3s;
        }

        .forgot-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>

<div class="login-box">
    <div class="glass-card">
        <div class="logo-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h2>SISTEM LOGIN</h2>
        <p class="subtitle">Enkripsi End-to-End Aktif</p>

        <?php if(isset($error)): ?>
            <div class="alert alert-cyber">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="btn-cyber">Otentikasi Sekarang</button>
        </form>

        <a href="#" class="forgot-link">Masalah akses? Hubungi tim IT</a>
    </div>
</div>

<script>
    // Partikel Background Script
    const canvas = document.getElementById('bg-canvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 1;
            this.speedX = Math.random() * 1 - 0.5;
            this.speedY = Math.random() * 1 - 0.5;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x > canvas.width) this.x = 0;
            if (this.x < 0) this.x = canvas.width;
            if (this.y > canvas.height) this.y = 0;
            if (this.y < 0) this.y = canvas.height;
        }
        draw() {
            ctx.fillStyle = 'rgba(0, 242, 254, 0.3)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function init() {
        for (let i = 0; i < 80; i++) {
            particles.push(new Particle());
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.update();
            p.draw();
        });
        requestAnimationFrame(animate);
    }

    init();
    animate();
</script>

</body>
</html>