<?php

class Scrape
{

  protected $source;
  protected $html;

  /**
  ** @param string $url Target page
  **/
  function __construct($url)
  {
    $this->source = $url;
  }

  function getHtml() {

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $this->source); 
    $this->html = curl_exec($ch); 
    curl_close($ch);
    return $this->html;

  }

  /**
  ** @param String $resource Html that requires processing
  ** @param String $starttag First target tag/string to search by
  ** @param String $endtag last target tag/string to search by
  ** @return Array Containing contents of tags
  **/
  function getItemsByTag($resource, $starttag, $endtag) {
    preg_match_all("'".$starttag."(.*?)".$endtag."'si", $resource, $result);

    return $result[1];

  }

  /**
  ** @param Array $data Html that requires processing
  ** @param Int $beginning Items to be trimmed from beginning
  ** @param Int $end last Items to be trimmed from end
  ** @return Array Containing trimmed data
  **/
  function trimData($data, $beginning, $end) {

    for ($i=0; $i < $beginning; $i++) {
      array_shift($data);
    }
    for ($i=0; $i < $end; $i++) {
      array_pop($data);
    }

    return $data;

  }

  /**
  ** @param Array $data Raw scraped data
  ** @return Json Converted array
  **/
  function cleanData($data) {

    $data = json_encode($data);
    $data = str_replace('\n', '', $data);
    $data = strip_tags($data);

    return $data;

  }

}

 ?>
