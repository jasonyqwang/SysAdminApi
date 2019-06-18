<?php
/**
 * Created by PhpStorm.
 * @author jason
 */
namespace Jsyqw\PHPUnit;

use Jsyqw\Utils\FileHelper;


class FileHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat(){
        $size = FileHelper::format(200, 2);
        $this->assertSame('200B',$size);


        $size = FileHelper::format(2000, 2);
        $this->assertSame('1.95KB',$size);
    }

    public function testDelDir(){
        $path = __DIR__.'/tmp/test';
        if(!file_exists($path)){
            mkdir($path,null, true);
        }

        $path = __DIR__.'/tmp';

        $rs = FileHelper::delDir($path);
        $this->assertTrue($rs);

        $rs = FileHelper::delDir($path, true);
        $this->assertTrue($rs);
    }

    public function testGetExt(){
        $str ='/tmp/test.JPG';

        $rs = FileHelper::getExt($str);
        $this->assertSame('jpg',$rs);
    }
}