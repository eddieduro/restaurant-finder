<?php
    class Restaurant
    {
        private $name;
        private $id;
        private $cuisine_id;

      function __construct($name, $id = null, $cuisine_id)
      {
        $this->name = $name;
        $this->id = $id;
        $this->cuisine_id = $cuisine_id;
      }
      function getId()
      {
          return $this->id;
      }
      function getCuisineId()
      {
          return $this->cuisine_id;
      }
      function setName($new_name)
      {
        $this->name = (string) $new_name;
      }
      function getName()
      {
        return $this->name;
      }
      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO restaurant (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
      }
      static function getAll()
      {
        $returned_Restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
        $restaurants = array();
        foreach($returned_Restaurants as $restaurant)
          {
            $name = $restaurant['name'];
            $id = $restaurant['id'];
            $cuisine_id = $restaurant['cuisine_id'];
            $new_Restaurant = new Restaurant($name, $id, $cuisine_id);
            array_push($restaurants, $new_Restaurant);
          }
          return $restaurants;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM restaurant;");
      }
      static function find($search_id)
      {
        $found_restaurant = null;
        $restaurants = Restaurant::getAll();
        foreach($restaurants as $restaurant)
        {
          $restaurant_id = $restaurant->getId();
          if($restaurant_id == $search_id)
            {
              $found_restaurant = $restaurant;
            }
        }
        return $found_restaurant;
      }
        function update($new_name)
      {
        $GLOBALS['DB']->exec("UPDATE restaurant SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
      }
      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE id = {$this->getId()};");
      }
    }

 ?>
