<main class="container">
<section class="promo">
	<h2 class="promo__title">Нужен стафф для катки?</h2>
	<p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
	<ul class="promo__list">
		<?php foreach ($categories_array as $key => $value): ?>
			<li class="promo__item promo__item--<?=$value['icon'];?>">
				<a class="promo__link" href="all-lots.php?category_id=<?=$value['id'];?>"><?=$value['name']; ?></a>
			</li>
		<?php endforeach; ?>
    </ul>
</section>
<section class="lots">
	<div class="lots__header">
		<h2>Открытые лоты</h2>
	</div>
	<ul class="lots__list">
		<?php foreach($lots_array as $key => $value):?>
		<?php if (strtotime($value['date_finish']) > strtotime("today")) : ?>
			<li class="lots__item lot">
				<div class="lot__image">
					<img src="<?=$value['image'];?>" width="350" height="260" alt="<?=$value['title'];?>">
				</div>
				<div class="lot__info">
					<span class="lot__category"><?=$value['name'];?></span>
					<h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?=$value['id'];?>"><?=$value['title'];?></a></h3>
					<div class="lot__state">
						<div class="lot__rate">
							<span class="lot__amount">Стартовая цена</span>
							<span class="lot__cost"><?=price_format($value['start_price']); ?></span>
						</div>
						<div class="lot__timer timer <?=(strtotime($value['date_finish']) < strtotime("+24 hours now")) ? "timer--finishing" : "" ;?>">
							<?=time_rest($value['date_finish']);?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</section>
</main>