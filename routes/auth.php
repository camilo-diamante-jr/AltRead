<?php


$this->router->addRoute('/login', ['AuthController', 'login']);
$this->router->addRoute('/student/registration', ['AuthController', 'registrationForm']);
$this->router->addRoute('/logout', ['AuthController', 'logout']);
