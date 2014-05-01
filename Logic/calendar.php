<?php
    require_once('config.php');
    include "getters.php";
?>
<?php
    /**Derek
     * @param None
     * @return Whether or not the addition was successful
     * @Caller Admin page
     * */
    function addNewCalendarEvent() {
        //Runs SQL query to add calendar event to database.
    }

    /**Derek
     * @param $event - The event to change
     * @return Whether or not the delete was successful
     * @Caller Admin page
     * */
    function deleteCalendarEvent($event) {
        //Runs SQL query to delete calendar event to database.
    }

    /**Derek
     * @param $event - The event to change, $field - the field to change, $newValue - The new value
     * @return Whether or not the modification was successful
     * @Caller Admin page
     * */
    function modifyCalendarEvent($event, $field, $newValue) {
        //Runs SQL query to modify the event in the database.
    }

    /**
     * @param None
     * @return None
     * @Caller Functions on this page
     * */
    function reloadCalendar() {
        //Implementation depends on what calendar system we use(Google calendar or maybe something else)

        //Basically just reloads the calendar with updated data from the database.
    }
?>
