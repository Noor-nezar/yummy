# Yummy

Yummy is a simple website used to show restaurant meals.

## Getting Started

To run the website make sure you have the prerequisites in your device then follow the running locally steps.

### Prerequisites

- PHP >= 7
- Mysql database
- Mysqli extension enabled

### Running Locally

1. In a directory where you will be working on this project, run the following command:

   ```sh
   git clone https://github.com/Noor-nezar/yummy.git
   ```

   This will create a folder called `yummy` that is the home directory of the website.

2. In this folder create new file named `env.php`, in this file put this content:
  
   ```php
   <?php
   $variables = [
      'DB_HOST' => 'your_db_host',
      'DB_USERNAME' => 'your_db_username',
      'DB_PASSWORD' => 'your_db_password',
      'DB_NAME' => 'your_db_name',
      'DB_PORT' => 'your_db_port',
   ];

   foreach ($variables as $key => $value) {
      putenv("$key=$value");
   }
   ```

   replace  `your_db_host`, `your_db_username`, `your_db_password`, `your_db_name`, `your_db_port` with your environment configurations.

   > You can use `env.example.php` file as an example.

3. In your terminal, cd into the directory you created in step 1 and run this command:

   ```sh
   php -S localhost:8000
   ```

4. Open [http://localhost:8000](http://localhost:8000/) in your browser and you should see the website.

## Admin Panel

Initially the meals are empty, you can add new meals by clicking on the admin link then you can use `admin@admin.com` as an email and `1234` as a password after login you will be redirected to the admin panel, after that you can create new meals.
