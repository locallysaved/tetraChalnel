<?php
$resp_xp = file_get_contents("https://ch.tetr.io/api/users/by/xp?limit=100");
$leaderboard_xp = json_decode($resp_xp, true);
$entries_xp = $leaderboard_xp['data']['entries'] ?? [];

$resp_league = file_get_contents("https://ch.tetr.io/api/users/by/league?limit=100");
$leaderboard_league = json_decode($resp_league, true);
$entries_league = $leaderboard_league['data']['entries'] ?? [];

$resp_ar = file_get_contents("https://ch.tetr.io/api/users/by/ar?limit=100");
$leaderboard_ar = json_decode($resp_ar, true);
$entries_ar = $leaderboard_ar['data']['entries'] ?? [];

$serverStats = json_decode(file_get_contents("https://ch.tetr.io/api/general/stats"), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboards</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js" defer></script>
</head>
<body>
    <div class="header margin-center">
        <a href="index.php">
            <div><img style="height: 4rem; width: auto;" src="images/tetrio.png" alt="Tetrio"></div>
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

    <div class="main-2 margin-center">
        <h1 style="color: white; margin:0; padding-top: 2rem; padding-bottom: 2rem;">Choose a Leaderboard!</h1>

        <!-- BUTTON -->
        <div class="dropdown-container">
            <button class="dropdown-button" id="dropdownBtn">xp ▼</button>
            <div class="dropdown-menu display-none" id="dropdownMenu">
                <div class="dropdown-item" data-target="xp-lead">XP leaderboard</div>
                <div class="dropdown-item" data-target="league-lead">Tetra League Leaderboard</div>
                <div class="dropdown-item" data-target="ar-lead">Achievement Leaderboard</div>
            </div>
        </div>

        <div class="main__main-table margin-center" style="height: 40rem">
            <div id="xp-lead" class="display-flex">
                <table>
                    <tr>
                        <th class="td-1" style="color: rgb(186, 186, 186)">Place</th>
                        <th class="td-2" style="color: rgb(186, 186, 186); font-weight: 700; font-size: 15pt">Player</th>
                        <th class="td-3" style="color: rgb(186, 186, 186)">XP</th>
                    </tr>
                    <?php
                    $place = 1;
                    foreach ($entries_xp as $entry) {
                        $username = htmlspecialchars($entry['username'] ?? '');
                        $xp = number_format((int)($entry['xp'] ?? 0), 0, '', ' ');
                        $profileLink = "player.php?user=" . urlencode($entry['username'] ?? '');
                        echo "<tr>
                                <td class='td-1'>$place</td>
                                <td class='td-2'><a style='color:white; text-decoration: none' href='$profileLink'>$username</a></td>
                                <td class='td-3'>$xp</td>
                              </tr>\n";
                        $place++;
                    }
                    ?>
                </table>
            </div>

            <div id="league-lead" class="display-none">
                <table>
                    <tr>
                        <th class="td-1" style="color: rgb(186, 186, 186)">Place</th>
                        <th class="td-2" style="color: rgb(186, 186, 186); font-weight: 700; font-size: 15pt">Player</th>
                        <th class="td-3" style="color: rgb(186, 186, 186)">Games Won</th>
                    </tr>
                    <?php
                    $place = 1;
                    foreach ($entries_league as $entry) {
                        $username = htmlspecialchars($entry['username'] ?? '');
                        $wins = isset($entry['league']['gameswon']) ? (int)$entry['league']['gameswon'] : 0;
                        $profileLink = "player.php?user=" . urlencode($entry['username'] ?? '');
                        echo "<tr>
                                <td class='td-1'>$place</td>
                                <td class='td-2'><a style='color:white; text-decoration: none' href='$profileLink'>$username</a></td>
                                <td class='td-3'>$wins</td>
                              </tr>\n";
                        $place++;
                    }
                    ?>
                </table>
            </div>

            <div id="ar-lead" class="display-none">
                <table>
                    <tr>
                        <th class="td-1" style="color: rgb(186, 186, 186)">Place</th>
                        <th class="td-2" style="color: rgb(186, 186, 186); font-weight: 700; font-size: 15pt">Player</th>
                        <th class="td-3" style="color: rgb(186, 186, 186)">Achievements</th>
                    </tr>
                    <?php
                    $place = 1;
                    foreach ($entries_ar as $entry) {
                        $username = htmlspecialchars($entry['username'] ?? '');
                        $ar = isset($entry['ar']) ? (int)$entry['ar'] : 0;
                        $profileLink = "player.php?user=" . urlencode($entry['username'] ?? '');
                        echo "<tr>
                                <td class='td-1'>$place</td>
                                <td class='td-2'><a style='color:white; text-decoration: none' href='$profileLink'>$username</a></td>
                                <td class='td-3'>$ar</td>
                              </tr>\n";
                        $place++;
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script>
    const btn = document.getElementById('dropdownBtn');
    const menu = document.getElementById('dropdownMenu');
    const items = document.querySelectorAll('.dropdown-item');

    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.classList.toggle('display-none');
      menu.classList.toggle('display-flex');
    });

    items.forEach(item => {
      item.addEventListener('click', () => {
        const targetId = item.dataset.target;

        document.querySelectorAll('#xp-lead, #league-lead, #ar-lead').forEach(el => {
          el.classList.add('display-none');
          el.classList.remove('display-flex');
        });

        const target = document.getElementById(targetId);
        if (target) {
          target.classList.add('display-flex');
          target.classList.remove('display-none');
        }

        btn.textContent = item.textContent + ' ▼';

        menu.classList.add('display-none');
        menu.classList.remove('display-flex');
      });
    });

    document.addEventListener('click', () => {
      menu.classList.add('display-none');
      menu.classList.remove('display-flex');
    });
    </script>
</body>
</html>
