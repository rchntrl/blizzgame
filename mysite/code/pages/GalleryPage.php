<?php/** * Class GalleryPage * * @property string GalFolder * @method \DataList GalleryImages() */class GalleryPage extends Page {// Used to automatically include photos in a specific folder    public static $db = array(        'GalFolder' => 'Varchar(100)'    );    // One gallery page has many gallery images    public static $has_many = array(        'GalleryImages' => 'GalleryImage'    );    // Add CMS description    static $description = "Add an Image Gallery to the site";    static $singular_name = 'Photo Gallery';    // Set Permissions    function canCreate($Member = null) {return (permission::check('EDIT_GALLERY')) ? true : false;}    function canEdit($Member = null) {return (permission::check('EDIT_GALLERY')) ? true : false;}    function canDelete($Member = null) {return (permission::check('DELETE_GALLERY')) ? true : false;}    public function getCMSFields() {        $fields = parent::getCMSFields();        /** @var GridFieldConfig $gridFieldConfig */        $gridFieldConfig = GridFieldConfig_RecordEditor::create();        $gridFieldConfig->addComponent(new GridFieldBulkManager());        // Creates field where you can type in the folder name --- IT WILL CREATE IN ROOT OF ASSET DIRECTORY!!!        $fields->addFieldToTab("Root.Main", new TextField('GalFolder', 'Folder name'), 'Metadata');        $fields->removeFieldFromTab('Root.Main', 'Content');        $uploadFolderName  = 'Gallery-Images';        if($this->GalFolder != '' || $this->GalFolder != NULL) {            $uploadFolderName = $this->GalFolder;        }        $bulkUpload = new GridFieldBulkUpload();        $bulkUpload->setUfSetup('setFolderName', $uploadFolderName);        $gridFieldConfig->addComponent($bulkUpload);        $gridFieldConfig->removeComponentsByType('GridFieldPaginator'); // Remove default paginator        $gridFieldConfig->addComponent(new GridFieldPaginator(20)); // Add custom paginator        $gridFieldConfig->addComponent(new GridFieldFilterHeader('AuthorID'));        $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton'); // We only use bulk upload button        // Creates sortable grid field        $gridField = new GridField("GalleryImages", _t("Gallery.GALLERY_CMS_TITLE", "Image Gallery"), $this->GalleryImages(), $gridFieldConfig);        $fields->addFieldToTab('Root.ImageGallery', $gridField);        return $fields;    }    // Check that folder name conforms to assets class standards. remove spaces and special charachters if used    function onBeforeWrite() {        $this->GalFolder = str_replace(array(' ','-'),'-', preg_replace('/\.[^.]+$/', '-', $this->GalFolder));        parent::onBeforeWrite();    }}class GalleryPage_Controller extends Page_Controller implements PermissionProvider  {    private static $allowed_actions = array(        'viewAuthor',        'viewTag',        'viewSize',        'view',        'rss',    );    static $url_handlers = array(        'author/$ID!' => 'viewAuthor',        'size/$ID!' => 'viewSize',        'tag/$ID!' => 'viewTag',        '$ID!' => 'view',    );    protected $arraySize = array(        'all' => array(            'Name' => '',            'Title'=>'Отменить фильтры размера',            'MenuTitle'=>'Все',        ),        'small' => array(            'Name' => 'small',            'Title'=>'рисунки до 700px',            'MenuTitle'=>'Маленькие'        ),        'medium' => array(            'Name' => 'medium',            'Title'=>'рисунки от 700px до 1400px',            'MenuTitle'=>'Средние'        ),        'large' => array(            'Name' => 'large',            'Title'=>'рисунки от 1400px до 3000px',            'MenuTitle'=>'Большие'        ),        'extra-large' => array(            'Name' => 'extra-large',            'Title' => 'рисунки больше 3000px',            'MenuTitle'=> 'Огромные'        ),    );    public function init() {        parent::init();    }    //Add permission check boxes to CMS    public function providePermissions() {        return array(            "VIEW_GALLERY" => "View Gallery Pages",            "EDIT_GALLERY" => "Edit Gallery Pages",        );    }    public function BackURL() {        $BackURL = Session::get('BackURL');        return $BackURL  ?: $this->Link();    }    protected function getFilterURLParams() {        $urlParams = $this->request->getVars();        foreach ($urlParams as $key => $val) {            if (!in_array($key, array('author', 'size', 'tag'))) {                unset($urlParams[$key]);            }        }        return $urlParams;    }    public function getAppliedTags() {        $value = $this->request->getVar('tag');        if ($value) {            if (!is_array($value)) {                $value = array($value);            }            if ($this->getAction() == 'viewTag') {                $value[] = $this->urlParams['ID'];            }            $qb = new SQLQuery();            $qb                ->setFrom('ElementLink')                ->setWhere(array(                    'ElementLink.SubsiteID = ' . Subsite::currentSubsiteID(),                    'ElementLink.LastLinkSegment in (\'' . implode("', '", $value) . '\')'                ))            ;            $records = $qb->execute();            $tags = new ArrayList();            foreach($records as $rowArray) {                $tags->push(new ElementLink($rowArray));            }            return $tags;        }        return new ArrayList();    }    protected function getAppliedFilterValues() {        $filterValues = array();        if ($this->urlParams['Action']) {            $filterValues[] = $this->urlParams['ID'];        }        foreach ($this->getFilterURLParams() as $filter) {            if (is_array($filter)) {                foreach($filter as $subFilter) {                    $filterValues[] = $subFilter;                }            } else {                $filterValues[] = $filter;            }        }        return $filterValues;    }    public function FilterByAuthor() {        $qb = new SQLQuery();        $qb            ->setSelect(array(                'PeopleFace.ID',                'PeopleFace.ClassName',                'PeopleFace.TitleEN',                'PeopleFace.TitleRU',                'Nick',                'PeopleFace.LastLinkSegment'            ))            ->setFrom('PeopleFace')            ->addLeftJoin('GalleryImage', 'GalleryImage.AuthorID = PeopleFace.ID')            ->setWhere('GalleryImage.ID IS NOT NULL')            ->setGroupBy(array('GalleryImage.AuthorID'))            ->setOrderBy('PeopleFace.ID')        ;        $records = $qb->execute();        $arrayList = new ArrayList();        $filterValues = $this->getAppliedFilterValues();        foreach($records as $rowArray) {            if (!in_array($rowArray['LastLinkSegment'], $filterValues)) {                $arrayList->push(new PeopleFace($rowArray));            }        }        return $arrayList;    }    public function FilterBySize() {        $sizes = $this->arraySize;        $id = $this->urlParams['Action'] == 'size' ? $this->urlParams['ID'] : $this->request->getVar('size');        $sizes[$id]['Current'] = $id;        $sizes['all']['Current'] = !$id;        $sizes = new ArrayList($sizes);        return $sizes;    }    public function FilterByTags() {        $qb = new SQLQuery();        $qb            ->setSelect(array(                'ElementLink.ID', 'ElementLink.TitleEN', 'ElementLink.TitleRU',                'ElementLink.Created', 'ElementLink.LastEdited',                'ElementLink.LastLinkSegment'            ))            ->setFrom('ElementLink')            ->addLeftJoin('GalleryImage_Tags', 'GalleryImage_Tags.ElementLinkID = ElementLink.ID')            ->setWhere(array(                'ElementLink.SubsiteID = ' . Subsite::currentSubsiteID(),                'GalleryImageID is not null'            ))            ->setGroupBy(array('ElementLinkID'))            ->setOrderBy('ElementLink.TitleRU')        ;        $filters = $this->getFilterURLParams();        if ($filters['author']) {            $author = DataObject::get_one("PeopleFace", "\"PeopleFace\".\"LastLinkSegment\" = '" . $filters['author'] . "'");            $qb->addLeftJoin('GalleryImage', 'GalleryImage_Tags.GalleryImageID = GalleryImage.ID');            $qb = $this->addFilterToQuery($qb, 'author', $author->ID);        }        $records = $qb->execute();        $tags = new ArrayList();        $filterValues = $this->getAppliedFilterValues();        foreach($records as $rowArray) {            if (!in_array($rowArray['LastLinkSegment'], $filterValues)) {                $tags->push(new ElementLink($rowArray));            }        }        return $tags;    }    public function getFilterUrl($filterName, $value) {        $url = $this->Link();        $filterParams = $this->getFilterURLParams();        // todo оптимизировать так, чтобы урл внутри цикла не генерился каждый раз заново для каждого элемента        $action = $this->urlParams['Action'];        // if I am on some filter page        if ($action && $this->getAction() != 'view') {            if ($filterName == $action) {                // and generate url for the same filter                if (in_array($filterName, array('tag'))) {                    $filterParams[$filterName] = array($this->urlParams['ID'], $value);                } else {                    $url .= $value ? $filterName . '/' . $value : '';                }            }            else {                // or generate url for another filter                $url .= $action . '/' . $this->urlParams['ID'];                if ($value) {                    $filterParams[$filterName] = $value;                }                else {                    unset($filterParams[$filterName]);                }            }        } else {            // if I am on index page            $filterParams[$filterName] = $value;            //$url .=  !$value ? '' : $filterName . '/' . $value;            //unset($filterParams[$filterName]);        }        if (count($filterParams)) {            $url .= '?' . http_build_query($filterParams);        }        return $url;    }    public function getAddTagUrl($value) {        $url = $this->Link();        $filterParams = $this->getFilterURLParams();        $action = $this->urlParams['Action'];        // if I am on some filter page        if ($this->getAction() != 'view' && $action && $action != 'tag') {            $url .= $action . '/' . $this->urlParams['ID'];        }        if ($filterParams['tag']) {            if (is_array($filterParams['tag'])) {                $filterParams['tag'][] = $value;            } else {                $filterParams['tag'] = array($filterParams['tag'], $value);            }        } else {            $filterParams['tag'] = $value;        }        if (count($filterParams)) {            $url .= '?' . http_build_query($filterParams);        }        return $url;    }    public function getClearTagUrl($value) {        $url = $this->Link();        $filterParams = $this->getFilterURLParams();        if (is_array($filterParams['tag'])) {            foreach ($filterParams['tag'] as $key => $val) {                if ($val == $value) {                    unset($filterParams['tag'][$key]);                }            }        } else {            unset($filterParams['tag']);        }        if (count($filterParams)) {            $url .= '?' . http_build_query($filterParams);        }        return $url;    }    /**     * Common sql query to select GalleryImage rows from database table     *     * @return SQLQuery     */    protected function getGalleryQueryBuilder() {        $qb = new SQLQuery();        $qb            ->setSelect(array(                'GalleryImage.ID',                'GalleryImage.ClassName',                'GalleryImage.Created',                'GalleryImage.LastEdited',                'GalleryImage.Title',                'GalleryImage.Size',                'GalleryImage.MaxSize',                'GalleryImage.LastLinkSegment',                'GalleryImage.GalleryPageID',                'GalleryImage.ImageID',                'GalleryImage.AuthorID',            ))            ->setFrom('GalleryImage')            ->setOrderBy(array('GalleryImage.Created DESC'))            ->setWhere('GalleryImage.GalleryPageID = ' . $this->ID) // Images must belong to this page        ;        return $qb;    }    /**     * Filter Gallery Images by author, size and tag     *     * @param SQLQuery $qb     * @param String $filterName author|size|tag     * @param string $id filterName id in database table     * @return SQLQuery     */    protected function addFilterToQuery(SQLQuery $qb, $filterName, $id) {        switch ($filterName) {            case 'author':                $qb                    ->addWhere(array(                        'GalleryImage.AuthorID = ' . $id,                    ))                ;                break;            case 'size':                //$qb->addWhere($this->arraySize[$id]['SQLWhere']);                $qb->addWhere('GalleryImage.Size = \'' . $id . '\'');                break;            case 'tag':                $list = '';                if (is_array($id)) {                    $list = '\'' . implode('\', \'', $id) . '\'';                } else {                    $list = '\'' . $id . '\'';                }                $qb                    ->addLeftJoin('GalleryImage_Tags', 'GalleryImage_Tags.GalleryImageID = GalleryImage.ID')                    ->addWhere(array(                        'GalleryImage_Tags.ElementLinkID in (' . $list . ')',                    ))                    ->setGroupBy("GalleryImage.ID")                    ->setHaving("count(ElementLinkID) = " . count($id))                ;                break;        }        return $qb;    }    /**     * Filter Gallery Images by existing url params     *     * @param SQLQuery $qb     * @return SQLQuery     */    protected function applyFiltersFromRequest($qb) {        $filters = $this->getFilterURLParams();        if ($this->getAction() == 'viewTag') {            $value = $filters['tag'];            if (is_array($value)) {                $value[] = $this->urlParams["Action"];            } else {                $value = array($value, $this->urlParams["ID"]);            }            $filters['tag'] = $value;        } else {            $filters[$this->urlParams['Action']] = $this->urlParams['ID'];        }        foreach ($filters as $var => $value) {            $id = null;            switch ($var) {                case 'author':                    $author = DataObject::get_one("PeopleFace", "\"PeopleFace\".\"LastLinkSegment\" = '" . $value . "'");                    $id = $author->ID;                    break;                case 'size':                    $id = $value;                    break;                case 'tag':                    $filterBySubSite = "ElementLink.SubsiteID = " . Subsite::currentSubsiteID();                    if (is_array($value)) {                        $id = array_keys(DB::query("SELECT ID FROM ElementLink WHERE " . $filterBySubSite . " and LastLinkSegment in ('" . implode('\', \'', $value) . "')")->map());                    }                    else {                        $id = array_keys(DB::query("SELECT ID FROM ElementLink WHERE " . $filterBySubSite . " and LastLinkSegment = '" . addslashes($value) . "'")->map());                    }                    break;            }            if ($id) {                $qb = $this->addFilterToQuery($qb, $var, $id);            }        }        return $qb;    }    /**     * Gallery Images Page filtered by Author     *     * @return array     */    public function viewAuthor() {        /** @var PeopleFace $author */        $author = null;        if ($this->urlParams['ID']) {            $id = preg_replace('!([^a-z0-9-])!', '', str_replace(' ', '-', strtolower($this->urlParams['ID'])));            $author = DataObject::get_one("PeopleFace", "\"PeopleFace\".\"LastLinkSegment\" = '" . $id . "'");            if(!$author){                $this->httpError(404);            }        }        else {            $this->httpError(404);        }        $title = $author->TitleRU ? $author->TitleRU : $author->TitleEN;        return array(            'MenuTitle' => $title,            'Title' => $title,            'BackURL' => $this->request->getHeader('Referer')        );    }    /**     * Gallery Images Page filtered by Tag     *     * @return array     */    public function viewTag() {        /** @var ElementLink $tag */        $tag = null;        if($this->urlParams['ID']) {            $id = preg_replace('!([^a-z0-9-])!', '', str_replace(' ', '-', strtolower($this->urlParams['ID'])));            $tag = DataObject::get_one("ElementLink", "\"ElementLink\".\"LastLinkSegment\" = '" . $id . "'");            if(!$tag){                $this->httpError(404);            }        }        else {            $this->httpError(404);        }        $title = $tag->TitleRU ? $tag->TitleRU : $tag->TitleEN;        return array(            'Title' => $title,            'MenuTitle' => $title,            'BackURL' => $this->request->getHeader('Referer')        );    }    /**     * Gallery Images Page filtered by Size     *     * @return array     */    public function viewSize() {        $title = $this->Title;        $id = $this->urlParams['ID'];        if ($id) {            $title = $this->arraySize[$id]['MenuTitle'];        }        else {            $this->httpError(404);        }        return array(            'Title' => $title,            'MenuTitle' => $title,            'BackURL' => $this->request->getHeader('Referer')        );    }    /**     * view Gallery Image     *     * @return array     */    public function view() {        // todo отображать главную картинку и маленький список картинок, расположенных справа и слева        /** @var GalleryImage|null $image */        $image = null;        if($this->urlParams['ID']) {            $id = $this->urlParams['ID'];            if (is_numeric($id)) {                $image = GalleryImage::get_by_id("GalleryImage", $id);            } else {                $image = GalleryImage::get_by_url($id);            }            if (!$image->ID) {                $this->httpError(404);            }        }        else {            $this->httpError(404);        }        $ssv = new SSViewer('Page');        $ssv->setTemplateFile('Layout', 'GalleryPage_view');        return $this->customise($image)->renderWith($ssv);    }    /**     * @param int $itemsPerPage     * @param SQLQuery|null $query     * @return null|PaginatedList     */    public function GalleryImages(SQLQuery $query = null,  $itemsPerPage = 25)    {        if (!$query) {            $query = $this->getGalleryQueryBuilder();        }        $query = $this->applyFiltersFromRequest($query); // additional filters based on url params        Session::set('BackURL', $this->request->getURL(true));        $start = $this->request->getVar('start');        $query = new SQLQuery("*", '(' . $query->sql() . ') t');        $query->setLimit($itemsPerPage, $start ?: 0);        $images = new ArrayList();        $records = $query->execute();        foreach($records as $rowArray) {            $images->push(new GalleryImage($rowArray));        }        $pages = new PaginatedList($images, $this->request);        $pages            ->setLimitItems(false)            ->setPaginationFromQuery($query)        ;        return $pages;    }    public function Tags() {    }}