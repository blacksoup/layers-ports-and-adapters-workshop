@echo off

call docker-compose run --rm php deptrac analyze --formatter-graphviz-dump-image=var/dependency-graph.png
