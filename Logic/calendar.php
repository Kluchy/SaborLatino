<?php
    require_once('config.php');
    include "getters.php";
?>
<?php
    /**Derek
     * @param $eventInfo - Array of information to be added to the performances table to signify an added new event.
     * @return Whether or not the addition was successful
     * @Caller Admin page
     * */
    function addNewCalendarEvent($eventInfo) {
        //First, split up the array $eventInfo into a query string that will add the event
        //to the database.
        
        //Runs SQL query to add calendar event to database.
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
?>
