<?php
/**
 * Classer pour parser des fichier csv qui sont au format windows-1252
 */
abstract class sfCsvParserWin extends sfCsvParser{
	
	public function clean(&$value, $key){
		stripslashes(trim(iconv('Windows-1252', 'UTF-8//TRANSLIT',$value)));
	}
}