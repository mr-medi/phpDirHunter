<?php
    class BruterDirectory extends Bruter
    {
        private $directories;
        private $domain;

        public function __construct($domain,$list)
        {
            parent::__construct($list);
            $this -> domain = $domain;
            $this -> directories = array();
        }

        function doSearch()
        {
              $directorios = array();
              $rolling_window = 100;
              $rolling_window = (count($this -> list) < $rolling_window) ? count($this -> list) : $rolling_window;
              $master = curl_multi_init();
              $curl_arr = array();
              $std_options = array(CURLOPT_RETURNTRANSFER => true,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_MAXREDIRS => 2,
              CURLOPT_USERAGENT => 'DHunter');
              $options = $std_options;
              for ($i = 0; $i < $rolling_window; $i++)
              {
                $ch = curl_init();
                $options[CURLOPT_URL] = $this -> list[$i];
                curl_setopt_array($ch,$options);
                curl_multi_add_handle($master, $ch);
              }
              $i = 0;
              do
              {
                while(($execrun = curl_multi_exec($master, $running)) == CURLM_CALL_MULTI_PERFORM);
                if($execrun != CURLM_OK)
                    break;
                while($done = curl_multi_info_read($master))
                {
                    $info = curl_getinfo($done['handle']);                     
                    if ($info['http_code'] == 200)
                    {
                        $directorios[] = $info['url'];
                        $i++;
                    }
                    $output = curl_multi_getcontent($done['handle']);
                    $ch = curl_init();
                    curl_setopt_array($ch,$options);
                    curl_multi_add_handle($master, $ch);
                    curl_multi_remove_handle($master, $done['handle']);
                    $options[CURLOPT_URL] = $this -> list[$i++];
                }
            }while ($running);
          curl_multi_close($master);
          return $directorios;
        }

        public function doBruterDir($directories)
        {

        }

        public function doBruterFiles($extensions)
        {

        }

        public function __toString()
        {
            return $this -> directories .":".$this -> files;
        }

        public function addDirectory(Directory $directory)
        {
            $this -> directories[] = $directory;
        }
    }
 ?>
