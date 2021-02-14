<?php

include ('server.php') ;
//Your Database Connection include file here.
//This Entire PHP part can be placed in a seperate action file

            //Upload File
            if (isset($_POST['submit'])) {
                //Upload Directory path.
                $uploaddir = 'uploads/';
                //FilePath with File name.
                $uploadfile = $uploaddir . basename($_FILES["filename"]["name"]);
                    //Check if uploaded file is CSV and not any other format.
                    
                    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $uploadfile)) {
                    echo "File Uploaded successfully";
                         }
                //Import uploaded file to Database
           
                $handle = fopen($uploadfile, "r"); //here "r" is used to give Read only permission.
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    
                        $array = array(

                            "date" => $data[0],
                             "year" => $data[1],
                             "month" => $data[2],
                             "day" => $data[3],
                            "time" => $data[4], // Just replace it with the keys in your collection
                            "location" => $data[5], 
                            "username" => $data[6],
                            "unit" => (double)$data[7]
                            // And increment the data[i] as per the number of values or coloumns in the csv files.
                        );
                    //Finally insert the data into your collection!
                        $collection6->insertOne($array);
                                    }
                        //close the file
                fclose($handle);
                echo "Import done";
                     

                
            }
echo date("Y-m-d",strtotime("yesterday"));

?>
                        <!--Simple Form(no css) to Upload the File-->
<html>
    <body>
         <form enctype='multipart/form-data' action='#' method='post'>
         File name to import:<br />

         <input size='50' type='file' name='filename'><br />

         <input type='submit' name='submit' value='Upload'></form>
    </body>
</html>