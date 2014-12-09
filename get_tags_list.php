<?php
        include_once "db_interface/DatabaseClass.php";
        $db=new Database();
        $query = "select * from tag";
        $result=$db->query($query);
        $result->bind_result($tid,$t_name);
        while($result->fetch()){
           echo "<li>";
           echo '<a href=tag_search.php?tid=';
           echo $tid;
           echo ">";
           echo $t_name;
           echo "</a></li>\n";
        }
?>
