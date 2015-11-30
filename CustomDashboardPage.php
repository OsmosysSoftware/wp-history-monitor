<?php

/* *
 * Plugin Name: Wp-History-Monitor
 * Plugin URI:
 * Description: This plugin is used to monitor the history of posts, pages and user's details.
 * Version: 0.1.0
 * Author: Osmosys-Sivakumar T
 * Author URI: http://www.osmosys.asia
 * License: GPL2
 */

class CustomDashboardPage {
    
    public function __construct() {
        $this->enqueueStyles();
        $this->enqueueScripts();
        add_action('admin_menu', array($this, 'showUserDataUpToRequiredDate'));
        add_action('wp_ajax_show_user_posts', array($this, 'showUserPosts'));
        add_action('wp_ajax_show_user_pages', array($this, 'showUserPages'));
        add_action('wp_ajax_show_user_registered', array($this, 'showUsersRegistered'));
    }
    
    // Function to enqueue all the styles.
    function enqueueStyles() {
        wp_register_style('bootstrap-css', plugins_url() . '/CustomDashboardPage/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-css');
        wp_register_style('bootstrap-datepicker-css', plugins_url() . '/CustomDashboardPage/css/datepicker-min.css');
        wp_enqueue_style('bootstrap-datepicker-css');
        wp_register_style('pnotify.custom.min', plugins_url() . '/CustomDashboardPage/css/pnotify.custom.min.css');
        wp_enqueue_style('pnotify.custom.min');
        wp_register_style('datatable-css', plugins_url() . '/CustomDashboardPage/css/datatables.min.css');
        wp_enqueue_style('datatable-css');
        wp_enqueue_style( 'style', plugins_url() . '/CustomDashboardPage/css/style.css');
    }
    
