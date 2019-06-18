<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\PHPUnit;


class ArrayHelperTest
{
    public function testToArray(){
        $users = [
            1 => (object)['id' => '1', 'title' => 'Manager', 'createTime' => '2018-01-01 12:00:00'],
            2 => (object)['id' => '2', 'title' => 'Manager2', 'createTime' => '2018-01-02 12:00:00'],
            3 => (object)['id' => '3', 'title' => 'Manager3', 'createTime' => '2018-01-03 12:00:00'],
        ];
        $users = (object)$users;

    }
}