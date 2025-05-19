<?php

require_once '../core/Controller.php';

class LandingPageController extends Controller
{

    public function homepage()
    {
        $this->renderView("/homepage/homepage");
    }

    public function navbar()
    {
        $this->renderView("/homepage/components/navbar");
    }
    public function hero()
    {
        $this->renderView("/homepage/components/hero");
    }
    public function features()
    {
        $this->renderView("/homepage/components/features");
    }
    public function howItWorks()
    {
        $this->renderView("/homepage/components/how-it-works");
    }
    public function about()
    {
        $this->renderView("/homepage/components/about");
    }
    public function contact()
    {
        $this->renderView("/homepage/components/contact");
    }
}
