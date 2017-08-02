<?php

namespace App\Test\TestCase\Utils;

use Cake\TestSuite\TestCase;
use App\Utils\StringUtils;

class StringUtilsTest extends TestCase {
    
    public function testParametrosVazio(){
        $result = StringUtils::extractParamters("");
        $this->assertTrue($result->success);
        $this->assertEmpty($result->values);
    }
    
    public function testParametroSemFormatacao(){
        $result = StringUtils::extractParamters("(");
        $this->assertFalse($result->success);
        $this->assertEquals("O valor desse parametro deve estar entre parenteses",$result->error);
        
        $result = StringUtils::extractParamters(")");
        $this->assertFalse($result->success);
        
        $this->assertEquals("O valor desse parametro deve estar entre parenteses",$result->error);
        
        $result = StringUtils::extractParamters("ola");
        $this->assertFalse($result->success);
        
        $this->assertEquals("O valor desse parametro deve estar entre parenteses",$result->error);
      
    }
    
    public function testParametro_umValor() {
        $result = StringUtils::extractParamters("(param1)");
        $this->assertTrue($result->success);
        $this->assertEquals(1, sizeof($result->values));
        $this->assertEquals("param1",$result->values[0]);
    }
    
    public function testParametro_doisValores() {
        $result = StringUtils::extractParamters("(param1,param2)");
        $this->assertTrue($result->success);
        $this->assertEquals(2, sizeof($result->values));
        $this->assertEquals("param1",$result->values[0]);
        $this->assertEquals("param2",$result->values[1]);
    }
    
    public function testParametro_semValor() {
        $result = StringUtils::extractParamters("()");
        $this->assertTrue($result->success);
        $this->assertEquals(0, sizeof($result->values));
    }

}