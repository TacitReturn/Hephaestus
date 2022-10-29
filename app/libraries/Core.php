<?php
    /*
    * Core.php
    * HephaestusMVC
    * Created: 10, 14 2022
    *@author Glenn G. Rudge <glenn@hyperwebdev.com>
    *@package
    */

    /*
     * Main app core class. Creates URL and loads core controller.
     * URL FORMAT: controller/method/params
     */

    use JetBrains\PhpStorm\Pure;

    class Core
    {
//        TODO:// Create a Controller class so this value isn't of type mix.
        protected mixed $currentController = "Pages";
        protected string $currentMethod = "index";
        protected array $params = [];

        public function __construct()
        {
            $url = $this->getUrl();

            /*
             * Check if $url array first value is available
             * Look in controller for first value.
             */

            if (isset($url[0]) && file_exists("../app/controllers/".ucwords($url[0]).".php")) {
                // If exists set as controller.
                $this->currentController = ucwords($url[0]);
                // Unset 0 Index.
                unset($url[0]);
            }
            // Require the controller
            require_once "../app/controllers/".$this->currentController.".php";

            // Instantiate controller class from /app/controllers
            $this->currentController = new $this->currentController;
        }

        public function getUrl()
        {
            if (isset($_GET["url"])) {
                // Removes white space from the URL.
                $url = rtrim($_GET["url"], "/");
                // Removes any characters from the URL that shouldn't be there.
                $url = filter_var($url, FILTER_SANITIZE_URL);
                // Returns an array of arguments passed to the URL, for example posts/edit/1 returns ['posts','edit', 1];
                return explode("/", $url);
            }
        }
    }
