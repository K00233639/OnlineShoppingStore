<?php
/**
 * Class: Home
 * This class is used to generate text content for the HOME page view.
 * 
 * This is the 'landing' page for the web application. 
 * 
 * It handles bot logged in and not logged in usee cases. 
 *
 * @author gerry.guinane
 * 
 */

class Home extends Model{
	//class properties
        private $pageTitle;
        private $pageHeading;
        private $panelHead_1;
        private $panelContent_1;
        private $panelHead_2;
        private $panelContent_2;
        private $panelHead_3;
        private $panelContent_3;
        private $user;
	
	//constructor
	function __construct($user,$pageTitle,$pageHead){   
            parent::__construct($user->getLoggedInState());
            $this->user=$user;
            

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();


            //set the DECOND panel content
            $this->setPanelHead_2();
            $this->setPanelContent_2();
        
            //set the THIRD panel content
            $this->setPanelHead_3();
            $this->setPanelContent_3();
	} //end METHOD constructor
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
                $this->panelHead_1='<h3>College Online System</h3>';
        }//end METHOD - //set the panel 1 heading
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){
                
                if ($this->user->getUserType()==='LECTURER'){
                    $this->panelContent_1='<h4>Overview</h4>';
                    $this->panelContent_1.='<p>College online system is designed for lecturers to manage their modules, classes and student grades.'; 
                    $this->panelContent_1.='<p>You are currently logged in.';
                }
                else{
                    $this->panelContent_1='<h4>Overview</h4>';
                    $this->panelContent_1.='<p>College online system is designed for STUDENTS to view student and user account.'; 
                    $this->panelContent_1.='<p>You are currently logged in.';   
                }
            }
            else{
                $this->panelContent_1='<h4>Overview</h4>';
                $this->panelContent_1.='<p>College online system is designed for both lecturers and students to manage their college affairs..'; 
                $this->panelContent_1.='<p>You must log in to use this system.';  
            }
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading
            if($this->loggedin){
                $this->panelHead_2='<h3>Welcome</h3>';
            }
            else{        
                $this->panelHead_2='<h3>Login required</h3>';
            }
        }//end METHOD - //set the panel 2 heading        
        public function setPanelContent_2(){//set the panel 2 content
            //get the Middle panel content
            if($this->loggedin){
                
                if ($this->user->getUserType()==='LECTURER'){
                    $this->panelContent_2='Thank you '.$this->user->getUserFirstName() .' for logging in successfully as a LECTURER to the College Online System. Please use the links above to manage your modules, students and grades. <br><br>Don\'t forget to logout when you are done.';
                }
                else{
                    $this->panelContent_2='Thank you '.$this->user->getUserFirstName() .' for logging in successfully as a STUDENT to the College Online System. Please use the links above to manage your modules, students and grades. <br><br>Don\'t forget to logout when you are done.';
                }
                
                
            }
            else{        
                $this->panelContent_2='You are required to login - Please use the link above to login';
            }
        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
        public function setPanelHead_3(){ //set the panel 3 heading
            if($this->loggedin){
                $this->panelHead_3='<h3>College Online</h3>';
            }
            else{        
                $this->panelHead_3='<h3>College Online</h3>';
            } 
        } //end METHOD - //set the panel 3 heading      
        public function setPanelContent_3(){ //set the panel 2 content
            if($this->loggedin){
                $this->panelContent_3='';
                $this->panelContent_3.='<p>Logged on to College Online System</p>'; 
            }
            else{        
                $this->panelContent_3='';
                $this->panelContent_3.='<p>Please log in or register</p>'; 
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
        