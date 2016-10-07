<?php
namespace stats\Test;
use stats\BaseballApi;

require_once 'BaseballApi.php';

class BaseballApiTest extends \PHPUnit_Framework_TestCase
{/*mock objects - are create to pass data that has not been created yet. something like a DB call.*/
    
    
       /*Stub Methods

     * Stubs replace objects
     * will use getMock();
     * stubs and mocks are very different - from the Author
        * 
        * but for me they were very similar. he just have changed this code $baseball varible to $stub.
        * there were no difference.
        * 
     *      */
    public function  test_MockObject()
    {
       /* $baseball = $this->getmock('BaseballApi',array('submitAtBat')); //getMock is depreciated 
        print_r(get_class_methods($baseball));*/
        //this comes with the PHPunit framework.
        $baseball = $this->getMockBuilder('BaseballApi'); 
        $baseball->setMethods(array('submitAtBat'));
        #print_r(get_class_methods($baseball->getMock()));// this is how we access get mock object
        $mockobject = $baseball->getMock();
        $mockobject->expects($this->any())
                   ->method('submitAtBat')
                   ->will($this->returnValue(true));
        $somevalue=$mockobject->submitAtBat('1','bh');//the method that we need a mockobject.
        $this->assertEquals($somevalue, true);
    }
    
    /*Mockery is an external  framework for unit testing, they say this is popluar among developers*/
    public function testMockery()
    {
        //$mock->shouldReceive('somemethod')->atLeast()->once()->atMost()->twice();
        //->with(some arguments)->andReturn( new stdClass)
        $someObj= new BaseballApi();
        $someVal = true;
        $mockeryMock = \Mockery::mock('BaseballApi');
        $mockeryMock->shouldReceive('submitAtBat')->with('1','bh')->once()->andReturn($someVal);
       # print_r(get_class_methods($mockeryMock));
        $this->assertEquals($someVal,$someObj->submitAtBat('1', 'bh'));
        
    }
    
 
    
}


?>