<?php
$user = $_GET['user'] ?? '';
$profile_data = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user"), true);
$tl_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/league"), true);
$fl_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/40l"), true);
$blitz_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/blitz"), true);
$qp_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/zenith"), true);
$zen_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/zen"), true);
$eqp_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user/summaries/zenithex"), true);

$eqp_summary = json_decode(file_get_contents("https://ch.tetr.io/api/users/aviolo/summaries/league"), true);

$url = "https://ch.tetr.io/api/users/{$user}/records/40l/top";
$data = json_decode(file_get_contents($url), true);



if ($qp_summary['data']['rank'] == -1) {
    $qp_result = "No games on record";
} else {
    $qp_result = $qp_summary['data']['rankz'];
}
//PREVENT ERROR WHEN "BIO" IS NULL
if (!empty($profile_data['data']['bio'])) {
    $user_bio = $profile_data['data']['bio'];
} else {
    $user_bio = "User has no bio yet. Or do they.....";
}

//PREVENT ERRORS (YOUTUBE)
if (!empty($profile_data['data']['connections']['youtube'])) {
    $youtubeId = $profile_data['data']['connections']['youtube']['id'];
    $youtubeUser = $profile_data['data']['connections']['youtube']['display_username'];
    $youtubeLink = "https://www.youtube.com/channel/$youtubeId";
    $youtubeClass = "display: flex";
} else {
    $youtubeClass = 'display:none;';
}

//PREVENT ERRORS (TWITCH)
if (!empty($profile_data['data']['connections']['twitch'])) {
    $twitchDisplayUser = $profile_data['data']['connections']['twitch']['display_username'];
    $twitchUser = $profile_data['data']['connections']['twitch']['display_username'];
    $twitchLink = "https://www.twitch.tv/$twitchUser";
    $twitchClass = "display: flex";
} else {
    $twitchClass = 'display:none;';
}

//PREVENT ERRORS (TWITTER / X)
if (!empty($profile_data['data']['connections']['twitter'])) {
    $twitterUser = $profile_data['data']['connections']['twitter']['username'];
    $twitterLink = "https://www.x.com/$twitterUser";
    $twitterDisplayUser = $profile_data['data']['connections']['twitter']['display_username'];
    $twitterClass = "display: flex";
} else {
    $twitterClass = 'display:none;';
}

//PREVENT ERRORS (REDDIT)
if (!empty($profile_data['data']['connections']['reddit'])) {
    $redditUser = $profile_data['data']['connections']['reddit']['username'];
    $redditLink = "https://www.reddit.com/user/$redditUser";
    $redditClass = "display: flex";
} else {
    $redditClass = 'display:none;';
}

//PREVENT ERRORD (STEAM)
if (!empty($profile_data['data']['connections']['steam'])) {
    $steamId = $profile_data['data']['connections']['steam']['id'];
    $steamUser = $profile_data['data']['connections']['steam']['username'];
    $steamLink = "https://steamcommunity.com/profiles//$steamId";
    $steamClass = "display: flex";
} else {
    $steamClass = 'display:none;';
}

//PREVENT ERROR(DISCORD)
if (!empty($profile_data['data']['connections']['discord'])) {
    $discordUser = $profile_data['data']['connections']['discord']['username'];
    $discordLink = "https://steamcommunity.com/profiles//$discordUser";
    $discordClass = "display: flex";
} else {
    $discordClass = 'display:none;';
}


