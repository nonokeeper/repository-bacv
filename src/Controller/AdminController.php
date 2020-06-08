<?php

namespace App\Controller;
 
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
 
class AdminController extends EasyAdminController
{
    public function persistEntity($entity)
    {
        $this->setEntity($entity);
        parent::persistEntity($entity);
    }
 
    public function updateEntity($entity)
    {
        $this->setEntity($entity);
        parent::updateEntity($entity);
    }
 
    private function setEntity($entity)
    {
        if (method_exists($entity, 'addSondage') and method_exists($entity, 'removeSondage')) {
            $sondages = $entity->getSondages();

            if ($sondages->count() > 0) {
                foreach ($sondages->getIterator() as $i => $sondage) {
                    $sondage->addQuestion($entity);
                }
            }
        }
    }
}