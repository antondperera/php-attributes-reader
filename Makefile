.PHONY: up down setup

up:
	iptables -P FORWARD ACCEPT
	docker-compose -f docker-compose.yml up -d

down:
	docker-compose -f docker-compose.yml down

setup:
	./docker-setup.sh

run:
	docker exec -it php-attributes-reader sh