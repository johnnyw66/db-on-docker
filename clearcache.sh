# clear redis cache on running 'redis' container
docker container exec $(docker container ls -q --filter name=redis) redis-cli flushdb async
#docker container exec $(docker container ls -q --filter name=redis) redis-cli flushall async
