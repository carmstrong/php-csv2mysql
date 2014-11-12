#php-csv2mysql

**Note on most conditions it is much better to simply import the CSV file using the fast import which will get you done in seconds rather than minutes or hours**
  
**Reccomended sytnax with CSV import:**  
**_LOAD DATA LOCAL INFILE 'file.csv' INTO TABLE table   
FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'  
(@col1,@dummy,@col3) set  
EX1=@col1,EX2=@col3;_**

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
