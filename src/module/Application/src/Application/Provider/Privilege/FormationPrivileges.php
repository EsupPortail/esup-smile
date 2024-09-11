<?php

namespace Application\Provider\Privilege;

use UnicaenPrivilege\Provider\Privilege\Privileges;

class FormationPrivileges extends Privileges
{
    const FORMATION_INDEX = 'formation-formation_index';

    const FORMATION_AFFICHER = 'formation-formation_afficher';
    const FORMATION_AJOUTER = 'formation-formation_ajouter';
    const FORMATION_MODIFIER = 'formation-formation_modifier';
    const FORMATION_SUPPRIMER = 'formation-formation_supprimer';

    const FORMATION_MOBILITE = 'formation-formation_mobilite';

    const FORMATION_PARAMETRE_AFFICHER = 'formation-parametre_afficher';
    const FORMATION_PARAMETRE_MODIFIER = 'formation-parametre_modifier';

    const COMPOSANTE_AFFICHER = 'formation-composante_afficher';
    const COMPOSANTE_AJOUTER = 'formation-composante_ajouter';
    const COMPOSANTE_MODIFIER = 'formation-composante_modifier';
    const COMPOSANTE_SUPPRIMER = 'formation-composante_supprimer';
}
