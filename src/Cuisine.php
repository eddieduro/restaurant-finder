<?php
    class Cuisine
    {
      private $description;
      private $id;

      function __construct($description, $id = null)
      {
        $this->description = $description;
        $this->id = $id;
      }

      function getId()
      {
        return $this->id;
      }

      function setDescription($new_description)
      {
        $this->description = (string) $new_description;
      }

      function getDescription()
      {
        return $this->description;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO cuisine (description) VALUES ('{$this->getDescription()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
      }

      function getRestaurant()
      {
          $restaurants = array();
          $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()}");
          var_dump($returned_restaurants);
          foreach($returned_restaurants as $restaurant) {
              $name = $restaurant['name'];
              $id = $restaurant['id'];
              $cuisine_id = $restaurant['cuisine_id'];
              $new_restaurant = new Restaurant($name, $id, $cuisine_id);
              array_push($restaurants, $new_restaurant);
          }
          return $restaurants;
      }

      static function getAll()
      {
        $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
        var_dump($returned_cuisines);
        $cuisines = array();
        foreach($returned_cuisines as $cuisine)
        {
            $description = $cuisine['description'];
            $id = $cuisine['id'];
            $new_cuisine = new Cuisine($description, $id);
            array_push($cuisines, $new_cuisine);
        }
        return $cuisines;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM cuisine;");
      }

      static function find($search_id)
      {
        $found_cuisine = null;
        $cuisines = Cuisine::getAll();
        foreach($cuisines as $cuisine) {
          $cuisine_id = $cuisine->getId();
          if($cuisine_id == $search_id) {
            $found_cuisine = $cuisine;
          }
        }
        return $found_cuisine;
      }

      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getId()};");
      }

    }

 ?>
