<?php

namespace Barberry\Pipe;

class Exception extends \Exception {
    public function __construct($msg) {
        parent::__construct($msg);
    }
}
