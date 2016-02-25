<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=food';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use($app){
      return $app['twig']->render('index.html.twig');
    });

    $app->get("/cuisines", function() use($app){
      return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app){
        $new_cuisine = new Cuisine($_POST['description']);
        $new_cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}", function ($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('current_cuisine.html.twig', array(
            'cuisine' => $cuisine, 'restaurants' => Restaurant::getAll()
        ));
    });

    $app->patch("/cuisines/{id}/rest_edit/{restaurant_id}", function ($id, $restaurant_id) use ($app) {
        $cuisine = Cuisine::find($id);
        $name = $_POST['name'];
        $restaurant = Restaurant::find($restaurant_id);
        $restaurant->update($name);
        // $restaurant->save();
        return $app['twig']->render('current_cuisine.html.twig', array(
            'cuisine' => $cuisine, 'restaurants' => Restaurant::getAll()
        ));
    });

    $app->get("/cuisine/{id}/edit/{restaurant_id}", function ($id, $restaurant_id) use ($app) {
        $cuisine = Cuisine::find($id);
        $restaurant = Restaurant::find($restaurant_id);
        // $restaurant->save();
        return $app['twig']->render('edit_restaurant.html.twig', array('cuisine' => $cuisine, 'restaurant' => $restaurant
        ));
    });

    $app->post("/cuisines/{id}", function ($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $new_restaurant = new Restaurant($_POST['name'], null, $id);
        $new_restaurant->save();
        return $app['twig']->render('current_cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $new_restaurant));
    });

    $app->delete("/cuisines/{id}", function($id) use ($app) {
    $cuisine = Cuisine::find($id);
    $cuisine->delete();
    return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    return $app;

 ?>
