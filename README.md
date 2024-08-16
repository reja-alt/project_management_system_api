- **Title**: Project Task Management API.
- **Description**: This project is a RESTful API built with Laravel for managing projects and tasks. It includes user authentication, error handling, input validation, and rate limiting. The API is secured using Laravel Passport for authentication.

- **Features**:
    - CRUD operations for projects and tasks.
    - User authentication with Laravel Passport.
    - Error handling and input validation.
    - Rate-limiting to prevent abuse.
    
- **Prerequisites**:
    - PHP 7.4+
    - Composer
    - MySQL or any other database
    - Laravel 8.x
    - Node.js and NPM/Yarn (if applicable)

- **Prerequisites**:
  ## Installation

  1. **Clone the repository:**
     ```bash
     git clone [https://github.com/your-username/your-repository.git](https://github.com/reja-alt/project_management_system_api.git)
     cd project_management_system_api
     ```

  2. **Install dependencies:**
     ```bash
     composer install
     npm install && npm run dev # If using frontend assets
     ```

  3. **Set up the environment:**
     - Copy `.env.example` to `.env`:
       ```bash
       cp .env.example .env
       ```
     - Update the `.env` file with your database credentials and other configuration settings.

  4. **Generate application key:**
     ```bash
     php artisan key:generate
     ```

  5. **Run migrations:**
     ```bash
     php artisan migrate
     ```

  6. **Install Laravel Passport:**
     ```bash
     php artisan passport:install
     ```

  7. **Seed the database (optional):**
     ```bash
     php artisan db:seed
     ```

  8. **Serve the application:**
     ```bash
     php artisan serve
     ```
  ```

- **API Documentation**:
  Example:
  ```markdown
  ## API Endpoints

**Authentication:**
  - **POST /api/login**: Authenticate user and retrieve access token.
  - **POST /api/register**: Register a new user.

**Projects:**
  - **GET /api/projects**: Retrieve a list of all projects.
  - **POST /api/projects**: Create a new project.
  - **GET /api/projects/{project}**: Retrieve a specific project.
  - **PUT /api/projects/{project}**: Update a project.
  - **DELETE /api/projects/{project}**: Delete a project.

**Tasks:**
  - **GET /api/projects/{project}/tasks**: Retrieve a list of all tasks.
  - **POST /api/projects/{project}/tasks**: Create a new task.
  - **GET /api/projects/{project}/tasks/{task}**: Retrieve a specific task.
  - **PUT /api/projects/{project}/tasks/{task}**: Update a task.
  - **DELETE /api/projects/{project}/tasks/{task}**: Delete a task.

**SubTasks:**
  - **GET /api/tasks/{task}/subtasks**: Retrieve a list of all subtasks.
  - **POST /api/tasks/{task}/subtasks**: Create a new subtask.
  - **GET /api/tasks/{task}/subtasks/{subtask}**: Retrieve a specific subtask.
  - **PUT /api/tasks/{task}/subtasks/{subtask}**: Update a subtask.
  - **DELETE /api/tasks/{task}/subtasks/{subtask}**: Delete a subtask.

**Report Generate:**
    - **GET /api/projects/{projectId}/report**: Generate a specific project's task and subtask report.
    
**Error Handling:**

  Example:
  ```markdown
  ## Error Handling

  The API returns standardized error responses. Here are some examples:

  - **401 Unauthorized**: Returned when the user is not authenticated.
  - **404 Not Found**: Returned when a resource cannot be found.
  - **422 Unprocessable Entity**: Returned when validation fails.
  ```
**Rate Limiting:**

  Example:
  ```markdown
  ## Rate Limiting

  The API is rate-limited to prevent abuse. Users can make up to 60 requests per minute. If the limit is exceeded, a `429 Too Many Requests` response is returned.
  ```
**Deployment:**

  Example:
  ```markdown
  ## Deployment

  To deploy the application, ensure the following steps are completed:

  1. **Set up the production environment:**
     - Update the `.env` file with production settings.
     - Run migrations and install Laravel Passport.

  2. **Build assets:**
     ```bash
     npm run production
     ```

  3. **Set up a web server (e.g., Nginx, Apache):**
     - Point the server to the `public` directory of the application.

  4. **Optimize the application:**
     ```bash
     php artisan optimize
     php artisan config:cache
     php artisan route:cache
     php artisan view:cache
     ```
  ```

  ```
