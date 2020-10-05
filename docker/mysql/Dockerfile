FROM mysql:8.0.18

COPY ./mysql.cnf /etc/mysql/conf.d/mysql.cnf

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 3306
CMD ["mysqld"]

RUN usermod -u 1000 www-data
