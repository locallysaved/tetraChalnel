<?php 
$resp = file_get_contents("https://ch.tetr.io/api/users/by/xp?limit=30");
$leaderboard = json_decode($resp, true);
$entries = $leaderboard['data']['entries'] ?? [];
$serverStats = json_decode(file_get_contents("https://ch.tetr.io/api/general/stats"), true);$user = $_GET['user'] ?? '';
if (isset($_GET['user']) && !empty($_GET['user'])) {
    $user = $_GET['user'];
    $profile_data = json_decode(file_get_contents("https://ch.tetr.io/api/users/$user"), true);
    
    if ($profile_data['success'] == false) {
        header("Location: err.php?user=" . urlencode($user));
    } else {
        header("Location: player.php?user=" . urlencode($user));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header margin-center">
        <div><img src="images/tetrio.png" style="width: 100%;"></div>
        
    </div>
    <div class="main margin-center">
        
        <div style="width: 100%; height: 100%; display: flex; align-items: center;">
            <div class="green-bg">
                <div class="main__main-title">
                    JOIN THE <?php echo $serverStats['data']['usercount'] ?> PLAYERS WORLDWIDE!
                </div>
            </div>
        </div>

    <div>
        <div class="header__src-bar-2 margin-center">
        <form id="searchForm" method="GET" action="">
            <input 
                class="header__src-bar-2__src-bar-input-2" 
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
        <h1>Search for a player!</h1>
        <h1 style="font-size: 25pt">...or scroll for leaderboard overview</h1>
    </div>

    <div class="main__leaderboard-container">
    <div class="main__leaderboard-title-box">XP leaderboard</div>
    <div class="main__main-table">
        <table>
            <tr>
                <th class="td-1" style="color: rgb(186, 186, 186)">Place</th>
                <th class='td-2' style="color: rgb(186, 186, 186); font-weight: 700; font-size: 15pt">Player</th>
                <th class='td-3' style="color: rgb(186, 186, 186)">XP count</th>
            </tr>
            <?php
                $place = 1;
                foreach ($entries as $entry) {
                    $username = htmlspecialchars($entry['username']); 
                    $xp = number_format($entry['xp'] ?? 0, 0, '', ' ');

                    $profileLink = "player.php?user=" . urlencode($entry['username']);

                    echo "<tr>
                        <td class='td-1'>$place</td>
                        <td class='td-2'><a style='color:white; text-decoration:' href='$profileLink'>$username</a></td>
                        <td class='td-3'>$xp</td>
                    </tr>\n";

                    $place++;
                }
            ?>
        </table>
    </div>
    <button class="main__more-leaderboards-btn" onclick="window.location.href='leaderboards.php'">More leaderboards \/</button>
</div>


    </div>
</body>
</html>