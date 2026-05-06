pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
    }

    stages {

        stage('Checkout') {
            steps {
                echo "📥 Clonando repositório via SCM..."
                checkout scm
            }
        }

        stage('Build') {
            steps {
                echo "🔨 Build da aplicação..."
                sh 'echo "build ok"'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh '''
                        echo "📊 Executando SonarQube Scanner..."

                        sonar-scanner \
                        -Dsonar.projectKey=jenkins-html-test \
                        -Dsonar.sources=. \
                        -Dsonar.sourceEncoding=UTF-8
                    '''
                }
            }
        }

        stage('Quality Gate') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    waitForQualityGate abortPipeline: true
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "🐳 Buildando imagem Docker..."
                sh "docker build -t ${IMAGE_NAME} ."
            }
        }

        stage('Deploy') {
            steps {
                echo "🚀 Subindo container..."
                sh """
                    docker rm -f ${CONTAINER_NAME} || true
                    docker run -d -p 8080:80 --name ${CONTAINER_NAME} ${IMAGE_NAME}
                """
            }
        }
    }

    post {
        success {
            echo "✅ Pipeline executado com sucesso!"
        }

        failure {
            echo "❌ Falha no pipeline"
            sh "docker logs ${CONTAINER_NAME} || true"
        }
    }
}