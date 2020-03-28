<?php
/**
 * Class: Modukes
 * 
 * This class interfac3s between the application and the Modules table in the database
 * 
 * It handles both logged in and not logged in users
 * 
 * @author gerry.guinane
 * 
 */

class Modules extends Model{
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
	function __construct($user,$postArray,$pageTitle,$pageHead,$database,$pageID) {   
            parent::__construct($user->getLoggedinState());
            $this->user=$user;

            $this->pageID=$pageID;
            
            //set the database connection
            $this->db=$database;
            
            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //get the postArray
            $this->postArray=$postArray;

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

            
	} //end METHOD -  constructor
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading

            switch ($this->pageID) { //check which button is pressed           
                case 'modulesViewEdit':
                      $this->panelHead_1='<h3>Modules View/Edit Selection Form</h3>';   
                    break;
                case 'modulesAdd':
                    $this->panelHead_1='<h3>Add a new Module</h3>';   
                    break;
                case 'modulesEdit':
                      $this->panelHead_1='<h3>Edit a Module</h3>';   
                    break;
                case 'modulesDelete':
                      $this->panelHead_1='<h3>Delete a Module</h3>';   
                    break;
                default:
                      $this->panelContent_1='Invalid Choice';
                    break;
                }
            
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            
            switch ($this->pageID) { //check which button is pressed           
                case 'modulesViewEdit':
                      $this->panelContent_1=file_get_contents('forms/form_modules_select.html');
                    break;
                case 'modulesAdd':
                    $this->panelContent_1=file_get_contents('forms/form_modules_add.html');
                    break;
                case 'modulesEdit':
                    switch ($this->postArray['btn']){
                    case 'moduleSave':
                        //escape any special characters entered in the form
                        $moduleID=$this->db->real_escape_string($this->postArray['ModuleID']);
                        break;
                    default :
                        //escape any special characters entered in the form
                        $moduleID=$this->db->real_escape_string($this->postArray['selectedModuleID']);
                        break;
                    }
                    $sql="SELECT ModuleID,ModuleTitle,Credits,LecturerID FROM modules WHERE ModuleID='".$moduleID."'"; 
                    //display the edit form
                    $this->panelContent_1=$this->dbEditForm($sql);
                    break;
                case 'modulesDelete':
                      $this->panelContent_1=file_get_contents('forms/form_modules_delete.html');
                    break;
                default:
                      $this->panelContent_1='Invalid Choice';
                    break;
                }

        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading

