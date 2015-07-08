# sql-to-json
	This is a php program which connects to a mysql database and produce json encoded data from the database based on the query provided in time of calling the page


## Usage Guide
### Setup

You have to provide the database details inside the fetch.php file as follows
```
  $host = "localhost";
	$user = "root";
	$password = "";
	$databaseName = "world-db";
```




### How to run
You have to call the page from apache web server using any browser. The case to call option for the page is as follows

```	
http://localhost/fetch.php
```

### The output

Above call will return all of the table's data from the provided world-db as JSON data

```	
http://localhost/fetch.php?limit=10
```

### The output

Above call will return all of the table's first 10 data from the provided world-db as JSON data

```	
http://localhost/fetch.php?table=city&limit=10&order=asc&sort=Name
```

### The output

Above call will return "city" table's first 10 data order by "Name" ascendically from the provided world-db as JSON data
			
```	
http://localhost/fetch.php?table=city&limit=10
```

### The output

Above call will return "city" table's first 10 data from the provided world-db as JSON data			
