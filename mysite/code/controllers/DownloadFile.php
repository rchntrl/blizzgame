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

    public function image() {
        $id = $this->urlParams['ID'];
        $ip = $_SERVER['REMOTE_ADDR'];
        /** @var Image $image */
        $image = Image::get_by_id('Image', $id);
        if ($image) {
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
        return $this->httpError(404);
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
}
