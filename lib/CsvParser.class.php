<?php

/**
 * Classe pour gérer les traitements en csv
 */
abstract class CsvParser {

  /**
   * Liste des colonnes du fichier csv
   */
  protected $_columns = array();

  /**
   * Est-ce que l'on doit ignorer la première ligne (si elle contient le nom des colonnes par exemple)
   */
  protected $_ignoreFirstLine = true;

  /**
   * Le séparateur pour les colonnes ';' par défaut, mais ça peut être ','
   */
  protected $_separator = ';';


  public function parse($filename) {
    if(!file_exists($filename)) {
      throw new Exception('File not found: '.$filename);
    }

    $this->preParse();

    $f = fopen($filename,'rb');
    if($f == null){
      throw new Exception('Cound not open '.$filename.' for read');
    }
    
    if($this->_ignoreFirstLine) {
      fgets($f,1024);
    }

    while($line = fgets($f,1024)) {
      $line = $this->clean($line);
      $line = str_getcsv($line,$this->_separator);
      if(count($line) != count($this->_columns)) continue;
      $line = array_combine($this->_columns,$line);
      array_walk($line,array($this,'clean'));
      $this->parseLine((object)$line);
    }

    $this->postParse();
  }

  /**
   * Méthode qui est executer pour chaque ligne du fichier csv
   */
  abstract public function parseLine(stdClass $line);

  /**
   * Méthode executer avant que le fichier ne soit parser
   */
  public function preParse() {

  }

  /**
   * Méthode executer après que tous le fichier ai été parsé
   */
  public function postParse() {

  }

  /**
   * Méthode pour nettoyer le fichier csv
   */
  public function clean($value) {
    return trim(stripslashes($value));
  }
}
