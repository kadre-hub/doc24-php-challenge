# Doc24 > Medical turns challenge

## Things to consider
1. I have used Laravel 10 as the framework instead of Slim, because I have never used Slim before.
2. Before running the project, you have to create a database on your own. I have developed the project in a dockerized environment, so I have not created the database manually. You can use the .env.dev file, it has the credentials for the database I used.
3. The file '.env.example' has the credentials for the database I used.


## Steps to run the project:
1. Run `composer install`
2. Run `php artisan serve` - The project should be running on http://localhost:8000
3. Run `php artisan migrate:fresh --seed` - This will create the tables and seed the database.
4. The file: 'Doc24.postman_collection' contains the requests to test the API. You can import it in Postman. Remember to save the bearer token after the login request. The token is saved as a variable in the Doc24 folder.


## For the usage:
- The date format is 'Y-m-d'. Example: 2020-12-31.
- The time format is 'H:i'. Example: 12:00.
- You can not select a turn in the past.
- You can choose only one turn per hour.


## Things to complete.
- In the collection of the API, we could complete with all the test cases of for the function add, update and delete. Test the sharp cases and the errors.
I did not complete them because I did not want to be redundant.
