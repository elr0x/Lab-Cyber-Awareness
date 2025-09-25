<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cybersecurity Awareness Portal</title>
    <style>
        * {margin: 0; padding: 0; box-sizing: border-box;}
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            width: 100%;
            max-width: 700px;
            text-align: center;
            animation: slideIn 0.8s ease-out;
            position: relative;
            z-index: 2;
        }
        @keyframes slideIn {
            from {opacity: 0; transform: translateY(-30px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .logo {
            width: 100px; height: 100px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
        }
        h1 { color: #333; font-size: 32px; font-weight: 700; margin-bottom: 23px;}
        .description {
            color: #555; font-size: 16px; line-height: 1.7;
            text-align: justify;
            margin-bottom: 24px;
        }
        .challenge-structure {
            background: #f2f7fa;
            border: 2px solid #b9e2e7;
            border-radius: 10px;
            padding: 22px 24px;
            color: #22435d;
            font-size: 16px;
            margin-bottom: 29px;
            text-align: left;
            box-shadow: 0 2px 8px rgba(46, 204, 113, 0.07);
        }
        .challenge-structure ul {
            margin-top: 12px; margin-left: 18px;
            margin-bottom: 0; padding-left: 0;
        }
        .challenge-structure li {
            margin-bottom: 7px;
            line-height: 1.5;
        }
        .cta-btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .footer {
            margin-top: 32px;
            color: #888;
            font-size: 12px;
        }
        .ssh-box {
            background: #fff9ed;
            border: 2px solid #ffeaa7;
            border-radius: 10px;
            padding: 18px 20px;
            color: #5a4300;
            font-size: 15px;
            text-align: left;
            box-shadow: 0 2px 8px rgba(255, 234, 167, 0.25);
            margin-bottom: 26px;
        }
        .ssh-box code {
            background: #fff3cd;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🛡️</div>
        <h1>Cybersecurity Awareness Portal</h1>

        <p class="description">
            Welcome to a gamified learning experience where you'll develop real cybersecurity skills through interactive challenges focused on Linux basics and web security.  
            Each challenge simulates real-world scenarios crafted to sharpen your problem-solving and hacking techniques in a safe environment.
        </p>

        <div class="challenge-structure">
            <strong>How It Works:</strong>
            <ul>
                <li>You will navigate through six carefully designed challenges, each building upon the previous to deepen your understanding of cyber risks and defenses.</li>
                <li>In every challenge, your goal is to discover a hidden flag—a secret token that proves you've solved the puzzle and mastered the concept.</li>
                <li>Collecting these flags is essential to unlock and progress through the entire series.</li>
                <li>Helpful tips are provided within each challenge to guide you, encouraging learning and critical thinking without giving away the solutions outright.</li>
            </ul>
            <br>
            This progressive structure builds confidence step-by-step, enabling you to apply commands and security concepts that are directly transferable to real-world systems and applications.
        </div>

        <div class="ssh-box">
            <strong>Remote Access per Challenge (SSH):</strong><br><br>
            In each challenge you will see an IP address to connect to via SSH. The challenge itself will indicate the username to use. The password will be the flag obtained in the previous challenge (for Challenge 1, credentials are provided directly on the page).  
            The tutorial includes the SSH basics you need, including syntax and options.
        </div>

        <a href="tutorial.php" class="cta-btn">Start Tutorial</a>

        <div class="footer">
            <p>Fernando Rodríguez © 2025</p>
        </div>
    </div>
</body>
</html>
