<?php
session_start();

// Initialize score if not set
if (!isset($_SESSION['player_score'])) {
    $_SESSION['player_score'] = 0;
    $_SESSION['computer_score'] = 0;
    $_SESSION['draws'] = 0;
}

$choices = ['rock', 'paper', 'scissors'];
$result = '';

if (isset($_POST['player_choice'])) {
    $player = $_POST['player_choice'];
    $computer = $choices[rand(0, 2)];

    if ($player === $computer) {
        $result = "🤝 Draw! You both chose $player.";
        $_SESSION['draws']++;
    } elseif (
        ($player === 'rock' && $computer === 'scissors') ||
        ($player === 'paper' && $computer === 'rock') ||
        ($player === 'scissors' && $computer === 'paper')
    ) {
        $result = "✅ You Win! $player beats $computer.";
        $_SESSION['player_score']++;
    } else {
        $result = "❌ You Lose! $computer beats $player.";
        $_SESSION['computer_score']++;
    }
}

if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: rock_paper_scissors.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Endless Rock Paper Scissors</title>
    <style>
        body { font-family: Arial; background: #f8f8f8; text-align: center; padding-top: 40px; }
        h1 { color: #333; }
        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 18px;
            cursor: pointer;
        }
        .score {
            margin: 20px auto;
            font-size: 20px;
        }
        .result {
            font-size: 22px;
            margin: 20px;
            color: #006600;
        }
        .reset-btn {
            margin-top: 30px;
            background: #ff4444;
            color: white;
            border: none;
            padding: 10px 30px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>🎮 Endless Rock Paper Scissors</h1>

    <form method="post">
        <button name="player_choice" value="rock">🪨 Rock</button>
        <button name="player_choice" value="paper">📄 Paper</button>
        <button name="player_choice" value="scissors">✂️ Scissors</button>
    </form>

    <div class="result"><?php echo $result; ?></div>

    <div class="score">
        🧑 You: <?php echo $_SESSION['player_score']; ?> |
        💻 Computer: <?php echo $_SESSION['computer_score']; ?> |
        🤝 Draws: <?php echo $_SESSION['draws']; ?>
    </div>

    <form method="post">
        <button class="reset-btn" name="reset">🔁 Reset Game</button>
    </form>

</body>
</html>
