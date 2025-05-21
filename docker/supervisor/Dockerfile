FROM app_php
USER root

# ставим supervisor
RUN apt-get update \
 && apt-get install -y --no-install-recommends supervisor \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/laravel
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY conf.d/       /etc/supervisor/conf.d/

# воркеры от пользователя www-data (или laravel)
RUN chown -R www-data:www-data /etc/supervisor /var/www/laravel

CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
