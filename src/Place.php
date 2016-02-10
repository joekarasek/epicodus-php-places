<?php
class Place
{
    private $city;
    private $country;
    private $image_src;
    private $year_visited;

    function __construct($city, $country, $year_visited, $image_src)
    {
        $this->city = $city;
        $this->country = $country;
        $this->image_src = $image_src;
        $this->year_visited = $year_visited;
    }

    function getCity()
    {
        return $this->city;
    }

    function setCity($city)
    {
        $this->city = (string) $city;
    }

    function getCountry()
    {
        return $this->country;
    }

    function getImage()
    {
        return $this->image_src;
    }

    function getYear()
    {
        return $this->year_visited;
    }

    function save()
    {
        array_push($_SESSION['list_of_places'], $this);
    }

    static function getAll()
    {
        return $_SESSION['list_of_places'];
    }



}

?>
