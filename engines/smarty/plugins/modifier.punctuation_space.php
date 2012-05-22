<?php

function smarty_modifier_punctuation_space($text)
{
    return preg_replace('/(\S[,\.])\s*(\S)/', '$1 $2', $text);
}
