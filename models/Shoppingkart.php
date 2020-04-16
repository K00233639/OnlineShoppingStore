<?php

/**
 * Class: Student
 * 
 * This class interfac3s between the application and the Students table in the database
 * 
 * It handles both logged in and not logged in users
 * It prepares a student enquiry form for Panel 1
 * It handles two types of query and prepares the results for Panel 2
 * 1. Student Enquiry - Presents the result of the studnet enquiry by Student ID. The result also contains a BUTTON which can be used to generate a student transcript.
 * 2. Student Transcript - When a valid student enquiry result is displayed - a TRANSCRIPT button can be used to generate the selected student's transcript.
 *
 * @author gerry.guinane
 * 
 */
class Shoppingkart extends Model {

    //class properties
    private $db;                //MySQLi object: the database connection ( 
    private $user;
    private $pageTitle;         //String: containing page title
    private $pageHeading;       //String: Containing Page Heading
    private $postArray;         //Array: Containing copy of $_POST array
    private $panelHead_1;       //String: Panel 1 Heading
    private $panelHead_2;       //String: Panel 2 Heading
    private $panelHead_3;       //String: Panel 3 Heading
    private $panelContent_1;    //String: Panel 1 Content
    private $panelContent_2;    //String: Panel 2 Content     
    private $panelContent_3;    //String: Panel 3 Content

    //constructor

    function __construct($user, $postArray, $pageTitle, $pageHead, $database) {
        parent::__construct($user->getLoggedinState());
        $this->user = $user;

        //set the database connection
        $this->db = $database;

        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

        //get the postArray
        $this->postArray = $postArray;

        //set the FIRST panel content
        $this->setPanelHead_1();
        $this->setPanelContent_1();


        //set the DECOND panel content
        $this->setPanelHead_2();
        $this->setPanelContent_2();

        //set the THIRD panel content
        $this->setPanelHead_3();
        $this->setPanelContent_3();
    }

//end METHOD -  constructor
    //setter methods
    public function setPageTitle($pageTitle) { //set the page title    
        $this->pageTitle = $pageTitle;
    }

//end METHOD -   set the page title       

    public function setPageHeading($pageHead) { //set the page heading  
        $this->pageHeading = $pageHead;
    }

//end METHOD -   set the page heading
    //Panel 1
    public function setPanelHead_1() {//set the panel 1 heading
        if ($this->loggedin) {
            $this->panelHead_1 = '<h3>Number of products in cart</h3>';
        } else {
            $this->panelHead_1 = '<h3>Number of products in cart</h3>';
        }
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        if ($this->loggedin) {  //display the calculator form
            $this->panelContent_1 = file_get_contents('forms/Shoppingkart.html');  //this reads an external form file into the string           
        } else { //if user is not logged in they see some info about bootstrap                
            $this->panelContent_1 = 'Please log in to use the shopping cart function. ';
            ;
        }
    }

//end METHOD - //set the panel 1 content        
    //Panel 2
    public function setPanelHead_2() { //set the panel 2 heading
        if ($this->loggedin) {
            $this->panelHead_2 = '<h3>Result</h3>';
        } else {
            $this->panelHead_2 = '<h3>Result</h3>';
        }
    }

//end METHOD - //set the panel 2 heading     

