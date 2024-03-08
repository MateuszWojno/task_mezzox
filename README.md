Used tools
The application was developed using the Laravel 10 framework. MySQL database was used for data storage. The code was crafted in the PHPStorm editor. This application was built using Docker Compose, enabling easy deployment in isolated containers. Dockers are an ideal tool for managing the development environment without the need to configure a local setup. The software was developed using Test-Driven Development (TDD) methodology.

Application Features
The application is intended for library staff. It can be used by regular employees as well as administrators who have the highest privileges. Library employees can use the application to add customers and monitor the status of books, as well as track which customer has borrowed which book.

API Endpoints

GET api/customers - responsible for displaying customers, displaying the first name and last name of all customers

POST api/customers - responsible for creating a new customer, when creating, you must provide the first name and last name of the customer; if the data is correct, the customer will be created

DELETE api/customers/{id} - responsible for deleting a customer from the system, only an employee with admin permissions has the right to delete a customer

GET api/customers/{id} - responsible for displaying a single customer, along with a list of books they have borrowed

GET api/books - responsible for displaying books along with the data of the person who borrowed them, a maximum of 20 items can be displayed on one page

GET api/books/{id} - responsible for displaying detailed information about a single book along with its status and information about the person who borrowed it

POST api/books/customers/{customerId}/borrow-book{bookId} - responsible for borrowing books by a customer

POST api/books/customers/{customerId}/return-book{bookId} - responsible for returning a borrowed book by a customer

GET api/books{search} - responsible for searching for books, books can be searched by title, author, or by the first name and last name of the person who currently borrows the book

POST api/auth/login - responsible for logging in an employee to the system, you must provide an email and password

POST api/auth/register - responsible for adding a new employee to the system
