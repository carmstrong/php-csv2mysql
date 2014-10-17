#php-csv2mysql

Chris Armstrong
chris@chrisarmstrong.me
   
Converts CSV files to .SQL files, with a CREATE TABLE and INSERT statements for each row of the CSV.
Will automatically ignore columns that contain no data, and will make all columns type VARCHAR with a size equal to the length of that column's longest value.

## Instructions 
1. Replace the mysql connect database and password name the applicaion. 

### To Use

```bash
php csv_to_sql.php inputfile.csv outputfile.sql database_name
```

## Optional Commands  

### Disable automatically primary key to first column  
--nopk
