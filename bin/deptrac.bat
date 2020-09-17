@echo off

call docker-compose run --rm php deptrac analyze --formatter-graphviz=true --formatter-graphviz-dump-image=var/dependency-graph.png
