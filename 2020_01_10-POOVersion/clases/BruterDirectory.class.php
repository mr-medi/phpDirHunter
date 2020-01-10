<?php
    class BruterDirectory extends Bruter
    {
        private $directories;

        public function __construct($list)
        {
            parent::__construct($list);
            $this -> directories = array();
        }

        function doBruter($urls, $custom_options = null, &$DIRECTORIOS)
        {
              $rolling_window = 10;
              $rolling_window = (count($urls) < $rolling_window) ? count($urls) : $rolling_window;
              $master = curl_multi_init();
              $curl_arr = array();
              $std_options = array(CURLOPT_RETURNTRANSFER => true,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_MAXREDIRS => 5,
              CURLOPT_USERAGENT => 'DHUnter ;)');
              $options = ($custom_options) ? ($std_options + $custom_options) : $std_options;
              for ($i = 0; $i < $rolling_window; $i++)
              {
                $ch = curl_init();
                $options[CURLOPT_URL] = $urls[$i];
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
                        $DIRECTORIOS[$i] = $info['url'];
                        ++$i;
                    }
                    $output = curl_multi_getcontent($done['handle']);
                    $ch = curl_init();
                    curl_setopt_array($ch,$options);
                    curl_multi_add_handle($master, $ch);
                    curl_multi_remove_handle($master, $done['handle']);
                    $options[CURLOPT_URL] = $urls[$i++];
                }
            }while ($running);
          curl_multi_close($master);
          return true;
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
