<?php

  /**
  * @backupGlobals disabled
  * @bacupStaticAttributes disabled
  */

  require_once "src/Cuisine.php";

  $server = 'mysql:host=localhost;dbname=food_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class CuisineTest extends PHPUnit_Framework_TestCase
  {
        protected function tearDown()
        {
          Cuisine::deleteAll();
        }

        function test_save()
        {
          //Arrange
          $description = "Vietnamese";
          $test_cuisine = new Cuisine($description);
          //Act
          $test_cuisine->save();
          //Assert
          $result = Cuisine::getAll();
          $this->assertEquals($test_cuisine, $result[0]);
        }
        function test_getAll()
        {
          //Arrange
          $description = "Vietnamese";
          $description2 = "Mexican";
          $test_cuisine = new Cuisine($description);
          $test_cuisine->save();
          $test_cuisine2 = new Cuisine($description2);
          $test_cuisine2->save();
          //Act
          $result = Cuisine::getAll();
          //Assert
          $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
          //Arrange
          $description = "Vietnamese";
          $description2 = "Mexican";
          $test_cuisine = new Cuisine($description);
          $test_cuisine->save();
          $test_cuisine2 = new Cuisine($description2);
          $test_cuisine2->save();

          //Act
          Cuisine::deleteAll();

          //Assert
          $result = Cuisine::getAll();
          $this->assertEquals([], $result);
        }
        function test_getId()
        {
          //Arrange
          $description = "Vietnamese";
          $id = 1;
          $test_cuisine = new Cuisine($description, $id);
          //Act
          $result = $test_cuisine->getId();
          //Assert
          $this->assertEquals(1, $result);
        }

        function test_find()
        {
          //Arrange
          $description = "Vietnamese";
          $description2= "Mexican";
          $test_cuisine = new Cuisine($description);
          $test_cuisine->save();
          $test_cuisine2 = new Cuisine($description2);
          $test_cuisine2->save();

          //Act
          $id = $test_cuisine->getId();
          $result = Cuisine::find($id);

          //Assert
          $this->assertEquals($test_cuisine, $result);
        }


  }


?>
