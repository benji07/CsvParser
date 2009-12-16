<?php

require dirname(__FILE__).'/CsvParser.class.php';

/**
 * Classer pour parser des fichier csv qui sont au format windows-1252
 */
abstract class CsvParserISO extends CsvParser {

  public function clean(&$value, $key) {
    stripslashes(trim(iconv('ISO-8859-1', 'UTF-8//TRANSLIT',$value)));
  }
}