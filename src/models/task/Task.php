<?php

declare(strict_types=1);

namespace taskforce\models\task;

use taskforce\exceptions\task\ActionNotFoundException;
use taskforce\exceptions\task\StatusNotFoundException;
use taskforce\exceptions\user\UserRuleNotFoundException;
use taskforce\models\action\ActionCancel;
use taskforce\models\action\ActionCreate;
use taskforce\models\action\ActionExecute;
use taskforce\models\action\ActionRefuse;
use taskforce\models\action\ActionRespond;

/**
 * Class Task - класс "Задание"
 * @package taskforce\models\task
 */
class Task
{
    private $executor_id;
    private $customer_id;
    private $current_user_id;
    private $current_status;
    private $current_user_role;

    const STATUS_NEW = 'status_new';
    const STATUS_CANCELED = 'status_canceled';
    const STATUS_WORK = 'status_work';
    const STATUS_EXECUTED = 'status_executed';
    const STATUS_FAILED = 'status_failed';

    const RULE_EXECUTOR = 'executor';
    const RULE_CUSTOMER = 'customer';

    const ACTION_CREATE = 'action_create';
    const ACTION_CANCEL = 'action_cancel';
    const ACTION_RESPOND = 'action_respond';
    const ACTION_EXECUTE = 'action_execute';
    const ACTION_REFUSE = 'action_refuse';

    const STATUSES_MAP = [
        self::RULE_EXECUTOR => [
            self::ACTION_CREATE => self::STATUS_NEW,
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_EXECUTE => self::STATUS_EXECUTED,
        ],
        self::RULE_CUSTOMER => [
            self::ACTION_CREATE => self::STATUS_NEW,
            self::ACTION_RESPOND => self::STATUS_WORK,
            self::ACTION_REFUSE => self::STATUS_FAILED
        ]
    ];

    public function __construct(string $user_rule, string $current_status)
    {
        $this->executor_id = 1;
        $this->customer_id = 2;
        $this->current_user_id = 2;

        if (!in_array($user_rule, $this->getUserRules())) {
            throw new UserRuleNotFoundException("Такой роли пользователя не существует.");
        }

        $this->current_user_role = $user_rule;

        if (!in_array($current_status, $this->getStatuses())) {
            throw new StatusNotFoundException("Такого статуса задачи не существует.");
        }

        $this->current_status = $current_status;
    }

    private function getUserRules(): array {
        return [self::RULE_EXECUTOR, self::RULE_CUSTOMER];
    }

    private function getActions(): array {
        return [self::ACTION_CANCEL, self::ACTION_CREATE, self::ACTION_EXECUTE,
            self::ACTION_REFUSE, self::ACTION_RESPOND];
    }

    private function getStatuses(): array {
        return [self::STATUS_CANCELED, self::STATUS_EXECUTED, self::STATUS_FAILED,
            self::STATUS_NEW, self::STATUS_WORK];
    }

    /**
     * @return int
     */
    public function getExecutorId(): int
    {
        return $this->executor_id;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    /**
     * @return string
     */
    public function getCurrentStatus(): string
    {
        return $this->current_status;
    }

    /**
     * @return string
     */
    public function getCurrentUserRole(): string
    {
        return $this->current_user_role;
    }

    /**
     * Получение списка действий для ролей
     * @return array[]
     */
    private function getActionsMap(): array
    {
        return [
            self::RULE_CUSTOMER => [
                self::STATUS_NEW => [new ActionCancel('Отменить', self::ACTION_CANCEL)],
                self::STATUS_WORK => [new ActionExecute('Выполнено', self::ACTION_EXECUTE)]
            ],
            self::RULE_EXECUTOR => [
                self::STATUS_NEW => [new ActionRespond('Откликнуться', self::ACTION_RESPOND)],
                self::STATUS_WORK => [new ActionRefuse('Отказаться', self::ACTION_REFUSE)]
            ],
        ];
    }

    /**
     * Получение списка доступных действий для роли пользователя
     * @param $status
     * @return mixed|null
     */
    public function getUserActions($status): ?array
    {
        $currentUserRole = $this->getCurrentUserRole();
        $actions = $this->getActionsMap();

        // поиск текущей роли в списке
        if(!array_key_exists($currentUserRole, $actions)) {
            throw new UserRuleNotFoundException("Такой роли пользователя не существует.");
        }

        // поиск статуса в списке действий
        if (!array_key_exists($status, $actions[$currentUserRole])) {
            throw new UserRuleNotFoundException("Такого статуса задачи не существует.");
        }

        $statusActions = $actions[$currentUserRole][$status];

        for ($i = 0; $i < count($statusActions); $i++) {
            if (!$statusActions[$i]->checkRights($this->executor_id, $this->customer_id, 2)) {
                unset($statusActions[$i]);
            }
        }

        return array_filter($statusActions);
    }

    /**
     * Получение следующего статуса
     * @param $action
     * @return string|null
     */
    public function getNextStatus($action): ?array
    {
        if(!array_key_exists($this->current_user_role, self::STATUSES_MAP)) {
            throw new UserRuleNotFoundException("Такой роли пользователя не существует.");
        }

        if (!array_key_exists($action, self::STATUSES_MAP[$this->current_user_role])) {
            throw new ActionNotFoundException("Такого действия не существует.");
        }

        return self::STATUSES_MAP[$this->current_user_role][$action];
    }
}
