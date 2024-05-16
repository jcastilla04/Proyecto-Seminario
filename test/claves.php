<?php

$clave1 = "SENATI30353";
$clave2 = "SISTEMA2025";

var_dump(password_hash($clave1,PASSWORD_BCRYPT));
var_dump(password_hash($clave2,PASSWORD_BCRYPT));
