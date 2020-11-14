<?php


namespace taskforce\models\actions;


class ActionRefuse extends AbstractAction
{

    function getName(): string
    {
        return "Отказаться";
    }

    function getInternalName(): string
    {
        return "action_refuse";
    }

    function checkRole($executorId, $userId): bool
    {
        return $executorId === $userId;
    }
}
