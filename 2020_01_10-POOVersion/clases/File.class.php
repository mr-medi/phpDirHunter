<?php
    class File
    {
        private $name;
        private $extension;

        public function __construct($name , $extension)
        {
            $this -> name = $name;
            $this -> extension = $extension;
        }
    }
 ?>
