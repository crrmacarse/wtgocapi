<?php

    function odbc_escape_string_access($value){
        $replacements= array(
            "'" => "''",
        );
        return strtr($value, $replacements);
    }

    function base64_url_encode($input) {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

?>