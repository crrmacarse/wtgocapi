<?php

    function odbc_escape_string_access($value){
        $replacements= array(
            "'" => "''",
        );
        return strtr($value, $replacements);
    }

?>