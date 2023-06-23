Pour générer (terminale dans le docker) : 

Commande de base
`php vendor/doctrine/doctrine-module/bin/doctrine-module`

Génère le xml depuis la base
`php vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --from-database --namespace='Application\Entity\' xml module/Application/src/Application/Entity/Mapping/Generated/`

Génère les entités php depuis le xml
`php vendor/doctrine/doctrine-module/bin/doctrine-module orm:generate-entities module/Application/src/Application/Entity/Generated/`

Copie/paste your new xml Entities then remove the fils
`rm -rf /var/www/html/module/Application/src/Application/Entity/Mapping/Generated/*`

Copie/paste your new Entities then remove the fils
`rm -rf /var/www/html/module/Application/src/Application/Entity/Generated/*`

Il est possible que doctrine change la disposition du répertoire en fonction du namespace, vous pouvez redéplacer après.
