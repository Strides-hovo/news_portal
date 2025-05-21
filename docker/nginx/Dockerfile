FROM nginx:alpine

# Add user and group for nginx
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -h /home/laravel -D laravel

# Create laravel directory and set ownership
RUN mkdir -p /var/www/laravel && \
    chown -R laravel:laravel /var/www/laravel

# Set working directory
WORKDIR /var/www/laravel

# Copy default nginx configuration
COPY ./default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]