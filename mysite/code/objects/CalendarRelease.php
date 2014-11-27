<?php 

class CalendarRelease extends DataObject {
	static $db = array (
		'Title' => 'Varchar(255)',
		'Date' => 'Date',		
		'LinkTo' => 'Varchar(255)',
        'Year' => 'Int',
        'Type' => "Enum('Продукт,Событие','Продукт')",
        'DateEnd' => 'Date',
	);

   	static $default_sort = 'Date DESC';	

   	public function onBeforeWrite() {		
            parent::onBeforeWrite();
            
            $this->Year = $this->dbObject('Date')->Year();
            
        } 	
        function DateCheck() {
            return (mktime(0, 0, 0, date('m', strtotime($this->Date)), $this->dbObject('Date')->DayOfMonth(), $this->dbObject('Date')->Year()) <= mktime(0, 0, 0, date("m"), date("d"), date("Y")))?true:false;
        }
        
        function CategoriaCheck() {
            return ('Событие' == $this->Categoria)?true:false;
        }        
	
        function DateCurrentCheck(){
            return (mktime(0, 0, 0, date('m',strtotime($this->Date)), $this->dbObject('Date')->DayOfMonth(), $this->dbObject('Date')->Year()) == mktime(0, 0, 0, date("m"), date("d"), date("Y")))?true:false;
        }        
        
        function DateCheckNew(){
            return (mktime(0, 0, 0, date('m',strtotime($this->Created)), $this->dbObject('Created')->DayOfMonth(), $this->dbObject('Created')->Year()) >= mktime(0, 0, 0, date("m"), date("d")-3, date("Y")))?true:false;
        }        
        
        function DateCheckUpdate(){
            return (!$this->DateCheckNew() && mktime(0, 0, 0, date('m',strtotime($this->LastEdited)), $this->dbObject('LastEdited')->DayOfMonth(), $this->dbObject('LastEdited')->Year()) >= mktime(0, 0, 0, date("m"), date("d")-3, date("Y")))?true:false;
        }        
        
}
