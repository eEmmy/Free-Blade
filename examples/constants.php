<?php

/*
|--------------------------------------------------------------------------------------
| Constants.
|---------------------------------------------------------------------------------------
|
| These constants serve to indicate the path of the types of files and the domain of the
| site. This file will not be included in the production version (composer stable), and the
| constants must be defined manually.
|
| All values ​​must be passed with a forward slash (/).
|
*/

/*
|------------------------------------------------- -------------------------------------
| VIEWS.
|---------------------------------------------------------------------------------------
|
| Here you must define the path of the main directory of your views. O
| path must be passed from the server root ($_SERVER["DOCUMENT_ROOT"])
|
*/

define("VIEWS", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/views/");

/*
|--------------------------------------------------------------------------------------
| BASE_URL.
|--------------------------------------------------------------------------------------
|
| Here you must enter the domain of your website, with a slash (/) at the end.
|
*/

define("BASE_URL", "http://localhost/");

/*
|--------------------------------------------------------------------------------------
| JS_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your JS files will be stored in.
|
*/

define("JS_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/js/");

/*
|--------------------------------------------------------------------------------------
| CSS_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your CSS files will be stored in.
|
*/

define("CSS_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/css/");

/*
|--------------------------------------------------------------------------------------
| IMAGE_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your image files will be stored in.
|
*/

define("IMAGE_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/images/");

/*
|--------------------------------------------------------------------------------------
| VIDEO_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your video files will be stored in.
|
*/

define("VIDEO_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/videos/");

/*
|--------------------------------------------------------------------------------------
| AUDIO_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your audio files will be stored in.
|
*/

define("AUDIO_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/audios/");

/*
|--------------------------------------------------------------------------------------
| FAVICON_DIR.
|--------------------------------------------------------------------------------------
|
| Here you define which directory your favicon.ico file will be stored in.
|
*/

define("FAVICON_DIR", $_SERVER["DOCUMENT_ROOT"] . "/Free-Blade/examples/content/images/");