//GET PROFLE PICTURE
if (!empty($profile_data['data']['avatar_revision'])) {
    $avatar_id = $profile_data['data']['avatar_revision'];
    $user_id = $profile_data['data']['_id'];
    $avatar =  "https://tetr.io/user-content/avatars/$user_id.jpg?rv=$avatar_id";
} elseif (empty($profile_data['data']['avatar_revosion'])) {
    $avatar = "images/anon.jpeg";
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>
    <div class="header margin-center">

        <a href="index.php">
            <div><img style="height: 4rem; width: auto;" src="images/tetrio.png"></div>
        </a>    
        
        <div>
    <div class="header__src-bar margin-center">
            <form id="searchForm" method="GET" action="player.php">
                <input 
                    class="header__src-bar__src-bar-input" 
                    name="user" 
                    type="text" 
                    placeholder="Search for Tetr.io players">
                <button type="submit" style="display:none;"></button> 
            </form>
            <img 
                src="images/src.png"
                style="width: auto; height: 1.5rem; cursor:pointer;" 
                onclick="document.getElementById('searchForm').submit();"
                alt="Search">
        </div>
</div>

    </div>
    <div class="main margin-center">
        <div class="profile-top">
            
            <div class="profile-top__profile-top-left">
                <div class="profile-top__profile-top-left__pfp"> <?php echo "<img style='border-radius: 1rem; width: 320px; height:320px' src='$avatar'>" ?>  </div>
                <div class="profile-top__profile-top-left__user-info">
                    <div class="profile-top__profile-top-left__user-info__username"><?php echo $user ?>
                        <div class="country" style="margin-right: 1rem; font-size: 25pt"><?php echo $profile_data['data']['country'] ?></div>
                    </div>
                    <div class="profile-top__profile-top-left__user-info__achievements"><? echo $profile_data['data']['gamesplayed'] ?></div>
                    <div class="profile-top__profile-top-left__user-info__user-bio"><?php echo $user_bio ?></div>
                </div>
            </div>

            <div class="profile-top__profile-top-right">
                <div class="socials-board"> 
                    <div class="socials-board__socials-title">Socials</div>


                        <div class="socials-sec" style="<?php echo $youtubeClass?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/youtube.jpeg" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Youtube
                            </div>
                            <button onclick="window.open('<?php echo $youtubeLink ?>')" class="connections-btn">
                            <?php echo $youtubeUser?>     
                            </button>                   
                        </div>

                        <div class="socials-sec" style="<?php echo $twitchClass ?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/twitch.png" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Twitch
                            </div>
                            <button onclick="window.open('<?php echo $twitchLink ?>')" class="connections-btn">
                            <?php echo $twitchDisplayUser?>     
                            </button>                   
                        </div>

                        <div class="socials-sec" style="<?php echo $twitterClass ?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/twitter.png" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Twitter
                            </div>
                            <button onclick="window.open('<?php echo $twitterLink ?>')" class="connections-btn">
                            <?php echo $twitterDisplayUser?>     
                            </button>                   
                        </div>

                        <div class="socials-sec" style="<?php echo $redditClass?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/reddit.png" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Reddit
                            </div>
                            <button onclick="window.open('<?php echo $redditLink ?>')" class="connections-btn">
                            <?php echo $redditUser?>     
                            </button>                   
                        </div>

                        <div class="socials-sec" style="<?php echo $steamClass?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/steam.png" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Steam
                            </div>
                            <button onclick="window.open('<?php echo $steamLink ?>')" class="connections-btn">
                            <?php echo $steamUser?>     
                            </button>                   
                        </div>

                        <div class="socials-sec" style="<?php echo $discordClass?>"> 
                            <div class="socials-sec__logo-name">
                                <img src="images/discord.png" class="flex-v-center socials-sec__logo-name__socials-logo">
                                Discord
                            </div>
                            <button class="connections-btn" style="text-decoration: none; cursor: default">
                            <?php echo $discordUser?>     
                            </button>                   
                        </div>
                        <div class="socials-sec">___________________</div>


                    </div>
                </div>  
            </div>
        <div class="profile-mid">
    
            <div class="standings">
                <div class="standings__standings-title">Player's standings</div>
                <div class="standings__standings-main">


                    <div class="standings-sec-1">
                        <p class="standings-title-1">Gamemode</p>
                        <p class="standings-sec__standings-each" style="color:gray">Games Played</p>
                        <p class="standings-sec__standings-each" style="color:gray">Games Won</p>
                        <p class="standings-sec__standings-each" style="color:gray">Global Rank</p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each">
                            <div class="standings-sec__standings-logo"><img src="images/tl-icon.jpeg" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">Tetra League</div>
                        </div>
                        <p class="standings-sec__standings-each"><?php echo $tl_summary['data']['gamesplayed'] ?></p>
                        <p class="standings-sec__standings-each"><?php echo $tl_summary['data']['gameswon']?></p>
                        <p class="standings-sec__standings-each"><?php echo $tl_summary['data']['standing'] ?></p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each">
                            <div class="standings-sec__standings-logo"><img src="images/40l.png" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">40 Lines</div>
                        </div>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each"><?php echo $fl_summary['data']['rank'] ?></p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each">
                            <div class="standings-sec__standings-logo"><img src="images/blitz.png" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">Blitz</div>
                        </div>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each"><?php echo $blitz_summary['data']['rank'] ?></p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each">
                            <div class="standings-sec__standings-logo"><img src="images/quickPlay.png" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">Quick Play</div>
                        </div>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each"><?php echo $qp_result?></p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each">
                            <div class="standings-sec__standings-logo"><img src="images/zen.png" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">Zen</div>
                        </div>
                        <p class="standings-sec__standings-each"><?php echo $zen_summary['data']['level'] ?></p>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each">No rankings</p>
                    </div>

                    <div class="standings-sec">
                        <div class="standings-logo-name standings-sec__standings-each" style="width:20rem;">
                            <div class="standings-sec__standings-logo"><img src="images/exqp.png" class="img-format-100"></div>
                            <div class="standings-sec__standings-title">Expert Quick Play</div>
                        </div>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each">____</p>
                        <p class="standings-sec__standings-each"><?php echo $eqp_summary['data']['rank'] ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>