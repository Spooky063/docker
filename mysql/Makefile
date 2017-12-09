DB_CONTAINER_NAME := db
NETWORK := $(shell docker inspect $(DB_CONTAINER_NAME) -f "{{json .HostConfig.NetworkMode }}")

phpmyadmin:
	docker run --rm --link $(DB_CONTAINER_NAME):db --net $(NETWORK) -p 8080:80 phpmyadmin/phpmyadmin

.PHONY: phpmyadmin
