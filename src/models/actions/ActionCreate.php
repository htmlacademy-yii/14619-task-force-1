<?php


namespace taskforce\models\actions;


class ActionCreate extends AbstractAction
{
    function getName(): string
    {
        return "Создать";
    }

    function getInternalName(): string
    {
        return "action_create";
    }

    function checkRole($executorId, $userId): bool
    {
        return $executorId === $userId;
    }
}
