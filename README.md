# Doc24 > Medical turns challenge

To start you'll need to fork this repo. Once finish please submit a PR using the following format in the title:

`[your-name] - Doc24 backend challenge`

## Requirements

- PHP (Slim Framework)
- Composer
- PostgreSQL

## Installation

To install the project, follow these steps:

1. Clone the repository: `git clone <repository-url>`
2. Navigate into the project directory: `cd <project-directory>`
3. Install the dependencies: `composer install`

## Database

Feel free to name your DB as you want, we want to see you creating all schemas, models and tables you may think are necessary and feel free to come up with your own data structure. Keep it simple to a minimum structure of data as possible.

Add a seeder for the DB so we can actually test the app with some dummy data.

## Running the Application

To run the application, use the following command:

```bash
php -S localhost:[PORT] -t public
```

## What should I do?

You'll need to build a REST API that will allow users the following:

- Login and Logout.
- Once logged, create a CRUD endpont to manage medical turns.
- Medical turns should include an Institution (place), a Doctor, a day and a time.
- You cannot set 2 appointments for the same doctor at the same time or institutions.
- Feel free to create the folder structure you think will cover the requirements under `./src` folder.
- We want to see you validate authentication using a middleware and make sure only login is a public endpoint.
- Get the app ready to be tested by using Postman.
- Replace this README file to provide your own instructions on how to run the app, DB, seeder and provide a Postman collection to test the endpoints.
- Please use an ORM to interact with PostgreSQL.

## To have in mind

- Authentication must be done using JWT
- Use PostgreSQL as a database engine
- Try to write a clean code
- Use `.env` files to secure sensitive information