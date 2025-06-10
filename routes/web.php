<?php


$this->router->addRoute('/', ['LandingPageController', 'homepage']);
$this->router->addRoute('/navbar', ['LandingPageController', 'navbar']);
$this->router->addRoute('/hero', ['LandingPageController', 'hero']);
$this->router->addRoute('/features', ['LandingPageController', 'features']);
$this->router->addRoute('/how-it-works', ['LandingPageController', 'howItWorks']);
$this->router->addRoute('/about', ['LandingPageController', 'about']);
$this->router->addRoute('/contact', ['LandingPageController', 'contact']);
