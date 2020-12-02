<?php

namespace taskforce\models\task;

/**
 * Class Task
 * @package taskforce\models\task
 */
class Task
{
    private $executor_id;
    private $customer_id;
    private $current_status;
    private $current_user_rule;

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
    const ACTION_EXECUTE = 'action_executed';
    const ACTION_REFUSE = 'action_refuse';

    const ACTIONS_MAP = [
        self::RULE_CUSTOMER => [
            self::STATUS_NEW => [self::ACTION_CANCEL],
            self::STATUS_WORK => [self::ACTION_EXECUTE]
        ],
        self::RULE_EXECUTOR => [
            self::STATUS_NEW => [self::ACTION_RESPOND],
            self::STATUS_WORK => [self::ACTION_REFUSE]
        ],
    ];

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
        $this->current_user_rule = $user_rule;
        $this->current_status = $current_status;
    }

    public function getCurrentUser()
    {
        return $this->current_user_rule;
    }

    public function getActions($status)
    {
        if(array_key_exists($this->current_user_rule, self::ACTIONS_MAP)) {
            if (array_key_exists($status, self::ACTIONS_MAP[$this->current_user_rule])) {
                return self::ACTIONS_MAP[$this->current_user_rule][$status];
            }
        }

        return null;
    }

    public function getNextStatus($action)
    {
        if(array_key_exists($this->current_user_rule, self::STATUSES_MAP)) {
            if (array_key_exists($action, self::STATUSES_MAP[$this->current_user_rule])) {
                return self::STATUSES_MAP[$this->current_user_rule][$action];
            }
        }

        return null;
    }
}
