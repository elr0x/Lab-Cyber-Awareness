<?php
// Flag correcto
$correct_flag = "FRM{sql_injection}";

$login_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && !isset($_POST['flag'])) {
    // Procesa login vulnerable (form de abajo)
    $conn = @new mysqli("127.0.0.1", "webuser", "webpass", "challenge_web");
    if ($conn->connect_error) {
        $login_message .= '<div class="result error"><strong>Connection Failed: </strong>' . htmlspecialchars($conn->connect_error) . '</div>';
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($query);

            if ($conn->error) {
                $login_message .= '<div class="result error"><strong>Query Error:</strong> ' . htmlspecialchars($conn->error) . '</div>';
            } else if ($result && $result->num_rows > 0) {
                $login_message .= '<div class="result success"><strong>✅ Login Successful!</strong><br>Flag: <strong>FRM{sql_injection}</strong></div>';
            } else {
                $login_message .= '<div class="result error"><strong>❌ Invalid credentials. Please try again.</strong></div>';
            }
        } catch (Exception $e) {
            $login_message .= '<div class="result error"><strong>Exception caught:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        $conn->close();
    }
}

// Procesa comprobación de flag vía AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flag'])) {
    $submitted_flag = trim($_POST['flag'] ?? '');
    $is_correct = ($submitted_flag === $correct_flag);
    echo json_encode(['correct' => $is_correct, 'flag' => $is_correct ? $correct_flag : null]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Challenge 6 - SQL Injection</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0; padding: 20px;
        display: flex; justify-content: center;
    }
    .main-container {
        max-width: 900px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    .container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        padding: 40px;
        position: relative;
        z-index: 10;
        animation: fadeIn 0.6s ease-in-out;
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
    .input-section {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    input[type="text"], input[type="password"] {
        flex: 1;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 10px;
        font-size: 16px;
        margin-bottom: 10px;
        transition: background 0.4s ease, color 0.4s ease;
    }
    input[type="text"]:disabled, input[type="password"]:disabled { background: #f0f0f0; color: #555; }
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
    }
    .btn:hover:not(.disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.3);
    }
    .btn.disabled { opacity: 0.4; pointer-events: none; cursor: not-allowed; }
    .message-box { margin-top: 15px; border-radius: 10px; padding: 15px; font-size: 16px; font-weight: 500; }
    .success-box { background: #d4edda; border: 2px solid #c3e6cb; color: #155724; box-shadow: 0 2px 8px rgba(21,87,36,0.2); }
    .error-box { background: #f8d7da; border: 2px solid #f5c6cb; color: #842029; box-shadow: 0 2px 8px rgba(248,215,218,0.15); }
    .best-practices-box {
        background: #eaf7fa;
        border: 2px solid #c8e6ec;
        border-radius: 10px;
        padding: 14px;
        font-size: 15px;
        color: #0c4861;
        margin-top: 18px;
        display: none;
    }
    .hint-box {
        display: none;
        background: #fff3cd;
        border: 2px dashed #ffeaa7;
        border-radius: 10px;
        padding: 10px;
        margin-top: 10px;
        font-size: 14px;
        color: #856404;
    }
    .button-group { display: flex; justify-content: space-between; margin-top: 25px; }
    canvas#confettiCanvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; }
    /* vulnerable login styles */
    .login-box {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        padding: 40px;
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
        animation: slideIn 0.8s ease-out;
    }
    @keyframes slideIn { from {opacity: 0; transform: translateY(-30px);} to {opacity: 1; transform: translateY(0);} }
    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .login-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
        box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
    }
    .login-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .login-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.3);}
    .login-btn:active { transform: translateY(0);}
    .login-result { margin-top: 25px; padding: 20px; border-radius: 12px; font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.6; animation: fadeIn 0.5s ease-in; max-height: 300px; overflow-y: auto;}
    .login-success { background: #d4edda; border: 2px solid #c3e6cb; color: #155724;}
    .login-error { background: #f8d7da; border: 2px solid #f5c6cb; color: #721c24;}
    .login-warning { background: #fff3cd; border: 2px solid #ffeaa7; color: #856404;}
    .footer { text-align: center; margin-top: 30px; color: #888; font-size: 12px;}
</style>
</head>
<body>
<canvas id="confettiCanvas"></canvas>
<div class="main-container">

    <div class="container">
        <h1>Challenge 6 - SQL Injection</h1>
        <p><strong>Story:</strong> Despite numerous attempts to secure passwords, the notorious ACME Corp employee has now launched a public-facing website. Proud of their new login system, they claim it's "completely safe." But is it really?</p>
        <p><strong>What is SQL Injection?</strong><br>
        SQL Injection is a serious web vulnerability that happens when user input is incorporated directly into SQL queries without proper sanitization or parameterization. This allows attackers to manipulate the queries, potentially accessing, modifying, or destroying database data. A simple injection like <code>user' OR 1=1 -- -</code> can bypass authentication, leak sensitive information, and even gain full control of the system.</p>
        <p><strong>Objective:</strong> Your task is to analyze the login page below and exploit the SQL Injection vulnerability to retrieve the hidden flag. Enter the flag you find into the input above to proceed to the summary page.</p>
        <div class="progress-bar">
            <div class="progress-fill" id="progress"></div>
            <span class="progress-text" id="progressText">0 / 6</span>
        </div>
        <div class="input-section" id="inputSection">
            <button class="btn" id="hintButton" type="button" onclick="showHint()">Hint</button>
            <input type="text" id="flagInput" placeholder="Enter your flag here">
            <button class="btn" id="submitButton" onclick="checkFlag()">Submit</button>
        </div>
        <div id="hintBox" class="hint-box">💡 Tip: Try using the technique explained above.</div>
        <div id="result" class="message-box" style="display:none;"></div>
        <div id="bestPractices" class="message-box best-practices-box">
<strong>🛠 How to fix SQL Injection:</strong><br><br>
✅ Use <strong>prepared statements</strong> (parameterized queries) instead of string concatenation.<br>
✅ Escape and validate user input before using it in a query.<br>
✅ Apply the Principle of Least Privilege for database users.<br>
✅ Enable error logging but do not expose raw SQL errors to users.<br><br>
Example using PHP + MySQLi:
<pre>
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
</pre>
These best practices prevent attackers from injecting arbitrary SQL code.
        </div>
        <div class="button-group">
            <a href="http://172.28.0.10/challenge5.php" class="btn">⬅ Back to challenge 5</a>
            <a href="http://172.28.0.10/summary.php?progress=6" id="nextButton" class="btn disabled">Go to Summary ➜</a>
        </div>
    </div>

    <div class="login-box">
        <div class="login-header">
            <div class="login-logo">🔐</div>
            <h1>SecureAuth Portal</h1>
            <p class="subtitle">User Authentication System</p>
        </div>
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn pulse">Login</button>
        </form>
        <?php
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        echo '<div class="result"><strong>Executed Query:</strong><br>' . htmlspecialchars($query) . '</div>';
        echo $login_message;
        ?>
        <div class="footer">
            <p>Fernando Rodríguez © 2025</p>
        </div>
    </div>

</div>
<script>
// Lee un parámetro de la URL
function getParameterByName(name) {
  return new URLSearchParams(window.location.search).get(name);
}

(function syncProgressFromURL() {
    const urlProgress = parseInt(getParameterByName("progress")) || 0;
    const localProgress = parseInt(localStorage.getItem("overallProgress")) || 0;
    let updated = false;

    // Si el progreso de la URL es mayor, lo guardamos en localStorage
    if (urlProgress > localProgress) {
        localStorage.setItem("overallProgress", urlProgress);
        updated = true;
    }

    // Eliminamos el parámetro "progress" de la URL para evitar recarga/bucle
    if (getParameterByName("progress") !== null) {
        const url = new URL(window.location.href);
        url.searchParams.delete('progress');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }

    // Ahora validamos el acceso, pero solo después de sincronizar/limpiar la URL
    // (asumiendo challenge6 requiere overallProgress >= 5)
    const accessProgress = parseInt(localStorage.getItem("overallProgress")) || 0;
    if (accessProgress < 5) {
        window.location.href = "http://172.28.0.10/index.php";
    }
})();

// ----------- RESTRICCIÓN DE ACCESO SECUENCIAL -----------
(function enforceChallengeOrder(){
    const progress = parseInt(localStorage.getItem("overallProgress")) || 0;
    if(progress < 5) {
        window.location.href = "http://172.28.0.10/index.php";
    }
})();
// --------- BARRA DE PROGRESO DINÁMICA Y ESTADO --------------
document.addEventListener("DOMContentLoaded", () => {
    const completed = localStorage.getItem("challenge6Completed") === "true";
    const savedFlag = localStorage.getItem("flag6") || "FRM{sql_injection}";
    const maxProgress = parseInt(localStorage.getItem("overallProgress")) || 1;
    setProgressBar(maxProgress);
    if (completed) {
        restoreCompletedState();
    }
});
function setProgressBar(progress) {
    const total = 6;
    const p = Math.max(0, Math.min(progress, total));
    document.getElementById('progress').style.width = (p / total * 100) + '%';
    document.getElementById('progressText').innerText = `${p} / ${total}`;
}
function showHint() {
    document.getElementById("hintBox").style.display = "block";
}
async function checkFlag() {
    const input = document.getElementById('flagInput').value.trim();
    const resultBox = document.getElementById('result');
    const submitButton = document.getElementById("submitButton");
    const response = await fetch("", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "flag="+encodeURIComponent(input)
    });
    const data = await response.json();
    if(data.correct) {
        localStorage.setItem("challenge6Completed", "true");
        localStorage.setItem("flag6", data.flag);
        let progress = parseInt(localStorage.getItem("overallProgress")) || 5;
        if (progress < 6) progress = 6;
        localStorage.setItem("overallProgress", progress);
        setProgressBar(progress);
        restoreCompletedState();
    } else {
        resultBox.innerHTML = "❌ Incorrect flag. Try again.";
        resultBox.className = "message-box error-box";
        resultBox.style.display = "block";
    }
}
function restoreCompletedState() {
    const savedFlag = localStorage.getItem("flag6") || "FRM{sql_injection}";
    document.getElementById("flagInput").value = savedFlag;
    document.getElementById("flagInput").disabled = true;
    document.getElementById("hintButton").style.display = "none";
    document.getElementById("submitButton").style.display = "none";
    document.getElementById("result").style.display = "block";
    document.getElementById("result").className = "message-box success-box";
    document.getElementById("result").innerHTML =
        "🎉 Congratulations! You found the flag. You can now advance to summary to see what you have learned.";
    document.getElementById("bestPractices").style.display = "block";
    unlockNextChallenge();
    launchConfetti();
}
function unlockNextChallenge() {
    let progress = parseInt(localStorage.getItem("overallProgress")) || 6;
    setProgressBar(progress);
    document.getElementById('nextButton').classList.remove('disabled');
}
// ----------- CONFETTI --------------
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
