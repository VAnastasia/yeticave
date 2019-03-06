<main>
<nav class="nav">
	<ul class="nav__list container">
		<?php foreach ($categories_array as $key => $value): ?>
			<li class="nav__item">
				<a href="pages/all-lots.html"><?=$value['name']; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
<section class="lot-item container">
	<h2><?=$lots_array['title'];?></h2>
	<div class="lot-item__content">
		<div class="lot-item__left">
			<div class="lot-item__image">
				<img src="<?=$lots_array['image'];?>" width="730" height="548" alt="<?=$lots_array['title'];?>">
			</div>
			<p class="lot-item__category">Категория: <span><?=$lots_array['name'];?></span></p>
			<p class="lot-item__description"><?=$lots_array['description'];?></p>
		</div>
        <?php if ($user_name):?>
		<div class="lot-item__right">
			<div class="lot-item__state">
				<div class="lot-item__timer timer">
					<?=time_rest($lots_array['date_finish']);?>
				</div>
                <div class="lot-item__cost-state">
					<div class="lot-item__rate">
						<span class="lot-item__amount">Текущая цена</span>
						<span class="lot-item__cost"><?=price_format($current_price); ?></span>
					</div>
					<div class="lot-item__min-cost">
						Мин. ставка <span><?=number_format(($current_price + $lots_array['step']), 0, '.', ' ' ); ?> р.</span>
					</div>
				</div>
                <?php if (($lots_array['author_id'] !== $user) && $rate_done): ?>
				<form class="lot-item__form" action="<?= $url ;?>" method="post" enctype="application/x-www-form-urlencoded">
					<p class="lot-item__form-item form__item <?=(isset($errors['cost']) && $errors['cost'] ? "form__item--invalid" : "");?>">
						<label for="cost">Ваша ставка</label>
						<input id="cost" type="text" name="cost" placeholder="<?=number_format(($current_price + $lots_array['step']), 0, '.', ' ' ); ?>">
						<span class="form__error"><?=($errors['cost'] ?? "");?></span>
					</p>
					<button type="submit" class="button">Сделать ставку</button>
				</form>
                <?php endif ;?>
			</div>
			<div class="history">
				<h3>История ставок (<span><?=$count_rates;?></span>)</h3>
				<table class="history__list">
                    <?php foreach($history as $value) :?>
					<tr class="history__item">
						<td class="history__name"><?=$value['name'];?></td>
						<td class="history__price"><?=number_format($value['amount'], 0, '.', ' ' );?> р</td>
						<td class="history__time"><?=date_format(date_create($value['date_add']),
                                'd.m.y' . ' в ' . 'H:i');?></td>
					</tr>
                    <?php endforeach; ?>
				</table>
			</div>
		</div>
        <?php endif;?>
	</div>
</section>
</main>