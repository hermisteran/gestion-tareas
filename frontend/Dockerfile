FROM node:20 AS build

ARG VITE_API_URL

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .

RUN VITE_API_URL=$VITE_API_URL npm run build

FROM nginx:alpine


COPY --from=build /app/dist /usr/share/nginx/html

# Exponer puerto 80
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
