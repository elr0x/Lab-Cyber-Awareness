<?php
// Store flag securely on server side
$correct_flag = "FRM{passwords_in_clear_text}";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted_flag = trim($_POST['flag'] ?? '');
    $is_correct = ($submitted_flag === $correct_flag);
    echo json_encode(['correct' => $is_correct, 'flag' => $is_correct ? $correct_flag : null]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Challenge 1 - Hidden Password - </title>
<style>
    /* --- Tus estilos originales --- */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
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
    }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(15px);} to {opacity: 1; transform: translateY(0);} }
    h1 { text-align: center; margin-bottom: 20px; }
    .progress-bar { background: #eee; border-radius: 12px; overflow: hidden; height: 28px; margin-bottom: 20px; position: relative; }
    .progress-fill { height: 100%; width: 0%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: width 0.5s ease; }
    .progress-text { position: absolute; width: 100%; text-align: center; font-weight: bold; font-size: 14px; color: #333; top: 3px; }
    .input-section { display: flex; gap: 10px; margin-bottom: 20px; }
    input[type="text"] { flex: 1; padding: 12px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px; transition: background 0.4s ease, color 0.4s ease; }
    input[type="text"]:disabled { background: #f0f0f0; color: #555; }
    .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px; padding: 10px 18px; cursor: pointer; font-weight: bold; text-transform: uppercase; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
    .btn:hover:not(.disabled) { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.3); }
    .btn.disabled { opacity: 0.4; pointer-events: none; cursor: not-allowed; }
    .message-box { margin-top: 15px; border-radius: 10px; padding: 15px; font-size: 16px; font-weight: 500; }
    .success-box { background: #d4edda; border: 2px solid #c3e6cb; color: #155724; box-shadow: 0 2px 8px rgba(21, 87, 36, 0.2); }
    .best-practices-box { background: #e9f7ef; border: 2px solid #2ecc71; color: #145a32; margin-top: 15px; box-shadow: 0 2px 8px rgba(46, 204, 113, 0.2); display: none; }
    .hint-box { display: none; background: #fff3cd; border: 2px dashed #ffeaa7; border-radius: 10px; padding: 10px; margin-top: 10px; font-size: 14px; color: #856404; }
    .button-group { display: flex; justify-content: space-between; margin-top: 25px; }
    .footer { margin-top: 30px; color: #888; font-size: 12px; }
    canvas#confettiCanvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; }
</style>
</head>
<body>


    <canvas id="confettiCanvas"></canvas>
    <div class="container">
        <h1>Challenge 1 - Discover a Password</h1>
        <p><strong>Story:</strong> You are an IT security analyst at ACME Corp. During a routine check, you discover that an employee has stored a password in plain text inside a hidden file. Your job is to find it.</p>
        <p><strong>Objective:</strong> Use Linux commands to list files (including hidden ones), find the secret file, retrieve the password, and enter it below to proceed.</p>
        <p><strong>Connection:</strong> Connect to 172.28.0.11 via SSH with the user <strong>user1</strong> and password <strong>password1</strong>.</p>

        <div class="progress-bar">
            <div class="progress-fill" id="progress"></div>
            <span class="progress-text" id="progressText">0 / 6</span>
        </div>

        <div class="input-section" id="inputSection">
            <button class="btn" id="hintButton" type="button" onclick="showHint()">Hint</button>
            <input type="text" id="flagInput" placeholder="Enter your flag here">
            <button class="btn" id="submitButton" onclick="checkFlag()">Submit</button>
        </div>

        <div id="hintBox" class="hint-box">
            💡 What command do you use to list files? And which option lists hidden files?
        </div>

        <div id="result" class="message-box success-box" style="display:none;"></div>
        <div id="bestPractices" class="message-box best-practices-box">
            ✅ <strong>Best Practice:</strong> Never store passwords in plain text. Use a password manager or hashed & salted passwords in secure storage.
        </div>

        <div class="button-group">
            <a href="../tutorial.php" class="btn">⬅ Back to Tutorial</a>
            <a href="challenge2.php" id="nextButton" class="btn disabled">Go to Challenge 2 ➜</a>
        </div>
        
        <div class="footer">
            <p>Fernando Rodríguez © 2025</p>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const completed = localStorage.getItem("challenge1Completed") === "true";
    const progress = parseInt(localStorage.getItem("overallProgress")) || 0;
    const inputField = document.getElementById("flagInput");
    const hintButton = document.getElementById("hintButton");
    const submitButton = document.getElementById("submitButton");

    // Progreso dinámico en todas las páginas
    setProgressBar(progress);

    if (completed) {
        inputField.value = "FRM{passwords_in_clear_text}";
        inputField.disabled = true;
        hintButton.style.display = "none";
        submitButton.style.display = "none";
        document.getElementById("result").style.display = "block";
        document.getElementById("result").innerHTML =
            "🎉 Congratulations! You found the flag. You can now advance to the next challenge.";
        document.getElementById("bestPractices").style.display = "block";
        unlockNextChallenge(progress);
        launchConfetti();
    }
});

function setProgressBar(progress) {
    const total = 6;
    const p = Math.max(0, Math.min(progress, total));
    document.getElementById('progress').style.width = (p / total * 100) + '%';
    document.getElementById('progressText').innerText = `${p} / ${total}`;
}

function showHint() {
    document.getElementById('hintBox').style.display = 'block';
}

async function checkFlag() {
    const input = document.getElementById('flagInput').value.trim();
    const resultBox = document.getElementById('result');
    const submitButton = document.getElementById("submitButton");
    const response = await fetch("", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "flag=" + encodeURIComponent(input)
    });
    const data = await response.json();
    if (data.correct) {
        localStorage.setItem("challenge1Completed", "true");
        // Calcula progreso general
        let progress = parseInt(localStorage.getItem("overallProgress")) || 0;
        if (progress < 1) progress = 1;
        localStorage.setItem("overallProgress", progress);
        setProgressBar(progress);

        document.getElementById("flagInput").value = data.flag;
        document.getElementById("flagInput").disabled = true;
        document.getElementById("hintButton").style.display = "none";
        submitButton.style.display = "none";
        resultBox.innerHTML =
            "🎉 Congratulations! You found the flag. You can now advance to the next challenge.";
        resultBox.style.display = "block";
        document.getElementById("bestPractices").style.display = "block";
        unlockNextChallenge(progress);
        launchConfetti();
    } else {
        resultBox.innerHTML = "❌ Incorrect flag. Try again.";
        resultBox.style.display = "block";
    }
}

function unlockNextChallenge(progress) {
    setProgressBar(progress);
    document.getElementById('nextButton').classList.remove('disabled');
}

// Confetti infinito
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
        color: `hsl(${Math.random()*360},100%,50%)`,
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
