FROM java
ENV LIQUIBASEVERSION 3.6.2
ENV MYSQLJDBCVERSION 5.1.34

MAINTAINER Johnny 

# download liquibase
ADD https://github.com/liquibase/liquibase/releases/download/liquibase-parent-${LIQUIBASEVERSION}/liquibase-${LIQUIBASEVERSION}-bin.tar.gz /tmp/liquibase-${LIQUIBASEVERSION}-bin.tar.gz
#COPY lib/liquibase-3.2.2-bin.tar.gz /tmp/liquibase-3.2.2-bin.tar.gz

# Create a directory for liquibase
RUN mkdir /opt/liquibase

# Unpack the distribution
RUN tar -xzf /tmp/liquibase-${LIQUIBASEVERSION}-bin.tar.gz -C /opt/liquibase
RUN chmod +x /opt/liquibase/liquibase

# Symlink to liquibase to be on the path
RUN ln -s /opt/liquibase/liquibase /usr/local/bin/

# Get the postgres and mySQL JDBC drivers 
ADD http://jdbc.postgresql.org/download/postgresql-9.3-1102.jdbc41.jar /opt/jdbc_drivers/
ADD http://dev.mysql.com/get/Downloads/Connector-J/mysql-connector-java-5.1.34.zip /tmp/mysql-connector-java-5.1.34.zip
RUN unzip -p /tmp/mysql-connector-java-5.1.34.zip  mysql-connector-java-5.1.34/mysql-connector-java-5.1.34-bin.jar > /tmp/mysql-connector-java-5.1.34-bin.jar
RUN cp /tmp/mysql-connector-java-5.1.34-bin.jar /opt/jdbc_drivers
RUN chmod -R +x /opt/jdbc_drivers/

#COPY lib/postgresql-9.3-1102.jdbc41.jar /opt/jdbc_drivers/
#COPY lib/mysql-connector-java-5.1.34-bin.jar /opt/jdbc_drivers


RUN ln -s /opt/jdbc_drivers/postgresql-9.3-1102.jdbc41.jar /usr/local/bin/
RUN ln -s /opt/jdbc_drivers/mysql-connector-java-5.1.34-bin.jar /usr/local/bin

# Add command scripts
ADD scripts /scripts
RUN chmod -R +x /scripts

VOLUME ["/changelogs"]

WORKDIR /

ENTRYPOINT ["/bin/bash"]
