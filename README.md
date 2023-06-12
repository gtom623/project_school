
# Project "School"

## Introduction

This repository contains the source code for the Project School application, which is built using CakePHP and is configured to run in a Docker environment.

## Features

1. **Student Management**: Ability to add, edit, delete, and browse information about students.
2. **Teacher Management:**: Ability to add, edit, delete, and browse information about teachers.
3. **Class Management**: Ability to add, edit, delete, and browse information about classes.
4. **Data Retrieval API**: The application provides an API that allows retrieving information about teachers and students in JSON format.
5. **API Documentation with Swagger UI**: The application includes a Swagger UI interface that allows browsing and testing API endpoints in a user-friendly manner. Users can browse the available API resources, request and response structures, as well as execute requests directly from the Swagger UI interface.

## Requirements

- PHP >= 8.2.0
- MySQL version 10.4.27-MariaDB
- Composer

## 1 Installation (first installation method)

### Step 1: Clone the repository to your server or local development environment.
    ```
    git clone https://github.com/gtom623/project_school.git
    cd project_school
    ```
### Step 2: Install dependencies using Composer
    ```
    composer install
    ```
### Step 3: Create a MySQL user and database with phpMyAdmin
    ```
    CREATE USER 'school'@'localhost' IDENTIFIED BY 'school';
    CREATE DATABASE school_db;
    GRANT ALL PRIVILEGES ON school_db.* TO 'school'@'localhost';
    FLUSH PRIVILEGES;
    
    ```
### Step 4: Configure the database connection by editing the `config/app_local.php`.
 
 !!Change the host field to localhost!!
 
   'Datasources' => [
        'default' => [
        'host' => 'school-db',   => 'localhost'
        'port' => 3306,
        'username' => 'school',
        'password' => 'school',
        'database' => 'school_db',
    ]
   ]
### Step 5: Run the migrations to create the tables in the database.
    ```
    bin/cake migrations migrate
    ```
### Step 6: Start the development server.
    ```
    bin/cake server
    ```

## Usage

After starting the server, open your browser and go to `http://localhost:8765` to access the application.

## 2 Docker Installation  (second installation method)

## Requirements

- [Docker](https://www.docker.com/products/docker-desktop)


## How to Run

### Step 1: Clone the repository

Clone this repository onto your local machine using git. Open the terminal and enter:

```
git clone https://github.com/gtom623/project_school.git
cd project_school
```
### Step 2: Build and run the containers

In the repository directory, where the docker-compose.yml file is located, use the docker-compose command to build and run the containers:
```
docker-compose up --build
```
The --build flag is used to build the images before running the containers.

Docker will create 3 containers:

 ✔ Container school-db                                                                                    
 ✔ Container project_school-phpmyadmin-1                                                                          
 ✔ Container project_school-school-1        

### Step 3: Run migrations to recreate the database structure
```
  docker exec project_school-school-1  bin/cake migrations migrate
```
### Step 4: Open the application in your browser

After the containers are up and running, your application should be accessible in the browser. Open your browser and go to:
```
aplication homepage                                 -  http://localhost:8765
phpmyadmin   (school_db user: school pass:school)   -  http://localhost:8080
```

### Stopping the Application
To stop the application and remove the containers, open the terminal, navigate to the repository directory, and use the following command
```
docker-compose down
docker rmi project_school-school mysql phpmyadmin/phpmyadmin
```