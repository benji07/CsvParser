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

    $f = fopen($filename,'r');
    if($this->_ignoreFirstLine) {
      fgetcsv($f,0,$this->_separator);
    }

    $this->preParse();

    while($line = fgetcsv($f,0,$this->_separator)) {
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
  public function clean(&$value, $key) {
    $value = trim(stripslashes($value));
  }
}
