<?php
namespace App\Controller;

class MentionsLegalesController {

    public function __construct() {}

    public function index(?array $params) {
        include __DIR__.'/../../templates/mentions_legales.html';
    }
}

?>