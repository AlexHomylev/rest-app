FROM yiisoftware/yii2-php:7.2-apache

LABEL maintainer="MinIO Inc <dev@min.io>"

RUN apt-get update && apt-get install -y \
  apt-transport-https \
  apache2 \
  wget \
  curl \
  openssl \
  libssl-dev \
  libcurl4-openssl-dev \
  locate \
  libgeoip-dev \
  git \
  libxml2-utils \
  lsb-release \
  ca-certificates

RUN wget https://dl.min.io/server/minio/release/linux-amd64/minio
RUN chmod +x minio

ENV MINIO_ACCESS_KEY_FILE=access_key \
  MINIO_SECRET_KEY_FILE=secret_key \
  MINIO_KMS_MASTER_KEY_FILE=kms_master_key \
  MINIO_SSE_MASTER_KEY_FILE=sse_master_key \
  MINIO_UPDATE_MINISIGN_PUBKEY="RWTx5Zr1tiHQLwG9keckT0c45M3AGeHD6IvimQHpyRywVWGbP1aVSGav"

EXPOSE 9000

VOLUME ["/data"]