    // Function to enqueue all the scripts.
    function enqueueScripts() {
        wp_enqueue_script('jquery');
        wp_register_script('bootstrap-js', plugins_url() . '/CustomDashboardPage/js/bootstrap.min.js');
        wp_enqueue_script('bootstrap-js');
        wp_register_script('moment-js', plugins_url() . '/CustomDashboardPage/js/moment.js');
        wp_enqueue_script('moment-js');
        wp_register_script('pnotify.custom.min', plugins_url() . '/CustomDashboardPage/js/pnotify.custom.min.js');
        wp_enqueue_script('pnotify.custom.min');
        wp_register_script('bootstrap-datepicker-script', plugins_url() . '/CustomDashboardPage/js/datepicker.js');
        wp_enqueue_script('bootstrap-datepicker-script');
        wp_register_script('datatable-js', plugins_url() . '/CustomDashboardPage/js/datatables.min.js');
        wp_enqueue_script('datatable-js');
        wp_enqueue_script('blockui',  plugins_url() . '/CustomDashboardPage/js/blockui.js');
        wp_enqueue_script( 'script', plugins_url() . '/CustomDashboardPage/js/script.js');
        wp_localize_script('script', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
    
    // Function to add menu page to wordpress dashboard. 
    function showUserDataUpToRequiredDate() {
	add_menu_page( 'Activity', 'Site activity', 'activate_plugins', 'userpage', array($this,'customDashBoardPage'), plugins_url('CustomDashboardPage/images/activity.png'), 6 );
    }
    
    // Function to show user posts during entered date periods.
    /*
     *  This function requires from date and to date, those are provided by ajax call.
     *  This function checks whether logged in user is whether administrator or not, If logged in user is administrator
     *  then he can access the site acitivity manager otherwise he can't.
     *  It fetches the required data related to posts from database and creates template to show all posts during entered 
     *  time period.
     */
    function showUserPosts() {
        $currUser = wp_get_current_user();
        $role = $currUser->roles[0];
        if($role == "administrator") {
            global $wpdb;
            $result=array();
            $from = $_POST['from'];
            $to = $_POST['to'];
            $posts = $wpdb->get_results($wpdb->prepare("select post_author, post_date, post_modified, post_name, post_title, post_status, guid from wp_posts where post_type = %s", "post"));

            for($i=0; $i<count($posts);$i++){
                $temp=(array)$posts[$i];
                $dateToSplit = $temp['post_date'];
                $splittedDate = explode(" ", $dateToSplit);
                $user_data=  get_userdata($temp['post_author']);
                $username=$user_data->user_login;
                if($splittedDate[0] <= $to && $splittedDate[0] >= $from) {
                    $postAuthor=$username;
                    $postDate=$temp['post_date'];
                    $postModified=$temp['post_modified'];
                    $postName=$temp['post_name'];
                    $postTitle=$temp['post_title'];
                    $postStatus=$temp['post_status'];
                    $postLink=$temp['guid'];
                    $postArray=array('author'=> $postAuthor, 'date'=>$postDate, 'modified' => $postModified, 'name'=>$postName, 'title'=>$postTitle,'status'=>$postStatus, 'link'=>$postLink);
                    array_push($result,$postArray);
                }
            }
            $file= __DIR__.'/Template/userposts.php';
            echo($this->parseTemplate($file,$result));
            die(); 
        }
        else {
            echo "<h1 class='not-admin-error'>You must be an administrator to view this page.</h2>";
            die();
        }
    }
    
    // Function to show user pages during entered date periods.
    /*
     *  This function requires from date and to date, those are provided by ajax call.
     *  This function checks whether logged in user is whether administrator or not, If logged in user is administrator
     *  then he can access the site acitivity manager otherwise he can't.
     *  It fetches the required data related to pages from database and creates template to show all pages during entered 
     *  time period.
     */
    function showUserPages() {
        $currUser = wp_get_current_user();
        $role = $currUser->roles[0];
        if($role == "administrator") {
            global $wpdb;
            $result=array();
            $from = $_POST['from'];
            $to = $_POST['to'];
            $pages = $wpdb->get_results($wpdb->prepare("select post_author, post_date, post_modified, post_name, post_title, post_status, guid from wp_posts where post_type = %s", "page"));

            for($i=0; $i<count($pages);$i++){
                $temp=(array)$pages[$i];
                $dateToSplit = $temp['post_date'];
                $splittedDate = explode(" ", $dateToSplit);
                $user_data= get_userdata($temp['post_author']);
                $username=$user_data->user_login;
                if($splittedDate[0] <= $to && $splittedDate[0] >= $from) {
                    $pageAuthor=$username;
                    $pageDate=$temp['post_date'];
                    $pageModified=$temp['post_modified'];
                    $pageName=$temp['post_name'];
                    $pageTitle=$temp['post_title'];
                    $pageStatus=$temp['post_status'];
                    $pageLink=$temp['guid'];
                    $pageArray=array('author'=> $pageAuthor, 'date'=>$pageDate, 'modified' => $pageModified,'name'=>$pageName, 'title'=>$pageTitle,'status'=>$pageStatus, 'link'=>$pageLink);
                    array_push($result,$pageArray);
                }
            }
            $file= __DIR__.'/Template/userpages.php';
            echo($this->parseTemplate($file,$result));
            die(); 
        }
        else {
            echo "<h1 class='not-admin-error'>You must be an administrator to view this page.</h2>";
            die();
        }
    }
    
    // Function to show users registered during entered date periods.
    /*
     *  This function requires from date and to date, those are provided by ajax call.
     *  This function checks whether logged in user is whether administrator or not, If logged in user is administrator
     *  then he can access the site acitivity manager otherwise he can't.
     *  It fetches the required data related to users from database and creates template to show all users registered during 
     *  entered time period.
     */
    public function showUsersRegistered() {
        $currUser = wp_get_current_user();
        $role = $currUser->roles[0];
        if($role == "administrator") {
            global $wpdb;
            $result=array();
            $from = $_POST['from'];
            $to = $_POST['to'];
            $users = $wpdb->get_results("select ID, user_login, user_nicename, user_email, user_registered, display_name from wp_users");

            for($i=0; $i<count($users);$i++){
                $temp=(array)$users[$i];
                $dateToSplit = $temp['user_registered'];
                $splittedDate = explode(" ", $dateToSplit);
                $user_data= get_userdata($temp['ID']);
                $userRole=$user_data->roles[0];
                if($splittedDate[0] <= $to && $splittedDate[0] >= $from) {
                    $id=$temp['ID'];
                    $username=$temp['user_login'];
                    $nicename=$temp['user_nicename'];
                    $email=$temp['user_email'];
                    $registered=$temp['user_registered'];
                    $displayname=$temp['display_name'];
                    $userrole=$userRole;
                    $userArray=array('id'=> $id, 'username'=>$username,'nicename'=>$nicename, 'email'=>$email,'registered'=>$registered, 'displayname'=>$displayname, 'userrole'=> $userrole);
                    array_push($result,$userArray);
                }
            }
            $file= __DIR__.'/Template/userregistered.php';
            echo($this->parseTemplate($file,$result));
            die();  
        }
        else {
            echo "<h1 class='not-admin-error'>You must be an administrator to view this page.</h2>";
            die();
        }
    }
    
    // Function to make custom dashboard menu template page.
    public function customDashBoardPage(){
        $file= __DIR__.'/Template/userpage.php';
        echo($this->parseTemplate($file,NULL));
        
    }
    
    // Function to parse templates.
    public function parseTemplate($file, $data){
        ob_start();
        include ($file);
        return ob_get_clean();
    }
    
}

new CustomDashboardPage;

