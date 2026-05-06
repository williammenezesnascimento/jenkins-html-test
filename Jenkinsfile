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
                    --volumes-from \$(hostname) \
                    -w \$WORKSPACE \
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
                // Utilizando a variável ambiente IMAGE_NAME definida no topo
                sh "docker build -t ${IMAGE_NAME} ."
            }
        }

        stage('Deploy') {
            steps {
                // Utilizando as variáveis IMAGE_NAME e CONTAINER_NAME
                sh """
                docker stop ${CONTAINER_NAME} || true
                docker rm ${CONTAINER_NAME} || true

                docker run -d \
                --restart unless-stopped \
                -p 8081:80 \
                --name ${CONTAINER_NAME} \
                ${IMAGE_NAME}
                """
            }
        }
    }
}