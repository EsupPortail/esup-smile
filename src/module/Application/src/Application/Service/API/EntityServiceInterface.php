<?php


namespace Application\Application\Service\API;


interface EntityServiceInterface
{
    /**
     * Retourne la classe de l'entité courante
     */
    public function getEntityClass();


    public function find($id);
    public function findAll();

    public function add($entity, $serviceEntityClass = null);
    public function update($entity, $serviceEntityClass = null);
    public function delete($entity, $serviceEntityClass = null);
}