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
        $this->IPAddress = $ip;

        return $this;
    }

    public function setDownloadedFile(File $file) {
        $this->FileID = $file->ID;
        $this->FileName = $file->getTitle();
        $this->Size = $file->getSize();
        $this->AbsoluteSize = $file->getAbsoluteSize();

        return $this;
    }

    public function setBrowser(Browser $browser) {
        $this->setField('Browser', $browser->getName());
        $this->setField('System', $browser->getSystem());
        $this->setField('Device', $browser->getDevice());

        return $this;
    }
}
