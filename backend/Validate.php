<?php
  abstract class Validate {
    # vars
    public $value;
  }

  class ValidateString extends Validate {
    # constructor
    function __construct(string $value) {
      $this->value = $value;
    }

    # functions
    function min(int $value) : bool {
      return (strlen($this->value) >= $value) ? true : false;
    }

    function max(int $value) : bool {
      return (strlen($this->value) <= $value) ? true : false;
    }

    function length(int $value) : bool {
      return (strlen($this->value) == $value) ? true : false;
    }
  }
?>