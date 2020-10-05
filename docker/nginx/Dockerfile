FROM nginx:latest

RUN apt-get update && apt-get install -y nano

RUN deluser www-data
RUN adduser --disabled-password --no-create-home --uid 1000 --shell /bin/bash www-data

COPY ./nginx.conf /etc/nginx/conf.d/default.conf
COPY ./shop.loc.crt /etc/ssl/certs/shop.loc.crt
COPY ./shop.loc.key /etc/ssl/private/shop.loc.key

ENV TERM xterm
