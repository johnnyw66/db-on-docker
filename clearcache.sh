docker container exec $(docker container ls -aq --filter name=redis) redis-cli flushdb async
