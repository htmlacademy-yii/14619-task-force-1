<?php


namespace taskforce\models\action;

/**
 * Class ActionCreate - описывает действие "Выполнено" (для заказчика)
 * @package taskforce\models\action
 */
class ActionCreate extends Action
{
    /**
     * Проверка прав для выполнения действия
     * @param int $idExecutor - исополнитель задания
     * @param int $idCustomer - заказчик задания
     * @param int $idCurrentUser - текущий пользователь
     * @return bool
     */
    public function checkRights(int $idExecutor, int $idCustomer, int $idCurrentUser): bool
    {
        // Чтобы создать задание необходимо быть авторизованным в системе.
        return  $idCurrentUser !== 0;
    }
}
