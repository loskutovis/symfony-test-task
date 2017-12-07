Import
===========

A Symfony project that helps to import data from CSV file to database.
Using of the ParseCsv extension allows to avoid encoding issues and other problems of provided data.

In order to use this application you should:
1. Install requirements from composer.json
2. Apply migrations to your database
3. Run the application using cmd. Example:
   php bin/console app:import-test path_to_csv_file test_mode
   
   test_mode should be 0 for production and 1 for testing