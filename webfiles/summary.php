<?php
// No flag needed; this is summary/final page
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Summary - Cybersecurity Learning Journey</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0; padding: 20px;
        display: flex; justify-content: center;
    }
    .container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        padding: 40px;
        max-width: 900px;
        width: 100%;
        position: relative;
        z-index: 10;
        animation: fadeIn 0.6s ease-in-out;
        margin-top: 40px;
    }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(15px);} to {opacity: 1; transform: translateY(0);} }
    h1 { text-align: center; margin-bottom: 20px; }
    .progress-bar {
        background: #eee;
        border-radius: 12px;
        overflow: hidden;
        height: 28px;
        margin-bottom: 20px;
        position: relative;
    }
    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.5s ease;
    }
    .progress-text {
        position: absolute;
        width: 100%;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        color: #333;
        top: 3px;
    }
    .summary-box {
        background: #f2f7fa;
        border: 2px solid #b9e2e7;
        border-radius: 10px;
        padding: 28px;
        font-size: 18px;
        color: #22435d;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(46, 204, 113, 0.07);
    }
    .concept-box {
        background: #eaf7fa;
        border: 2px solid #c8e6ec;
        border-radius: 10px;
        padding: 17px 23px;
        margin-bottom: 20px;
        font-size: 15px;
        color: #0c4861;
        box-shadow: 0 1px 5px rgba(46,204,113,0.04);
    }
    .cmd-table {
        width: 100%; border-collapse: collapse; margin-top: 22px; margin-bottom: 22px; font-size: 15px;
    }
    .cmd-table th, .cmd-table td { border: 1px solid #e0e6ea; padding: 9px 13px; text-align: left; }
    .cmd-table th { background: #f7f9fb; }
    .cmd-table td.code { font-family: monospace; background: #f5f5fa; border-radius: 5px;}
    .button-group { display: flex; justify-content: flex-end; margin-top: 23px; }
	.button-group {
	    display: flex;
	    justify-content: space-between;
	    margin-top: 23px;
	    padding: 0 10px; /* Opcional, para dar algo de espacio interno al contenedor */
	}
	.btn {
	    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	    color: white;
	    border: none;
	    border-radius: 12px;
	    padding: 10px 18px;
	    cursor: pointer;
	    font-weight: bold;
	    text-transform: uppercase;
	    text-decoration: none;
	    display: inline-block;
	    transition: all 0.3s ease;
	    margin-left: 0; /* Eliminar margen izquierdo global */
	}

    .btn:hover:not(.disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.22);
    }
    .btn.disabled { opacity: 0.4; pointer-events: none; cursor: not-allowed; }
    .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; }
    canvas#confettiCanvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; }
</style>
</head>
<body>
<canvas id="confettiCanvas"></canvas>
<div class="container">
    <h1>Cybersecurity Learning Journey - Summary</h1>
    <div class="progress-bar">
        <div class="progress-fill" id="progress"></div>
        <span class="progress-text" id="progressText">0 / 6</span>
    </div>
    <div class="summary-box">
        Well done! You have completed all six practical challenges and learned crucial cybersecurity principles. Here’s a recap of what you explored:
    </div>
    <div class="concept-box"><strong>Core Concepts:</strong><br>
        <ul>
            <li><strong>Hidden files and directories:</strong> Sensitive data may be hidden, but simple enumeration can reveal it.</li>
            <li><strong>Directory trees:</strong> Attackers can automate the discovery of files in deeply nested folder structures.</li>
            <li><strong>Encoding & encryption:</strong> Base64 is not encryption—anyone can decode it instantly.</li>
            <li><strong>Hashing algorithms:</strong> MD5 is obsolete for secure storage, vulnerable to brute force attacks online.</li>
            <li><strong>Password reuse:</strong> Even robust storage is unsafe if users repeat passwords across accounts/services.</li>
            <li><strong>SQL injection:</strong> Direct insertion of user input into SQL queries exposes databases to dangerous manipulations.</li>
        </ul>
    </div>
    <table class="cmd-table">
        <thead>
            <tr>
                <th>Challenge</th>
                <th>Command / Technique</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1. Hidden password</td>
                <td class="code">ls -a</td>
                <td>List all files, including hidden ones</td>
            </tr>
            <tr>
                <td>2. Directory tree</td>
                <td class="code">tree -a</td>
                <td>Recursive display of directory structure, including hidden files</td>
            </tr>
            <tr>
                <td>3. Base64</td>
                <td class="code">base64 --decode &lt;file&gt;</td>
                <td>Decode base64-encoded contents</td>
            </tr>
            <tr>
                <td>4. MD5 hash</td>
                <td class="code">Online hash cracker</td>
                <td>Services like crackstation.net can reveal the original value of weak hashes</td>
            </tr>
            <tr>
                <td>5. SQL passwords</td>
                <td class="code">SQL SELECT queries</td>
                <td>Review stored data and beware repeated passwords in the database</td>
            </tr>
            <tr>
                <td>6. SQL Injection</td>
                <td class="code">' OR 1=1 --</td>
                <td>Example of an injection that bypasses login and demonstrates query vulnerability</td>
            </tr>
        </tbody>
    </table>
    <div class="concept-box"><strong>Best Practices:</strong><br>
        <ul>
            <li>Never store sensitive data in plain text or obscure locations. Use environment variables and secrets managers.</li>
            <li>Apply strong encryption and modern hashing algorithms (bcrypt/Argon2) when storing secrets.</li>
            <li>Never reuse passwords. Use trusted password vaults to generate and store unique credentials.</li>
            <li>Validate and sanitize all user inputs. Prevent direct concatenation in SQL queries and use prepared statements instead.</li>
            <li>Restrict database privileges, audit files and credentials often, and update outdated cryptography.</li>
        </ul>
    </div>
    <div class="concept-box"><strong>Next Steps:</strong>
        Keep practicing! Join bug bounty programs, CTFs, online training, and always apply security fundamentals in daily development.
    </div>
    <div class="button-group">
        <a href="index.php" class="btn">⬅ Back to main page</a>
        <a href="https://www.cyberseek.org/pathway.html" class="btn" target="_blank">Explore Cybersecurity Careers ➜</a>
    </div>
    <div class="footer">
        <p>Fernando Rodríguez © 2025</p>
    </div>
</div>
<script>
// ------- SYNC PROGRESS FROM URL, SAFE & NO RELOAD LOOP -------
function getParameterByName(name) {
  return new URLSearchParams(window.location.search).get(name);
}
(function syncProgressFromURL() {
    const urlProgress = parseInt(getParameterByName("progress")) || 0;
    const localProgress = parseInt(localStorage.getItem("overallProgress")) || 0;
    if (urlProgress > localProgress) {
        localStorage.setItem("overallProgress", urlProgress);
    }
    if (getParameterByName("progress") !== null) {
        const url = new URL(window.location.href);
        url.searchParams.delete('progress');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
    // Block access if not completed all prior challenges
    const accessProgress = parseInt(localStorage.getItem("overallProgress")) || 0;
    if (accessProgress < 6) {
        window.location.href = "index.php";
    }
})();

document.addEventListener("DOMContentLoaded", () => {
    // Always show max progress achieved
    const maxProgress = parseInt(localStorage.getItem("overallProgress")) || 1;
    setProgressBar(maxProgress);
    launchConfetti();
});
function setProgressBar(progress) {
    const total = 6;
    const p = Math.max(0, Math.min(progress, total));
    document.getElementById('progress').style.width = (p / total * 100) + '%';
    document.getElementById('progressText').innerText = `${p} / ${total}`;
}
// ---- Confetti identical to previous challenges ----
const canvas = document.getElementById("confettiCanvas");
const ctx = canvas.getContext("2d");
let confetti = [], confettiRunning = false;
function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
window.addEventListener("resize", resizeCanvas);
resizeCanvas();
function launchConfetti() {
    if (confettiRunning) return;
    confettiRunning = true;
    confetti = Array.from({ length: 200 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        w: Math.random() * 8 + 4,
        h: Math.random() * 12 + 6,
        color: `hsl(${Math.random() * 360},100%,50%)`,
        speed: Math.random() * 3 + 2,
        tilt: Math.random() * 5 - 5,
        angle: Math.random() * 360
    }));
    animateConfetti();
}
function animateConfetti() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    confetti.forEach((p) => {
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.angle * Math.PI / 180);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h);
        ctx.restore();
        p.y += p.speed;
        p.angle += p.tilt;
        if (p.y > canvas.height) p.y = -10;
    });
    requestAnimationFrame(animateConfetti);
}
</script>
</body>
</html>
