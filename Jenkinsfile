pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
        DOCKER_BUILDKIT = "0"
    }

    triggers {
        githubPush()
    }

    stages {

        stage('Build Docker Image') {
            steps {
                sh '''
                echo "🔨 Building Docker image..."
                docker build --no-cache -t $IMAGE_NAME .
                '''
            }
        }

        stage('Remove Old Container') {
            steps {
                sh '''
                echo "🧹 Removing old container if exists..."
                docker rm -f $CONTAINER_NAME || true
                '''
            }
        }

        stage('Run Container') {
            steps {
                sh '''
                echo "🚀 Starting new container..."

                docker run -d \
                  -p 80:80 \
                  --name $CONTAINER_NAME \
                  --restart unless-stopped \
                  $IMAGE_NAME
                '''
            }
        }

        stage('Health Check') {
            steps {
                sh '''
                echo "🔍 Checking application..."

                sleep 5
                curl -I http://localhost:80 || exit 1
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deploy realizado com sucesso!"
        }
        failure {
            echo "❌ Falha no pipeline!"
        }
    }
}