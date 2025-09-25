#!/usr/bin/env bash
set -e

######################################
# Create repository structure
######################################
echo "[+] Creating repository structure..."

BASE_DIR="infra"
mkdir -p $BASE_DIR/{base,containers}

######################################
# Base Dockerfile for SSH challenges
######################################
mkdir -p $BASE_DIR/base
cat > $BASE_DIR/base/Dockerfile << 'EOF'
# Base image for SSH challenges
FROM debian:bullseye

RUN apt-get update -y > /dev/null && \
    apt-get install -y openssh-server sudo tree > /dev/null && \
    mkdir /var/run/sshd

ARG USERNAME=user_default
ARG PASSWORD=changeme

RUN useradd -m -s /bin/bash $USERNAME && \
    echo "$USERNAME:$PASSWORD" | chpasswd && \
    usermod -aG sudo $USERNAME

# SSH configuration: disable root login, enable password authentication
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config && \
    sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config

EXPOSE 22
CMD ["/usr/sbin/sshd", "-D"]
EOF

######################################
# Container 1 - SSH challenge simple
######################################
echo "[+] Creating container1..."
mkdir -p $BASE_DIR/containers/container1

cat > $BASE_DIR/containers/container1/Dockerfile << 'EOF'
# Container 1: SSH challenge (simple)
FROM challenge-base

ARG USERNAME=user1
ARG PASSWORD=password1

RUN useradd -m -s /bin/bash $USERNAME && \
    echo "$USERNAME:$PASSWORD" | chpasswd && \
    usermod -aG sudo $USERNAME

COPY flag.txt /home/$USERNAME/.flag.txt
RUN chown $USERNAME:$USERNAME /home/$USERNAME/.flag.txt
EOF

echo "FRM{passwords_in_clear_text}" > $BASE_DIR/containers/container1/flag.txt

######################################
# Container 2 - SSH + directory tree
######################################
echo "[+] Creating container2..."
mkdir -p $BASE_DIR/containers/container2

cat > $BASE_DIR/containers/container2/Dockerfile << 'EOF'
# Container 2: SSH challenge with directory tree
FROM challenge-base

ARG USERNAME=user2
ARG PASSWORD=FRM{passwords_in_clear_text}

RUN useradd -m -s /bin/bash $USERNAME && \
    echo "$USERNAME:$PASSWORD" | chpasswd && \
    usermod -aG sudo $USERNAME

# Create deep directory tree with random folder names, flag hidden at level 8, folder 4
RUN set -eux; \
    BASE_DIR="/home/$USERNAME/root"; \
    mkdir -p "$BASE_DIR"; \
    current="$BASE_DIR"; \
    for level in $(seq 1 10); do \
        for i in $(seq 1 5); do \
            folder=$(tr -dc 'a-z' < /dev/urandom | head -c 10); \
            mkdir -p "$current/$folder"; \
            if [ "$level" -eq 8 ] && [ "$i" -eq 4 ]; then \
                echo "FRM{tree_is_useful}" > "$current/$folder/.flag.txt"; \
                chown $USERNAME:$USERNAME "$current/$folder/.flag.txt"; \
            fi; \
        done; \
        first_sub=$(ls -1 "$current" | head -n 1); \
        current="$current/$first_sub"; \
    done

RUN chown -R $USERNAME:$USERNAME /home/$USERNAME/root
EOF

######################################
# Container 3 - SSH challenge simple
######################################
echo "[+] Creating container3..."
mkdir -p $BASE_DIR/containers/container3

cat > $BASE_DIR/containers/container3/Dockerfile << 'EOF'
# Container 3: SSH challenge (simple)
FROM challenge-base

ARG USERNAME=user3
ARG PASSWORD=FRM{tree_is_useful}

RUN useradd -m -s /bin/bash $USERNAME && \
    echo "$USERNAME:$PASSWORD" | chpasswd && \
    usermod -aG sudo $USERNAME

COPY flag.txt /home/$USERNAME/flag.txt
RUN chown $USERNAME:$USERNAME /home/$USERNAME/flag.txt
EOF

echo "RlJNe2Jhc2U2NF9pc19ub3Rfc2VjdXJlfQo=" > $BASE_DIR/containers/container3/flag.txt

######################################
# Container 4 - SSH challenge simple
######################################
echo "[+] Creating container4..."
mkdir -p $BASE_DIR/containers/container4

