pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
        CONTAINER_NAME = "site"
    }

    stages {

        stage('Checkout') {
            steps {
                git credentialsId: 'github-ssh-key',
                git branch: 'main',
                    url: 'git@github.com:williammenezesnascimento/jenkins-html-test.git'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('sonarqube') {
                    sh '''
                    sonar-scanner \
                    -Dsonar.projectKey=jenkins-html-test \
                    -Dsonar.sources=.
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
                docker rm -f site || true
                docker run -d -p 8080:80 --name site jenkins-site
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Pipeline OK"
        }
        failure {
            echo "❌ Pipeline falhou"
        }
    }
}