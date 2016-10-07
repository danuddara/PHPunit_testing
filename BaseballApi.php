<?php
namespace stats;
class BaseballApi
{
    public function submitAtBat($playerid,$result)
    {
        //insert at bat in database
        return true;
    }
    
    public function showAllStats($playerid)
    {
        //if this were an inaccessible external api we could also mock
        //select updated batting average
        $avg =.234;
        return true;
        
    }
}