cat > $BASE_DIR/containers/container4/Dockerfile << 'EOF'
# Container 4: SSH challenge (simple)
FROM challenge-base

ARG USERNAME=user4
ARG PASSWORD=FRM{base64_is_not_secure}

RUN apt-get update -y > /dev/null && \
    apt-get install -y default-mysql-client


RUN useradd -m -s /bin/bash $USERNAME && \
    echo "$USERNAME:$PASSWORD" | chpasswd && \
    usermod -aG sudo $USERNAME

COPY flag.txt /home/$USERNAME/flag.txt
RUN chown $USERNAME:$USERNAME /home/$USERNAME/flag.txt
EOF

echo "482c811da5d5b4bc6d497ffa98491e38" > $BASE_DIR/containers/container4/flag.txt

######################################
# Container 5 - MySQL challenge DB
######################################
echo "[+] Creating container5 (MySQL DB)..."
mkdir -p $BASE_DIR/containers/container5

cat > $BASE_DIR/containers/container5/Dockerfile << 'EOF'
FROM mysql:8.0
CMD ["mysqld", "--ssl=0"]
ENV MYSQL_ROOT_PASSWORD=rootpass
ENV MYSQL_DATABASE=challenge_db
ENV MYSQL_USER=user5
ENV MYSQL_PASSWORD=password123
COPY init.sql /docker-entrypoint-initdb.d/
EXPOSE 3306
EOF

cat > $BASE_DIR/containers/container5/init.sql << 'EOF'
CREATE DATABASE IF NOT EXISTS challenge_db;
USE challenge_db;
CREATE TABLE IF NOT EXISTS flags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag VARCHAR(255)
);
INSERT INTO flags (flag) VALUES ('FRM{password_reusing_is_not_secure}');
CREATE USER IF NOT EXISTS 'user5'@'%' IDENTIFIED BY 'password123';
ALTER USER 'user5'@'%' REQUIRE NONE;
ALTER USER 'user5'@'%' IDENTIFIED WITH mysql_native_password BY 'password123';
GRANT ALL PRIVILEGES ON challenge_db.* TO 'user5'@'%';
FLUSH PRIVILEGES;
EOF

######################################
# Container 6 - Web + MariaDB
######################################
echo "[+] Creating container6 (Web + MariaDB)..."
mkdir -p $BASE_DIR/containers/container6

cat > $BASE_DIR/containers/container6/Dockerfile << 'EOF'
FROM debian:12-slim
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -y > /dev/null && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server mariadb-client net-tools > /dev/null && \
    rm -rf /var/lib/apt/lists/*
RUN sed -i 's/^Listen .*/Listen 0.0.0.0:80/' /etc/apache2/ports.conf && \
    rm -f /var/www/html/index.html && \
    echo "DirectoryIndex index.php" > /etc/apache2/conf-available/dir-php.conf && \
    a2enconf dir-php
COPY init.sql /tmp/init.sql
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
EXPOSE 80 3306
ENTRYPOINT ["/entrypoint.sh"]
EOF

cat > $BASE_DIR/containers/container6/init.sql << 'EOF'
CREATE DATABASE IF NOT EXISTS challenge_web;
USE challenge_web;
CREATE TABLE IF NOT EXISTS flags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag VARCHAR(255)
);
INSERT INTO flags (flag) VALUES ('FRM{sql_injection}');
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);
INSERT INTO users (username, password) VALUES
('admin', 'admin123'),
('guest', 'guest123'),
('test', 'password');
DROP USER IF EXISTS 'webuser'@'%';
CREATE USER 'webuser'@'%' IDENTIFIED BY 'webpass';
GRANT ALL PRIVILEGES ON challenge_web.* TO 'webuser'@'%';
FLUSH PRIVILEGES;
EOF

cat > $BASE_DIR/containers/container6/entrypoint.sh << 'EOF'
#!/bin/bash
set -e
service mariadb start
until mysqladmin ping >/dev/null 2>&1; do sleep 1; done
mysql -u root < /tmp/init.sql || true
service apache2 start
tail -f /var/log/apache2/access.log
EOF

######################################
# Container 7 - Web only challenge
######################################
echo "[+] Creating container7 (Web only)..."
mkdir -p $BASE_DIR/containers/container7