    public function setPanelContent_2() {//set the panel 2 content
        //this function generates page content by determining which button press values are in the POST array
        //it generates database queries depending on the detected button press
        //two types of query are supported
        //  1--> Query by studentID
        //  2--> Student Transcipt results query
        //
            $this->panelContent_2 = '';  //create an empty string 
        if ($this->loggedin & isset($this->postArray['btn'])) {  //check that the user is logged on and a button is pressed
            switch ($this->postArray['btn']) { //check which button is pressed           
                case 'studentQuery':  //the student query button has been pressed
                    $sql = 'SELECT prodid, pname, pquality, price FROM shoppingkart;';

                    $this->panelContent_2 .= '<p>list of selected products:</p></br>';
                    //$this->panelContent_2='SQL Query= '.$sql; //comment out for diagnostic purposes
                    if ((@$rs = $this->db->query($sql)) && ($rs->num_rows)) {  //execute the query and check it worked and returned data    
                        //iterate through the resultset to create a HTML table
                        $this->panelContent_2 .= '<table class="table table-bordered">';
                        $this->panelContent_2 .= '<tr><tr><th>ProductID</th><th>ProductName</th><th>Quality</th><th>Price</th></tr>'; //table headings
                        while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                            $this->panelContent_2 .= '<tr>'; //--start table row
                            foreach ($row as $key => $value) {
                                $this->panelContent_2 .= "<td>$value</td>";
                            }
                            //Transcript button
                            $this->panelContent_2 .= '<td>';
                            $this->panelContent_2 .= '<form action="' . $_SERVER["PHP_SELF"] . '?pageID=shopkart" method="post">';
                            $this->panelContent_2 .= '<input type="submit" type="button" value="confirm purchase" name="btn">';
                            $this->panelContent_2 .= '<input type="hidden" value="' . $row['pname'] . '" name="selectedID">';
                            //when the button is pressed the 
                            //studentID 'hidden' value is inserted 
                            //into the $_POST array
                            $this->panelContent_2 .= '</form>';
                            $this->panelContent_2 .= '</td>';
                            $this->panelContent_2 .= '</tr>';  //end table row
                        }
                        $this->panelContent_2 .= '</table>';
                    } else {  //resultset is empty or something else went wrong with the query
                        if (!$rs->num_rows) {
                            $this->panelContent_2 .= '<br>No records have been returned - resultset is empty - Nr Rows = ' . $rs->num_rows . '<br>';
                        } else {
                            $this->panelContent_2 .= '<br>SQL Query has FAILED - possible problem in the SQL - check for syntax errors<br>';
                        }
                    }
                    //free result set memory
                    $rs->free();
                    break;       //the student query button has been pressed      
                case "confirm purchase":
                      $id = $this->postArray['selectedID'];
                    //$sql="CALL sp_transcript('$id')";  //call the stored procedure
                    //Or use regular SQL to generate transcript
                    $sql = 'INSERT INTO purchasedproducts(shoppingkart_prodid, productname, productquality, price) select prodid, pname, pquality, price FROM shoppingkart WHERE pname="' . $id . '"';
                      $this->db->query($sql); 
                      $sql = 'DELETE FROM shoppingkart WHERE pname="' . $id . '"'; 
                      $this->db->query($sql); 
                      
                    break;
                    
                default :  //the transcript button has been pressed
                    //$this->panelContent_2='The transcript button has been pressed -  selected ID='.$this->postArray['selectedID']; //comment out for diagnostic purposes
                    //use a STORED PROCEDURE to return the transcript
                  
                    break;  //the transcript button has been pressed
            } //end of SWITCH statement to check which button is pressed  
        } else {//no button has been pressed        
            $this->panelContent_2 = 'lists of products will appear here';
        }//end IF     
    }

//end METHOD - //set the panel 2 content  
    //Panel 3
    public function setPanelHead_3() { //set the panel 3 heading
        if ($this->loggedin) {
            $this->panelHead_3 = '<h3>Panel 3</h3>';
        } else {
            $this->panelHead_3 = '<h3>Panel 3</h3>';
        }
    }

//end METHOD - //set the panel 3 heading

    public function setPanelContent_3() { //set the panel 2 content
        if ($this->loggedin) {
            $this->panelContent_3 = 'Panel 3 content - unser construction (user logged in)';
        } else {
            $this->panelContent_3 = 'Panel 3 content - unser construction (user not logged in)';
        }
    }

//end METHOD - //set the panel 2 content        
    //getter methods
    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function getPageHeading() {
        return $this->pageHeading;
    }

    public function getPanelHead_1() {
        return $this->panelHead_1;
    }

    public function getPanelContent_1() {
        return $this->panelContent_1;
    }

    public function getPanelHead_2() {
        return $this->panelHead_2;
    }

    public function getPanelContent_2() {
        return $this->panelContent_2;
    }

    public function getPanelHead_3() {
        return $this->panelHead_3;
    }

    public function getPanelContent_3() {
        return $this->panelContent_3;
    }

}

//end class
        