apt install docker.io -y

iptables -P FORWARD ACCEPT

docker build --no-cache -t localhost:25000/php-attributes-reader:v0.1 -f Dockerfile .
docker push localhost:25000/php-attributes-reader:v0.1

docker-compose -f docker-compose.yml up -d
