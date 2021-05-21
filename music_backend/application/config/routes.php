<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

$route['genresListing'] = 'genres/genresListing';
$route['genresListing/(:num)'] = "genres/genresListing/$1";
$route['addNewGenre'] = "genres/addNewGenres";
$route['editGenre'] = "genres/editGenres";
$route['deleteGenre'] = "genres/deleteGenres";

$route['djsListing'] = 'djs/djsListing';
$route['djsListing/(:num)'] = "djs/djsListing/$1";
$route['addNewDJ'] = "djs/addNewDJs";
$route['editDJ'] = "djs/editDJs";
$route['deleteDJ'] = "djs/deleteDJs";

$route['musicListing'] = 'music/musicListing';
$route['musicListing/(:num)'] = "music/musicListing/$1";
$route['addNewMusic'] = "music/addNewMusic";
$route['saveNewMusic'] = "music/saveNewMusic";
$route['editMusic/(:num)'] = "music/editMusic/$1";
$route['saveEditMusic'] = "music/saveEditMusic";
$route['deleteMusic'] = "music/deleteMusic";

/*frondend urls*/
$route['home'] = "frontend";
$route['privacy-policy'] = "Privarypolicy/index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */

/*
 * Image List
 * */
$route['saveResponse'] = "response/saveResponse";
/**
 *Backend
 */
$route['register'] = 'authenticate/register';
$route['login'] = 'authenticate/login';
$route['resetpassword'] = 'authenticate/resetPassword';

$route['getgenreslist'] = 'genres/getGenresList';
$route['getdjslist'] = 'djs/getDJsList';
$route['getprofile'] = 'djs/getProfile';
$route['setprofile'] = 'djs/setProfile';
$route['getmusiclist'] = 'music/getMusicList';
$route['gettopmusiclist'] = 'music/getTopMusicList';
$route['getmusicswithgenre'] = 'music/getMusicsWithGenre';
$route['getmusicswithdj'] = 'music/getMusicsWithDJ';
$route['getmusicinfo'] = 'music/getMusicPlay';
$route['sendrequest'] = 'contact/sendEmail';
$route['regist_token'] = 'authenticate/registerToken';
$route['sendnotification/(:any)'] = 'music/sendNotification/$1';

$route['like-music'] = 'music/likeMusic';
$route['dislike-music'] = 'music/disLikeMusic';

$route['addplaylist'] = 'music/addPlaylist';
$route['removeplaylist'] = 'music/removePlaylist';
$route['getplaylist'] ='music/getPlaylist';

$route['add-comment'] = 'music/addComment';
$route['update-comment'] = 'music/updateComment';
$route['delete-comment'] = 'music/deleteComment';