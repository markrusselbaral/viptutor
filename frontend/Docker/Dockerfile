# Use official Node.js 22 Alpine image
FROM node:22-alpine

ARG user=markrusselbaral
ARG uid=2000

RUN addgroup -g ${uid} ${user} && \
    adduser -D -u ${uid} -G ${user} ${user}

WORKDIR /var/www

# Change ownership
RUN chown -R ${user}:${user} /home/${user}

# Switch to the non-root user
USER ${user}

# Expose dev port
EXPOSE 5173

# Keep the container running so you can exec into it
CMD ["tail", "-f", "/dev/null"]
