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
	docker run -it --rm \
		--name $(CONTAINER_NAME) \
		-v $(PWD):/code \
		$(IMAGE_NAME) \
		/bin/bash

# Stop and remove the container and image
.PHONY: destroy
destroy:
	docker rmi $(IMAGE_NAME)

# List all commands
.PHONY: help
help:
	@echo "Available commands:"
	@echo "  build   - Build the Docker image"
	@echo "  run     - Run the container with current directory mounted"
	@echo "  destroy - Stop and remove the container and image"
	@echo "  help    - Show this help message"
