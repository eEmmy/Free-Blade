# Free-Blade
Implementation almost identical to the Laravel framework's Blade template engine.

### Prerequisites
* PHP 7.2 ou superior;
* Composer;

## Installation
Include ```"eemmy/free-blade": "1.0.0"``` in the require of your *composer.json* file.

### How to use
To use Free-Blade you will need, in addition to your views, two more things:

* Define the necessary constants, if you need help there are examples of how to do it in the examples (only available in the GitHub version);
* Call the required method for rendering the views

Views, just like in Laravel, must be saved with extension *.blade.php*
Subdirectories can be used in all folders that contain files related to page rendering (CSS, JS, etc.), however they must be indicated with a period instead of the traditional bar, thus: ```Template::render("subdir.view"); ```
