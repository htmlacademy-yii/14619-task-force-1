<?php


namespace taskforce\models\actions;


abstract class AbstractAction
{
    abstract function getName() : string;

    abstract function getInternalName() : string;

    abstract function checkRole() : bool;
}
