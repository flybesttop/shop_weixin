<?php
class utilHelper
{
    public function toCamel($data)
    {
        $result = array();
        for ($i = 0; $i < sizeof($data); $i++) {
            $temp = array();
            foreach ($data[$i] as $key => $value) {

                $key = preg_replace_callback("/_[a-z]/", function ($matches) {
                    return strtoupper($matches[0][1]);
                }, $key);
                $temp[$key] = $value;
            }
            array_push($result, $temp);
        }
        return $result;
    }
}
?>