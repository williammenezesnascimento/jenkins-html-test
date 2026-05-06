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
                    echo "📂 Estrutura do projeto:"
                    ls -R .

                    echo "🔎 Running SonarQube analysis..."

                    docker run --rm \
                        -v $(pwd):/usr/src \
                        -w /usr/src \
                        sonarsource/sonar-scanner-cli \
                        -Dsonar.projectKey=jenkins-site \
                        -Dsonar.projectName=jenkins-site \
                        -Dsonar.sources=. \
                        -Dsonar.inclusions=**/* \
                        -Dsonar.exclusions=**/node_modules/**,**/dist/** \
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