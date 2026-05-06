<?php
// Você pode usar PHP aqui depois (logs, variáveis, etc)
$title = "CI/CD DevOps - Jenkins + Docker + AWS";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title; ?></title>

<style>
body { margin:0; font-family: Inter, Arial; background:#0b1220; color:#e5e7eb; }

.sidebar {
  width:270px; height:100vh; position:fixed;
  background:#111827; padding:20px; overflow:auto;
}

.sidebar h2 { color:#38bdf8; }

.sidebar a {
  display:block;
  color:#9ca3af;
  text-decoration:none;
  margin:8px 0;
}

.sidebar a:hover { color:#fff; }

.content {
  margin-left:290px;
  padding:40px;
  max-width:1000px;
}

h1,h2,h3 { color:#38bdf8; }

.card {
  background:#111827;
  padding:20px;
  border-radius:10px;
  margin-bottom:25px;
  box-shadow:0 0 10px rgba(0,0,0,0.3);
}

code {
  display:block;
  background:#1f2937;
  padding:12px;
  border-radius:8px;
  margin:10px 0;
  white-space:pre-wrap;
}

.success { border-left:5px solid #22c55e; }
.error { border-left:5px solid #ef4444; }
.warning { border-left:5px solid #f59e0b; }

</style>
</head>

<body>

<div class="sidebar">
<h2>📘 CI/CD Docs</h2>
<a href="#terraform">Terraform</a>
<a href="#ssh">SSH</a>
<a href="#docker">Docker</a>
<a href="#scp">SCP</a>
<a href="#build">Build</a>
<a href="#jenkins">Jenkins</a>
<a href="#buildkit">BuildKit</a>
<a href="#github">GitHub SSH</a>
<a href="#credentials">Credentials</a>
<a href="#pipeline">Pipeline</a>
<a href="#webhook">Webhook</a>
<a href="#dockerhub">DockerHub CI/CD</a>
<a href="#errors">Erros</a>
<a href="#aws">AWS Debug</a>
<a href="#architecture">Arquitetura</a>
</div>

<div class="content">

<h1>🚀 CI/CD com Jenkins + Docker + AWS</h1>
<p>Guia completo baseado em implementação real com erros, correções e boas práticas DevOps.</p>

<div class="card" id="terraform">
<h2>1. Terraform</h2>
<code>
terraform init
terraform plan
terraform apply
</code>
</div>

<div class="card" id="ssh">
<h2>2. SSH (Windows)</h2>
<code>
icacls Jenkins-key.pem /inheritance:r
icacls Jenkins-key.pem /grant:r "$($env:USERNAME):(R)"

ssh -i Jenkins-key.pem ubuntu@SEU_IP
</code>
</div>

<div class="card" id="docker">
<h2>3. Docker Setup</h2>
<code>
sudo apt update
sudo apt install docker.io -y
sudo usermod -aG docker ubuntu
</code>
</div>

<div class="card" id="scp">
<h2>4. Enviar arquivos (SCP)</h2>
<code>
scp -i Jenkins-key.pem Dockerfile ubuntu@IP:/home/ubuntu
</code>
</div>

<div class="card" id="build">
<h2>5. Build da Imagem</h2>
<code>
docker build -t jenkins .
docker images
</code>
</div>

<div class="card" id="jenkins">
<h2>6. Subir Jenkins</h2>
<code>
docker run -d \
--name jenkins \
-p 8080:8080 \
-p 50000:50000 \
-v jenkins_home:/var/jenkins_home \
-v /var/run/docker.sock:/var/run/docker.sock \
-v /usr/bin/docker:/usr/bin/docker \
--group-add $(getent group docker | cut -d: -f3) \
jenkins/jenkins:lts
</code>
</div>

<div class="card" id="buildkit">
<h2>7. BuildKit</h2>
<code>
sudo apt install docker-buildx-plugin -y
docker buildx create --use
docker buildx inspect --bootstrap
</code>
</div>

<div class="card" id="github">
<h2>8. GitHub SSH</h2>
<code>
ssh-keygen
cat /var/jenkins_home/.ssh/id_ed25519.pub
</code>
</div>

<div class="card warning">
<h2>⚠️ Permissões SSH</h2>
<code>
chmod 700 ~/.ssh
chmod 600 id_ed25519
chmod 644 id_ed25519.pub
ssh-keyscan github.com >> ~/.ssh/known_hosts
</code>
</div>

<div class="card" id="credentials">
<h2>9. Credentials Jenkins</h2>
<p><b>ID:</b> github-ssh</p>
<p><b>Username:</b> git</p>
<p><b>Private Key:</b> id_ed25519</p>
</div>

<div class="card" id="pipeline">
<h2>10. Pipeline Jenkins</h2>
<code>
pipeline {
 agent any

 stages {
  stage('Checkout') {
   steps {
    git branch: 'main',
        credentialsId: 'github-ssh',
        url: 'git@github.com/SEU_REPO.git'
   }
  }

  stage('Build') {
   steps {
    sh 'docker build -t app .'
   }
  }

  stage('Deploy') {
   steps {
    sh '''
    docker stop app || true
    docker rm app || true
    docker run -d -p 80:80 app
    '''
   }
  }
 }
}
</code>
</div>

<div class="card" id="webhook">
<h2>11. Webhook</h2>
<code>
http://SEU_IP:8080/github-webhook/
</code>
</div>

<div class="card" id="dockerhub">
<h2>12. CI/CD com DockerHub</h2>
<code>
docker build -t usuario/app .
docker push usuario/app
</code>
</div>

<div class="card error" id="errors">
<h2>⚠️ Erros Reais Resolvidos</h2>
<ul>
<li>Branch master vs main</li>
<li>Permission denied SSH</li>
<li>Docker socket</li>
<li>Webhook 403 / 404</li>
</ul>
</div>

<div class="card" id="aws">
<h2>13. Debug AWS</h2>
<code>
curl localhost
curl ifconfig.me
docker ps
</code>
</div>

<div class="card success" id="architecture">
<h2>📊 Arquitetura Final</h2>
<code>
GitHub
 ↓
Webhook
 ↓
Jenkins
 ↓
Docker Build
 ↓
Deploy EC2
</code>
</div>

</div>
</body>
</html>