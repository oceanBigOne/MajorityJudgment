demo1:
	docker run -it --rm --name demo1 -v $(shell pwd):/usr/src/samples -w /usr/src/samples php:7.4-cli php samples/demo1.php


