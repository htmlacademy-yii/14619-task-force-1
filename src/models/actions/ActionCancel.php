<?php


namespace taskforce\models\actions;


class ActionCancel extends AbstractAction
{

    function getName(): string
    {
        return "Отменить";
    }

    function getInternalName(): string
    {
        return "action_cancel";
    }

    function checkRole($executorId, $userId): bool
    {
        return $executorId === $userId;
    }
}
