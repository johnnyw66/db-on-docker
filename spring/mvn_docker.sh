docker run -it --rm --name my-maven-project -v "$PWD"/pom.xml:/usr/src/app/pom.xml -v "$HOME"/.m2:/root/.m2 -w /usr/src/app mvn_builder:latest clean install
# create application WAR file (skip tests) - $PWD/target/spring-boot-rest-example-0.3.0.war
#docker run -it --rm -v "$PWD"/target:/usr/src/app/target -w /usr/src/app maven:3-jdk-8-alpine mvn package -T 1C -o -Dmaven.test.skip=true

