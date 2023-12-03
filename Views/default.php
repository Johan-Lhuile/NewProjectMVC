<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'site' ?></title>
</head>
<body>

<div class="">

<?php if(!empty($_SESSION['error'])): ?>
<div class="flex items-center rounded shadow-md overflow-hidden max-w-xl relative dark:bg-gray-900 dark:text-gray-100">
	<div class="self-stretch flex items-center px-3 flex-shrink-0 dark:bg-gray-700 dark:text-violet-400">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
		</svg>
	</div>
	<div class="p-4 flex-1">
		<h3 class="text-xl font-bold">Erreur</h3>
		<p class="text-sm dark:text-gray-400"><?= $_SESSION['error']; unset($_SESSION['error']);?>
			
		</p>
	</div>
	<button class="absolute top-2 right-2">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 p-2 rounded cursor-pointer">
			<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
		</svg>
	</button>
</div>
			
<?php endif; ?>

<?php if(!empty($_SESSION['sucess'])): ?>
<div class="flex shadow-md gap-6 rounded-lg overflow-hidden divide-x max-w-2xl dark:bg-gray-900 dark:text-gray-100 dark:divide-gray-700">
	<div class="flex flex-1 flex-col p-4 border-l-8 dark:border-violet-400">
		<span class="text-2xl">Success</span>
		<span class="text-xs dark:text-gray-400"><?= $_SESSION['sucess']; unset($_SESSION['sucess']);?></span>
	</div>
</div>
			
<?php endif; ?>

    <?=$content?>
</div>
    <script src="Public/js/script.js"></script>
</body>
</html>