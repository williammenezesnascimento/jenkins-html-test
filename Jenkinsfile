pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
    }

    triggers {
        githubPush()
    }

    stages {

        stage('Checkout') {
            steps {
                git credentialsId: 'github-ssh-key',
                    url: 'git@github.com:williammenezesnascimento/jenkins-html-test.git'

                sh 'echo "📦 Código baixado com sucesso"'
                sh 'ls -la'
            }
        }

        stage('Debug') {
            steps {
                sh '''
                echo "🔍 DEBUG WORKSPACE"
                pwd
                ls -la
                '''
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh '''
                    echo "📊 Iniciando análise SonarQube"

                    sonar-scanner \
                    -Dsonar.projectKey=jenkins-html-test \
                    -Dsonar.projectName=jenkins-html-test \
                    -Dsonar.sources=. \
                    -Dsonar.exclusions=.git/**,node_modules/** \
                    -Dsonar.sourceEncoding=UTF-8 \
                    -Dsonar.scm.disabled=true
                    '''
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                echo "🔨 Build da imagem Docker"
                docker build --no-cache -t $IMAGE_NAME .
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                echo "🧹 Removendo container antigo"
                docker rm -f $CONTAINER_NAME || true

                echo "🚀 Subindo novo container"
                docker run -d \
                  -p 8080:80 \
                  --name $CONTAINER_NAME \
                  --restart unless-stopped \
                  $IMAGE_NAME
                '''
            }
        }

        stage('Health Check') {
            steps {
                sh '''
                echo "🔍 Validando aplicação"
                sleep 5
                curl -f http://localhost:8080 || exit 1
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Pipeline executado com sucesso!"
        }

        failure {
            echo "❌ Falha no pipeline!"
            sh 'docker logs site || true'
        }
    }
}