pipeline {
    agent any

    environment {
        IMAGE_NAME = "jenkins-site"
    }

    stages {

        stage('Clone Repo') {
            steps {
                git 'git@github.com:williammenezesnascimento/jenkins-html-test.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Stop Old Container') {
            steps {
                sh '''
                docker stop site || true
                docker rm site || true
                '''
            }
        }

        stage('Run Container') {
            steps {
                sh '''
                docker run -d -p 80:80 --name site $IMAGE_NAME
                '''
            }
        }
    }
}
