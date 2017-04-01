CONTAINER_NAME=myshop-local
RUNNING=$(docker inspect --format {{.State.Running}} ${CONTAINER_NAME} 2>/dev/null)

if [ "${RUNNING}" == "true" ]; then
    docker stop ${CONTAINER_NAME}
fi

echo "STOPPED"
