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
APP_ENV=dev
APP_SECRET=d26646463528db4c11d4facb7f159d07

DATABASE_URL="mysql://blize:blize@host.docker.internal:3306/blize?serverVersion=8.0.32&charset=utf8mb4"
MONGODB_URL=mongodb://host.docker.internal:27017
MONGODB_DB=blize
SOCKET_REDIS_HOST=host.docker.internal
SOCKET_REDIS_PORT=6379
RSA_SECRET_KEY=%kernel.project_dir%/config/rsa/private.key
RSA_PUBLIC_KEY=%kernel.project_dir%/config/rsa/public.crt
UPLOADED_IMAGES_PATH=/files/images
SOCKET_CONNECTION_URL=http://localhost:3000
ANGULAR_HASH=$ANGULAR_HASH
EOL

echo ".env created"

composer install


