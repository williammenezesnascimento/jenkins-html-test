pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
        SONAR_TOKEN = credentials('sonar-token')
    }

    triggers {
        githubPush()
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

    stage('SonarQube Analysis') {
        steps {
            withSonarQubeEnv('sonarqube') {
                sh '''
                echo "📁 Arquivos do projeto:"
                find . -type f

                echo "🔎 Sonar analysis..."

                docker run --rm \
                    -v $(pwd):/usr/src \
                    -w /usr/src \
                    sonarsource/sonar-scanner-cli \
                    -Dsonar.projectKey=jenkins-html-test \
                    -Dsonar.projectName=jenkins-html-test \
                    -Dsonar.sources=. \
                    -Dsonar.exclusions=.git/**,node_modules/** \
                    -Dsonar.javascript.file.suffixes=.js \
                    -Dsonar.html.file.suffixes=.html \
                    -Dsonar.css.file.suffixes=.css \
                    -Dsonar.sourceEncoding=UTF-8 \
                    -Dsonar.host.url=$SONAR_HOST_URL \
                    -Dsonar.token=$SONAR_TOKEN
                '''
            }
        }
    }

        stage('Build Docker Image') {
            steps {
                sh '''
                echo "🔨 Building Docker image..."
                docker build --no-cache -t $IMAGE_NAME .
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                echo "🧹 Removing old container..."
                docker rm -f $CONTAINER_NAME || true

                echo "🚀 Starting new container..."
                docker run -d \
                  -p 8081:80 \
                  --name $CONTAINER_NAME \
                  --restart unless-stopped \
                  $IMAGE_NAME
                '''
            }
        }

        stage('Health Check') {
            steps {
                sh '''
                echo "🔍 Checking container..."

                sleep 5

                docker exec $CONTAINER_NAME wget -qO- http://localhost || exit 1
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
            sh 'docker logs site || true'
        }
    }
}