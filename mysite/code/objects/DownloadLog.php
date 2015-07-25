<?php

class DownloadLog extends DataObject {

    private static $db = array(
        'IPAddress' => 'Varchar',
        'FileID' => 'Int',
        'Title' => 'Varchar',
        'FileName' => 'Varchar(255)',
        'Size' => 'Varchar(10)',
        'AbsoluteSize' => 'Int',
        'Browser' => 'Varchar',
        'System' => 'Varchar',
        'Device' => 'Varchar',
    );

    public function setIP($ip) {
        $this->setField('IPAddress', $ip);

        return $this;
    }

    public function setDownloadedFile(File $file) {
        $this->setField('FileID', $file->ID);
        $this->setField('Title', $file->getTitle());
        $this->setField('FileName', $file->getFilename());
        $this->setField('Size', $file->getSize());
        $this->setField('AbsoluteSize',$file->getAbsoluteSize());

        return $this;
    }

    public function setBrowser(Browser $browser) {
        $this->setField('Browser', $browser->getName());
        $this->setField('System', $browser->getSystem());
        $this->setField('Device', $browser->getDevice());

        return $this;
    }
}
