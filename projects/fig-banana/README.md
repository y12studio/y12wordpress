
## ref

[fig/wordpress.md at master · docker/fig](https://github.com/docker/fig/blob/master/docs/wordpress.md)

[nikolaplejic/docker.hhvm](https://github.com/nikolaplejic/docker.hhvm)

[jeffutter/wordpress-hhvm-docker](https://github.com/jeffutter/wordpress-hhvm-docker)

## fig install

TODO : fix mysql remote access issue (--skip-name-resolve?)
[orchardup/mysql Repository | Docker Hub Registry - Repositories of Docker Images](https://registry.hub.docker.com/u/orchardup/mysql/)

MYSQL_ROOT_PASSWORD pass issue.


```
sudo pip install -U fig
$ sudo fig up
client and server don't have same version (client : 1.12, server: 1.11)
$ curl -sL https://get.docker.io/ | sh
$ sudo fig up
Creating figbanana_db_1...
Pulling image orchardup/mysql...
ab3b99429ab1: Pulling dependent layers

browser to http://localhost:8080/
show Error establishing a database connection

fig console show
db_1  | 140815  9:53:35 [Warning] IP address '172.17.0.9' could not be resolved: Name or service not known

```


## test round1 without wordpress

```
docker build -t=test/fig .
docker run -d -p 8080:80 test/fig
curl http://localhost:8080
```