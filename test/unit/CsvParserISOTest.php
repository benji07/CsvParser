<?php

require_once dirname(__FILE__).'/../lime/lime.php';

require_once dirname(__FILE__).'/../../lib/CsvParserISO.class.php';

$t = new lime_test(1);

class MockupCsvParserISO extends CsvParserISO{
  
  protected $_columns = array('id','name');
  
  public function parseLine(stdClass $line){
    $this->data[] = $line;  
  }
  
  public $data = array();
}

$compare = new stdClass();
$compare->id = '1';
$compare->name = 'éèàe';

$parser = new MockupCsvParserISO();

$parser->parse(dirname(__FILE__).'/../fixtures/mock_iso.csv');

$t->is($parser->data[0]->name,$compare->name, 'Convert ISO to UTF-8 string');