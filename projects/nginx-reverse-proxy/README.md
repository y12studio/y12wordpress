Nginx Reverse Proxy

how to boot nginx

```
$ grunt dk-build:test/ng
$ grunt yrunt:test/ng:8080 --target=start
$ grunt yrunt:test/ng:8081 --target=start
$ grunt yrunt:test/ng:8082 --target=start
$ curl http://localhost:8080
$ curl http://localhost:8081
$ curl http://localhost:8082
$ grunt dk-psip
Running "exec:dk_ps" (exec) task
CONTAINER ID        IMAGE               COMMAND             CREATED             STATUS              PORTS                  NAMES
9dc04f57506f        test/ng:latest      /yrunt.sh start     2 minutes ago       Up 2 minutes        0.0.0.0:8082->80/tcp   stoic_galileo
bf8c716a4d53        test/ng:latest      /yrunt.sh start     2 minutes ago       Up 2 minutes        0.0.0.0:8081->80/tcp   berserk_bohr
fbac9ffbd7be        test/ng:latest      /yrunt.sh start     2 minutes ago       Up 2 minutes        0.0.0.0:8080->80/tcp   backstabbing_ritchie

Running "exec:dk_ip" (exec) task
/stoic_galileo 172.17.0.4
/berserk_bohr 172.17.0.3
/backstabbing_ritchie 172.17.0.2
```

how to inject Gruntfile.js
```
$ nano Gruntfile.js.inject
// inside container # grunt cat:/root/package.json
$ grunt yrunt:test/ng:8099 --target=cat:/root/package.json
```

grunt task
```
Available tasks
         clean  Clean files and folders. *
          exec  Execute shell commands. *
         watch  Run predefined tasks whenever watched files change.
           zip  Zip files together *
         unzip  Unzip files into a folder *
        concat  Concatenate files. *
         shell  Run shell commands *
      dk-build  build docker image
         yrunt  run grunt in container, ex grunt yrunt:test/img:80
                --target=start
    dk-stopall  Stop all docker container
       dk-psip  docker ps and ip
      dk-clean  Alias for "exec:dk_rm", "exec:dk_rmi" tasks.
       default  Alias for "exec:grunt_help" task.
```