<?php

require_once dirname(__FILE__).'/../lime/lime.php';

require_once dirname(__FILE__).'/../../lib/CsvParser.class.php';

$t = new lime_test(4);

class MockupCsvParser extends CsvParser{
  
  protected $_columns = array('id','name');
  
  public function parseLine(stdClass $line){
    $this->data[] = $line;  
  }
  
  public $data = array();
}

$parser = new MockupCsvParser();

// file not found test
try{  
  $parser->parse(dirname(__FILE__).'/../fixtures/mock2.csv');
  $t->fail('File found');
}
catch (Exception $e){
  $t->pass('File not found');
}

// file found test
try{  
  $parser->parse(dirname(__FILE__).'/../fixtures/mock.csv');
  $t->pass('File found');
}
catch (Exception $e){
  $t->fail('File not found');
}

$t->is(count($parser->data),1, 'One object parse');
// parse line accept stdObject in right format

$compare = new stdClass();
$compare->id = '1';
$compare->name = 'Lorem ipsum';

$t->is((array)$parser->data[0], (array)$compare, 'Object type get by parseLine is right');