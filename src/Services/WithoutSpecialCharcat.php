<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class WithoutSpecialCharcat
{
    public function replace($stringToConvert)
    {
        /*MAJUSCULES*/
        $without = strtolower($stringToConvert);
        /*espace*/
        $without = str_replace(" ", "", $without);
        /*speciaux*/
        $without = str_replace(" ", "", $without);
        $without = str_replace("'", "", $without);
        $without = str_replace("[", "", $without);
        $without = str_replace("]", "", $without);
        $without = str_replace("«", "", $without);
        $without = str_replace("»", "", $without);
        $without = str_replace("!", "", $without);
        $without = str_replace(":", "", $without);
        $without = str_replace("?", "", $without);
        $without = str_replace("#", "", $without);
        $without = str_replace("(", "", $without);
        $without = str_replace(")", "", $without);
        $without = str_replace("}", "", $without);
        $without = str_replace("{", "", $without);
        $without = str_replace("+", "", $without);
        $without = str_replace("/", "", $without);
        $without = str_replace("*", "", $without);
        $without = str_replace("_", "", $without);
        $without = str_replace("&", "", $without);
        $without = str_replace("=", "", $without);
        $without = str_replace("^", "", $without);
        $without = str_replace("%", "", $without);
        $without = str_replace("$", "", $without);
        $without = str_replace("¤", "", $without);
        $without = str_replace("£", "", $without);
        $without = str_replace("~", "", $without);
        $without = str_replace("°", "", $without);
        $without = str_replace(";", "", $without);
        $without = str_replace("§", "", $without);
        /*A*/
        $without = str_replace("Á", "a", $without);
        $without = str_replace("À", "a", $without);
        $without = str_replace("Â", "a", $without);
        $without = str_replace("Ã", "a", $without);
        $without = str_replace("Ä", "a", $without);
        $without = str_replace("à", "a", $without);
        $without = str_replace("ä", "a", $without);
        $without = str_replace("â", "a", $without);
        $without = str_replace("á", "a", $without);
        $without = str_replace("ã", "a", $without);
        $without = str_replace("ª", "a", $without);
        /*I*/
        $without = str_replace("Í", "i", $without);
        $without = str_replace("Ì", "i", $without);
        $without = str_replace("Î", "i", $without);
        $without = str_replace("Ï", "i", $without);
        $without = str_replace("í", "i", $without);
        $without = str_replace("ï", "i", $without);
        $without = str_replace("î", "i", $without);
        $without = str_replace("ì", "i", $without);
         /*E*/
        $without = str_replace("É", "e", $without);
        $without = str_replace("È", "e", $without);
        $without = str_replace("Ê", "e", $without);
        $without = str_replace("Ë", "e", $without);
        $without = str_replace("é", "e", $without);
        $without = str_replace("è", "e", $without);
        $without = str_replace("ê", "e", $without);
        $without = str_replace("ë", "e", $without);
        /*O*/
        $without = str_replace("Ó", "o", $without);
        $without = str_replace("Ó", "o", $without);
        $without = str_replace("Ò", "o", $without);
        $without = str_replace("Ô", "o", $without);
        $without = str_replace("Õ", "o", $without);
        $without = str_replace("Ö", "o", $without);
        $without = str_replace("ó", "o", $without);
        $without = str_replace("ò", "o", $without);
        $without = str_replace("ö", "o", $without);
        $without = str_replace("ô", "o", $without);
        $without = str_replace("õ", "o", $without);
        $without = str_replace("º", "o", $without);
         /*u*/
        $without = str_replace("ü", "u", $without);
        $without = str_replace("û", "u", $without);
        $without = str_replace("ú", "u", $without);
        $without = str_replace("ù", "u", $without);
        $without = str_replace("Ú", "u", $without);
        $without = str_replace("Ù", "u", $without);
        $without = str_replace("Û", "u", $without);
        $without = str_replace("Ü", "u", $without);
        $without = str_replace("µ", "u", $without);
        $without = str_replace("ů", "u", $without);
        /*ç*/
        $without = str_replace("Ç", "c", $without);
        $without = str_replace("ç", "c", $without);
        /*N*/
        $without = str_replace("ñ", "n", $without);
        $without = str_replace("Ñ", "n", $without);

        return $without;
    }
}
