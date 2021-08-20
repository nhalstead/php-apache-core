#!/usr/bin/env bash
set -eo pipefail

# Allow early Exit if IMAGE_PATH does note exist.
if [ "" == "$IMAGE_PATH" ] ; then exit 0; fi

pwd

# Build Image
docker build --pull --no-cache -t $IMAGE_PATH:$TAG_PREFIX$CIRCLE_BUILD_NUM .

docker login -u $DOCKER_USER -p $DOCKER_PASS

# Add latest tag and branch build number tag
docker tag $IMAGE_PATH:$TAG_PREFIX$CIRCLE_BUILD_NUM $IMAGE_PATH:${CIRCLE_BRANCH}_${TAG_PREFIX}${CIRCLE_BUILD_NUM}
docker tag $IMAGE_PATH:$TAG_PREFIX$CIRCLE_BUILD_NUM $IMAGE_PATH:${TAG_PREFIX}latest
docker tag $IMAGE_PATH:$TAG_PREFIX$CIRCLE_BUILD_NUM $IMAGE_PATH:latest_${TAG_PREFIX}${CIRCLE_BRANCH}

# Deploy image to Docker Hub
docker push $IMAGE_PATH:${CIRCLE_BRANCH}_${TAG_PREFIX}${CIRCLE_BUILD_NUM}
docker push $IMAGE_PATH:${TAG_PREFIX}latest
docker push $IMAGE_PATH:latest_${TAG_PREFIX}${CIRCLE_BRANCH}
