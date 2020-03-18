#!/bin/bash

# Run scheduler
while [ true ]
do
  php /backend/artisan schedule:run --verbose --no-interaction
  sleep 60
done
