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
                    echo "📂 Workspace:"
                    pwd
                    ls -la
                    find . -type f

                    docker run --rm \
                    -v $WORKSPACE:/usr/src:rw \
                    -w /usr/src \
                    sonarsource/sonar-scanner-cli:5 \
                    sonar-scanner \
                    -Dsonar.projectKey=to-do-list \
                    -Dsonar.projectBaseDir=/usr/src \
                    -Dsonar.sources=. \
                    -Dsonar.inclusions=**/*.js,**/*.html,**/*.css \
                    -Dsonar.exclusions=.git/**,node_modules/** \
                    -Dsonar.sourceEncoding=UTF-8 \
                    -Dsonar.host.url=http://54.232.129.247:9000 \
                    -Dsonar.token=$SONAR_TOKEN \
                    -Dsonar.scm.disabled=true
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