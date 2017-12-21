<?php
require '../vendor/autoload.php';
require '../includes/authconfig.php';

$newempname = $_REQUEST['newname'];
$supervisorname = $_REQUEST['supervisorname'];
$subject = 'New Employee (' . $newempname . ')';
$newcurremail = $_REQUEST['newcurremail'];
$newcurrphone = $_REQUEST['newcurrphone'];
$startdate = $_REQUEST['startdate'];
$uid = $_REQUEST['uid'];
$uclalogon = $_REQUEST['uclalogon'];
$tags = array('new-employee', str_replace(' ', '-', $newempname));
$assignee_email = '';

$description = "Several \"child\" tickets will be created as a result of this " 
             . "New Employee ticket." . "<br />New Employee Name: " . $newempname
             . "<br />New Employee Current Email Address: " . $newcurremail
             . "<br />New Employee Current Phone: " . $newcurrphone
             . "<br />New Employee Start Date: " . $startdate
             . "<br />New Employee UID: " . $uid
             . "<br />New Employee UCLA Logon: " . $uclalogon
             . "<br />New Employee Supervisor: " . $supervisorname;

// Child tickets array

$childtickets = array (
                    array(
                        "subject" => "New Employee ($newempname) Computer",
                        "comment" => array (
                                "html_body" => "Secure and prepare desktop computer for new employee. New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "assignee_email" => "cnguyen@psych.ucla.edu",
                        "group_id" => 61754),

                    array(
                        "subject" => "New Employee ($newempname) Distribution Lists",
                        "comment" => array (
                                "html_body" => "The supervisor of this new employee must ensure that the employee is subscribed to the appropriate departmental lists.  Contact the appropriate list owner named on the EM Distribution List (or Google Group or other list owner). Once the supervisor has confirmed that the subscriptions are complete, 
                                    the supervisor or Psych IT may close this ticket" . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 61754),

                    array(
                        "subject" => "New Employee ($newempname) Door Access",
                        "comment" => array (
                                "html_body" => "Please communicate with the new employee’s supervisor about the need for special door access.  Please grant that access."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 27055823),

                    array(
                        "subject" => "New Employee ($newempname) Email",
                        "comment" => array (
                                "html_body" => "Please provide the new employee’s current contact email address and UID.   We cannot create an email address for an employee until their UID is created." . 
                                    "<br />Current email address : $newcurremail" .
                                    "<br />UID: $uid"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 61754),

                    array(
                        "subject" => "New Employee ($newempname) Keys",
                        "comment" => array (
                                "html_body" => "Please provide the new employee with the necessary building and office/lab keys."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 27055823),

                    array(
                        "subject" => "New Employee ($newempname) Mailbox",
                        "comment" => array (
                                "html_body" => "Please setup a physical mailbox for the new employee."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 27055823),

                    array(
                        "subject" => "New Employee ($newempname) Name Plate",
                        "comment" => array (
                                "html_body" => "Please setup a physical mailbox for the new employee."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 27055823),

                    array(
                        "subject" => "New Employee ($newempname) Phone",
                        "comment" => array (
                                "html_body" => "Please update the telephone device for this new employee."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 27055823),

                    array(
                        "subject" => "New Employee ($newempname) Background Check",
                        "comment" => array (
                                "html_body" => "Please ensure that this employee’s background check is done at least 5 business days before the start date."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 24614866),

                    array(
                        "subject" => "New Employee ($newempname) Hiring Paperwork",
                        "comment" => array (
                                "html_body" => "Please ensure that this employee’s background check is done at least 5 business days before the start date."
                                    . "<br />New employee's supervisor is $supervisorname"),
                        "type" => "task",
                        "priority" => "Normal",
                        "tags" => $tags,
                        "group_id" => 24614866)                    
                    );
                    
try {
 	$newTicket = $client->tickets()->create([
        'type' => 'problem',
        'tags'  => $tags,
        'subject'  => $subject,
        'comment'  => array(
            'html_body' => $description
        ),
        'assignee_email' => $assignee_email,
        'group_id' => 27055823,
        'priority' => 'normal',
    ]);

    echo "<br />Tickets are created.";


    // Start create child ticket
    
    foreach ($childtickets as $childticket) {

        try {
            $newChildTicket = $client->tickets()->create($childticket);
            echo "<br />Ticket with Subject \"" . $childticket['subject'] . "\" has been created.";
        } catch (\Zendesk\API\Exeptions\ApiResponseException $e1) {
            echo $e1->getMessage().'</br>';
        } 

        
    }

} catch (\Zendesk\API\Exeptions\ApiResponseException $e) {
        echo $e->getMessage().'</br>';
}


?>
