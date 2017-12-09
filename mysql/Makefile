DB_CONTAINER_NAME := mysql
NETWORK := $(shell docker inspect $(DB_CONTAINER_NAME) -f "{{json .HostConfig.NetworkMode }}")

pma:
	docker run --rm \
	--name pma \
	--link $(DB_CONTAINER_NAME):db \
	--net $(NETWORK) \
	-p 8080:80 \
	phpmyadmin/phpmyadmin

adminer:
	docker run --rm \
	--name adminer \
	--link $(DB_CONTAINER_NAME):db \
	--net $(NETWORK) \
	-p 8080:8080 \
	adminer

.PHONY: pma adminer