            switch ($this->pageID) { //check which button is pressed           
                case 'modulesViewEdit':
                      $this->panelHead_2='<h3>View/Edit Modules</h3>';
                    break;
                case 'modulesAdd':
                      $this->panelHead_2='<h3>New Module</h3>';
                    break;
                case 'modulesEdit':
                      $this->panelHead_2='<h3>Edit A Module</h3>';
                    break;
                case 'modulesDelete':
                      $this->panelHead_2='<h3>Delete a Module</h3>';
                    break;
                default:
                      $this->panelHead_2='<h3>Modules</h3>';
                    break;
                }
            
        }//end METHOD - //set the panel 2 heading     
        
        public function setPanelContent_2(){//set the panel 2 content
            //this function generates page content by determining which button press values are in the POST array
            //it generates page content and database queries depending on the detected button press

            $this->panelContent_2='';  //create an empty string 
            switch ($this->pageID) { //check which button is pressed           
                case 'modulesViewEdit':  //the student query button has been pressed

                        if ($this->postArray['btn']){  //check if a button has been pressed
                            switch ($this->postArray['btn']){  //check which button has been pressed
                                case 'viewSelected':
                                    //escape any special characters entered in the form
                                    $moduleID=$this->db->real_escape_string($this->postArray['moduleCode']);
                                    
                                    //construct the SELECT SQL
                                    $sql='SELECT ModuleID,ModuleTitle,Credits,LecturerID FROM modules WHERE ModuleID="'.$moduleID.'"';
                                    
                                    //execute the query and construct the output panel string
                                    $this->panelContent_2.='<p>Selected Module: '.$this->postArray['moduleCode'].'</p></br>';
                                    $this->panelContent_2.=$this->dbViewEditQuery($sql);
                                    break;
                                case 'viewAll':
                                    //construct the SELECT SQL
                                    $sql='SELECT ModuleID,ModuleTitle,Credits,LecturerID FROM modules';
                                    
                                    //execute the query and construct the output panel string
                                    $this->panelContent_2.=$this->dbViewEditQuery($sql);
                                    break;
                                default:
                                    //set the output panel string
                                    $this->panelContent_2.='<p>Please select a MODULE or ALL MODULES to view</p></br>';
                                    break;
                            }
                        }
                        else{ //no button has been pressed
                            //set the output panel string
                            $this->panelContent_2.='<p>Please select a MODULE or ALL MODULES to view</p></br>';
                        }
                break;       //the student query button has been pressed             
                case 'modulesEdit':

                    if ($this->postArray['btn']==='moduleSave'){  //check if a button has been pressed
                        //escape any special characters entered in the form
                        $moduleID=$this->db->real_escape_string($this->postArray['ModuleID']);
                        $moduleTitle=$this->db->real_escape_string($this->postArray['ModuleTitle']);
                        $moduleCredits=$this->db->real_escape_string($this->postArray['Credits']);
                        $moduleLecturer=$this->db->real_escape_string($this->postArray['Lecturer']);

                        //construct the INSERT SQL
                        $sql="UPDATE modules ";
                        $sql.="SET ";
                        $sql.="ModuleTitle='".$moduleTitle."', ";
                        $sql.="Credits=".$moduleCredits.", ";
                        $sql.="LecturerID='".$moduleLecturer."' ";
                        $sql.="WHERE moduleID='".$moduleID."'";
                        
                        //
                        $this->postArray['selectedModuleID']=$moduleID;
                        
                        if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                            $this->panelContent_2.='Changes to Module : '.$moduleID.' Successfully Saved in DB';
                            //$this->panelContent_2.='<p>'.$sql;
                        }
                        else{ //the DELETE query has failed
                            $this->panelContent_2.='No changes to made to module record: <ul><li>Possible already deleted Module ID Code</li><li>Or nochanges to record were detected</li></ul>';
                        }
                    }
                    else{                              
                        $this->panelContent_2.='Please make required changes in module Edit form';
                    }
                    


                    break;
                case 'modulesDelete':
                    if(isset($this->postArray['btn'])){
                        $sql="DELETE FROM modules WHERE ModuleID='".$this->postArray['selectedModuleID']."'"; 
                        
                        if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                            $this->panelContent_2.='Module : '.$this->postArray['selectedModuleID'].' DELETED Successfully';
                        }
                        else{ //the DELETE query has failed
                            $this->panelContent_2.='Unable to DELETE module - possible invalid Module ID Code or related records in the RESULTS table related to this module';
                        }
                    }
                    else{  //the button has not been pressed yet
                        $this->panelContent_2.='Please enter new module details in form';
                    }
                    break;                    
                case 'modulesAdd':
                    if(isset($this->postArray['btn'])){
                        
                        //escape any special characters entered in the form
                        $moduleID=$this->db->real_escape_string($this->postArray['ModuleID']);
                        $moduleTitle=$this->db->real_escape_string($this->postArray['ModuleTitle']);
                        $moduleCredits=$this->db->real_escape_string($this->postArray['Credits']);
                        $moduleLecturer=$this->db->real_escape_string($this->postArray['Lecturer']);

                        //construct the INSERT SQL
                        $sql="INSERT INTO modules (ModuleID,ModuleTitle,Credits,LecturerID) ";
                        $sql.="VALUES (";
                        $sql.="'".$moduleID."',";
                        $sql.="'".$moduleTitle."',";
                        $sql.=$moduleCredits.",";
                        $sql.="'".$moduleLecturer."'";
                        $sql.=")";
                        
                        //execute the INSERT SQL and check that the new row is inserted OK
                        if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                            $sql='SELECT ModuleID,ModuleTitle,Credits,LecturerID FROM modules WHERE ModuleID="'.$moduleID.'"';
                            $this->panelContent_2.='<p>New Module Added Successfully: '.$moduleID.'</p></br>';
                            $this->panelContent_2.=$this->dbViewQuery($sql);
                        }
                        else{
                            $this->panelContent_2.='Unable to add new module - possible duplicate Module ID or invalid Lecturer ID Code';
                            //uncomment for debug purposes
                            //$this->panelContent_2.='<p>SQL Generated :  '.$sql;
                            //$this->panelContent_2.='<p>Rows Affected :  '.$this->db->affected_rows;
                        }
                    }
                    else{  //the button has not been pressed yet
                        $this->panelContent_2.='Please enter new module details in form';
                    }
                    break;
                default :  //none of the above
                    $this->panelContent_2.='Please select a valid menu option';      
                    break; 
                } //end of SWITCH statement to check which button is pressed  
  
        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
        public function setPanelHead_3(){ //set the panel 3 heading
            if($this->loggedin){
                $this->panelHead_3='<h3>Panel 3</h3>';   
            }
            else{        
                $this->panelHead_3='<h3>Panel 3</h3>'; 
            }
        } //end METHOD - //set the panel 3 heading
        
        public function setPanelContent_3(){ //set the panel 2 content
            if($this->loggedin){
                $this->panelContent_3='Panel 3 content - unser construction (user logged in)';
            }
            else{        
                $this->panelContent_3='Panel 3 content - unser construction (user not logged in)';
            }
        }  //end METHOD - //set the panel 2 content        
       
        private function dbViewEditQuery($sql){
                            //This method returns a string containing the requested (SQL) query of the modules table. 
                            //The returned string contains all the required HTML element tags to format the table result
                            //The table result also contains an EDIT MODULE button 
                            $returnString='';
                            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                                //iterate through the resultset to create a HTML table
                                
                                $returnString.= '<table class="table table-bordered">';
                                $returnString.='<tr><th>ModuleID</th><th>ModuleTitle</th><th>Credits</th><th>Lecturer</th><th>Select</th></tr>';//table headings
                                while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                                        $returnString.='<tr>';//--start table row
                                           foreach($row as $key=>$value){
                                                    $returnString.= "<td>$value</td>";
                                            }
                                            //Edit button
                                            $returnString.= '<td>';
                                            $returnString.= '<form action="'.$_SERVER["PHP_SELF"].'?pageID=modulesEdit" method="post">';
                                            $returnString.= '<input type="submit" type="button" class="btn btn-warning btn-sm" value="Edit" name="btn">';
                                            $returnString.= '<input type="hidden" value="'.$row['ModuleID'].'" name="selectedModuleID">';
                                                //when the button is pressed the 
                                                //ModuleID 'hidden' value is inserted 
                                                //into the $_POST array
                                            $returnString.= '</form>';
                                            $returnString.= '</td>';
                                            $returnString.= '</tr>';  //end table row
                                        }
                                $returnString.= '</table>';   
                            }  
                            else{  //resultset is empty or something else went wrong with the query
                            
                                    $returnString.= '<br>No records available to view - please try again<br>';
                                    
                            }
                            //free result set memory
                            $rs->free();
                            return $returnString;
        }
        
        private function dbEditForm($sql){
            $returnString='';
            
            if((@$rs=$this->db->query($sql))&&($rs->num_rows===1)){  //execute the query and check it worked and returned data    
                //use the resultset to create the EDIT form
                $row=$rs->fetch_assoc();
                

                //construct the EDIT MODULE form 
                    $returnString.='<form method="post" action="index.php?pageID=modulesEdit">';
                    $returnString.='<div class="form-group">';
                    $returnString.='<label for="ModuleID">ModuleID</label><input required readonly type="text" class="form-control" value="'.$row['ModuleID'].'" id="ModuleID" name="ModuleID" pattern="[A-Z0-9]{5,10}" title="ModuleID - Upper Case Letters and digits, 5-10 characters">';
                    $returnString.='<label for="ModuleTitle">ModuleTitle</label><input required type="text" class="form-control" value="'.$row['ModuleTitle'].'" id="ModuleTitle" name="ModuleTitle" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="Module Title (up to 45 Characters)">';
                    $returnString.='<label for="Credits">Credits</label><input required type="text" class="form-control" value="'.$row['Credits'].'" id="Credits" name="Credits" pattern="[0-9]{1,2}" title="Credits (Integer Value)" >';
                    $returnString.='<label for="Lecturer">Lecturer ID</label><input required type="text" class="form-control" value="'.$row['LecturerID'].'"  id="Lecturer" name="Lecturer" pattern="[a-zA-Z0-9]{5,10}" title="Enter a valid Lecturer ID">';
                    $returnString.='</div>';
                    $returnString.='<button type="submit" class="btn btn-default" name="btn" value="moduleSave">Save Changes</button>';
                    $returnString.='</form>'; 
            }
            else{
                $returnString.='Invalid module selection - Module may already have been deleted.';
            }
                    return $returnString;
        }
        
        private function dbViewQuery($sql){
                            //This method returns a string containing the requested (SQL) query of the modules table. 
                            //The returned string contains all the required HTML element tags to format the table result
                            $returnString='';
                            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                                //iterate through the resultset to create a HTML table
                                
                                $returnString.= '<table class="table table-bordered">';
                                $returnString.='<tr><th>ModuleID</th><th>ModuleTitle</th><th>Credits</th><th>Lecturer</th></tr>';//table headings
                                while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                                        $returnString.='<tr>';//--start table row
                                           foreach($row as $key=>$value){
                                                    $returnString.= "<td>$value</td>";
                                            }
                                            $returnString.= '</tr>';  //end table row
                                        }
                                $returnString.= '</table>';   
                            }  
                            else{  //resultset is empty or something else went wrong with the query
                            
                                    $returnString.= '<br>No records available to view - please try again<br>';
                                    
                            }
                            //free result set memory
                            $rs->free();
                            return $returnString;
        }
        
        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getPanelContent_3(){return $this->panelContent_3;}
        

        
}//end class
        