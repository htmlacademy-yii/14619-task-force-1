<?php


namespace taskforce\models\action;

/**
 * Class ActionRespond - описывает действие "Откликнуться" (для исполнителя)
 * @package taskforce\models\action
 */
class ActionRespond extends Action
{
    /**
     * Проверка прав для выполнения действия
     * @param int $idExecutor - исополнитель задания
     * @param int $idCustomer - заказчик задания
     * @param int $idCurrentUser - текущий пользователь
     * @return bool
     */
    protected function checkRights(int $idExecutor, int $idCustomer, int $idCurrentUser): bool
    {
        return !empty($idCurrentUser) && !empty($idExecutor) && $idCurrentUser === $idExecutor;
    }
}
