# CV Project

#### Project Name: Website Statistics Collection from Providers

#### Description:
This project is an application designed to collect statistical data from various websites using APIs provided by different providers. The main functionalities include:

- Integration with various provider APIs to obtain website statistics.
- Processing and storing the received data using the repository pattern, allowing flexibility in data storage and retrieval from different sources.
- Providing data through an API for other systems and users.
- Swagger documentation for all available routes and endpoints.
- Error handling and logging to ensure system reliability.

#### Key Features:
1. **Provider API Integration**: Ability to connect and interact with multiple APIs to gather statistics.
2. **Data Storage and Retrieval**: Using the repository pattern to store and retrieve data, allowing for flexibility in data sources (e.g., databases, file systems, external services).
3. **Data Provision**: API to access the collected statistics.
4. **Documentation**: Auto-generated Swagger documentation for ease of API usage.
5. **Error Handling**: Logging and handling errors to ensure the application's robust operation.
6. **Feature Tests**: Examples for testing core functionalities and routes.

#### Repository Pattern Implementation
The repository pattern is used to abstract the data access logic and business logic, allowing the application to use different data sources seamlessly. This implementation supports data management for the following entities:

1. **Site Repository**: Handles data operations for the `Site` entity.
2. **Provider Repository**: Manages interactions with various provider APIs and handles data for the `Provider` entity.
3. **Statistic Repository**: Manages the collection and storage of statistical data from various sources for the `Statistic` entity.

By using the repository pattern, this project ensures that the data layer is flexible and easily extensible, promoting cleaner architecture and easier maintenance.

#### Technology Stack:
- **Backend**: Laravel
- **Documentation**: Swagger
- **Database**: MySQL/PostgreSQL
- **Testing**: PHPUnit

# Laravel Project Deployment Guide

This guide provides step-by-step instructions for deploying a CV project. Follow these steps to get your project up and running.

## Prerequisites

Ensure you have the following installed on your local machine:
- Docker
- Docker Compose
- Composer

## Steps to Deploy the Project

1. **Clone the Repository**

   Clone the project repository to your local machine using the following command:
   ```bash
   git clone https://github.com/ShevtsovTN/cv-project.git
   cd cv-project
   ```

2. **Install Dependencies**

   Install the project dependencies using Composer:
   ```bash
   composer install
   ```

3. **Copy Environment File**

   Copy the `.env.example` file to create a new `.env` file:
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**

   Generate a new application key for the Laravel application:
   ```bash
   php artisan key:generate
   ```

5. **Configure Environment Variables**

   Open the `.env` file and configure the necessary environment variables, including database connection settings. Ensure the database credentials match your local or Dockerized database setup.

6. **Start Laravel Sail**

   Start the Laravel Sail environment:
   ```bash
   ./vendor/bin/sail up -d
   ```

7. **Run Migrations and Seeders**

   Once the containers are up and running, run the following command to refresh the database and seed it with data:
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```

8. **Access the Application**

   Open your web browser and navigate to `http://localhost` to access the Laravel application.

## Additional Commands

Here are some additional commands you might find useful while working with Laravel Sail:

- **Stop Sail Environment**
  ```bash
  ./vendor/bin/sail down
  ```

- **Execute Artisan Commands**
  To execute any artisan command within the Sail environment, prefix it with `./vendor/bin/sail`. For example:
  ```bash
  ./vendor/bin/sail artisan migrate
  ```

- **Access Container Shell**
  To access the shell of the running container:
  ```bash
  ./vendor/bin/sail shell
  ```

## Troubleshooting

- **Database Connection Issues**
  Ensure that the database credentials in your `.env` file match the settings in the `docker-compose.yml` file.

- **Docker Issues**
  Ensure Docker and Docker Compose are running correctly on your system. Restart Docker if necessary.

For further assistance, refer to the [Laravel Sail documentation](https://laravel.com/docs/sail) or the [Laravel documentation](https://laravel.com/docs).

---

By following this guide, you should be able to deploy and run your Laravel project successfully. If you encounter any issues, refer to the troubleshooting section or consult the Laravel documentation for more detailed information.
