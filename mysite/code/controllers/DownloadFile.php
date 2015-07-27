<?php

/**
 * Class DownloadFile
 *
 * @method Browser getBrowser
 */
class DownloadFile extends Controller {

    private static $allowed_actions = array(
        'image',
        'weekly',
        'daily'
    );

    private static $url_handlers = array(
        'image/$ID!' => 'image',
    );

    public function getBaseUrl() {
        return Director::BaseURL();
    }

    public function getDownloadsByIP($ip) {
        $q = new SQLQuery();
        $q
            ->setFrom('DownloadLog')
            ->setSelect('Count(*)')
            ->setWhere(array(
                'DAY(NOW()) = DAY(Created)',
                'IPAddress = \'' . $ip . '\'',
            ))
        ;
        return $q->execute()->value();
    }

    public function image() {
        $id = $this->urlParams['ID'];
        $ip = $_SERVER['REMOTE_ADDR'];
        /** @var Image $image */
        $image = Image::get_by_id('Image', $id);
        if ($image && $this->getDownloadsByIP($ip) < 100) {
            header('Content-type: ' . Http::get_mime_type($image->getFilename()));
            header('Content-Disposition: ' . 'attachment; filename="' . $image->getTitle() . '.' . $image->getExtension() . '"');
            header('Content-length: ' . $image->getAbsoluteSize());
            header('Cache-control: ' . 'private');
            try {
                readfile($image->getFullPath());
                $log = new DownloadLog();
                $log->setDownloadedFile($image);
                $log->setBrowser($this->getBrowser());
                $log->setIP($ip);
                $log->write();
            } catch (\Exception $ex) {
                $ex->getMessage();
            }
            exit;
        }
        echo 'You have exceeded the limit of downloads per day.';
    }

    public function weekly() {
        $q = new SQLQuery();
        $q
            ->setFrom('DownloadLog')
            ->setSelect(array(
                'IPAddress', 'Sum(AbsoluteSize) as CommonSize', 'Count(*) Count'
            ))
            ->setWhere('WEEK(NOW()) = WEEK(Created)')
            ->setGroupBy(array(
                'IPAddress'
            ))
            ->setOrderBy('CommonSize')
        ;
        $result = $q->execute();


        return $this->response->setBody($result->table());
    }

    public function daily() {
        $q = new SQLQuery();
        $q
            ->setFrom('DownloadLog')
            ->setSelect(array(
                'IPAddress', 'Sum(AbsoluteSize) as CommonSize', 'Count(*) Count'
            ))
            ->setWhere('DAY(NOW()) = DAY(Created)')
            ->setGroupBy(array(
                'IPAddress'
            ))
            ->setOrderBy('CommonSize')
        ;
        $result = $q->execute();
        return $this->response->setBody($result->table());
    }

    public function formatSize($integer) {
        $size = $integer;
        $metrics = array('bytes', 'KB', 'MB', 'GB', 'TB');
        $metric = 0;
        while (floor($size / 1024) > 0) {
            ++$metric;
            $size /= 1024;
        }
        if (isset($metrics[$metric])) {
            $format = round($size, 1) . ' ' . $metrics[$metric];
        } else {
            $format = $integer . ' ' . $metrics[0];
        }
        return $format;
    }
}
