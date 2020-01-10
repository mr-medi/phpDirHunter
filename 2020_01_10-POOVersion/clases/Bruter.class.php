<?php
    abstract class Bruter
    {
        protected $list;

        public function __construct($list)
        {
            $this -> list = $list;
        }

        public function __toString()
        {
            return $this -> list;
        }
    }
 ?>
