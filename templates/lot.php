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
				<form class="lot-item__form" action="lot.php?lot_id=<?=($lots_array['id']);?>" method="post" enctype="application/x-www-form-urlencoded">
					<p class="lot-item__form-item form__item <?=(isset($errors['cost']) && $errors['cost'] ? "form__item--invalid" : "");?>">
						<label for="cost">Ваша ставка</label>
						<input id="cost" type="text" name="cost" placeholder="<?=number_format(($current_price + $lots_array['step']), 0, '.', ' ' ); ?>">
						<span class="form__error"><?=($errors['cost'] ?? "");?></span>
					</p>
					<button type="submit" class="button">Сделать ставку</button>
				</form>
			</div>
			<div class="history">
				<h3>История ставок (<span>10</span>)</h3>
				<table class="history__list">
					<tr class="history__item">
						<td class="history__name">Иван</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">5 минут назад</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Константин</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">20 минут назад</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Евгений</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">Час назад</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Игорь</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 08:21</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Енакентий</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 13:20</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Семён</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 12:20</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Илья</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 10:20</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Енакентий</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 13:20</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Семён</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 12:20</td>
					</tr>
					<tr class="history__item">
						<td class="history__name">Илья</td>
						<td class="history__price">10 999 р</td>
						<td class="history__time">19.03.17 в 10:20</td>
					</tr>
				</table>
			</div>
		</div>
        <?php endif;?>
	</div>
</section>
</main>