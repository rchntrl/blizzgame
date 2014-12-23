<?php 
class AttachedImageChapter extends Image {
 
	static $has_one = array (
		'Chapter' => 'Chapter'
	);

	function needResizePhoto($size){
		return ($size < $this->getWidth())?true:false;	
	}	
	
}

class Chapter extends DataObject
{
	static $db = array (
		'Title' => 'Varchar(255)',
		'Content' => 'Text',
		'NumberSort' => 'Int'
	);

	static $has_one = array (
        'BCMID' => 'Book'
	);

	/*
	static $has_many = array (
		'AttachedImage' => 'AttachedImageChapter'
	);/**/
	
	public function getCMSFields_forPopup(){//echo '['.$this->Parent()->ID.']['.$this->LinkPage()->ID.']';die();
		$ds = DataObject::get("BookComicManga",'LinkPageID = '.DB::query("SELECT ParentID FROM SiteTree WHERE ID = ".$_SESSION['CMSMain']['currentPage'])->value(),'DateSaleEN DESC');

		$TinyMCE = new SimpleTinyMCEField('Content','Текст');
		
		if($this->BCMID){//echo '['.'BookComicManga/Chapter/'.$this->BCMID.']';
			$file = new MultipleImageUploadField('AttachedImage','Foto',array('fileDesc'=>'Images','image_class' => 'AttachedImageChapter'));//'sortable'=>true,
			//$file->removeFolderSelection();
			$file->setUploadFolder('BookComicManga/Chapter/'.$this->BCMID);		
		}
		$fields = new FieldSet(
			new TextField('Title','Заголовок (полностью)'),
			new DropdownField('BCMID','Произведение',(($ds)?$ds->toDropdownMap('ID', 'TitleRU', 'None'):null)),			
			new NumericField('NumberSort',' Порядок сортировки глав',null,3),
			$TinyMCE,(($file)?$file:new LiteralField('HelpText','После задания имени, Вы сможете добавить файлы'))
		);
		return $fields;
	}
	
	public function Link(){
		$obj = DataObject::get_by_id("BookComicManga",$this->BCMID);
		return $obj->Link().'translate/'.$this->ID.'/';
	}
	public function LinkParent(){
		$obj = DataObject::get_by_id("BookComicManga",$this->BCMID);
		return $obj->AbsoluteLink();
	}
		
	
	public function Comments() {
		$spamfilter = isset($_GET['showspam']) ? '' : "AND \"IsSpam\"=0";
		$unmoderatedfilter = Permission::check('ADMIN') ? '' : "AND \"NeedsModeration\"=0";
		$comments =  DataObject::get("PageComment", "\"ParentID\" = '" . Convert::raw2sql($this->LinkPageID) . "' AND \"DataObjectID\" = '" . Convert::raw2sql($this->ID) . "' $spamfilter $unmoderatedfilter", "\"Created\" DESC");
		
		return $comments ? $comments : new DataObjectSet();
	}	
	
	public function TitleBCMID(){
		return DB::query("SELECT TitleRU FROM BookComicManga WHERE ID = ".$this->BCMID)->value();
	}
	public function bookInfo(){
		return DataObject::get_by_id("BookComicManga",$this->BCMID);
	}        
	public function GetTitleB(){
		return DataObject::get_by_id("BookComicManga",$this->BCMID)->TitleRU;
	}
	public function GetTitleP(){
		return DataObject::get_one("BookComicManga",$this->BCMID)->Categoria;
	}

	function getTitleSubsite(){	return Page::getTitleSubsite();	}
	
	function AbsoluteLink(){return $this->LinkParent().'translate/'.$this->ID.'/';}//substr($this->BaseHref(),0,strlen($this->BaseHref())-1).$this->Link()
	
    public function LinkOrCurrent(){
    	return ($_GET['url'] == $this->Link()) ? 'current' : 'link';
    }		

    public function GetAttachedImage(){
    	//echo 'Title = '."'".Convert::raw2sql(preg_replace('/([^a-z0-9-])/si','',str_replace(' ','-',$_GET['page'])))."'";die();
    	return (!$_GET['page'])?$this->AttachedImage()->First():$this->AttachedImage('Title = '."'".Convert::raw2sql(preg_replace('/([^a-z0-9-\s])/si','',$_GET['page']))."'")->First();
    }
    public function GetAttachedImage2(){
    	//echo 'Title = '."'".Convert::raw2sql(preg_replace('/([^a-z0-9-])/si','',str_replace(' ','-',$_GET['page'])))."'";die();
    	return $this->AttachedImage();
    }
   	public function PrevNextPage($Mode = 'next') {
   		$Where = '';
   		$currentSort = $this->GetAttachedImage()->SortOrder;
       	if($Mode == 'next'){
    	   	$Where = " SortOrder > ".$currentSort;
       		$Sort = "SortOrder ASC";       		
       	}elseif($Mode == 'prev'){
       		$Where = " SortOrder < ".$currentSort;
       		$Sort = "SortOrder DESC";       		
       	}else{
        	return false;
       	}
    	return $this->AttachedImage($Where,$Sort,null,1);
   	}  
        
   	public function PrevNextPage2($Mode = 'next') {
   		$Where = '';
   		$currentSort = $this->NumberSort;
       	if($Mode == 'next'){
    	   	$Where = " NumberSort = ".($currentSort+1);       		
       	}elseif($Mode == 'prev'){
       		$Where = " NumberSort = ".($currentSort-1);       			
       	}else{
        	return false;
       	}
    	return DataObject::get_one('Chapter','BCMID = '.$this->BCMID.' AND '.$Where);
   	}
}
