<?php
namespace stats\Test;
use stats\Baseball;

require_once 'Baseball.php';

class BaseballTest extends \PHPUnit_Framework_TestCase
{
    /*setUp and tearDown runs with every assertion, before and afer*/
    
    public  function setUp() {
        parent::setUp();
        $this->instance = new Baseball();
    }
    
    public function tearDown() {
        parent::tearDown();
        unset( $this->instance);
    }

        public function testCalcAvgEquals()
    {
        $atbats = 389;
        $hits = 129;
        
        $result = $this->instance->calc_avg($atbats,$hits);
        $expectedresult = $hits/$atbats;
        
        //$this->assertEquals($result, $expectedresult);
        
        $formatexpectedresult = number_format($hits/$atbats);
         $this->assertEquals($result, $formatexpectedresult);
    }
    
    public function testCalcHitsAreStrings()
    {
         $atbats = 389;
        $hits = 'wefaw';
   
        $result = $this->instance->calc_avg($atbats,$hits);
        $expectedresult = $hits/$atbats;
        
        //$this->assertEquals($result, $expectedresult);
      
        $formatexpectedresult =0.000;
         $this->assertEquals($result, $formatexpectedresult);
    }
    
    /*
     * annotation -dataproviders.
     * there are alot like these. chcek these in https://phpunit.de/manual/current/en/appendixes.annotations.html#appendixes.annotations.covers*/
    /**
     *@dataProvider providerCalcArgs
    * @covers Baseball::calc_avg
    */
    
    
    public function testCalc($atbats,$hits)
    {
         if(!is_numeric($atbats)){
                $avg="not a number";
                return $avg;
              
            }
        
        $result = $this->instance->calc_avg($atbats,$hits);
        $expectedresult = $hits/$atbats;
        
        //$this->assertEquals($result, $expectedresult);
        
        $formatexpectedresult = number_format($hits/$atbats);
         $this->assertEquals($result, $formatexpectedresult);
    }
//data providers
        public function  providerCalcArgs()
    {
        return array(
           
            array(389,129),
            array('hello',129),
            array(389,'hello'),
            array('hello','hello')
            );
           
            
    }
    
    /*Dependency testing*/
    public function testSlugging()
    {
        
        $slg = $this->instance->calc_slg(389, 106,12, 4, 7);
        $expectedslg = number_format(((106*1)+(12*2)+(4*3)+(7*4))/389,3);
        $this->assertEquals($expectedslg, $slg);
        return $slg;
        
    }
    
    
    public  function testOnBasePerc()
    {
        
        $obp = $this->instance->calc_obp(389, 23,6,7,129);
        $expectedobp = number_format((129+23+6+7)/389,3);
        $this->assertEquals($obp,$expectedobp );
        return $obp;
    }
    
    /** annotationss -depends
     * this depends on the order we delecare this parameters, 
     * it have to be in the order of the passing parameters
     * 
     * @depends testSlugging
     *  @depends testOnBasePerc
     */
    public function testOps($slgg,$obp)
    {
       // var_dump("slg: $slgg\n","obp: $obp");
      
        $ops = $this->instance->calc_ops($slgg,$obp);
        $expectedops= $obp + $slgg;
        $this->assertEquals($ops,$expectedops );
    }  
    //if either testSluggling or TestOnbasePerc fail, testOps wil be skipped.
    

    
    //PHPUnit relies heavily on reflection class,
    // it makes a copy and allow us to access private methods.
    /*
     * call proteced/private method of a class.
     * 
     * @param object &object Instantiated object that will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     * 
     * @return mixed method return
     * 
     * //PHPUnit refeection available in verions >=5.3.2
     * //accessing a private method with a refelction class.
     */
    
    public function invokeMethod(&$object,$methodName,array $parameters =  array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
    
    public function testcalc_ops_private()
    {
              $slgg = .363;
              $obp = .469;
              $expectedops= $obp + $slgg;
              $acutaloutput = $this->invokeMethod($this->instance, 'calc_ops_private',array($slgg,$obp));
              $this->assertEquals($expectedops,$acutaloutput);
              
    }
    
       /* public function testOpsprivate()
    {
        // var_dump("slg: $slgg\n","obp: $obp");
      $slgg = .363;
      $obp = .469;
        $ops = $this->instance->calc_ops_private($slgg,$obp); // you cannot access this private method like this.
        $expectedops= $obp + $slgg;
        $this->assertNotEquals($ops,$expectedops );
    }*/
    
    /*Mock Objects
     * 
     * mimics behavoir of the object.
     * ex: we mock a data object got from a DB where it's not set up yet.
     * known as a Test Double
     * ignore final,private and static variales.
     */
    
    
}

