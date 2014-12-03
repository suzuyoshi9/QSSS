 <?php
        include_once "db_interface/DatabaseClass.php";
        $db=new Database();
        $query = "select * from tag";
        $result=$db->query($query);
        $result->bind_result($tid,$t_name);
        while($result->fetch()){
           echo "<label>";
           echo '<input type="checkbox" name="tags[]" value=';
           echo $tid;
           echo ">";
           echo $t_name;
           echo "</label>\n";
        }
?>
