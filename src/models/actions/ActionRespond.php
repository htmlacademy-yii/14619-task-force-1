<?php


namespace taskforce\models\actions;


class ActionRespond extends AbstractAction
{

    function getName(): string
    {
        return "Откликнуться";
    }

    function getInternalName(): string
    {
        return "action_respond";
    }

    function checkRole($executorId, $userId): bool
    {
        return $executorId === $userId;
    }
}
