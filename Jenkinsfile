pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                sh 'echo build ok'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh """
                    docker run --rm \
                    -v \$(pwd):/usr/src \
                    -w /usr/src \
                    sonarsource/sonar-scanner-cli:latest \
                    sonar-scanner -X \
                    -Dsonar.projectKey=jenkins-html-test \
                    -Dsonar.sources=. \
                    -Dsonar.host.url=\$SONAR_HOST_URL \
                    -Dsonar.token=\$SONAR_AUTH_TOKEN
                    """
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t jenkins-site .'
            }
        }

        stage('Deploy') {
            steps {
                sh """
                docker stop site || true
                docker rm site || true

                docker run -d \
                --restart unless-stopped \
                -p 8081:80 \
                --name site \
                jenkins-site
                """
            }
        }
    }
}