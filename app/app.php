<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Place.php";

    session_start();
    if (empty($_SESSION['list_of_places'])) {
        $_SESSION['list_of_places'] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
        ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array(
            'places' => Place::getAll()
        ));
    });

    $app->post('/add_place', function() use ($app) {

        $place = new Place($_POST['city'], $_POST['country'], $_POST['year'], $_POST['image_src']);
        $place->save();

        return $app['twig']->render('home.html.twig', array(
            'places' => Place::getAll(),
            'message' => array(
                "text" => "Sounds like a fun trip!",
                'type' => 'info'
            )
        ));
    });

    $app->post('/delete_all', function() use ($app) {

        Place::deleteAll();
        return $app['twig']->render('home.html.twig', array(
            'places' => Place::getAll(),
            'message' => array(
                "text" => "Time to book a trip!",
                'type' => 'danger'
            )
        ));

    });

    $app->post('/delete_one', function() use ($app) {
        $name_of_place = $_POST['delete_one'];
        $found = false;
        foreach($_SESSION['list_of_places'] as $key => $place) {
            if ($place->getCity() == $name_of_place) {
                $found = true;
                $key_to_delete = $key;
                break;
            }
        }
        $place_to_delete = $_SESSION['list_of_places'][$key];
        $place_to_delete->delete();

        return $app['twig']->render('home.html.twig', array(
            'places' => Place::getAll(),
            'message' => array(
                "text" => $name_of_place . " was deleted!",
                'type' => 'danger'
            )
            ));
    });

    $app->get('/show_form', function() use ($app) {

        return $app['twig']->render('home.html.twig', array(
            'places' => Place::getAll(),
            'form' => true
            ));
    });

    return $app;
?>
