<?php

namespace App\Test\TestCase\Utils;

use Cake\TestSuite\TestCase;
use App\Utils\PathParams;

class PathParamsTest extends TestCase {

    public function testParametro_Include_SemFormatacao() {
        $result = PathParams::extractInclude("(");
        $this->assertFalse($result->success);
        $this->assertEquals("O valor desse parametro deve estar entre parenteses", $result->error);

        $result = PathParams::extractInclude(")");
        $this->assertFalse($result->success);
        $this->assertEquals("O valor desse parametro deve estar entre parenteses", $result->error);

        $result = PathParams::extractInclude("ola");
        $this->assertFalse($result->success);
        $this->assertEquals("O valor desse parametro deve estar entre parenteses", $result->error);
    }

    public function testParametro_Include_umValor() {
        $result = PathParams::extractInclude("(param1)");
        $this->assertTrue($result->success);
        $this->assertEquals(1, sizeof($result->values));
        $this->assertEquals("param1", $result->values[0]);
    }

    public function testParametro_Include_doisValores() {
        $result = PathParams::extractInclude("(param1,param2)");
        $this->assertTrue($result->success);
        $this->assertEquals(2, sizeof($result->values));
        $this->assertEquals("param1", $result->values[0]);
        $this->assertEquals("param2", $result->values[1]);
    }

    public function testParametro_Include_semValor() {
        $result = PathParams::extractInclude("()");
        $this->assertTrue($result->success);
        $this->assertEquals(0, sizeof($result->values));
        
        $result = PathParams::extractInclude("");
        $this->assertTrue($result->success);
        $this->assertEquals(0, sizeof($result->values));
    }

    public function testParametro_In_semFormatacao() {
        $result = PathParams::extractIn(null);
        $this->assertFalse($result->success);
        $this->assertEquals("Não setado", $result->error);
        
        $messageError = "O valor desse parametro deve ser no formato in(numeros)";
        
        $result = PathParams::extractIn("(");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);

        $result = PathParams::extractIn(")");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);

        $result = PathParams::extractIn("ola");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);

        $result = PathParams::extractIn("()");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);

        $result = PathParams::extractIn("");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);
        
        $result = PathParams::extractIn("in(ola)");
        $this->assertFalse($result->success);
        $this->assertEquals($messageError, $result->error);
        
    }
    
     public function testParametro_In_umValor() {
        $result = PathParams::extractIn("in(2)");
        
        $this->assertTrue($result->success);
        $this->assertEquals(1, sizeof($result->values));
        $this->assertEquals(2, $result->values[0]);
    }
    
    public function testParametro_In_doisValores() {
        $result = PathParams::extractIn("in(2,10)");
        
        $this->assertTrue($result->success);
        $this->assertEquals(2, sizeof($result->values));
        $this->assertEquals(2, $result->values[0]);
        $this->assertEquals(10, $result->values[1]);
    }
    
}
