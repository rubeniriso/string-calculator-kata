<?php

namespace RubenIriso\StringCalculatorKata;

class StringCalculator
{
    function add(String $numberInput){
        $sum = 0;
        $errorMessage = "";
        $thereAreErrors = false;
        $standardDelimiter = "/[\n,]/";

        if($numberInput != ""){
            $delimiter = $this->retrieveStringDelimiter($numberInput);
            $inputArguments = $this->retrieveInputArguments($numberInput, $delimiter);
            
            if ($delimiter == $standardDelimiter){
                $occurrenceLineJumpComma = strpos($numberInput, ",\n");
                $occurrenceCommaLineJump = strpos($numberInput, "\n,");
                if ($occurrenceLineJumpComma != false) {
                    $errorMessage .= "Number expected but '\n' found at position " . $occurrenceLineJumpComma + 1 . " ";
                    $thereAreErrors = true;
                } else if ($occurrenceCommaLineJump != false) {
                    $errorMessage .= "Number expected but '\n' found at position " . $occurrenceCommaLineJump + 1 . " ";
                    $thereAreErrors = true;
                }
            }

            $negativeNumberArray = array_filter($inputArguments, function($x) {
                return $x < 0 && $x != "";
            });
            if (sizeof($negativeNumberArray)>0) {
                $errorMessage .= "Negative not allowed : " . implode(', ', $negativeNumberArray) . " ";
                $thereAreErrors = true;
            }

            $positionOfLastElement = sizeof($inputArguments) - 1;
            if ($inputArguments[$positionOfLastElement] == "") {
                $errorMessage .= "Number expected but NOT found ";
                $thereAreErrors = true;
            }

            if ($thereAreErrors){
                return substr($errorMessage, 0, -1);
            }

            else {
                foreach ($inputArguments as $index => $argument) {
                    $sum = $sum + $argument;
                }
                return $sum;
            }
        }
        return(0);
    }
    private function retrieveStringDelimiter ($number)
    {
        if (($number[0]) == "/" && ($number[1]) == "/") {
            $lineJumpPosition = strpos($number, "\n");
            $customDelimiter = substr($number, 2, $lineJumpPosition-2);
            return $customDelimiter;
        }
        return "/[\n,]/";
    }
    private function retrieveInputArguments ($number, $delimiter){
        if ($delimiter == "/[\n,]/"){
            $inputArguments = preg_split($delimiter, $number);
        }
        else {
            $lineJumpPosition = strpos($number, "\n");
            $inputArguments = substr($number, $lineJumpPosition + 1, (strlen($number)));
            $inputArguments = preg_split("/[$delimiter]/", $inputArguments, 0,PREG_SPLIT_NO_EMPTY) ;
        }
        return $inputArguments;
    }
}