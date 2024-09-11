<?php


require __DIR__ . '/../vendor/autoload.php';

use Unicaen\BddAdmin\Bdd;

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/../.env');

/* Paramètres d'accès à votre BDD */
$config = [
    'driver'   => 'Postgresql', // Postgresql ou Oracle
    'host'     => $_ENV['DB_HOST'],  // IP ou nom DNS
    'port'     => $_ENV['DB_PORT'],  // port, à adapter
    'dbname'   => $_ENV['DB_NAME'],  // Nom de votre base de données
    'username' => $_ENV['DB_USER'],  // Utilisateur
    'password' => $_ENV['DB_PSWD'],  // Mot de passe
];

$bdd = new Bdd($config);

$bdd->setOptions([
    /* Facultatif, permet de spécifier une fois pour toutes le répertoire où sera renseignée la DDL de votre BDD */
    Bdd::OPTION_DDL_DIR                => getcwd() . '/BddAdmin/data/ddl',

    /* Facultatif, spécifie le répertoire où seront stockés vos scripts de migration si vous en avez */
    Bdd::OPTION_MIGRATION_DIR          => getcwd() . '/BddAdmin/migration/',

    /* Facultatif, permet de personnaliser l'ordonnancement des colonnes dans les tables */
    Bdd::OPTION_COLUMNS_POSITIONS_FILE => getcwd()
        . '/BddAdmin/data/ddl_columns_pos.php',
]);

// première requête pour tester, à personnaliser selon votre modèle de données


try {



    $ddl = $bdd->getRefDdl();

    $filters = [
        $ddl::FUNCTION => [
            'excludes' => ['uuid_%']
        ],
    ];

    $sql = $bdd->diff($ddl, $filters)->toScript();
    //save sql to file
    file_put_contents(getcwd() . '/BddAdmin/data/diff/diff.sql', $sql);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
