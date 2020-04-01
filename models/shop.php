<?php

/**
 * Class: UnderConstruction
 * This is a template/empty class that provides 'under construction' content.
 * 
 * It handles bot logged in and not logged in usee cases. 
 *
 * @author gerry.guinane
 * 
 */
class shop extends Model {

    //class properties
    private $db;                //MySQLi object: the database connection ( 
    private $user;
    private $pageID;
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

    function __construct($user, $postArray, $pageTitle, $pageHead, $database, $pageID) {
        parent::__construct($user->getLoggedinState());
        $this->user = $user;

        $this->pageID = $pageID;

        //set the database connection
        $this->db = $database;

        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

        //get the postArray
        $this->postArray = $postArray;

        //set the SECOND panel content
        $this->setPanelHead_2();
        $this->setPanelContent_2();

        //set the THIRD panel content
        $this->setPanelHead_3();
        $this->setPanelContent_3();

        //set the FIRST panel content 
        //This has to be done LAST! - because updates/changes implemented 
        //in panel 2 can result in 
        //changes in record displayed in panel 1
        $this->setPanelHead_1();
        $this->setPanelContent_1();
    }

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
            $this->panelHead_1 = '<h3>Panel 1</h3>';
        } else {
            $this->panelHead_1 = '<h3>Panel 1</h3>';
        }
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        if ($this->loggedin) {  //display the calculator form
            $this->panelContent_1 = file_get_contents('forms/shop.html');  //this reads an external form file into the string           
        } else { //if user is not logged in they see some info about bootstrap                
            $this->panelContent_1 = 'Please log in to use the customerlist function. ';
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
        $btn_ = filter_input(INPUT_POST, ProductEditFormHtmlTags::btn);
        $this->panelContent_2 = '';  //create an empty string 
        if (isset($btn_)) {

            switch ($btn_) {  //check which button has been pressed
                case 'viewSelected':
                    
                     //echo "<h1>Debug3</h1>";
                    //escape any special characters entered in the form
                    $prodID = $this->db->real_escape_string($this->postArray['productCode']);

                    //construct the SELECT SQL
                    $sql = 'SELECT productsid,Name,quality,price FROM products WHERE Name="' . $prodID . '"';

                    //execute the query and construct the output panel string
                    $this->panelContent_2 .= '<p>Selected Product: ' . $this->postArray['productCode'] . '</p></br>';
                    $this->panelContent_2 .= $this->dbViewEditQuery($sql);
                    break;
                case 'viewAll':
                    //construct the SELECT SQL
                    $sql = 'SELECT productsid,Name,quality,price FROM products';

                    //execute the query and construct the output panel string
                    $this->panelContent_2 .= $this->dbViewEditQuery($sql);
                    break;
                case 'Purchase':
//                   echo "<h1>Debug5</h1>";

                    //if(isset( $this->postArray["addProductButton"])) {
                        
                        $prodID = $this->db->real_escape_string($this->postArray[ProductEditFormHtmlTags::ProductId]);
                        $sql = 'INSERT INTO shoppingkart(prodid,pname,pquality,price) SELECT productsid,Name,quality,price FROM products WHERE productsid="' . $prodID . '"';
                        $this->db->query($sql); 

                    break;
                default:
                    //set the output panel string
                    $this->panelContent_2 .= '<p>Please select a Product or ALL Products to view</p></br>';
                    break;
            }
        } else { //no button has been pressed
            //set the output panel string
            $this->panelContent_2 .= '<p>Please select a Product or ALL Product to view</p></br>';
        }
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
            $this->panelContent_3 = "Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";
            ;
        } else {
            $this->panelContent_3 = "Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";
            ;
        }
    }

//end METHOD - //set the panel 2 content        

    private function dbViewEditQuery($sql) {
        //This method returns a string containing the requested (SQL) query of the modules table. 
        //The returned string contains all the required HTML element tags to format the table result
        //The table result also contains an EDIT MODULE button 
        $returnString = '';
        if ((@$rs = $this->db->query($sql)) && ($rs->num_rows)) {  //execute the query and check it worked and returned data    
            //iterate through the resultset to create a HTML table
            $returnString .= '' . '<table class="table table-bordered">';
            $returnString .= '<tr><th>ProductID</th><th>ProductName</th><th>Quality</th><th>Price</th></tr>'; //table headings
            while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                $returnString .= '<tr>'; //--start table row
                foreach ($row as $key => $value) {
                    $returnString .= "<td>$value</td>";
                }
                //Edit button
                $returnString .= '<td>';
                $returnString .= '<form action="' . $_SERVER["PHP_SELF"] . '?pageID=shop&' 
                        . ProductEditFormHtmlTags::ProductId . '=' . $row['productsid'] .
                        '" method="post">';
                $returnString .= '<input type="submit" type="button" class="btn btn-warning btn-sm" value="Purchase" name="btn">';
                $returnString .= '<input type="hidden" value="' . $row['productsid'] . '" name="' . ProductEditFormHtmlTags::ProductId . '">';
                //when the button is pressed the 
                //ModuleID 'hidden' value is inserted 
                //into the $_POST array
                $returnString .= '</form>';
                $returnString .= '</td>';
                $returnString .= '</tr>';  //end table row
            }
            $returnString .= '</table>';
        } else {  //resultset is empty or something else went wrong with the query
            $returnString .= '<br>No records available to view - please try again<br>';
        }
        //free result set memory
        $rs->free();
        return $returnString;
    }

    //getter methods
    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function getPageHeading() {
        return $this->pageHeading;
    }

    public function getMenuNav() {
        return $this->menuNav;
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
        