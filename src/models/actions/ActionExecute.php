<?php


namespace taskforce\models\actions;


class ActionExecute extends AbstractAction
{

    function getName(): string
    {
        return "Выполнить";
    }

    function getInternalName(): string
    {
        return "action_execute";
    }

    function checkRole($executorId, $userId): bool
    {
        return $executorId === $userId;
    }
}
