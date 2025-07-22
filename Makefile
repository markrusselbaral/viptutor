up:
	docker-compose up -d

down:
	docker-compose down

start:
	docker-compose start
	docker exec -it vip-tutor-frontend-1 sh -c "cd /var/www/app-frontend && npm run dev -- --host=0.0.0.0"

stop: 
	docker-compose stop

clearall:
	docker stop $(docker ps -q)
	docker rm $(docker ps -aq)
	docker rmi $(docker images -q)
