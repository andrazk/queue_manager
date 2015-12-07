FROM php:5.6-cli

RUN apt-get update && \
    apt-get install -y \
    sqlite3 libsqlite3-dev


COPY . /usr/src/

WORKDIR /usr/src/


EXPOSE 8000
