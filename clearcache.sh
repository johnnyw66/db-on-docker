docker container exec $(docker container ls -q --filter name=redis) redis-cli flushdb async
