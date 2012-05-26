#!/bin/bash
APACHE_USER="www-data"
APPLICATION_PATH=$(cd "$(dirname "$0")/../application" && pwd)
chmod -vR 777 \
	"$APPLICATION_PATH/../temp" \
	"$APPLICATION_PATH/../data/files"
chown -vR "$APACHE_USER" \
	"$APPLICATION_PATH/../temp" \
	"$APPLICATION_PATH/../data/files"
