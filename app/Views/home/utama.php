<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'az-green': '#1a6e4d', 'az-gold': '#fbbf24' } } }
        }
    </script>
	
    <title><?php echo $title; ?></title>
	<link rel="icon" type="image/png" href="<?php  echo base_url()?>/assets/img/bg-icon-title.jpg"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-50">
		<?php echo view('umum/header');?>	
		<?php echo view($content);?>
		<?php echo view('umum/footer');?>	
</body>

</html>