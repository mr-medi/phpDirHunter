<?php
    class Directory
    {
        private $directory;
        private $files;

        public function __construct($name)
        {
            $this -> directory = $name;
            $this -> files = array();
        }

        public function getDirectory()
        {
            return $this -> directory;
        }

        public function addFile(File $file)
        {
            $this -> files[] = $file;
        }
    }
 ?>
