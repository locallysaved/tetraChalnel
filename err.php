<?php 
$resp = file_get_contents("https://ch.tetr.io/api/users/by/xp?limit=30");
$leaderboard = json_decode($resp, true);
$entries = $leaderboard['data']['entries'] ?? [];

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
        <a  href="index.php"><img src="images/tetrio.png" style="width: 100%;"></a>
    </div>
    
    <div class="main margin-center" style="height:90vh">
    <p class="main__not-found-msg margin-center">The username youre looking for couldn't be found! Try checking your spelling!</p>
        <div>
            <div class="header__src-bar-2 margin-center">
                <form id="searchForm" method="GET" action="<?php echo $sendTo ?>">
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
        </div>

        
    </div>
</body>
</html>
