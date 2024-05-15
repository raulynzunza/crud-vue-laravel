# Welcome to my CRUD project!

To setup the application, follow the instructions:

## Setup repository

- First, clone the repository in your local.
- When is clone, open your terminal and go into the folder that was clone.
- First run `composer install`.
- Then run `npm install`.
- Copy the `.env.example` file and paste it into the root of your project.
- Rename the paste file like this: `.env`.
- Paste this into the .env file: `VITE_APP_URL=http://127.0.0.1:8000/api` (adjust the .env file in case that port is already in use).

## Setup MySQL

- First, you need to make sure you have MySQL on your computer or you have it in a container, if not, install it and continue this instructions.
- Once you have MySQL on your computer, input your credentials into the .env file. Example:

```
DB_CONNECTION=mysql
DB_HOST={{ Host where is running MySQL, if it is on your computer, must be 127.0.0.1 }}
DB_PORT={{ Port where is running your MySQL }}
DB_DATABASE={{ Name of your database }}
DB_USERNAME={{ Your MySQL username }}
DB_PASSWORD={{ Your MySQL password }}
```

- When you have the correct credentials of your database, you will be able to run the migrations with this command: `php artisan migrate`.

## Run project

- Open a terminal and run `php artisan serve`.
- Open another terminal and run `npm run dev`.

## Run tests

- To run tests, run the command `php artisan test`

And that's it! Go to the APP_URL that appears on your second terminal and you will be on the page 👌