# laravel-item-tracker
#### Author: David Millington, Nine Three Limited
This is a fun little personal project to help me learn Laravel and to test out the Pusher remote socket service.  Each user is has an item list where they can manage their own list items.  Using the handle next to each item they can drag items and their nested items to different nodes in their own list and also to other people's lists.  Changes are reflected in realtime for everybody that is logged in.  So if Amy and Alison are both logged in and Amy moves a branch of items then this change will be displayed on Alison's screen once the items have been placed.  A future update will show the items being dragged in realtime.  That functionality was not implemented in this version since I'm using the free Pusher package which is limited on the number of messages.

The site includes a user management system with 3 user levels:
1. Admin - Can edit modify users and interact with the item lists
2. Editor - Can interact with the item lists
3. Viewer - Can view the item lists but not interact with them

A live demo of the project can be found here:

https://itemtracker.ninethree.co.uk/login

Editor Logins:
* sandy@test.com ~ BingoBongo42
* amy@test.com ~ BingoBongo42

Viewer Login:
* alison@test.com ~ BingoBongo42

## Installation
1. Clone this repository: `git clone https://github.com/TannSan/laravel-item-tracker.git`
2. Create your `.env` file in the project root. There is a template file included called `.env.example` which you can rename
3. Set your site URL, email address and database details in the `.env` file.
4. Create a Pusher account: https://pusher.com
5. Create a new app channel via the Pusher dashboard called `item-tracker`
6. Set your Pusher ID, Key, Secret and Cluster in the `.env` file. You can find these details on the Pusher dashboard page for the app channel you created.
7. A bit of command line usage:
   * `composer update`
   * `php artisan key:generate`
   * `php artisan optimize`
   * `php artisan config:cache`
   * `php artisan migrate:fresh –seed`

## 3rd Party Assets
* [Lavaral 5](https://laravel.com)
* [jquery-sortable.js](http://johnny.github.com/jquery-sortable/)
* [Bootstrap 3.3.7](https://getbootstrap.com/docs/3.3/)
* [Spatie Laravel Permissions](https://github.com/spatie/laravel-permission)

## To Do
* Internationalisation of the admin and home screens
* Show real-time dragging on remote screens (mobile responsiveness makes this difficult)
* Add in the mobile HTML5 drag & drop shim
* Setup touch events for mobiles and tablets so can drag list items around with finger
* If a user is deleted then all their items should also be removed
* Do not delete a user that has items as it will create phantom items!
* Better visual handling for deep nesting
* Allow user panels to be repositioned
* Display new user panels without a page refresh being required
* User selectable icons for the list items
* Backend verification of Viewer role.  Currently the interactive toggle on the front end hides controls and disables fields but it can be easily changed
* Expand the user management system