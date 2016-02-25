<?php

  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once "src/Restaurant.php";
  require_once "src/Cuisine.php";

  $server = 'mysql:host=localhost;dbname=food_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class RestaurantTest extends PHPUnit_Framework_TestCase
  {
      protected function tearDown()
      {
        Restaurant::deleteAll();
        Cuisine::deleteAll();

      }

      function test_getName()
      {
        //Arrange
        $name = "Pho Shizzle";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        //Act
        $result = $test_Restaurant->getName();
        //Assert
        $this->assertEquals($name, $result);
      }
      function test_save()
      {
        //Arrange
        $id = null;
        $description = 'Vietnamese';
        $test_cuisine = new Cuisine($description, $id);
        $test_cuisine->save();

        $name = "Pho Shizzle";

        $cuisine_id = $test_cuisine->getId();

        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);

        //Act
        $test_Restaurant->save();
        //Assert
        $result = Restaurant::getAll();
        var_dump($result);
        $this->assertEquals($test_Restaurant, $result[0]);
      }
      function test_getAll()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2, $id, $cuisine_id);
        $test_Restaurant2->save();
        //Act
        $result = Restaurant::getAll();
        //Assess
        $this->assertEquals([$test_Restaurant, $test_Restaurant2], $result);
      }

      function test_deleteAll()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2, $id, $cuisine_id);
        $test_Restaurant2->save();

        //Act
        Restaurant::deleteAll();
        $result = Restaurant::getAll();

        //Assert
        $this->assertEquals([], $result);
      }
      function test_find()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2, $id, $cuisine_id);
        $test_Restaurant2->save();
        //Act
        $id = $test_Restaurant->getId();
        $result = Restaurant::find($id);
        //Assert
        $this->assertEquals($test_Restaurant, $result);
      }
        function testUpdate()
      {
        //Arrange
        $name = "Pho Shizzle";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        $test_Restaurant->save();
        $new_name = "Pho Kim";
        //Act
        $test_Restaurant->update($new_name);
        //Asses
        $this->assertEquals("Pho Kim", $test_Restaurant->getName());
      }
      function testDelete()
      {
        //Arrange
        $name = "Pho Shizzle";
        $id = 1;
        $cuisine_id = 1;
        $test_Restaurant = new Restaurant($name, $id, $cuisine_id);
        $test_Restaurant->save();

        $name2 = "Pho Kim";
        $test_Restaurant2 = new Restaurant($name2, $id, $cuisine_id);
        $test_Restaurant2->save();
        //Act
        $test_Restaurant->delete();
        //Assert
        $this->assertEquals([$test_Restaurant2], Restaurant::getAll());
      }

  }

?>
