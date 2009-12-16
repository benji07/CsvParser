<?php

require_once dirname(__FILE__).'/../lime/lime.php';

require_once dirname(__FILE__).'/../../lib/CsvParserWin.class.php';

$t = new lime_test(1);

class MockupCsvParserWin extends CsvParserWin{
  
  protected $_columns = array('id','name');
  
  public function parseLine(stdClass $line){
    $this->data[] = $line;  
  }
  
  public $data = array();
}

$compare = new stdClass();
$compare->id = '1';
$compare->name = 'éèàe';

$parser = new MockupCsvParserWin();

$parser->parse(dirname(__FILE__).'/../fixtures/mock_win.csv');

$t->is($parser->data[0],$compare, 'Convert Window-1252 to UTF-8 string');