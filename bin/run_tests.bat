@echo off

call docker-compose up -d
call docker-compose run --rm php sh -c "./run_tests.sh"
