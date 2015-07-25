<?php

class DownloadLog extends DataObject {

    private static $db = array(
        'IPAddress' => 'Varchar',
        'FileID' => 'Int',
        'FileName' => 'Varchar',
        'Size' => 'Varchar(10)',
        'AbsoluteSize' => 'Int',
        'Browser' => 'Varchar(50)',
        'System' => 'Varchar',
        'Device' => 'Varchar',
    );

    public function setIP($ip) {
        $this->IPAddress = $ip;

        return $this;
    }

    public function setDownloadedFile(File $file) {
        $this->FileID = $file->ID;
        $this->FileName = $file->getFilename();
        $this->Size = $file->getSize();
        $this->AbsoluteSize = $file->getAbsoluteSize();

        return $this;
    }

    public function setBrowser(Browser $browser) {
        $this->Browser = $browser->getName();
        $this->System = $browser->getSystem();
        $this->Device = $browser->getDevice();
    }
}
