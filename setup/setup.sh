apt install docker.io -y

iptables -P FORWARD ACCEPT

docker build --no-cache -t localhost:25000/php-attributes-reader:v1.0 -f ./docker/Dockerfile ../
docker push localhost:25000/php-attributes-reader:v1.0

docker-compose -f ./docker/docker-compose.yml up -d
