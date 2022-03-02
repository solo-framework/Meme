#!/usr/bin/env bash

echo Building MEME phar

TAG=$(date +%Y%m%d-%H%M%S)   # Альтернативный вариант.
sed -i "s/%VERSION%/${TAG}/g" ./bin/meme
./box.phar build