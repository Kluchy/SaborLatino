<?php
    require_once('../Database/config.php');
    include_once "../Database/getters.php";
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata');
    Zend_Loader::loadClass('Zend_Gdata_AuthSub');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
    Zend_Loader::loadClass('Zend_Gdata_Calendar');

?>
<?php
    
    /**Derek
     * @param None
     * @does: Prints a HTML string that displays the embedded calendar
     * @Caller Events page
     * */
    function displayGoogleCalendar() {
        echo '<div id="calendar"><iframe src="https://www.google.com/calendar/embed?src=saborlatinoeventscal%40gmail.com&ctz=America/New_York" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe></div>';
    }

    /**Derek
     * @param $eventInfo - Array of information to be added to the performances table to signify an added new event.
     * @return Whether or not the addition was successful
     * @Caller Admin page
     * */
    function addNewCalendarEvent($eventInfo, $client) {

        $gdataCal = new Zend_Gdata_Calendar($client);
        $newEvent = $gdataCal->newEventEntry();

        if(isset($eventInfo["performancetitle"])) {
            $title = $eventInfo["performancetitle"];
            $newEvent->title = $gdataCal->newTitle($title);
        }
        if(isset($eventInfo["performanceLocation"])) {
            $location = $eventInfo["performanceLocation"];
            $newEvent->where = array($gdataCal->newWhere($location));
        }
        if(isset($eventInfo["performanceDate"])) {
            $when = $gdataCal->newWhen();
            $date = $eventInfo["performanceDate"];
            $startTime = $eventInfo["startTime"];
            $endTime = $eventInfo["endTime"];
            echo $startTime.'<br>';
            echo $endTime;
            $when->startTime = "{$date}T{$startTime}:00";
            $when->endTime = "{$date}T{$endTime}:00";
            $newEvent->when = array($when);
        }

        $gdataCal->insertEvent($newEvent);

        
    }

    /**Derek
     * @param $event - The event to change. This will be equal to an idPerformances.
     * @return Whether or not the delete was successful
     * @Caller Admin page
     * */
    function deleteCalendarEvent($event) {
        //Runs SQL query to delete calendar event to database.
    }

    /**Derek
     * @param $event - The event to change. This will be equal to an idPerformances., $field - the field to change, $newValue - The new value
     * @return Whether or not the modification was successful
     * @Caller Admin page
     * */
    function modifyCalendarEvent($event, $field, $newValue) {
        //Runs SQL query to modify the event in the database.
    }

    /**
     * @param None
     * @return None
     * @Caller Events page
     * */
    function reloadCalendar() {
        //Implementation depends on what calendar system we use(Google calendar or maybe something else)

        //Basically just reloads the calendar with updated data from the database.
    }

    /**
     *Derek
     * @param None
     * @return An HTML string that displays calendar events
     * @Caller Events page
     * */
    function displayCalendarEvents() {
        $pastEventsQuery = 'SELECT * FROM Performances WHERE performanceDate < CURDATE() LIMIT 5';
        $todayEventsQuery = 'SELECT * FROM Performances WHERE performanceDATE = CURDATE()';
        $futureEventsQuery = 'SELECT * FROM Performances WHERE performanceDate > CURDATE()';

        $pastEvents = retrieve($pastEventsQuery); 
        $todayEvents = retrieve($todayEventsQuery);
        $futureEvents = retrieve($futureEventsQuery);

        $pastEvents = $pastEvents[0];
        $todayEvents = $todayEvents[0];
        $futureEvents = $futureEvents[0];

        $pastString = '<ul class = "past">';
        $todayString = '<ul class = "today">';
        $futureString = '<ul class = "future">';

        $pastString = $pastString. generateEventString($pastEvents). '</ul>';
        $todayString = $todayString. generateEventString($todayEvents). '</ul>';
        $futureString = $futureString. generateEventString($futureEvents). '</ul>';

        $finalString = '<h2>Upcoming events</h2>'.$futureString.'<h2>Events today</h2>'.$todayString.'<h2>Past events</h2>'.$pastString;

        return $finalString;

    }

    /**
     * Derek
     * @param events -> The records of events to generate an events string for
     * @return A string that displays events in a list
     * @Caller function displayCalendarEvents */ 
    function generateEventString($events) {
        $eventString = "";
        foreach($events as $event) {
            $eventString = $eventString. '<li>Date: '.$event['performanceDate'].'<br/> Title: '.$event['performanceTitle'].' <br/>
                Location: '.$event['performanceLocation'].'</li>';
        }
        return $eventString;

    }

?>
