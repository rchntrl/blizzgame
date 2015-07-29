<?php

class CardPagesHolder extends Page {
    private static $allowed_children = array("CardGamePage");

    private static $default_child = "CardGamePage";
}

class CardPagesHolder_Controller extends Page_Controller {

}
