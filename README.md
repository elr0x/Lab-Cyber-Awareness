# Cybersecurity Awareness Lab – ICT S1P1

## 📑 Table of Contents
- [Project Overview](#-project-overview)
- [Installation](#-installation)
- [Usage](#-usage)
- [Challenges](#-challenges)
- [Infrastructure](#-infrastructure)
- [Learning Outcomes](#-learning-outcomes)
- [Authors / Contact](#-authors--contact)

---
## 📌 Project Overview
This project is a **gamified cybersecurity learning environment** developed as **Project 1 (S1P1) of the ICT program at Fontys University of Applied Sciences (Eindhoven)**.  
It consists of a set of interactive **Linux and web security challenges**, each running inside an isolated Docker container, designed to teach students the fundamentals of cybersecurity in a safe, hands-on environment.

### ✨ What This Project Does
- Provides a **self-contained cyber lab** powered by Docker.
- Offers **progressively difficult challenges** focusing on Linux commands, base64 decoding, password cracking, SQL usage, and SQL injection.
- Includes a **web interface** and **tutorials** to guide users through the challenges.

### 🎯 Problem It Solves
Traditional cybersecurity learning can be abstract. This lab allows students to **practice real attacks and defenses in a controlled sandbox**, gaining practical skills without risking production systems.

### 🚀 Key Features
- **7+ Challenges** simulating real-world security problems.
- **Dockerized Infrastructure** with multiple containers (SSH, MySQL, Web).
- **Gamified progression** using flags to unlock the next challenge.
- **Tutorial section** introducing necessary Linux commands.
- **Easy setup** with automated installation scripts.

### 💡 Motivation
With cyberattacks rising worldwide, hands-on experience is essential.  
This project was created to help ICT students **bridge the gap between theory and practice**, making cybersecurity approachable, interactive, and engaging.


---

## 🛠 Installation

### Prerequisites
- **Operating System:** Debian/Ubuntu recommended (works on most Linux systems)
- **Software:**
  - [Docker](https://docs.docker.com/get-docker/) & Docker Compose
  - Git
  - Bash shell
### Steps
```bash
# 1. Clone the repository
git clone https://github.com/elr0x/Lab-Cyber-Awareness.git
cd Lab-Cyber-Awareness

# 2. (Optional) Install Docker using the helper script
sudo ./install.sh

# 3. Start the lab
sudo ./lab.sh
```

Once started, access the lab through your browser:

**🔗 [http://172.28.0.10](http://172.28.0.10)**

---

## ▶️ Usage
The `lab.sh` script manages the lifecycle of the entire environment:
- **Start the lab:**  
  ```bash
  ./lab.sh
  ```
- **Stop & remove everything:** Press **CTRL+C** in the terminal.  
  This will shut down containers, remove images, and clean up files automatically.

---

## 🧩 Challenges
| #   | Topic                      | Description                                                     |
| --- | -------------------------- | --------------------------------------------------------------- |
| 1   | Hidden File Discovery      | Find a password hidden in a dotfile.                            |
| 2   | Directory Tree Enumeration | Navigate a complex folder tree to locate the flag.              |
| 3   | Base64 Decoding            | Decode an encoded string to reveal the secret.                  |
| 4   | MD5 Hash Cracking          | Understand why MD5 is insecure by recovering a hashed password. |
| 5   | SQL Exploration            | Query a MySQL database and retrieve the hidden flag.            |
| 6   | SQL Injection              | Exploit a vulnerable login form to bypass authentication.       |
Each challenge **unlocks the next one** when you submit the correct flag.

---

## 🏗 Infrastructure
- **Dockerized network** with static IPs for each container.
- **Isolated services** per challenge (SSH, DB, Web).
- **Container 5** hosts a MySQL database.
- **Container 6** hosts a web app + database vulnerable to SQL injection.
- **Container 7** serves the main web portal and challenges.

You can view the full topology in `infra/docker-compose.yml`.

---

## 🎓 Learning Outcomes
### For Me (Developer)
- Built a networked Docker infrastructure.
- Improved skills in web development (PHP, HTML, CSS).
- Learned security best practices and exploitation techniques.

### For Learners (Students)
- Practice Linux fundamentals (`ls`, `find`, `tree`, `base64`, `mysql`).
- Understand common security issues (weak hashes, SQL injection).
- Learn how to defend against such attacks in real systems.

---

## 👤 Authors / Contact
**Developer:** Fernando Rodríguez  
📧 **Website:** [fernandoromo.net](https://fernandoromo.net) 
🔗 **LinkedIn:** [linkedin.com/in/fernando-ro-mo](https://linkedin.com/in/fernando-ro-mo)
