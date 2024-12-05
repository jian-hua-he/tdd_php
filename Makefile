# Variables
APP_NAME = php-dev
CONTAINER_NAME = $(APP_NAME)-container
IMAGE_NAME = $(APP_NAME)-image

# Build the Docker image
.PHONY: build
build:
	docker build -t $(IMAGE_NAME) .

# Run the container with current directory mounted
.PHONY: run
run: build
	docker run -d \
		--name $(CONTAINER_NAME) \
		-v $(PWD):/var/code \
		$(IMAGE_NAME) \
		tail -f /dev/null

.PHONY: exec
exec: run
	docker exec -it $(CONTAINER_NAME) /bin/bash

# Stop and remove the container and image
.PHONY: destroy
destroy:
	-docker stop $(CONTAINER_NAME)
	-docker rm $(CONTAINER_NAME)
	-docker rmi $(IMAGE_NAME)

# List all commands
.PHONY: help
help:
	@echo "Available commands:"
	@echo "  build   - Build the Docker image"
	@echo "  run     - Run the container with current directory mounted"
	@echo "  exec    - Run a custom command in the container"
	@echo "  destroy - Stop and remove the container and image"
	@echo "  help    - Show this help message"
