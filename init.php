<?
class Log
{
    //Log::write('message', 'file');
    static function write($mess = "", $n = true, $name = "log")
    {

        if (strlen(trim($mess)) < 2) {
            return false;
        }
        if (preg_match("/^([_a-z0-9A-Z]+)$/i", $name, $matches)) {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $name . '.txt';

            if(filesize($file_path) > (1024*1024)) //1мб то удаляем
            {
                self::fullclear($name);
            }
            if ($n) $text = date('d.m H:i:s') . ' | ' . $mess . "<br>";
            else $text = $mess . PHP_EOL;

            $handle = fopen($file_path, "a");
            @flock($handle, LOCK_EX);
            fwrite($handle, $text);
            @flock($handle, LOCK_UN);
            fclose($handle);
            return true;
        } else {
            return false;
        }
    }

    static function clear($name = "log")
    {
        if (preg_match("/^([_a-z0-9A-Z]+)$/i", $name, $matches)) {
            $handle = fopen($file_path, "a");
            @flock($handle, LOCK_EX);
            fwrite($handle, '<br> ------------------------------- </br>');
            @flock($handle, LOCK_UN);
            fclose($handle);
            return true;
            return true;
        } else {
            return false;
        }
    }

    static function fullclear($name = "log")
    {
        if (preg_match("/^([_a-z0-9A-Z]+)$/i", $name, $matches)) {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $name . '.txt';
            $handle = fopen($file_path, "w");
            @flock($handle, LOCK_EX);
            fwrite($handle, '');
            @flock($handle, LOCK_UN);
            fclose($handle);
            return true;
        } else {
            return false;
        }
    }

    static function writeArray($arr, $n = true, $name = "log")
    {
        ob_start();
        print '<pre>';
        print_r($arr);
        print '</pre>';
        $value = ob_get_contents();
        ob_end_clean();
        self::write($value, $n = true, $name);
    }
}