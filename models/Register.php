<?php
/**
 * Class: Register
 *
 * @author gerry.guinane
 * 
 */

class Register extends Model{
	//class properties
        private $db;
        private $user;
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $panelHead_2;
        private $panelContent_2;
        private $panelHead_3;
        private $panelContent_3;
 
	//($loggedin,$postArray,$pageTitle,$pageHead,$database)
	//constructor
        
        //Login($this->postArray,'MVC Example', strtoupper($this->getArray['pageID']),$this->db,$this->user);
        
	function __construct($postArray,$pageTitle,$pageHead,$database, $user)
	{   
            parent::__construct($user->getLoggedinState());
            
            $this->db=$database;

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
            $this->panelHead_1='<h3>Registration Form</h3>';       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content                                  
             $this->panelContent_1 = file_get_contents('forms/form_register.html');  //this reads an external form file into the string 
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading       
            
            $this->panelHead_2='<h3>Registration Result</h3>'; 
            
        }//end METHOD - //set the panel 2 heading     
        
        public function setPanelContent_2(){//set the panel 2 content
       
            //process the registration button
            if (isset($this->postArray['btn'])){
                
                if ($this->postArray['lectPass1']===$this->postArray['lectPass2']){  //verify passwords match
                    //process the registration data
                    $this->panelContent_2='Passwords Match<br>';
                    $this->panelContent_2.='User ID   : '.$this->postArray['lectID'].'<br>';
                    $this->panelContent_2.='Firstname : '.$this->postArray['lectFirstName'].'<br>';
                    $this->panelContent_2.='Lastname  : '.$this->postArray['lectLastName'].'<br>';
                      
                    $this->panelContent_2.='Password1 : '.$this->postArray['lectPass1'].'<br>';
                    $this->panelContent_2.='Password2 : '.$this->postArray['lectPass2'].'<br>';
                   
                    
                    if ($this->user->register($this->postArray)){
                        $this->panelContent_2.='REGISTRATION SUCCESSFUL - please log in<br>';
                    }
                    else{
                        $this->panelContent_2.='REGISTRATION NOT SUCCESSFUL<br>';
                    }
                    
                }
                else{
                    $this->panelContent_2='Passwords DONT Match<br>';
                    $this->panelContent_2.='User ID   : '.$this->postArray['lectID'].'<br>';
                    $this->panelContent_2.='Firstname : '.$this->postArray['lectFirstName'].'<br>';
                    $this->panelContent_2.='Lastname  : '.$this->postArray['lectLastName'].'<br>';
                      
                    $this->panelContent_2.='Password1 : '.$this->postArray['lectPass1'].'<br>';
                    $this->panelContent_2.='Password2 : '.$this->postArray['lectPass2'].'<br>';
                                    
                }
            }
            else{
                $this->panelContent_2='Please enter details in the form';
            }           
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
        public function getUser(){return $this->user;}

        
}//end class
        