<?php
    require_once 'vendor/autoload.php';
    
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => $_ENV['TTA_TOKEN'],
        'oauth_access_token_secret' => $_ENV['TTA_SECRET'],
        'consumer_key' => $_ENV['TTC_KEY'],
        'consumer_secret' => $_ENV['TTC_SECRET']
    );
    
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $requestMethod = "GET";
    $getfield = '?screen_name=bladeandsoul&count=5';
    $twitter = new TwitterAPIExchange($settings);
    
    $string = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(),$assoc = TRUE);
?>


<div id="ribbon">
    <div class="media">
<?php
    // if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
    foreach($string as $items)
    {
?>
        <div class="media-left media-middle">
            <a href="<?php $items['url'] ?>">
                <img class="media-object" src="<?php $items['profile_image_url'] ?>">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">"<?php $items['user']['name'] . $items['created_at']?>"</h4>
            <?php $items['text'] ?>
        </div>
<?php
        echo $items['urls']['url'];
        echo $items['profile_image_url'];
        echo $items['user']['name'];
        echo $items['created_at'];
    }
?>
    </div>
</div>
