<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>CI/CD Jenkins + SonarQube</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #e2e8f0;
    padding: 40px;
}

.container {
    max-width: 1000px;
    margin: auto;
}

h1 {
    color: #38bdf8;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #22c55e;
    margin-top: 40px;
}

.step {
    background: rgba(255,255,255,0.05);
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

code {
    display: block;
    background: #0b1220;
    color: #38bdf8;
    padding: 12px;
    border-radius: 8px;
    margin-top: 10px;
    overflow-x: auto;
}

.badge {
    display: inline-block;
    background: #22c55e;
    color: #000;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    margin-bottom: 10px;
}
</style>

</head>

<body>

<div class="container">

<h1>🚀 CI/CD Completo com Jenkins + Docker + SonarQube</h1>

<div class="step">
<span class="badge">1. Objetivo</span>
<p>Este projeto foi criado para aprender CI/CD na prática usando Jenkins, Docker e SonarQube.</p>
<p>O fluxo completo automatiza:</p>
<ul>
    <li>✔ Checkout do código no GitHub</li>
    <li>✔ Build da aplicação</li>
    <li>✔ Análise de qualidade com SonarQube</li>
    <li>✔ Build da imagem Docker</li>
    <li>✔ Deploy automático</li>
</ul>
</div>

<div class="step">
<span class="badge">2. Estrutura do Jenkins Pipeline</span>

<p>Pipeline base utilizado:</p>

<code>
pipeline {<br>
&nbsp;&nbsp;agent any<br><br>

&nbsp;&nbsp;environment {<br>
&nbsp;&nbsp;&nbsp;&nbsp;IMAGE_NAME = "jenkins-site"<br>
&nbsp;&nbsp;&nbsp;&nbsp;CONTAINER_NAME = "site"<br>
&nbsp;&nbsp;}<br><br>

&nbsp;&nbsp;stages {<br>
&nbsp;&nbsp;&nbsp;&nbsp;stage('Checkout') {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;steps { checkout scm }<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;stage('Build') {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;steps { sh 'echo build ok' }<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;stage('SonarQube') {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;steps { ... }<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;stage('Docker Build') {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;steps { sh 'docker build -t jenkins-site .' }<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br><br>

&nbsp;&nbsp;&nbsp;&nbsp;stage('Deploy') {<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;steps { ... }<br>
&nbsp;&nbsp;&nbsp;&nbsp;}<br>
&nbsp;&nbsp;}<br>
}
</code>

</div>

<div class="step">
<span class="badge">3. SonarQube (Análise de Código)</span>

<p>Execução via Docker:</p>

<code>
docker run --rm \<br>
&nbsp;&nbsp;-v $WORKSPACE:/usr/src \<br>
&nbsp;&nbsp;-w /usr/src \<br>
&nbsp;&nbsp;sonarsource/sonar-scanner-cli:latest \<br>
&nbsp;&nbsp;sonar-scanner \<br>
&nbsp;&nbsp;-Dsonar.projectKey=jenkins-html-test \<br>
&nbsp;&nbsp;-Dsonar.sources=. \<br>
&nbsp;&nbsp;-Dsonar.host.url=$SONAR_HOST_URL \<br>
&nbsp;&nbsp;-Dsonar.token=$SONAR_AUTH_TOKEN
</code>

<p>📌 O Sonar analisa o código e identifica bugs, code smells e qualidade geral.</p>

</div>

<div class="step">
<span class="badge">4. Docker Build</span>

<code>
docker build -t jenkins-site .
</code>

<p>Cria a imagem da aplicação PHP com Apache.</p>

</div>

<div class="step">
<span class="badge">5. Deploy Automatizado</span>

<code>
docker stop site || true<br>
docker rm site || true<br><br>

docker run -d \<br>
&nbsp;&nbsp;--restart unless-stopped \<br>
&nbsp;&nbsp;-p 8081:80 \<br>
&nbsp;&nbsp;--name site \<br>
&nbsp;&nbsp;jenkins-site
</code>

<p>Remove container antigo e sobe nova versão automaticamente.</p>

</div>

<div class="step">
<span class="badge">6. Resultado Final</span>

<p>
✔ Pipeline executado automaticamente<br>
✔ Código analisado pelo SonarQube<br>
✔ Aplicação publicada via Docker<br>
✔ Deploy contínuo funcionando
</p>

<p style="color:#22c55e; font-weight:bold;">
🚀 CI/CD funcionando com sucesso!
</p>

</div>

<div class="step">
<span class="badge">7. Aprendizado</span>

<p>
Este projeto demonstra conceitos reais de DevOps:
</p>

<ul>
    <li>Jenkins (orquestração do pipeline)</li>
    <li>Docker (containerização)</li>
    <li>SonarQube (qualidade de código)</li>
    <li>GitHub (versionamento)</li>
</ul>

</div>

</div>

</body>
</html>