#/bin/bah

git fetch
git checkout master
git reset --hard origin/master
git pull origin master

pwd=`pwd`

rm -rf .env
rm -rf var/cache
mkdir -p var/cache

ANGULAR_HASH=`cat $pwd/public/dist/ANGULAR_HASH.txt`

cat >> .env <<EOL
APP_ENV=prod
APP_SECRET=785acb814ee00d0bc0cc314ff05372823f96bdcf
DATABASE_URL="mysql://root:root@127.0.0.1:8889/blize?serverVersion=5.7"
MONGODB_URL=mongodb://127.0.0.1:27017
MONGODB_DB=blize
RSA_SECRET_KEY=%kernel.project_dir%/config/rsa/private.key
RSA_PUBLIC_KEY=%kernel.project_dir%/config/rsa/public.crt
UPLOADED_IMAGES_PATH=/files/images
SOCKET_REDIS_HOST=127.0.0.1
SOCKET_REDIS_PORT=6379
SOCKET_CONNECTION_URL=https://socket.blize.xyz
ANGULAR_HASH=$ANGULAR_HASH
EOL

echo ".env created"

composer install


