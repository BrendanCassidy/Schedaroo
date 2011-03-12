</head>
<body>

<div id="container">

<div id="header"><a href="<?php echo URL ?>/index.php"><img src="<?php echo URL ?>/images/Logo.png" ></a></div>

<div id="login"><?php loginlink() ?></div>

<div id="navmenu">
    <ul>
        <li><a <?php if (basename($_SERVER['PHP_SELF']) == "problems.php") { echo 'class="selected" '; } ?>href="<?php echo URL ?>/problems.php">MY EVENTS</a></li>
        <li><a <?php if (basename($_SERVER['PHP_SELF']) == "publicEvents.php") { echo 'class="selected" '; } ?>href="<?php echo URL ?>/publicEvents.php">PUBLIC EVENTS</a></li>
	<li><a <?php if (basename($_SERVER['PHP_SELF']) == "groups.php") { echo 'class="selected" '; } ?>href="<?php echo URL ?>/groups.php">GROUPS</a></li>
    </ul>
<div style="position:absolute; right:10px; top:95px; z-index:5"><a href="javascript:void(0)" id="opener"><img src="<?php echo URL ?>/images/help.png" style="border-style: none"></a></div>
</div>

<div id="body">

<?php if (isset($_GET['output'])): ?>
<div id="output">
    <?php echo $_GET['output'] ?>
    <a href="javascript:void();" onclick="javascript:$(this).parent().fadeOut('slow');">X</a>
</div>
<?php endif; ?>

