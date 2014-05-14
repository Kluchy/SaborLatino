<?php
function getEvent($client, $eventId)
{
  $gdataCal = new Zend_Gdata_Calendar($client);
  /*$query = $gdataCal->newEventQuery();
  $query->setUser('default');
  $query->setVisibility('default');
  $query->setProjection('full');
  $query->setOrderby("starttime");
  /*$query->setEvent($gdataCal->newID($eventId));
  $query->setStartMin('2014-06-01');
  $query->setStartMax('2014-06-07');*/
  echo $eventId;

    $eventEntry = $gdataCal->getCalendarEventFeed();
  /*try {
    //print_r($eventEntry);
    //return $eventEntry;
  } catch (Zend_Gdata_App_Exception $e) {
      echo "SUP";
    //return null;
  }*/
}
?>
