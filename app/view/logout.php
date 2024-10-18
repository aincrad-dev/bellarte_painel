<?php
defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');
session_destroy();
header('Location: ./');
?>