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
                    sh '''
                    docker run --rm \
                      -v $WORKSPACE:/usr/src \
                      -w /usr/src \
                      sonarsource/sonar-scanner-cli:latest \
                      sonar-scanner \
                      -Dsonar.projectKey=jenkins-html-test \
                      -Dsonar.sources=. \
                      -Dsonar.host.url=http://56.124.11.104:9000 \
                      -Dsonar.login=squ_fd09c94e1d6473f7df5c99c912634a47a87decf2
                    '''
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
                sh '''
                docker stop site || true
                docker rm site || true

                docker run -d \
                --restart unless-stopped \
                -p 8081:80 \
                --name site \
                jenkins-site
                '''
            }
        }
    }
}