<?php

require("./Scrape.php");

    $querystring = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($querystring, $vars);
    $data = array();
    $item = array();
    if(isset($vars['publishers'])) {
      $publisherList = explode(',', $vars['publishers']);
    }
    $publisherList = array_map('strtoupper', $publisherList);
    $scrapeUrl = $vars['week'] ? $vars['week'] . '-week' : 'this-week';
    $scrape = new scrape("http://www.comiclist.com/index.php/newreleases/" . $scrapeUrl);
    $page = $scrape->getHtml();
    $sections = $scrape->getItemsByTag($page,'<p>','</p>');
    foreach ($sections as $section) {
      $publisher = $scrape->getItemsByTag($section,'<u>','</u>');
      $titles = $scrape->getItemsByTag($section,'>','</a>');
      if (strpos($titles[0], $publisher[0]) !== false) {
        $newFirst = str_replace($publisher[0],'',$titles[0]);
        $titles[0] = $newFirst;
      }

      if(isset($vars['novariants']) && $vars['novariants'] == 1) {
        $novariants = array();
        foreach ($titles as $title) {
          $trimtitle = trim($title);
          if (strpos($trimtitle, ' Variant') !== false || strpos($trimtitle, '(Cover') !== false) {
            $stringArray = explode(" (", $trimtitle);
            $strippedTags = strip_tags($stringArray[0]);
            if(!in_array($strippedTags, $novariants)) {
              array_push($novariants, $strippedTags);
            }
          } else {
            array_push($novariants, $title);
          }
        }
        $titles = $novariants;
      }

      if($publisherList && (!isset($vars['titles']) || $vars['titles'] == 0)) {
        if(in_array($publisher[0], $publisherList)) {
          $item = array('publisher'=>$publisher[0], 'titles'=>$titles);
          array_push($data, $item);
        }
      } else if (isset($vars['titles']) && $vars['titles'] == 1) {
          foreach ($titles as $title) {
            array_push($item, $title);
          }
      } else {
          $item = array('publisher'=>$publisher[0], 'titles'=>$titles);
          array_push($data, $item);
      }
    }

    if(!isset($vars['publishers']) && (!isset($vars['titles']) || $vars['titles'] == 0)) {
      $data = $scrape->trimData($data, 6, 14);
    } else if (isset($vars['titles']) && $vars['titles'] == 1) {
      $data['titles'] = $scrape->trimData($item, 8, 14);
    }

    $data = $scrape->cleanData($data);
    header( "HTTP/1.1 200 OK" );
    header("Access-Control-Allow-Origin: *");
    echo($data);
?>
