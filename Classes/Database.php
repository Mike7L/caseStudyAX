<?php
/**
 * DatabaseClass
 */
class Database {
    
    /**
     * Creates database connection
     * @param Version $version
     */
    public function __construct($version) {

        $con=mysqli_connect("localhost:3306","root","","schwacke");
        // Check connection
        if (mysqli_connect_errno()) {
            throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
        };

        $result = mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) == 1) {
          $message = "The data was successfully added!";
        } else {
          $message = "The user update failed: ";
          $message .= mysqli_error($con); 
        };

        echo $message;
        mysqli_close($con);
    }
}
