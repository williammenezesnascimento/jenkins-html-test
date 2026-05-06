pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main',
                    url: 'git@github.com:williammenezesnascimento/jenkins-html-test.git'
            }
        }

        stage('Build') {
            steps {
                sh 'echo build ok'
            }
        }

        stage('SonarQube') {
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
    }
}