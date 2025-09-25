<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tutorial - Cybersecurity Awareness</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            max-width: 900px;
            margin: auto;
            padding: 40px;
            animation: slideIn 0.8s ease-out;
            position: relative;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header { text-align: center; margin-bottom: 30px; }
        .logo {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%; margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: white;
            box-shadow: 0 10px 20px rgba(76,175,80,0.3);
        }
        h1 { font-size: 28px; font-weight: 700; margin-bottom: 10px; text-align: center;}
        h2 { font-size: 22px; margin-top: 30px; margin-bottom: 15px; color: #444; }
        p { margin-bottom: 20px; }
        .command {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }
        .command code {
            background: #e9ecef;
            padding: 3px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 12px;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.4); }
        .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🛡️</div>
            <h1>Cybersecurity Tutorial</h1>
            <p>Learn the basic Linux and database commands required to complete the challenges.</p>
        </div>

        <h2>Overview</h2>
        <p>
            Cyberattacks against organizations continue to rise. According to Check Point Research, global cyber attacks per organization reached an average of <strong>1,984 weekly</strong> in Q2 2025 — a 21% increase compared to Q2 2024, with Europe experiencing the highest surge.
        </p>
        <p>
            Understanding basic command-line tools is essential to investigate systems, find misconfigurations, and identify vulnerabilities. This tutorial covers the minimal set of commands needed for these challenges.
        </p>

        <h2>Needed Commands</h2>

        <div class="command">
            <strong>ssh</strong> – Securely connect to a remote machine.<br>
            <code>ssh [user]@[host_or_ip]</code><br><br>
            Example: <code>ssh alice@192.168.1.10</code> connects to the remote server at this IP as user "alice".<br>
            You can also specify options like:<br>
            • <code>-p [port]</code> to define a non-default port.<br>
            • <code>-i [identity_file]</code> to specify an SSH key file.<br>
        </div>

        <div class="command">
            <strong>ls</strong> – List directory contents.<br>
            <code>ls [options]</code><br><br>
            Options:<br>
            • <code>-l</code> → Long listing format (permissions, owner, size, date).<br>
            • <code>-a</code> → Show hidden files (those starting with ".").<br>
            • <code>-i</code> → Show inode numbers.
        </div>

	<div class="command">
            <strong>cat</strong> – View file content.<br>
            <code>cat [file]</code><br><br>
        </div>

        <div class="command">
            <strong>tree</strong> – List contents of directories in a tree-like format in the current directory.<br>
            <code>tree [options]</code><br><br>
            Options:<br>
            • <code>-a</code> → Will display all files, including hidden ones.<br>
            • <code>-f</code> → Prints the full path prefix for each file.<br>
        </div>

        <div class="command">
            <strong>cd</strong> – Change the current directory.<br>
            <code>cd /path/to/directory</code><br><br>
            Example: <code>cd /home/user</code> moves you to the user directory.
        </div>

        <div class="command">
            <strong>find</strong> – Search for files or directories.<br>
            <code>find [path] -name "pattern"</code><br><br>
            Example: <code>find / -name flag.txt</code> searches for "flag.txt" starting from root.
        </div>

        <div class="command">
            <strong>base64</strong> – Encode/Decode data in Base64 format.<br>
            <code>base64 [file]</code> (encode)<br>
            <code>base64 -d [file]</code> (decode)<br><br>
            Example: <code>echo "SGVsbG8=" | base64 -d</code> → outputs "Hello".
        </div>

        <div class="command">
            <strong>mysql</strong> – MySQL/MariaDB command-line client.<br>
            <code>mysql -h [host] -u [user] -p</code><br><br>
            Once inside:<br>
            • <code>SHOW DATABASES;</code> → List databases.<br>
            • <code>USE database_name;</code> → Select a database.<br>
            • <code>SHOW TABLES;</code> → List tables.<br>
            • <code>SELECT * FROM table_name;</code> → Show all data in a table.
        </div>

        <h2>Flags and Progression</h2>
        <p>
            In each challenge, your task will be to locate a hidden flag — a secret token that confirms you have solved the challenge correctly. Collecting these flags is essential as you will need them to unlock and advance through the subsequent challenges.
            To support your progress, each challenge includes helpful tips that guide you towards the solution while encouraging critical thinking and exploration.
        </p>

        <div class="button-group">
            <a href="index.php" class="btn">⬅ Back to Home</a>
            <a href="./challenges/challenge1.php" class="btn">Go to Challenge 1 ➜</a>
        </div>

        <div class="footer">
            <p>Fernando Rodríguez © 2025</p>
        </div>
    </div>
</body>
</html>
