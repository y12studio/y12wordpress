Nginx Reverse Proxy



how to inject Gruntfile.js
```
$ grunt dk-build:test/ng
$ nano Gruntfile.js.inject
// inside container # grunt cat:/root/package.json
$ grunt yrunt:test/ng --target=cat:/root/package.json
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
      dk-build  build docker image
      dk-yrunt  run grunt in container, ex grunt dk-yrunt:test/im
                --target=cat:/root/package.json
 dk-brun-basic  stop, build and run basic docker image
   dk-stop-all  Stop all docker container
       dk-psip  docker ps and ip
      dk-clean  Alias for "exec:dk_rm", "exec:dk_rmi" tasks.
       default  Alias for "exec:grunt_help" task.

```

grunt in container

```
Available tasks
         clean  Clean files and folders. *
          exec  Execute shell commands. *
         watch  Run predefined tasks whenever watched files change.
           zip  Zip files together *
         unzip  Unzip files into a folder *
        concat  Concatenate files. *
           cat  cat file
      test arg  test
       default  Alias for "exec:grunt_help" task.

```