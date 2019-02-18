FROM tomcat:8-jre8
RUN apt-get update
RUN apt-get -y install locales

ARG JAVA_OPTS
ARG CATALINA_OPTS

# Set the locale
RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Install and run tomcat
RUN apt-get -y install openjdk-8-jdk wget nano maven

RUN mkdir -p /usr/local/tomcat
RUN wget https://archive.apache.org/dist/tomcat/tomcat-8/v8.0.32/bin/apache-tomcat-8.0.32.tar.gz -O /tmp/tomcat.tar.gz

RUN cd /tmp && tar xvfz tomcat.tar.gz
RUN cp -R /tmp/apache-tomcat-8.0.32/* /usr/local/tomcat/

RUN touch /usr/local/tomcat/bin/setenv.sh
RUN echo "CATALINA_OPTS=\"$CATALINA_OPTS\"" >> /usr/local/tomcat/bin/setenv.sh
RUN echo "JAVA_OPTS=\"$JAVA_OPTS\"" >> /usr/local/tomcat/bin/setenv.sh

EXPOSE 8080
CMD /usr/local/tomcat/bin/catalina.sh run
