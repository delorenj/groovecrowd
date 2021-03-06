<?php

namespace GC\DataLayerBundle\Tests;

use GC\DataLayerBundle\Helpers;

class HelpersTest extends \PHPUnit_Framework_TestCase
{
	private $terms = array(
   			"this is cool" => "this-is-cool",
   			"THIS is Balls" => "this-is-balls",
   			"Time & Shoes" => "time-shoes",
   			"I attempted to reduce boots...all i got was - ASS" => "i-attempted-to-reduce-bootsall-i-got-was-ass" 
   			);

    public function testSlugify()
    { 
   		foreach($this->terms as $pre=>$post) {
   			$this->assertEquals(Helpers::slugify($pre), $post);
   		}
    }

    public function testCodify()
    {
      $id = 100;
      $code = Helpers::idToCode($id);

      $this->assertEquals($id, Helpers::codeToId($code));
    }
}