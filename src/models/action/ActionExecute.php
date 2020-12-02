<?php


namespace taskforce\models\action;

/**
 * Class ActionExecute - описывает действие "Выполнено" (для заказчика)
 * @package taskforce\models\action
 */
class ActionExecute extends Action
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
        return !empty($idCurrentUser) && !empty($idCustomer) && $idCurrentUser === $idCustomer;
    }
}
