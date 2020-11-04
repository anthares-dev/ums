<?php

//* Creaiamo la connessione con il database

//utilizzo requiree non include perchè è essenziale che trovi qualcosa
//require 'config.php';
// Inseriamo ciò che ritorna config.php dentro una variabile globale che poi distrggiamo a fine codice
$config = require 'config.php';
//var_dump($config);

//classe/procedurale(construtto) mysqli (un metodo non piu tanto in uso)
//Represents a connection between PHP and a MySQL database.
$mysqli = new mysqli($config['mysql_host'],
    $config['mysql_user'],
    $config['mysql_password'],
    $config['mysql_db']
);

//distruggiamo variabile globale
unset($config);

//controlliamo se c'è un errore di connessione
if ($mysqli->connect_error) {
    die($sqli->connect_error);
} else {
    //echo 'Connessione riuscita';
    //var_dump($mysqli);
}