<?php


namespace taskforce\models\action;

/**
 * Class ActionRefuse - описывает действие "Отказаться" (для исполнителя)
 * @package taskforce\models\action
 */
class ActionRefuse extends Action
{
    /**
     * Проверка прав для выполнения действия
     * @param int $idExecutor - исполнитель задания
     * @param int $idCustomer - заказчик задания
     * @param int $idCurrentUser - текущий пользователь
     * @return bool
     */
    protected function checkRights(int $idExecutor, int $idCustomer, int $idCurrentUser): bool
    {
        return !empty($idCurrentUser) && !empty($idExecutor) && $idCurrentUser === $idExecutor;
    }
}
