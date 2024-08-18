## USERS DASHBOARD

## to run this project, run the following commands

`npm install`

## Keep the build watch for tailwind running

`npx tailwindcss -i ./styles.css -o ./public/css/tailwind.css --watch`

## To Run the server

`php -S localhost:8080`

## To navigate the routes found in "index.php"

`localhost:8080/?page=${route}` -> `http://localhost:8080/?page=login`

---

## ROUTES:

-   **HOME** -> /?page=home -> Protected, must login
-   **Login** -> /?page=login
-   **Register** -> /?page=register

---
