<?php
/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 6/10/2018
 * Time: 8:37 AM
 */

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

    $this->assertsEquals(42, $cart->getTotal());
    //return an arrray of count
    $this->assertCount(2, $games);
    $this->assertCount(2, $games, 'incorrect filtering');
    $this->assertFileExists('/www/omg/imnj.jpg', 'file ecists');
    $this->assertJsonStringEqualsJsonString($expected, $apiResponse);
    $this->assertNotContains(5, $recommendation);
    $this->assertTrue($user->isEnabled());
}
