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

class Calculator extends Model{
	//class properties
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $panelHead_2;
        private $panelContent_2;
        private $panelHead_3;
        private $panelContent_3;
 
	
	//constructor
	function __construct($user,$postArray,$pageTitle,$pageHead) 
	{   
            parent::__construct($user->getLoggedinState());
            $this->user=$user;

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //get the postArray
            $this->postArray=$postArray;
            
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
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3>Calculator Form</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Calculator Form</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){  //display the calculator form
                    $this->panelContent_1 = file_get_contents('forms/form_calculator.html');  //this reads an external form file into the string           
                }
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='Please log in to use the calculator function. ';;                          
                } 
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading
            if($this->loggedin){
                $this->panelHead_2='<h3>Result</h3>';   
            }
            else{        
                $this->panelHead_2='<h3>Result</h3>'; 
            }
        }//end METHOD - //set the panel 2 heading     
        
        public function setPanelContent_2(){//set the panel 2 content
             if($this->loggedin & isset($this->postArray['btn'])){  //check that the user is logged on and a button is pressed
                
                $this->panelContent_2='';  //create an empty string 
                
                switch ($this->postArray['btn']) {  //process the selected button
                case "add":
                    $this->panelContent_2.= '<table class="table table-striped"><tbody>';
                    $this->panelContent_2.= '<tr><td>The SUM of '.$this->postArray['value1'];
                    $this->panelContent_2.= ' and '.$this->postArray['value2'];
                    $this->panelContent_2.= ' is = '.($this->postArray['value1']+$this->postArray['value2']).'</td></tr>';
                    $this->panelContent_2.= '</tbody></table>';
                    break;
                
                case "subtract":
                    $this->panelContent_2.= '<table class="table table-striped"><tbody>';
                    $this->panelContent_2.= '<tr><td>The DIFFERENCE of '.$this->postArray['value1'];
                    $this->panelContent_2.= ' and '.$this->postArray['value2'];
                    $this->panelContent_2.= ' is = '.($this->postArray['value1']-$this->postArray['value2']).'</td></tr>';
                    $this->panelContent_2.= '</tbody></table>';
                    break;
                
                case "table":
                    $this->panelContent_2.= '<table class="table table-striped"><tbody>';
                    for ($i=1;$i<=$this->postArray['value2'];$i++)
                            {
                            $this->panelContent_2.= '<tr><td>'.$this->postArray['value1'].'</td><td>Times</td><td> '.$i.'</td><td> = '.($this->postArray['value1']*$i).'</td></tr>';
                            }
                    $this->panelContent_2.= '</tbody></table>';
                    break;
                
                case "clear": //the Clear Result button has been pressed
                    $this->panelContent_2.= "Please enter some values in the form.";
                    break; 
                
                default : //the form has not been submitted yet
                    $this->panelContent_2.= "Please enter some values in the form.";
                    break;
                } //end SWITCH
            }  
            else{        
                $this->panelContent_2='Result will appear here'; 
            }//end IF
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
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getPanelContent_3(){return $this->panelContent_3;}
        

        
}//end class
        