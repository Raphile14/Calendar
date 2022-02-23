# Calendar

## NOTES:
- Before running the application, make sure to create a database table and input the database name at the project's .env file found at <strong> /backend/.env</strong>. 
- Routes for the Laravel API calls are found on the <strong>request.rest</strong> file.
- Frontend server is proxied to <strong>http://localhost:8000</strong> in package.json inside the frontend folder

<br>

# Commands for Frontend
### === To run the backend ===

    cd frontend
Change directory to the frontend first

<br>

    npm run dev
Run the frontend as a <strong>dev</strong> environment

<br>

    npm run start
Run the frontend as a <strong>production</strong> environment

<br>

# Commands for Backend

### === To run the backend ===
    
    cd backend
Change directory to the backend first

<br>

    php artisan serve
Command to run the backend server. User will need to perform

<br>

### === To migrate database table ===
    php artisan migrate
Command to migrate MySQL database