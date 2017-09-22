<?php
const BR = '<br>';
session_start();
require 'autoload.php';
require 'config.php';
use Abraham\TwitterOAuth\TwitterOAuth;

echo "<div class='container'>";

    if (!isset($_SESSION['access_token'])) {
        //echo "if part".BR;
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    //echo $url;
        echo "<h2>Twitter Timeline Challenge</h2>";
	//Just a text
	echo "<div class='left_col'>";
	    //echo "<a href='#' class='know'>Know More</a>";
            echo "<div class='panel'>";
		echo "This is just an assignment done for <br> rtCamp Solutions Pvt. Ltd.";
		
                echo "<p><strong>Part-1: User Timeline</strong></p>
		<ol>
		    <li>Start => User visit your script page.
		    <li>He will be asked to connect using his Twitter account (Hint: Twitter Auth).
		    <li>Once authenticated, your script will pull latest 10 tweets form his \"home\" timeline.
		    <li>10 tweets will be displayed using a jQuery-slideshow.
		</ol>
					  
                <p><strong>Part-2: Followers Timeline</strong></p>
		<ol>
		    <li>Below jQuery-slideshow (in step#4 from part-1), display list 10 followers (you can take any 10 random followers).
		    <li>When user will click on a follower name, 10 tweets from that follower's user-timeline will be displayed in same jQuery-slider, without page refresh (use AJAX).";
	        echo "</ol>";
				
                
	    echo "</div>";	//Panel div ends
	echo "</div>";	//Left col div ends
		
	echo "<div class='right_col'>";
            echo "Dear User,<br>";
	    echo "<a href='$url'>Please Sign In through Your Twitter Account</a>";
        echo "</div>";	//Right col div ends
	
    }    
    else{//Otherwise if user got token then the to & fro part starts
        //echo "else part".BR;
	
        
        $access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials");
	//echo $user->screen_name;
       
        /*
        echo '<pre>';
        print_r($user);
        echo '</pre>';
        */
        
        $name = $user->name;
        $loc = $user->location;
        $screen_name = $user->screen_name;
        $profilepic = $user->profile_image_url;
        
        /*
        echo "Name  : ".$name.BR;
        echo "Address  : ".$loc.BR;
        echo "Screen Name  : ".$screen_name."  ";
        //echo $profilepic.BR;
        echo "<img src=$profilepic title='Profile Picture'><br>";
        
        // printing username on screen
	echo "Welcome " . $user->screen_name . '<br>';
	// getting recent tweeets by user 'snowden' on twitter
         * 
         */
        
        echo "<div class='left_col'>";
            echo "<div id='divWelcome' align='center'>Logged in as ".$screen_name;
		echo "<br><img src=$profilepic title='Profile Picture'></div>";
	echo "</div>";	//Left col div ends

	echo "<div class='right_col'>";		
            echo "<h2>Twitter Timeline Challnege</h2>";
			
            //Include tweet page which contains tweet grabbing code
            echo "Tweet Showcase:";		
		
           // echo "<div id='divTweetContainer' class='slideshowTweet'>";
                //$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);
		$tweets = $connection->get('statuses/user_timeline', ['count' => 20, 'exclude_replies' => true, 'screen_name' => $screen_name, 'include_rts' => false]);
                $totalTweets[] = $tweets;
                
                
                $i = 0;
                $start = 1;
                
                echo "<div id='Slider'>";
                    echo "<ul class='tweetSlides'>";
                        foreach ($totalTweets as $tweet) {
                            foreach ($tweet as $key) {
                        
                                 echo "<li class='Slide'>".$start . ':' . $key->text ; 
                                 echo "</li>";
                                 //echo $start . ':' . $key->text . '<br>';                                
                        
                                $start++;
                            }
                        }
                      
                    echo "</ul>";                     
                echo "</div>";
                
			
	    //Include follower page which contains followers grabbing code
	    //include 'follower.php';
	    //getFollo($username);
            // Empty array that will be used to store followers.
            echo "<br><br>";
            echo "Followers List: Follower's Name ['Twitter-Handler']"."<br>";
            
            $profiles = array();
            // Get the ids of all followers.
            $ids = $connection->get('followers/ids', ['count' => 20,'screen_name' => $screen_name]);
            
            foreach($ids as $singleid) {
              // Perform a lookup for each chunk of 100 ids.
              $profile = $connection->get('users/lookup', array('user_id' => $singleid));
              // Loop through each profile result.
               
              array_push($profiles,$profile); 
                /*
                echo '<pre>';
                    print_r($profile);
                echo '</pre>';*/
   
              }
              
            $profiles = array_filter($profiles); 
            echo "<div id='Followers'>";
                echo "<ul class='Followers'>";
                
                    foreach($profiles as $profile){
                
                        $profile = array_filter($profile); 
                
                        if(!empty($profile)){
                            foreach($profile as $user){
                                echo "<li class='follower'>".$user->name." [".$user->screen_name."] ";
                                echo "</li>";
                            }
                        }                
                    }  
                echo "</ul>";            
            echo "</div>";          
            
            //Follower's Search Box
            echo "      Search Box for Follower"."<br>";
            echo "<div id='SerachFollower'>";
            
            
            
            echo "</div>";   
            
            
        echo "</div>";	//Right col div ends        
    }        
echo "</div>";	// Container div ends
        
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Welcome to rtChallenge | A Twitter Timeline Assignment </title>

        <link rel="stylesheet" type="text/css" href="style.css" >

        <!-- Include jQuery library -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <!-- Include Cycle plugin By Mike Alsup, Thanks malsup-->
        <script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script>

       <script type="text/javascript" src="main.js"></script>

    </head>

    <body onload="Slider();">
    </body>

</html>



