<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');


 
    class Rt_SchoolsSugarpdfPdfmanager extends SugarpdfPdfmanager
    { 
        public function preDisplay()
        {
            parent::preDisplay();
            $this->getRelatedRecords();  
        }

        protected function getRelatedRecords() 
        {
            //Assigning Staff Members records
            $this->bean->load_relationship('staffs');
            if($this->bean->staffs) {
               
                $staff_list = $this->bean->staffs->getBeans();
                $staffs = array();
                foreach ($staff_list as $staff) {
                    $staffFields = PdfManagerHelper::parseBeanFields($staff, true);
                    $staffs[] = array( 'role'=> $staffFields['role_field'], 'name'=> $staffFields['name'] ) ;
                    
                    
                }
               
                $this->ss->assign('staffs', $staffs);
                
            }
            
            //Assigning Students records
            $this->bean->load_relationship('students');
            if($this->bean->students) {
               
                $student_list = $this->bean->students->getBeans();
                $students = array();
                foreach ($student_list as $student) {
                    $studentFields = PdfManagerHelper::parseBeanFields($student, true);
                    $students[] = array( 'first_name'=> $studentFields['first_name'], 'last_name'=> $studentFields['last_name'] ) ;
                        
                }
               
                $this->ss->assign('students', $students);
                
            }
            
        }

    }
?>
