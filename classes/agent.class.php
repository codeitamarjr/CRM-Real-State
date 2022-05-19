<?php

class Agent extends Dbh{

    public function getAgent(){
        $sql = "SELECT * FROM estate_agent";
        $stmt = $this->connect()->query($sql);
        while($row = $stmt->fetch()){
            echo $row['agent_name'];
        }
    }

}