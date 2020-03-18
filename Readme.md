1. docker-compose up --build -d
2. backend/.env.example -> backend/.env
3. docker-compose exec backend composer install
4. docker-compose exec backend php artisan migrate
5. docker-compose exec backend php artisan key:generate
