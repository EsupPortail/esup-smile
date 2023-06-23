<?php
/**
 * Exemple de configuration globale du module unicaen/db-import.
 */

namespace Application;

use \UnicaenDbImport\Entity\Db\Source;

$importConfig = [
    'connections' => [
        // Cf. `./unicaen-db-import.local.php
    ],

    //
    // Classe de l'entité Doctrine représentant une "Source".
    //
    'source_entity_class' => Source::class,
    //
    // Code de la Source par défaut (injectée dans les entités implémentant SourceAwareInterface).
    //
    'default_source_code' => 'smile',
    //
    // Alias éventuels des noms de colonnes d'historique.
    //
    'histo_columns_aliases' => [
        'created_on' => 'histo_creation',     // date/heure de création de l'enregistrement
        'updated_on' => 'histo_modification', // date/heure de modification
        'deleted_on' => 'histo_destruction',  // date/heure de suppression
        'created_by' => 'histo_createur_id',     // auteur de la création de l'enregistrement
        'updated_by' => 'histo_modificateur_id', // auteur de la modification
        'deleted_by' => 'histo_destructeur_id',  // auteur de la suppression
    ],
    //
    // Forçage éventuel de valeur pour les colonnes d'historique.
    //
    'histo_columns_values' => [
        'created_by' => 1, // auteur de la création de l'enregistrement
        'updated_by' => 1, // auteur de la modification
        'deleted_by' => 1, // auteur de la suppression
    ],

    //
    // Témoin indiquant si la table IMPORT_OBSERV doit être prise en compte.
    // La table IMPORT_OBSERV permet d'inscrire les changements de valeurs à détecter pendant la synchro.
    // Les changements détectés sont consignés dans la table IMPORT_OBSERV_RESULT.
    // TODO : a voir comment cette table marche, actuellement non fornctionnel
    'use_import_observ' => false,
];


//Note : Possibilité d'importer plusieurs sources dans une même table. Pour la synchronisation, possibilité de faire une seul vue qui regroupe les différentes sources
//Import depuis Pick Your Courses
$import_composantes_PYC = [
    'name' => "import_composantes_PYC",
    'source' => [
        'name' => 'Composante_PYC',
//      'table' => 'composante',
        'select' => "SELECT code, libelle, libelle_web as libelle_long, libelle_court as acronyme FROM composante where deleted_on is null",
        'connection' => 'orm_pyc',
        'source_code_column' => 'code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'TABLE import_composante',
        'table' => 'import_composante',
        'connection' => 'orm_default',
        'source_code_column' => 'code',
    ],
];
$synchro_composantes = [
    'name' => "synchro_composantes", // Synchro des données mise en forme vers la table finale
    'source' => [
        'name' => 'Vue src_composante',
        'table' => 'src_composante',
//                    'select'             => 'SELECT source_id, code, code as source_code, libelle, libelle_long, acronyme FROM src_composante',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'Table Composante',
        'table' => 'composante',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
    ],
];
$importConfig['imports']['import_composantes_PYC'] = $import_composantes_PYC;
$importConfig['synchros']['synchro_composantes'] = $synchro_composantes;

$import_types_formations_PYC = [
    'name' => "import_types_formations_PYC",
    'source' => [
        'name' => 'Types_Formations_PYC',
//      'table' => 'type_formation',
        'select' => "SELECT source_code as code, libelle, libelle_court as acronyme FROM type_formation where deleted_on is null",
        'connection' => 'orm_pyc',
        'source_code_column' => 'code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'TABLE import_type_formation',
        'table' => 'import_type_formation',
        'connection' => 'orm_default',
        'source_code_column' => 'code',
    ],
];

$import_formations_PYC = [
    'name' => "import_formations_PYC",
    'source' => [
        'name' => 'Formation_PYC',
//      'table' => 'formation',
        'select' => "SELECT f.code as code,
       f.libelle, f.niveau as niveau_etude,
    t.source_code as type_diplome_code, 
    c.code as composante_code
FROM FORMATION f
         join type_formation t on t.id = f.type_id -- !!! type de formation dans PYC  correspond au type de diplome dans SMILE 
         join composante c on c.id = f.composante_id
",
        'connection' => 'orm_pyc',
        'source_code_column' => 'code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'TABLE import_formation',
        'table' => 'import_formation',
        'connection' => 'orm_default',
        'source_code_column' => 'code',
    ],
];

$synchro_formations = [
    'name' => "synchro_formations",
    'source' => [
        'name' => 'Vue src_formation',
        'table' => 'src_formation',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'Table Formation',
        'table' => 'formation',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
    ],
];
$importConfig['imports']['import_formations_PYC'] = $import_formations_PYC;
$importConfig['synchros']['synchro_formations'] = $synchro_formations;

$import_cours_PYC = [
    'name' => "import_cours_PYC",
    'source' => [
        'name' => 'Cours_PYC',
        //      'table' => 'formation',
        'select' => "SELECT c.cod_elp as code ,f.code as formation_code, c.cod_elp as code_elp,
       c.lib_elp as libelle, c.langue_enseignement,
       c.s1, c.s2, c.nbr_crd_elp as ects, c.nbr_vol_elp as vol_elp
FROM COURS c
         join formation f on f.id = c.formation_id
",
        'connection' => 'orm_pyc',
        'source_code_column' => 'code_elp',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'TABLE import_cours',
        'table' => 'import_cours',
        'connection' => 'orm_default',
        'source_code_column' => 'code_elp',
    ],
];

$synchro_cours = [
    'name' => "synchro_cours",
    'source' => [
        'name' => 'Vue src_cours',
        'table' => 'src_cours',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
        'code' => 'pyc'
    ],
    'destination' => [
        'name' => 'Table Cours',
        'table' => 'cours',
        'connection' => 'orm_default',
        'source_code_column' => 'source_code',
    ],
];
$importConfig['imports']['import_cours_PYC'] = $import_cours_PYC;
$importConfig['synchros']['synchro_cours'] = $synchro_cours;

return ['import' => $importConfig];