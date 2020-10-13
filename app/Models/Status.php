<?php


namespace App\Models;


/**
 * @property int $id
 * @property string $name
 */
class Status extends ArrayModel
{
    /** @var int  */
    const CREATED = 1;

    /** @var int  */
    const PAID = 2;

    /** @var int  */
    const FULFILLED = 3;

    /** @var int  */
    const ERROR = 4;

    /**
     * @return array[]
     */
    protected function getData(): array
    {
        return [
            [
                'id' => self::CREATED,
                'name' => 'created'
            ],
            [
                'id' => self::PAID,
                'name' => 'paid'
            ],
            [
                'id' => self::FULFILLED,
                'name' => 'fulfilled'
            ],
            [
                'id' => self::ERROR,
                'name' => 'error'
            ],
        ];
    }
}
