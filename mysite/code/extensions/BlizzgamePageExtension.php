<?php

class BlizzgamePageExtension extends Extension {

    protected function translateCyrilicToLatin($string){
        $arr = array(
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH',
            'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU',
            'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
            'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        );
        $key = array_keys($arr);
        $val = array_values($arr);
        $translate = str_replace($key, $val, $string);
        $translate = (function_exists('mb_strtolower')) ? mb_strtolower($translate) : strtolower($translate);
        return $translate;
    }

    public function generateURLSegment($title) {
        $t = (function_exists('mb_strtolower')) ? mb_strtolower($title) : strtolower($title);
        $t = $this->translateCyrilicToLatin($t);
        $t = str_replace('&amp;', '-and-', $t);
        $t = str_replace('&','-and-',$t);
        $t = preg_replace('/[^A-Za-z0-9]+/', '-', $t);
        $t = preg_replace('/-+/', '-', $t);
        return parent::generateURLSegment($t);
    }
} 