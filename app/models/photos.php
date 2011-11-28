<?php
class photos extends model {

    public $page_length = 100;

    public function __construct() {
        $this->start_time = 1314001860; //mktime(4, 31, 0, 8, 22, 2011);
    }

    public function all($options) {
        $query = sprintf('SELECT * FROM photos %s', $this->getLimit($options));
        return $this->getFilenames($query);
    }

    public function consolodated($options) {
        // 2011_08_22_04_31_23.jpg
        $query = sprintf('SELECT * FROM photos WHERE timestamp >= %d %s', $this->start_time, $this->getLimit($options));
        return $this->getFilenames($query);
    }

    public function sunrises($options) {
        $query = sprintf('SELECT * FROM photos WHERE hour >= 4 AND hour <= 5 AND timestamp >= %d %s', $this->start_time, $this->getLimit($options));
        error_log($query);
        return $this->getFilenames($query);
    }

    private function getLimit($options) {
        $no_limit = in_array('show-all', $options) || isset($options['show-all']);
        print_r($no_limit);
        if(!isset($options['page'])) $options['page'] = 0;
        return ($no_limit) ? '' : sprintf('LIMIT %d, %d', $this->page_length * $options['page'], $this->page_length);
    }

    private function getFilenames($query) {
        $result = mysql_query($query) or die(mysql_error());
        while($row = mysql_fetch_array($result)) {
            $return[] = $row;
        }
        return $return;
    }
}
?>