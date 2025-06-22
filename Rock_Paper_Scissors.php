<?php
session_start();

$choices = ['rock', 'paper', 'scissors'];
$robot_choice = '';
$result = '';

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

if (isset($_POST['player'])) {
    $player = $_POST['player'];
    $robot_choice = $choices[rand(0, 2)];

    if ($player === $robot_choice) {
        $result = "🤝 Draw!";
    } elseif (
        ($player === 'rock' && $robot_choice === 'scissors') ||
        ($player === 'paper' && $robot_choice === 'rock') ||
        ($player === 'scissors' && $robot_choice === 'paper')
    ) {
        $result = "✅ You win!";
        $_SESSION['score']++;
    } else {
        $result = "❌ You lose!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Robot RPS</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            background: #eef;
            margin-top: 30px;
        }
        h1 { font-size: 2em; color: #333; }
        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 1.2em;
            cursor: pointer;
        }
        .robot-hand {
            width: 100px;
            height: 100px;
            background: gray;
            margin: 20px auto;
            border-radius: 50%;
            position: relative;
            animation: moveHand 1s ease;
        }
        @keyframes moveHand {
            0% { transform: rotate(-20deg); }
            50% { transform: rotate(20deg); }
            100% { transform: rotate(0deg); }
        }
        .draw-area {
            font-size: 2em;
            color: darkblue;
            margin-top: 20px;
            min-height: 50px;
            animation: drawText 1s steps(10) 1;
            white-space: nowrap;
            overflow: hidden;
            border-right: 3px solid black;
        }
        @keyframes drawText {
            from { width: 0; }
            to { width: 100%; }
        }
        .score {
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>🤖 Robot Rock, Paper, Scissors</h1>

<form method="post">
    <button name="player" value="rock">🪨 Rock</button>
    <button name="player" value="paper">📄 Paper</button>
    <button name="player" value="scissors">✂️ Scissors</button>
</form>

<div class="robot-hand"></div>

<?php if ($robot_choice): ?>
    <div class="draw-area">
        Robot plays:
        <?php
        if ($robot_choice == 'rock') echo "🪨 Rock";
        if ($robot_choice == 'paper') echo "📄 Paper";
        if ($robot_choice == 'scissors') echo "✂️ Scissors";
        ?>
    </div>
<?php endif; ?>

<?php if ($result): ?>
    <h2><?php echo $result; ?></h2>
<?php endif; ?>

<div class="score">Your Score: <?php echo $_SESSION['score']; ?></div>

</body>
</html>