cat > $BASE_DIR/containers/container7/Dockerfile << 'EOF'
FROM debian:12-slim
RUN apt-get update -y > /dev/null && \
    apt-get install -y apache2 php libapache2-mod-php > /dev/null && \
    rm -rf /var/lib/apt/lists/*
RUN sed -i 's/^Listen .*/Listen 0.0.0.0:80/' /etc/apache2/ports.conf && \
    rm -f /var/www/html/index.html && \
    echo "DirectoryIndex index.php" > /etc/apache2/conf-available/dir-php.conf && \
    a2enconf dir-php
EXPOSE 80
CMD ["apachectl", "-D", "FOREGROUND"]
EOF

######################################
# Docker Compose for all containers
######################################
echo "[+] Creating docker-compose.yml..."
cat > $BASE_DIR/docker-compose.yml << 'EOF'
services:
  container1:
    container_name: container_1
    build: ./containers/container1
    networks:
      challenge_net:
        ipv4_address: 172.28.0.11
    ports:
      - "2221:22"

  container2:
    container_name: container_2
    build: ./containers/container2
    networks:
      challenge_net:
        ipv4_address: 172.28.0.12
    ports:
      - "2222:22"

  container3:
    container_name: container_3
    build: ./containers/container3
    networks:
      challenge_net:
        ipv4_address: 172.28.0.13
    ports:
      - "2223:22"

  container4:
    container_name: container_4
    build: ./containers/container4
    networks:
      challenge_net:
        ipv4_address: 172.28.0.14
    ports:
      - "2224:22"

  container5:
    container_name: container_5
    build: ./containers/container5
    networks:
      challenge_net:
        ipv4_address: 172.28.0.15
    ports:
      - "3305:3306"

  container6:
    container_name: container_6
    build: ./containers/container6
    networks:
      challenge_net:
        ipv4_address: 172.28.0.16
    ports:
      - "8086:80"
    volumes:
      - ../webfiles/challenges/challenge6.php:/var/www/html/challenge6.php:ro

  container7:
    container_name: container_7
    build: ./containers/container7
    networks:
      challenge_net:
        ipv4_address: 172.28.0.10
    ports:
      - "8087:80"
    volumes:
      - ../webfiles:/var/www/html:ro

networks:
  challenge_net:
    driver: bridge
    ipam:
      config:
        - subnet: 172.28.0.0/16
EOF

echo "[✅] Repository structure created in '$BASE_DIR/'"

######################################
# Build, start, and manage containers
######################################

echo "[+] Checking base image..."
if ! docker image inspect challenge-base > /dev/null 2>&1; then
    echo "[+] Building base image..."
    docker build -q -t challenge-base "$BASE_DIR/base" > /dev/null
else
    echo "[=] Base image already exists, skipping build."
fi

echo "[+] Building containers..."
docker compose -f "$BASE_DIR/docker-compose.yml" build --quiet > /dev/null

echo "[+] Starting lab containers..."
docker compose -f "$BASE_DIR/docker-compose.yml" up -d > /dev/null

#Remove previous SSH fingerprints
for i in {1..4}; do
  ssh-keygen -f "/$(whoami)/.ssh/known_hosts" -R "172.28.0.1$i" > /dev/null 2>&1
done

echo ""
echo "[✅] Lab is running!"
echo "[✅] Connect to [http://172.28.0.10](http://172.28.0.10) to start the cyber challenges!"
echo "[ℹ️] Press CTRL+C to stop and remove all containers."

# ====== Trap CTRL+C to clean up all resources ======
trap 'echo -e "\n[!] Stopping and removing lab..."; \
docker compose -f "$BASE_DIR/docker-compose.yml" down -v > /dev/null; \
docker rmi -f infra-container5 infra-container7 infra-container1 infra-container4 infra-container3 infra-container2 infra-container6 challenge-base > /dev/null 2>&1; \
echo "[✅] Lab stopped and containers and images removed."; \
rm -rf "$BASE_DIR"; \
echo "[✅] Repository folder '$BASE_DIR/' removed."; \
#Remove this session SSH fingerprints
for i in {1..4}; do
  ssh-keygen -f "/$(whoami)/.ssh/known_hosts" -R "172.28.0.1$i" > /dev/null 2>&1
done

exit 0' INT

# Wait forever until interrupted with CTRL+C
while true; do
    sleep 1
done
