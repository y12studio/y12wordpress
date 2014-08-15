
## ref

[fig/wordpress.md at master · docker/fig](https://github.com/docker/fig/blob/master/docs/wordpress.md)

[nikolaplejic/docker.hhvm](https://github.com/nikolaplejic/docker.hhvm)

[jeffutter/wordpress-hhvm-docker](https://github.com/jeffutter/wordpress-hhvm-docker)

## test round1 without wordpress

docker build -t=test/fig .
docker run -d -p 8080:80 test/fig
curl http://localhost:8080