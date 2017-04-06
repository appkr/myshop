CONTAINER_NAME=myshop-local
IMAGE_NAME="appkr/myshop:local"
EXISTS=$(docker inspect --format {{.State.Status}} ${CONTAINER_NAME} 2>/dev/null)
RUNNING=$(docker inspect --format {{.State.Running}} ${CONTAINER_NAME} 2>/dev/null)

if [  "${RUNNING}" == "true" ];then
    echo "Container is already running."
    echo ""
    exit 0
fi

rm -rf `pwd`/docker-mount-point/*.pid `pwd`/docker-mount-point/*.err

if [ "${EXISTS}" == "exited" ]; then
    docker start ${CONTAINER_NAME}
else
    docker run --detach \
        --name ${CONTAINER_NAME} \
        --publish 8000:80 \
        --publish 9001:9001 \
        --publish 9999:9999 \
        --publish 3306:3306 \
        --publish 6379:6379 \
        --volume `pwd`:/var/www/html \
        --volume `pwd`/docker-mount-point:/var/lib/mysql \
        ${IMAGE_NAME}
fi

sleep 5

docker exec -it ${CONTAINER_NAME} bash /make_pid.sh
