FROM node:13-alpine

RUN apk add --no-cache python make g++

WORKDIR /frontend

USER node

EXPOSE 8080

CMD ["sh", "-c", "npm ci && npm run serve"]
