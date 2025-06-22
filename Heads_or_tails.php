<?php
session_start();

// Initialize score
if (!isset($_SESSION['wins'])) $_SESSION['wins'] = 0;
if (!isset($_SESSION['losses'])) $_SESSION['losses'] = 0;
if (!isset($_SESSION['draws'])) $_SESSION['draws'] = 0;

$choices = ['heads', 'tails'];
$player_choice = '';
$computer_choice = '';
$result = '';

if (isset($_POST['flip'])) {
    $player_choice = $_POST['flip'];
    $computer_choice = $choices[rand(0, 1)];

    if ($player_choice === $computer_choice) {
        $result = "🤝 It's a draw! You both picked $player_choice.";
        $_SESSION['draws']++;
    } elseif (
        ($player_choice === 'heads' && $computer_choice === 'tails') ||
        ($player_choice === 'tails' && $computer_choice === 'heads')
    ) {
        $result = "🎉 You win! Your $player_choice beats $computer_choice.";
        $_SESSION['wins']++;
    } else {
        $result = "😢 You lost. Computer's $computer_choice beats your $player_choice.";
        $_SESSION['losses']++;
    }
}

if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: coin_flip.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Coin Flip Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            text-align: center;
            margin-top: 40px;
        }
        h1 {
            color: #333;
        }
        button {
            padding: 12px 24px;
            margin: 10px;
            font-size: 18px;
            cursor: pointer;
        }
        .emoji {
            font-size: 60px;
            animation: flip 1s ease;
        }
        @keyframes flip {
            0% { transform: rotateY(0); }
            50% { transform: rotateY(180deg); }
            100% { transform: rotateY(360deg); }
        }
        .result {
            font-size: 22px;
            margin-top: 20px;
        }
        .score {
            font-size: 18px;
            margin-top: 15px;
        }
        .reset-btn {
            margin-top: 30px;
            background-color: #ff4444;
            color: white;
            padding: 10px 30px;
            border: none;
        }
    </style>
</head>
<body>

<h1>🪙 Coin Flip Battle</h1>

<form method="post">
    <button name="flip" value="heads">👑 Heads</button>
    <button name="flip" value="tails">🐍 Tails</button>
</form>

<?php if ($computer_choice): ?>
    <div class="emoji">
        <?php echo $computer_choice === 'heads' ? '👑' : '🐍'; ?>
    </div>
<?php endif; ?>

<?php if ($result): ?>
    <div class="result"><?php echo $result; ?></div>
<?php endif; ?>

<div class="score">
    ✅ Wins: <?php echo $_SESSION['wins']; ?> |
    ❌ Losses: <?php echo $_SESSION['losses']; ?> |
    🤝 Draws: <?php echo $_SESSION['draws']; ?>
</div>

<form method="post">
    <button name="reset" class="reset-btn">🔄 Reset Game</button>
</form>

</body>
</html>
