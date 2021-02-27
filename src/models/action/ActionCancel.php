<?php

declare(strict_types=1);

namespace taskforce\models\action;

/**
 * Class ActionCancel - описывает действие "Отменить" (для заказчика)
 * @package taskforce\models\action
 */
class ActionCancel extends Action
{
    /**
     * Проверка прав для выполненcheckRightsия действия
     * @param int $idExecutor - исополнитель задания
     * @param int $idCustomer - заказчик задания
     * @param int $idCurrentUser - текущий пользователь
     * @return bool
     */
    public function checkRights(int $idExecutor, int $idCustomer, int $idCurrentUser): bool
    {
        return !empty($idCurrentUser) && !empty($idCustomer) && $idCurrentUser === $idCustomer;
    }
}
