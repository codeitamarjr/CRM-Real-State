<?php

// Include config file
require "config/config.php";

//define max of results for pagination
$results_per_page = 15;  

//select all data from the mail_income sql
$query = "SELECT * FROM messages";
$result = mysqli_query($link,$query);

//find the total number of results
$number_of_result = mysqli_num_rows($result); 

//total number of pages in total
$number_of_page = ceil ($number_of_result / $results_per_page);  

//which page number visitor is currently on  
 if (!isset ($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = $_GET['page'];  
}  

 //determine the sql LIMIT starting number for the results on the displaying page  
 $page_first_result = ($page-1) * $results_per_page;  

 $query = "SELECT * FROM messages ORDER BY message_date DESC LIMIT " . $page_first_result . ',' . $results_per_page;  
 $result = mysqli_query($link, $query);  


 echo '            <div class="details">
 <!-- order details list -->
 <div class="recentOrders">
     <div class="cardHeader">
         <h2>Enquiries</h2>
         <a href="#" class="btn">View All</a>
     </div>
     <table>
         <thead>
             <tr>
                 <td>Email</td>
                 <td><img src="assets/icons/profile.svg" alt="Profile" height="30" width="30" /></td>
                 <td>Prospect Name</td>
                 <td>Date</td>
                 <td>Status</td>
             </tr>
         </thead>
         <tbody>'; // start a table tag in the HTML

//Start a table tag in the HTML
//Creates a loop to loop through results
while($row = mysqli_fetch_array($result)){   
    $message_id = htmlspecialchars($row['message_id']);

    echo "<tr><td><a href=\"dashboard.php?access=details&message_id=$message_id \">". htmlspecialchars($row['messages_email']) . "</a></td>
    <td>";
    //Check if the user fillout his data on prospect table, if so shows an clickable link to show his profile
    $message_hash = $row['message_hash'];
    $query_prospect = "SELECT * FROM prospect WHERE hash = '$message_hash'";
    $result_prospect = mysqli_query($link, $query_prospect);  
    while($row_prospect = mysqli_fetch_array($result_prospect)){
        $hash = $row_prospect['hash'];
        if (!empty($hash)){
            echo '<a href="dashboard.php?access=profile&key='.$hash.'"><img class="profile_icon" src="assets/icons/profile_fillout.svg" alt="Profile" height="30" width="30" /></a>';
        }
    };
    echo "</td>
    <td>" . htmlspecialchars($row['message_sender_name']) . "</td>
    <td>" . htmlspecialchars($row['message_date']) . "</td>
    <td><span class=\"status ". htmlspecialchars($row['status']) ."\">" . htmlspecialchars($row['status']) . "</span></td>
</tr>";  //$row['index'] the index here is a field name
}

echo '
</tbody>
</table>
</div>'; //Close the table in HTML

echo '<center>';
    //display the link of the pages in URL  
    for($page = 1; $page<= $number_of_page; $page++) {  
        echo '<a href = "dashboard.php?access=enquiries&page=' . $page . '">' . $page . ' </a>';  
    }  
    echo '</center>';

//Close SQL connection
mysqli_close($link); 

?>
