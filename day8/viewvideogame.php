<?php
#Page header
$siteTitle = 'View All Video Games';
$siteName = 'View all video games from my collection.';
$siteDescription = 'Here you see alle my video games.';

# Including the header.php file
include('includes/header.php');
?>

<?php
# Connecting to the database
include('includes/connectdb.php');

# Preparing a SQL - query with an INNER JOIN
$query = "SELECT videogames.title AS title, videogames.description AS description, videogames.price AS price, publishers.publishername AS publishername, platforms.platformname AS platformname FROM publishers INNER JOIN videogames ON publishers.id = videogames.publisherid INNER JOIN platforms ON videogames.platformid = platforms.id ORDER BY title";

# Executing SQL - Query
$result = mysqli_query($dbc, $query);

# if SQL-query OK (true) than display data records.
if ($result)
{
?>
   <!-- Table header -->
   <table class="table table-striped" id="showcontent">
       <thead>
           <tr>
               <th>Title</th>
               <th>Description</th>
               <th>Publisher</th>
               <th>Platform</th>
               <th>Price</th>
           </tr>
       </thead>
       <tbody>
       <?php
       # Fetch and print out all records from SQL-query
       while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
       {
       ?>
       <tr>
           <td><?php echo $row['title']; ?></td>
           <td><?php echo $row['description']; ?></td>
           <td><?php echo $row['publishername']; ?></td>
           <td><?php echo $row['platformname']; ?></td>
           <td><?php echo $row['price']; ?></td>
       </tr>   
       <?php
       }
       ?>
       </tbody>   
   </table> <!-- Closing table tag-->
   <?php
    mysqli_free_result($result); #Free up SQL ressources.
}
else # if the if-statement is not true then do this
{
    #Error message
    echo '<p class="error">The records could not be retrieved from the database.</p>';
    
    #Debugging message
    echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $query . '</p>';
}

#Closing database connection
mysqli_close($dbc);

# Including footer.php
include('includes/footer.php');
?>
    










