<?php


namespace taskforce\models\action;


abstract class Action
{
    private $name;
    private $innerName;

    /**
     * Action constructor.
     * @param $name
     */
    public function __construct(string $name, string $innerName)
    {
        $this->name = $name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getInnerName() : string {
        return $this->innerName;
    }

    /**
     * Проверка прав для выполнения действия
     * @param int $idExecutor
     * @param int $idCustomer
     * @param int $idCurrentUser
     * @return bool
     */
    abstract protected function checkRights(int $idExecutor, int $idCustomer, int $idCurrentUser) : bool;
}
